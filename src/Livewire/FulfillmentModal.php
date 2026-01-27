<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\Livewire;

use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Main\Traits\ConfigurableComponent;
use Livewire\Component;

class FulfillmentModal extends Component
{
    use ConfigurableComponent;

    public string $orderType = '';

    public string $orderTime = 'asap';

    public string $orderDate = '';

    public string $orderTimeSlot = '';

    public string $address = '';

    public static function componentMeta(): array
    {
        return [
            'code' => 'tipowerup-orange-tw::fulfillment-modal',
            'name' => 'Fulfillment Modal',
            'description' => 'Displays a modal for selecting order type and time',
        ];
    }

    public function defineProperties(): array
    {
        return [];
    }

    public function mount(): void
    {
        $this->orderType = Location::orderType() ?? LocationModel::DELIVERY;
        $this->orderTime = Location::orderTimeIsAsap() ? 'asap' : 'later';

        if (! Location::orderTimeIsAsap()) {
            $dateTime = Location::orderDateTime();
            $this->orderDate = $dateTime->format('Y-m-d');
            $this->orderTimeSlot = $dateTime->format('H:i');
        }
    }

    public function updateFulfillment(): void
    {
        $this->validate([
            'orderType' => 'required|in:delivery,collection',
            'orderTime' => 'required|in:asap,later',
        ]);

        Location::updateOrderType($this->orderType);

        if ($this->orderTime === 'asap') {
            Location::updateScheduleTimeSlot(null, true);
        } else {
            $this->validate([
                'orderDate' => 'required|date',
                'orderTimeSlot' => 'required',
            ]);

            $dateTime = \Carbon\Carbon::parse($this->orderDate.' '.$this->orderTimeSlot);
            Location::updateScheduleTimeSlot($dateTime->format('Y-m-d H:i:s'), false);
        }

        $this->dispatch('close-modal', 'fulfillment-modal');
        $this->dispatch('fulfillment-updated');
    }

    protected function getAvailableTimeSlots(): array
    {
        $slots = [];
        $current = Location::current();

        if (! $current) {
            return $slots;
        }

        $schedule = $current->getSchedule($this->orderType);
        $date = $this->orderDate ? \Carbon\Carbon::parse($this->orderDate) : now();

        for ($hour = 0; $hour < 24; $hour++) {
            for ($minute = 0; $minute < 60; $minute += 15) {
                $time = sprintf('%02d:%02d', $hour, $minute);
                $slots[] = $time;
            }
        }

        return $slots;
    }

    public function render()
    {
        return view('tipowerup-orange-tw::livewire.fulfillment-modal', [
            'orderTypes' => LocationModel::getOrderTypeOptions(),
            'timeSlots' => $this->getAvailableTimeSlots(),
        ]);
    }
}
