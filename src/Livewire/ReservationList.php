<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\Livewire;

use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\User\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ReservationList extends Component
{
    use ConfigurableComponent;
    use WithPagination;

    public int $itemsPerPage = 20;

    public string $sortOrder = 'reserve_date desc';

    public string $reservationPage = 'account.reservation';

    public static function componentMeta(): array
    {
        return [
            'code' => 'tipowerup-orange-tw::reservation-list',
            'name' => 'Reservation List',
            'description' => 'Displays a list of customer reservations',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'itemsPerPage' => [
                'label' => 'Number of reservations to display per page.',
                'type' => 'number',
                'validationRule' => 'required|numeric|min:0',
            ],
            'reservationPage' => [
                'label' => 'Page to redirect to when viewing a reservation.',
                'type' => 'select',
                'options' => [self::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
        ];
    }

    protected function loadReservations()
    {
        if (! $customer = Auth::customer()) {
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
