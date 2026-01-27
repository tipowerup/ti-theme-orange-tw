<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\View\Components;

use Igniter\Cart\Models\Order;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\User\Facades\Auth;
use Illuminate\View\Component;
use Override;

final class OrderList extends Component
{
    use ConfigurableComponent;
    use UsesPage;

    public function __construct(
        public int $itemsPerPage = 20,
        public string $sortOrder = 'created_at desc',
        public string $orderPage = 'account.order',
    ) {}

    public static function componentMeta(): array
    {
        return [
            'code' => 'tipowerup-orange-tw::order-list',
            'name' => 'Order List',
            'description' => 'Displays a paginated list of customer orders',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'itemsPerPage' => [
                'label' => 'Number of orders to display per page',
                'type' => 'number',
            ],
            'sortOrder' => [
                'label' => 'Default sort order of orders.',
                'type' => 'select',
            ],
            'orderPage' => [
                'label' => 'Page to redirect to when an order is clicked.',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
            ],
        ];
    }

    public static function getSortOrderOptions(): array
    {
        return collect((new Order)->queryModifierGetSorts())->mapWithKeys(fn ($value, $key): array => [$value => $value])->all();
    }

    protected function loadOrders()
    {
        if (! $customer = Auth::customer()) {
            return [];
        }

        return $customer->orders()
            ->with(['location', 'status'])
            ->whereProcessed(true)
            ->listFrontEnd([
                'page' => request()->input('page', 1),
                'pageLimit' => $this->itemsPerPage,
                'sort' => $this->sortOrder,
            ]);
    }

    #[Override]
    public function render()
    {
        return view('tipowerup-orange-tw::components.order-list', [
            'orders' => $this->loadOrders(),
        ]);
    }
}
