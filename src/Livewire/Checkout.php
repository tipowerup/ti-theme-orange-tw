<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\Livewire;

use DateTime;
use Exception;
use Igniter\Cart\Classes\CartManager;
use Igniter\Cart\Classes\CheckoutForm;
use Igniter\Cart\Classes\OrderManager;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Geolite\Contracts\GeoQueryInterface;
use Igniter\Flame\Geolite\Facades\Geocoder;
use Igniter\Flame\Geolite\GeoQuery;
use Igniter\Flame\Support\Facades\File;
use Igniter\Flame\Traits\EventEmitter;
use Igniter\Local\Classes\CoveredArea;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Local\Models\LocationArea;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\Orange\Actions\EnsureUniqueProcess;
use Igniter\System\Facades\Assets;
use Igniter\User\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Livewire\Livewire;
use Throwable;

/**
 * Checkout component
 *
 * @property-read Collection $paymentGateways
 */
final class Checkout extends Component
{
    use ConfigurableComponent;
    use EventEmitter;
    use UsesPage;

    public const string STEP_DETAILS = 'details';

    public const string STEP_PAY = 'pay';

    /** Whether to use a two-page checkout */
    public bool $isTwoPageCheckout = false;

    /** Whether to display the telephone form field */
    public bool $hideTelephoneField = false;

    /** Whether to display the comment form field */
    public bool $hideCommentField = false;

    /** Whether to display the delivery comment form field */
    public bool $hideDeliveryCommentField = false;

    /** Whether the telephone field should be required */
    public bool $telephoneIsRequired = true;

    /** The permalink slug for the agree checkout terms page */
    public string $agreeTermsSlug = 'terms-and-conditions';

    /** The menus page */
    #[Locked]
    public string $menusPage = 'local.menus';

    /** The checkout page */
    #[Locked]
    public string $checkoutPage = 'checkout.checkout';

    /** Page to redirect to when checkout is successful */
    #[Locked]
    public string $successPage = 'checkout.success';

    #[Url(as: 'step')]
    public string $checkoutStep = 'details';

    public array $fields = [];

    public string $addressSearchQuery = '';

    public array $addressSuggestions = [];

    public bool $isAddressSearching = false;

    public string $geocoder = 'nominatim';

    public bool $saveAddress = true;

    public array $timeslotDates = [];

    public array $timeslotTimes = [];

    public string $orderType = '';

    public bool $isAsap = true;

    public string $orderDate = '';

    public string $orderTime = '';

    protected CheckoutForm $checkoutForm;

    protected CartManager $cartManager;

    protected OrderManager $orderManager;

    protected ?Order $order = null;

    /** @var \Igniter\Local\Classes\Location */
    protected $location;

    public static function componentMeta(): array
    {
        return [
            'code' => 'tipowerup-orange-tw::checkout',
            'name' => 'Checkout',
            'description' => 'Displays the checkout form with payment processing',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'isTwoPageCheckout' => [
                'label' => 'Use two-page checkout.',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'hideTelephoneField' => [
                'label' => 'Display the telephone checkout field.',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'hideCommentField' => [
                'label' => 'Display the comment checkout field',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'hideDeliveryCommentField' => [
                'label' => 'Display the delivery comment checkout field',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'telephoneIsRequired' => [
                'label' => 'Require telephone number for checkout',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'agreeTermsSlug' => [
                'label' => 'Static page for the checkout terms and conditions',
                'type' => 'select',
                'options' => self::getStaticPageOptions(...),
                'comment' => 'If set, require customers to agree to terms before checkout',
                'validationRule' => 'sometimes|alpha_dash',
            ],
            'menusPage' => [
                'label' => 'Page to redirect to when checkout is unavailable.',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
            'checkoutPage' => [
                'label' => 'Page to redirect to when checkout fails',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
            'successPage' => [
                'label' => 'Page to redirect to when checkout is successful',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
        ];
    }

    public function render()
    {
        $requiresPayment = ! $this->isInitialCheckoutStep() && $this->getOrder()->order_total > 0;

        return view('tipowerup-orange-tw::livewire.checkout', [
            'customer' => Auth::customer(),
            'order' => $order = $this->getOrder(),
            'cart' => $this->cartManager->getCart(),
            'locationCurrent' => Location::current(),
            'locationOrderType' => Location::getOrderTypes()->get($order->order_type),
            'orderTypes' => $this->location->getActiveOrderTypes(),
            'requiresTerms' => $this->agreeTermsSlug && ! $this->isInitialCheckoutStep(),
            'noPaymentGateways' => $requiresPayment && $this->paymentGateways->isEmpty(),
        ]);
    }

    public function mount()
    {
        if (! is_null($order = $this->isOrderMarkedAsProcessed())) {
            return $this->redirect($order->getUrl($this->successPage));
        }

        if (! is_null($this->checkCheckoutSecurity())) {
            return $this->redirect(restaurant_url($this->menusPage));
        }

        Assets::addJs('tipowerup-orange-tw::/js/checkout.js', 'checkout-js');

        $this->geocoder = setting('default_geocoder', 'nominatim');

        $this->parseTimeslot($this->location->scheduleTimeslot());
        $this->orderType = $this->location->orderType();
        $this->isAsap = $this->location->orderTimeIsAsap();
        $this->orderDate = $this->location->orderDateTime()->format('Y-m-d');
        $this->orderTime = $this->location->orderDateTime()->format('H:i');

        foreach ($this->paymentGateways as $paymentGateway) {
            $paymentGateway->beforeRenderPaymentForm($paymentGateway, controller());
        }

        foreach ($this->checkoutForm->getFields() as $field) {
            $this->fields[$field->fieldName] = $field->value;
        }

        $this->prepareDeliveryAddress();

        $this->fields['address_1'] ??= '';
        $this->fields['city'] ??= '';
        $this->fields['state'] ??= '';
        $this->fields['postcode'] ??= '';
        $this->fields['country_id'] ??= null;

        return null;
    }

    public function boot(): void
    {
        $this->location = resolve('location');
        $this->orderManager = resolve(OrderManager::class);
        $this->cartManager = resolve(CartManager::class);
        $this->initForm();
    }

    #[Computed]
    public function cartTotal(): string
    {
        return currency_format($this->cartManager->getCart()->total());
    }

    #[Computed]
    public function formTabFields(string $tab): array
    {
        return array_get($this->checkoutForm->getTab('primary'), $tab, []);
    }

    #[Computed]
    public function paymentGateways()
    {
        if ($this->getOrder()->order_total <= 0) {
            return collect();
        }

        return $this->orderManager->getPaymentGateways()
            ->filter(fn ($gateway) => ! method_exists($gateway, 'isConfigured') || $gateway->isConfigured());
    }

    #[On('checkout::validate')]
    public function onValidate()
    {
        if ($this->checkCheckoutSecurity()) {
            return $this->redirect(restaurant_url($this->menusPage));
        }

        if (! is_null($order = $this->isOrderMarkedAsProcessed())) {
            return $this->redirect($order->getUrl($this->successPage));
        }

        $this->updateFulfillment();

        $order = $this->getOrder();

        $data = $this->validateCheckout($order);

        $this->orderManager->saveOrder($order, $data);

        $this->dispatch('checkout::validated');

        return null;
    }

    #[On('checkout::confirm')]
    public function onConfirm()
    {
        if ($this->checkCheckoutSecurity()) {
            return $this->redirect(restaurant_url($this->menusPage));
        }

        if (! is_null($order = $this->isOrderMarkedAsProcessed())) {
            return $this->redirect($order->getUrl($this->successPage));
        }

        $this->updateFulfillment();

        $order = $this->getOrder();

        // Ensure a configured payment gateway is selected when payment is required
        if (! $this->isInitialCheckoutStep() && $order->order_total > 0 && $this->paymentGateways->isEmpty()) {
            throw ValidationException::withMessages([
                'fields.payment' => lang('tipowerup.orange-tw::default.checkout.no_payment_gateways'),
            ]);
        }

        $data = $this->validateCheckout($order);

        $data['cancelPage'] = $this->checkoutPage;
        $data['successPage'] = $this->successPage;

        try {
            $lockKey = 'checkout::confirm-'.$order->order_date.$order->order_time.'-'.$order->order_type;
            resolve(EnsureUniqueProcess::class)->attemptWithLock($lockKey, function () use ($data, $order): void {
                $this->orderManager->saveOrder($order, $data);
            });

            $this->saveDeliveryAddress();

            if ($this->isInitialCheckoutStep()) {
                return $this->redirect(Livewire::originalUrl().'?step='.self::STEP_PAY);
            }

            if (($redirect = $this->orderManager->processPayment($order, $data)) === false) {
                return null;
            }

            if ($redirect instanceof RedirectResponse || $redirect instanceof Redirector) {
                return $redirect;
            }

            return $this->redirect($order->getUrl($this->successPage));
        } catch (Exception $ex) {
            $errorFieldName = $this->isInitialCheckoutStep() ? 'fields.comment' : 'fields.payment';

            throw ValidationException::withMessages([$errorFieldName => $ex->getMessage()]);
        }
    }

    #[On('checkout::choose-payment')]
    public function onChoosePayment($code): void
    {
        throw_unless($code, ValidationException::withMessages([
            'fields.payment' => lang('igniter.cart::default.checkout.error_invalid_payment'),
        ]));

        throw_unless($payment = $this->orderManager->getPayment($code), ValidationException::withMessages([
            'fields.payment' => lang('igniter.cart::default.checkout.error_invalid_payment'),
        ]));

        $this->fields['payment'] = $code;
        $this->checkoutForm->getField('payment')->value = $code;
        $this->orderManager->applyCurrentPaymentFee($payment->code);

        $this->order = null;
    }

    #[On('checkout::delete-payment-profile')]
    public function onDeletePaymentProfile($code)
    {
        $customer = Auth::customer();
        $payment = $this->orderManager->getPayment($code);

        throw_if(! $payment, ValidationException::withMessages([
            'fields.payment' => lang('igniter.cart::default.checkout.error_invalid_payment'),
        ]));

        throw_if(! $payment->paymentProfileExists($customer), ValidationException::withMessages([
            'fields.payment' => lang('igniter.cart::default.checkout.error_payment_profile_not_found'),
        ]));

        $payment->deletePaymentProfile($customer);

        return redirect()->back();
    }

    #[Computed]
    public function customerAddresses()
    {
        return collect(Auth::customer()?->addresses ?? []);
    }

    public function onSelectSavedAddress(int $id): void
    {
        $customer = Auth::customer();
        if (! $customer) {
            return;
        }

        $address = $this->customerAddresses->firstWhere('address_id', $id);
        if (! $address) {
            return;
        }

        $this->fields['address_1'] = $address->address_1;
        $this->fields['city'] = $address->city;
        $this->fields['state'] = $address->state;
        $this->fields['postcode'] = $address->postcode;
        $this->fields['country_id'] = $address->country_id;
        $this->addressSearchQuery = '';
        $this->isAddressSearching = false;
        $this->addressSuggestions = [];
    }

    public function updatedAddressSearchQuery(): void
    {
        if (strlen($this->addressSearchQuery) < 5) {
            $this->isAddressSearching = false;
            $this->addressSuggestions = [];

            return;
        }

        try {
            $this->isAddressSearching = true;
            $query = GeoQuery::create($this->addressSearchQuery)->withLimit(5);
            $this->addressSuggestions = $this->fetchAddressSuggestions($query);
        } catch (Exception $e) {
            $this->isAddressSearching = false;
            $this->addressSuggestions = [];
        }
    }

    public function onSelectAddressSuggestion(int $index): void
    {
        $suggestion = $this->addressSuggestions[$index] ?? null;
        if (! $suggestion) {
            return;
        }

        $this->isAddressSearching = false;
        $this->addressSearchQuery = '';
        $this->addressSuggestions = [];

        $data = $suggestion['data'] ?? [];

        if (! empty($data['street_name'])) {
            $this->fields['address_1'] = trim(($data['street_number'] ?? '').' '.($data['street_name'] ?? ''));
            $this->fields['city'] = $data['city'] ?? '';
            $this->fields['state'] = $data['state'] ?? '';
            $this->fields['postcode'] = $data['postcode'] ?? '';

            if (! empty($data['country_code'])) {
                $this->fields['country_id'] = array_get(
                    countries('country_id', 'iso_code_2'),
                    $data['country_code'],
                    LocationModel::getDefaultKey(),
                );
            }
        }
    }

    protected function fetchAddressSuggestions(GeoQueryInterface $query): array
    {
        $driver = Geocoder::driver();

        if ($this->geocoder !== 'nominatim') {
            return $driver->placesAutocomplete($query)->toArray();
        }

        return $driver->geocodeQuery($query)
            ->filter(fn ($location) => $location->hasCoordinates())
            ->map(fn ($location) => [
                'placeId' => null,
                'title' => $location->getSubLocality() ?: $location->getLocality() ?: $location->getFormattedAddress(),
                'description' => $location->getFormattedAddress(),
                'provider' => 'nominatim',
                'data' => [
                    'latitude' => $location->getCoordinates()->getLatitude(),
                    'longitude' => $location->getCoordinates()->getLongitude(),
                    'street_number' => $location->getStreetNumber(),
                    'street_name' => $location->getStreetName(),
                    'city' => $location->getSubLocality() ?: $location->getLocality(),
                    'state' => $location->getAdminLevels()->get(1)?->getName() ?? $location->getLocality(),
                    'postcode' => $location->getPostalCode(),
                    'country_code' => $location->getCountryCode(),
                ],
            ])
            ->values()
            ->toArray();
    }

    public function updatedOrderType(string $value): void
    {
        throw_unless($this->location->current(), ValidationException::withMessages([
            'orderType' => lang('igniter.local::default.alert_location_required'),
        ]));

        $orderType = $this->location->getOrderType($value);

        throw_unless($orderType, ValidationException::withMessages([
            'orderType' => lang('igniter.local::default.alert_order_type_required'),
        ]));

        throw_if($orderType->isDisabled(), ValidationException::withMessages([
            'orderType' => $orderType->getDisabledDescription(),
        ]));

        $this->location->updateOrderType($value);
        $this->parseTimeslot($this->location->scheduleTimeslot());
        $this->orderDate = $this->location->orderDateTime()->format('Y-m-d');
        $this->orderTime = $this->location->orderDateTime()->format('H:i');
        $this->isAsap = $this->location->orderTimeIsAsap();
        $this->order = null;
    }

    protected function parseTimeslot(Collection $timeslot): void
    {
        $this->timeslotDates = [];
        $this->timeslotTimes = [];

        $timeslot->collapse()->each(function (DateTime $slot): void {
            $dateKey = $slot->format('Y-m-d');
            $hourKey = $slot->format('H:i');
            $dateValue = make_carbon($slot)->isoFormat(lang('system::lang.moment.day_format'));
            $hourValue = make_carbon($slot)->isoFormat(lang('system::lang.moment.time_format'));

            $this->timeslotDates[$dateKey] = $dateValue;
            $this->timeslotTimes[$dateKey][$hourKey] = $hourValue;
        });
    }

    protected function updateFulfillment(): void
    {
        $this->location->updateOrderType($this->orderType);

        $timeSlotDateTime = $this->isAsap ? now() : make_carbon($this->orderDate.' '.$this->orderTime);

        throw_unless($this->location->checkOrderTime($timeSlotDateTime), ValidationException::withMessages([
            'isAsap' => sprintf(lang('igniter.local::default.alert_order_is_unavailable'), $this->location->getOrderType()->getLabel()),
        ]));

        $this->location->updateScheduleTimeSlot($timeSlotDateTime, $this->isAsap);
    }

    protected function saveDeliveryAddress(): void
    {
        $customer = Auth::customer();
        if (! $customer || ! $this->saveAddress || ! $this->getOrder()->isDeliveryType()) {
            return;
        }

        $address1 = trim($this->fields['address_1'] ?? '');
        $postcode = trim($this->fields['postcode'] ?? '');
        if (empty($address1)) {
            return;
        }

        $exists = $customer->addresses()
            ->where('address_1', $address1)
            ->where('postcode', $postcode)
            ->exists();

        if ($exists) {
            return;
        }

        $customer->addresses()->create([
            'address_1' => $address1,
            'city' => $this->fields['city'] ?? '',
            'state' => $this->fields['state'] ?? '',
            'postcode' => $postcode,
            'country_id' => $this->fields['country_id'] ?? LocationModel::getDefaultKey(),
        ]);
    }

    /**
     * Validate delivery address without requiring a street number.
     *
     * The core OrderManager::validateDeliveryAddress requires both streetNumber
     * AND streetName from the geocoder result, but street numbers are not stored
     * in the database and many geocoders (especially Nominatim) don't return them.
     */
    protected function validateDeliveryAddress(array $address): void
    {
        if (! array_get($address, 'country') && isset($address['country_id'])) {
            $address['country'] = app('country')->getCountryNameById($address['country_id']);
        }

        $addressInfo = array_only($address, ['address_1', 'address_2', 'city', 'state', 'postcode', 'country']);
        if (empty(array_filter($addressInfo))) {
            throw new ApplicationException(lang('igniter.local::default.alert_invalid_search_query'));
        }

        $collection = Geocoder::geocode(implode(' ', array_filter($addressInfo)));
        if ($collection->isEmpty()) {
            throw new ApplicationException(lang('igniter.local::default.alert_invalid_search_query'));
        }

        $userLocation = $collection->first();

        $this->location->updateUserPosition($userLocation);

        if (! ($area = $this->location->current()->searchDeliveryArea($userLocation->getCoordinates())) instanceof LocationArea) {
            throw new ApplicationException(lang('igniter.cart::default.checkout.error_covered_area'));
        }

        if (! $this->location->isCurrentAreaId($area->area_id)) {
            $this->location->setCoveredArea(new CoveredArea($area));
        }
    }

    protected function getOrder(): Order
    {
        if (! is_null($this->order)) {
            return $this->order;
        }

        return $this->order = $this->orderManager->loadOrder();
    }

    protected function checkCheckoutSecurity(): ?bool
    {
        try {
            $this->cartManager->validateContents();

            $this->orderManager->validateCustomer(Auth::getUser());

            $this->cartManager->validateLocation();

            $this->cartManager->validateOrderTime();

            if ($this->cartManager->cartTotalIsBelowMinimumOrder()) {
                throw new ApplicationException(sprintf(lang('igniter.cart::default.alert_min_order_total'),
                    currency_format(resolve('location')->minimumOrderTotal())));
            }

            if ($this->cartManager->deliveryChargeIsUnavailable()) {
                return true;
            }

            Event::dispatch('igniter.orange.checkCheckoutSecurity');

            return null;
        } catch (Exception $ex) {
            flash()->warning($ex->getMessage())->now();

            return true;
        }
    }

    /**
     * Validate the checkout form data and cart state before processing.
     *
     * Performs comprehensive validation on:
     * - Customer contact information (name, email, phone)
     * - Delivery/pickup address (if delivery order type)
     * - Payment method selection and availability
     * - Terms and conditions agreement (if required)
     * - Cart contents and availability
     *
     * @param  Order  $order  The order being validated
     * @return array Validated and merged form data ready for order processing
     *
     * @throws \Illuminate\Validation\ValidationException When validation fails
     */
    protected function validateCheckout(Order $order)
    {
        $rules = $this->checkoutForm->validationRules();
        $messages = $this->checkoutForm->validationMessages();
        $attributes = $this->checkoutForm->validationAttributes();

        if (! $this->agreeTermsSlug || $this->isInitialCheckoutStep()) {
            $rules = array_except($rules, ['fields.termsAgreed']);
        }

        $this->withValidator(function ($validator) use ($order): void {
            $validator->after(function ($validator) use ($order): void {
                if ($order->isDeliveryType()) {
                    rescue(function (): void {
                        $this->validateDeliveryAddress(array_only($this->fields, [
                            'address_1', 'city', 'state', 'postcode', 'country', 'country_id',
                        ]));
                    }, function (Throwable $ex) use ($validator): void {
                        $validator->errors()->add('delivery_address', $ex->getMessage());
                    });
                }

                if ($this->fields['payment'] && ! $this->orderManager->getPayment($this->fields['payment'])) {
                    $validator->errors()->add('payment', lang('igniter.cart::default.checkout.error_invalid_payment'));
                }
            });
        });

        $data = $this->validate($rules, $messages, $attributes);
        $data = array_merge(
            $this->fields,
            array_pull($data, 'fields.payment_fields', []),
            array_pull($data, 'fields', []),
            $data,
        );

        $this->orderManager->applyCurrentPaymentFee($this->fields['payment']);

        Event::dispatch('igniter.orange.validateCheckout', [$data, $order]);

        return $data;
    }

    protected function isOrderMarkedAsProcessed(): ?Order
    {
        $order = $this->getOrder();

        return $order->isPaymentProcessed() ? $order : null;
    }

    protected function prepareDeliveryAddress(): void
    {
        if (! $this->getOrder()->isDeliveryType()) {
            return;
        }

        $userPosition = Location::userPosition();
        if ($userPosition && $userPosition->isValid()) {
            $this->fields['address_1'] = $userPosition->getStreetNumber().' '.$userPosition->getStreetName();
            $this->fields['city'] = $userPosition->getSubLocality() ?: $userPosition->getLocality();
            $this->fields['state'] = $userPosition->getAdminLevels()->get(1)?->getName() ?? $userPosition->getLocality();
            $this->fields['postcode'] = $userPosition->getPostalCode();
            $this->fields['country_id'] = array_get(countries('country_id', 'iso_code_2'),
                $userPosition->getCountryCode(), LocationModel::getDefaultKey());
        }
    }

    protected function isInitialCheckoutStep(): bool
    {
        return $this->isTwoPageCheckout && $this->checkoutStep !== self::STEP_PAY;
    }

    protected function formExtendFieldsBefore(CheckoutForm $checkoutForm): void
    {
        if ($this->agreeTermsSlug !== '' && $this->agreeTermsSlug !== '0') {
            $checkoutForm->fields['termsAgreed']['placeholder'] = sprintf(
                lang('igniter.cart::default.checkout.label_terms'), url($this->agreeTermsSlug),
            );
        } else {
            unset($checkoutForm->fields['termsAgreed'], $this->fields['termsAgreed']);
        }

        if ($this->hideTelephoneField) {
            unset($checkoutForm->fields['telephone'], $this->fields['telephone']);
        }

        if ($this->hideCommentField) {
            unset($checkoutForm->fields['comment'], $this->fields['comment']);
        }

        if ($this->hideDeliveryCommentField) {
            unset($checkoutForm->fields['delivery_comment'], $this->fields['delivery_comment']);
        }
    }

    /**
     * Extension point for customizing checkout form fields.
     * Override this method to add or modify fields dynamically.
     */
    protected function formExtendFields(CheckoutForm $checkoutForm, array $fields): void
    {
        // Intentionally empty - override in subclass to extend
    }

    protected function initForm(): void
    {
        $config = File::getRequire(
            File::symbolizePath('tipowerup-orange-tw::/models/checkoutfields.php'),
        );

        $config['model'] = $this->getOrder();
        $this->checkoutForm = resolve(CheckoutForm::class, ['config' => $config]);

        $this->checkoutForm->bindEvent('form.extendFieldsBefore', function (): void {
            $this->formExtendFieldsBefore($this->checkoutForm);
        });

        $this->checkoutForm->bindEvent('form.extendFields', function (array $fields): void {
            $this->formExtendFields($this->checkoutForm, $fields);
        });

        $this->checkoutForm->initialize();
    }
}
