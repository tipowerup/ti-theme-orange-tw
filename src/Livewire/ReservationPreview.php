<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\Livewire;

use Livewire\Component;
use Igniter\Reservation\Classes\BookingManager;
use Igniter\User\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ReservationPreview extends Component
{
    public string $hashParamName = 'hash';
    public ?string $hash = null;
    public bool $showCancelButton = false;

    protected $manager;
    protected $reservation = null;

    public function boot(): void
    {
        $this->manager = resolve(BookingManager::class);
    }

    public function mount(?string $hash = null): void
    {
        $this->hash = $hash ?? request()->route()->parameter($this->hashParamName);
        $this->showCancelButton = $this->showCancelButton();
    }

    public function cancel(): void
    {
        throw_unless($reservation = $this->getReservation(), ValidationException::withMessages([
            'cancel' => lang('igniter.reservation::default.alert_cancel_failed'),
        ]));

        throw_unless($this->showCancelButton(), ValidationException::withMessages([
            'cancel' => lang('igniter.reservation::default.alert_cancel_failed'),
        ]));

        throw_unless($reservation->markAsCanceled(), ValidationException::withMessages([
            'cancel' => lang('igniter.reservation::default.alert_cancel_failed'),
        ]));

        flash()->success(lang('igniter.reservation::default.alert_cancel_success'));

        $this->showCancelButton = false;
    }

    protected function showCancelButton(): bool
    {
        return $this->getReservation() && !$this->getReservation()->isCanceled() && $this->getReservation()->isCancelable();
    }

    protected function getReservation()
    {
        return tap($this->reservation ??= $this->manager->getReservationByHash($this->hash, Auth::customer()), function($reservation): void {
            if ($reservation) {
                $this->manager->useLocation($reservation->location);
            }
        });
    }

    public function render()
    {
        return view('tipowerup-orange-tw::livewire.reservation-preview', [
            'reservation' => $this->getReservation(),
        ]);
    }
}
