<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\Livewire;

use DateTime;
use Igniter\Cart\Classes\AbstractOrderType;
use Igniter\Local\Models\Location;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\System\Facades\Assets;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\Livewire;

final class FulfillmentModal extends Component
{
    use ConfigurableComponent;

    public array $timeslotDates = [];

    public array $timeslotTimes = [];

    public string $orderType = '';

    public bool $isAsap = true;

    public string $orderDate = '';

    public string $orderTime = '';

    public string $defaultOrderType = Location::DELIVERY;

    public ?bool $previewMode = false;

    /**
     * @var \Igniter\Local\Classes\Location
     */
    protected $location;

    public static function componentMeta(): array
    {
        return [
            'code' => 'tipowerup-orange-tw::fulfillment-modal',
            'name' => 'tipowerup.orange-tw::default.component_fulfillment_modal_title',
            'description' => 'tipowerup.orange-tw::default.component_fulfillment_modal_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'previewMode' => [
                'label' => 'Render the component in preview mode to avoid making changes to order fulfillment.',
                'type' => 'switch',
            ],
            'defaultOrderType' => [
                'label' => 'The default selected order type.',
                'type' => 'select',
                'options' => [Location::class, 'getOrderTypeOptions'],
            ],
        ];
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('tipowerup-orange-tw::livewire.fulfillment-modal', [
            'orderTypes' => $this->location->getActiveOrderTypes(),
        ]);
    }

    public function mount(): void
    {
        Assets::addJs('tipowerup-orange-tw::/js/fulfillment.js', 'fulfillment-js');

        $this->parseTimeslot($this->location->scheduleTimeslot());

        $this->orderType = $this->location->orderType();
        $this->isAsap = $this->location->orderTimeIsAsap();
        $this->orderDate = $this->location->orderDateTime()->format('Y-m-d');
        $this->orderTime = $this->location->orderDateTime()->format('H:i');

        $this->updateCurrentOrderType();
    }

    public function boot(): void
    {
        $this->location = resolve('location');
    }

    public function updating($name, string $value): void
    {
        throw_unless($this->location->current(), ValidationException::withMessages([
            'orderType' => lang('igniter.local::default.alert_location_required'),
        ]));

        throw_if($this->previewMode, ValidationException::withMessages([
            'orderType' => lang('tipowerup.orange-tw::default.alert_preview_mode'),
        ]));

        if ($name == 'orderType') {
            $this->orderType = $value;
            $this->updateOrderType();
            $this->mount();
        }
    }

    public function onConfirm()
    {
        $this->validate([
            'orderType' => ['required', 'string'],
            'isAsap' => ['required', 'boolean'],
            'orderDate' => ['required_if:isAsap,0'],
            'orderTime' => ['required_if:isAsap,0'],
        ]);

        throw_if($this->previewMode, ValidationException::withMessages([
            'orderType' => lang('tipowerup.orange-tw::default.alert_preview_mode'),
        ]));

        throw_unless($this->location->current(), ValidationException::withMessages([
            'orderType' => lang('igniter.local::default.alert_location_required'),
        ]));

        $this->updateOrderType();

        $this->updateTimeslot();

        Event::dispatch('igniter.orange.fulfilmentUpdated');

        return $this->redirect(Livewire::originalUrl());
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

    protected function updateCurrentOrderType(): void
    {
        if (! $this->location->current()) {
            return;
        }

        $sessionOrderType = $this->location->getSession('orderType');
        if ($sessionOrderType && $this->location->hasOrderType($sessionOrderType)) {
            return;
        }

        $orderType = $this->defaultOrderType;
        if (! $this->location->hasOrderType($orderType)) {
            $orderType = optional($this->location->getOrderTypes()->first(fn (AbstractOrderType $orderType): bool => ! $orderType->isDisabled()))->getCode();
        }

        if ($orderType !== $this->orderType) {
            $this->location->updateOrderType($orderType);
            $this->redirect(Livewire::originalUrl());
        }
    }

    protected function updateOrderType(): void
    {
        throw_unless($orderType = $this->location->getOrderType($this->orderType), ValidationException::withMessages([
            'orderType' => lang('igniter.local::default.alert_order_type_required'),
        ]));

        throw_if($orderType->isDisabled(), ValidationException::withMessages([
            'orderType' => $orderType->getDisabledDescription(),
        ]));

        $this->location->updateOrderType($orderType->getCode());
    }

    protected function updateTimeslot(): void
    {
        $timeSlotDateTime = $this->isAsap ? now() : make_carbon($this->orderDate.' '.$this->orderTime);
        throw_unless($this->location->checkOrderTime($timeSlotDateTime), ValidationException::withMessages([
            'isAsap' => sprintf(lang('igniter.local::default.alert_order_is_unavailable'), $this->location->getOrderType()->getLabel()),
        ]));

        $this->location->updateScheduleTimeSlot($timeSlotDateTime, $this->isAsap);
    }
}
