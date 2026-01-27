<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\View\Components;

use Igniter\Cart\Models\Menu;
use Igniter\Main\Traits\ConfigurableComponent;
use Illuminate\View\Component;
use Override;
use TiPowerUp\OrangeTw\Data\MenuItemData;

final class FeaturedItems extends Component
{
    use ConfigurableComponent;

    public function __construct(
        public string $title = 'Featured Menu Items',
        public array $items = [],
        public int $limit = 8,
        public int $itemsPerRow = 4,
        public bool $showThumb = true,
        public ?int $itemWidth = 400,
        public ?int $itemHeight = 300,
    ) {}

    public static function componentMeta(): array
    {
        return [
            'code' => 'tipowerup-orange-tw::featured-items',
            'name' => 'Featured Items Component',
            'description' => 'Display featured menu items in a responsive grid',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'title' => [
                'label' => 'Title',
                'type' => 'text',
                'validationRule' => 'string',
            ],
            'items' => [
                'label' => 'Menu Items',
                'type' => 'selectlist',
                'mode' => 'checkbox',
                'validationRule' => 'required|array',
            ],
            'limit' => [
                'label' => 'Limit',
                'span' => 'left',
                'type' => 'number',
                'validationRule' => 'required|integer',
            ],
            'itemsPerRow' => [
                'label' => 'Items Per Row',
                'span' => 'right',
                'type' => 'select',
                'options' => [
                    1 => 'One',
                    2 => 'Two',
                    3 => 'Three',
                    4 => 'Four',
                    5 => 'Five',
                    6 => 'Six',
                ],
                'validationRule' => 'required|integer',
            ],
            'showThumb' => [
                'label' => 'Show Thumbnail',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'itemWidth' => [
                'label' => 'Width',
                'span' => 'left',
                'type' => 'number',
                'validationRule' => 'integer',
            ],
            'itemHeight' => [
                'label' => 'Height',
                'span' => 'right',
                'type' => 'number',
                'validationRule' => 'integer',
            ],
        ];
    }

    public static function getItemsOptions()
    {
        return Menu::whereIsEnabled()->dropdown('menu_name');
    }

    #[Override]
    public function render()
    {
        return view('tipowerup-orange-tw::components.featured-items', [
            'featuredItems' => $this->loadItems(),
        ]);
    }

    protected function loadItems(): \Illuminate\Support\Collection
    {
        return Menu::query()
            ->with(['locations', 'media'])
            ->whereIn('menu_id', $this->items)
            ->take($this->limit)
            ->get()
            ->mapInto(MenuItemData::class);
    }
}
