<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Igniter\User\Facades\Auth;

class ReservationList extends Component
{
    use WithPagination;

    public int $itemsPerPage = 20;
    public string $sortOrder = 'reserve_date desc';
    public string $reservationPage = 'account.reservation';

    protected function loadReservations()
    {
        if (!$customer = Auth::customer()) {
            return [];
        }

        return $customer->reservations()
            ->with(['location', 'status', 'tables'])
            ->listFrontEnd([
                'page' => $this->getPage(),
                'pageLimit' => $this->itemsPerPage,
                'sort' => $this->sortOrder,
            ]);
    }

    public function render()
    {
        return view('tipowerup-orange-tw::livewire.reservation-list', [
            'reservations' => $this->loadReservations(),
        ]);
    }
}
