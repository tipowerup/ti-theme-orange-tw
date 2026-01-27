<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\Livewire;

use Igniter\Cart\Classes\CartManager;
use Igniter\Cart\Classes\OrderManager;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Main\Helpers\MainHelper;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\User\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Throwable;

final class OrderPreview extends Component
{
    use ConfigurableComponent;
    use UsesPage;

    #[Locked]
    public string $hashParamName = 'hash';

    public ?string $hash = null;

    public string $loginPage = 'account.login';

    public string $ordersPage = 'account.orders';

    public string $checkoutPage = 'checkout.checkout';

    public string $menusPage = 'local.menus';

    public string $loginUrl = '';

    public bool $hideReorderBtn = true;

    public bool $showCancelButton = false;

    protected OrderManager $orderManager;

    protected ?Model $order = null;

    public static function componentMeta(): array
    {
        return [
            'code' => 'tipowerup-orange-tw::order-preview',
            'name' => 'Order Preview',
            'description' => 'Displays order details with status, items, and actions',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'hashParamName' => [
                'label' => 'URL routing parameter that holds the code used for displaying the order confirmation page.',
                'type' => 'text',
                'validationRule' => 'required|alpha',
            ],
            'loginPage' => [
                'label' => 'Page to redirect to when the user clicks the login button.',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
            'ordersPage' => [
                'label' => 'Page to redirect to when viewing as logged in customer and an order is incomplete or not found.',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
            'checkoutPage' => [
                'label' => 'Page to redirect to when viewing as guest and an order is incomplete or not found.',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
            'menusPage' => [
                'label' => 'Page to redirect to when the user clicks the reorder button.',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
            'hideReorderBtn' => [
                'label' => 'When rendering the component on the checkout confirmation page, hide the re-order button',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
        ];
    }

    public function render()
    {
        return view('tipowerup-orange-tw::livewire.order-preview', [
            'customer' => Auth::customer(),
            'order' => $this->getProcessedOrder(),
        ]);
    }

    public function boot(): void
    {
        $this->orderManager = resolve(OrderManager::class);
    }

    public function mount(?string $hash = null)
    {
        $this->loginUrl = $this->getLoginPageUrl();
        $this->hash = $hash ?? request()->route()->parameter($this->hashParamName);
        $this->showCancelButton = $this->showCancelButton();

        if (! $processedOrder = $this->getProcessedOrder()) {
            return $this->redirect(MainHelper::pageUrl($this->checkoutPage));
        }

        if ($this->orderManager->isCurrentOrderId($processedOrder->order_id)) {
            $this->orderManager->clearOrder();
        }

        return null;
    }

    public function getStatusWidthForProgressBars(): array
    {
        $result = [];

        $order = $this->getProcessedOrder();

        $result['default'] = 0;
        $result['processing'] = 0;
        $result['completed'] = 0;

        if ($order->status_id == setting('default_order_status')) {
            $result['default'] = 50;
        }

        if (in_array($order->status_id, setting('processing_order_status', []))) {
            $result['default'] = 100;
            $result['processing'] = 50;
        }

        if (in_array($order->status_id, setting('completed_order_status', []))) {
            $result['default'] = 100;
            $result['processing'] = 100;
            $result['completed'] = 100;
        }

        return $result;
    }

    public function showCancelButton(): bool
    {
        return $this->getProcessedOrder() && ! $this->getProcessedOrder()->isCanceled() && $this->getProcessedOrder()->isCancelable();
    }

    public function onReOrder(): void
    {
        $order = $this->getProcessedOrder();

        rescue(function () use ($order): void {
            $cartManager = resolve(CartManager::class);
            $currentInstance = $cartManager->getCart()->currentInstance();
            $cartManager->cartInstance($order->location_id);

            $notes = $cartManager->restoreWithOrderMenus($order->getOrderMenus());

            $cartManager->getCart()->instance($currentInstance);

            if ($notes) {
                throw new ApplicationException(implode(PHP_EOL, $notes));
            }

            flash()->success(sprintf(
                lang('igniter.cart::default.orders.alert_reorder_success'), $order->order_id,
            ));

            $this->redirect(page_url($this->menusPage, [
                'orderId' => $order->order_id,
                'location' => $order->location->permalink_slug,
            ]));
        }, function (Throwable $ex): never {
            throw ValidationException::withMessages(['onReOrder' => $ex->getMessage()]);
        });
    }

    public function onCancel(): void
    {
        $order = $this->getProcessedOrder();

        throw_unless($this->showCancelButton(), ValidationException::withMessages([
            'onCancel' => lang('igniter.cart::default.orders.alert_cancel_failed'),
        ]));

        throw_unless($order->markAsCanceled(), ValidationException::withMessages([
            'onCancel' => lang('igniter.cart::default.orders.alert_cancel_failed'),
        ]));

        flash()->success(lang('igniter.cart::default.orders.alert_cancel_success'));
    }

    protected function getProcessedOrder()
    {
        if (! $this->hash) {
            return null;
        }

        if (! is_null($this->order)) {
            return $this->order;
        }

        $order = $this->orderManager->getOrderByHash($this->hash, Auth::customer());
        if (! $order?->isPaymentProcessed()) {
            return null;
        }

        return $this->order = $order;
    }

    protected function getLoginPageUrl(): string
    {
        $currentUrl = str_after(request()->fullUrl(), request()->root());

        return page_url($this->loginPage).'?redirect='.urlencode($currentUrl);
    }
}
