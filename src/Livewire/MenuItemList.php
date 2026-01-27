<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\Livewire;

use Igniter\Local\Facades\Location;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use TiPowerUp\OrangeTw\Actions\ListMenuItems;

final class MenuItemList extends Component
{
    use WithPagination;

    public bool $isGrouped = true;

    public int $collapseCategoriesAfter = 5;

    public int $itemsPerPage = 200;

    public string $sortOrder = 'menu_priority asc';

    public bool $showThumb = true;

    public int $menuThumbWidth = 95;

    public int $menuThumbHeight = 80;

    public int $categoryThumbWidth = 1240;

    public int $categoryThumbHeight = 256;

    public int $ingredientThumbWidth = 28;

    public int $ingredientThumbHeight = 28;

    public string $selectedCategorySlug = '';

    public bool $hideMenuSearch = false;

    public bool $hideUnavailableItems = false;

    #[Url(as: 'q')]
    public string $menuSearchTerm = '';

    #[Url(as: 'menuId')]
    public string $selectedMenuId = '';

    public function render()
    {
        $menuListAction = $this->loadList();

        return view('tipowerup-orange-tw::livewire.menu-item-list', [
            'menuList' => $menuListAction->getList(),
            'menuListCategories' => $menuListAction->getCategoryList(),
        ]);
    }

    public function mount(): void
    {
        $this->selectedCategorySlug = request()->route()->parameter('category', '');
    }

    public function onAddToCart(int $menuId, int $quantity, bool $openModal = false): void
    {
        if ($openModal) {
            $this->dispatch('openModal', component: 'tipowerup-orange-tw::cart-item-modal', arguments: [
                'menuId' => $menuId,
                'quantity' => $quantity,
            ]);
        } else {
            $this->dispatch('cart-box:add-item', menuId: $menuId, quantity: $quantity);
        }
    }

    protected function loadList(): ListMenuItems
    {
        $location = Location::current()?->getKey();

        $filters = [
            'sort' => $this->sortOrder,
            'location' => $location,
            'category' => $this->selectedCategorySlug,
            'search' => $this->menuSearchTerm,
            'orderType' => Location::orderType(),
            'isGrouped' => $this->isGrouped,
        ];

        if ($this->itemsPerPage > 0) {
            $filters['page'] = $this->getPage();
            $filters['pageLimit'] = $this->itemsPerPage;
        }

        $with = [];

        if ($this->showThumb) {
            $with[] = 'media';
            $with[] = 'categories.media';
            $with[] = 'ingredients.media';
        }

        return resolve(ListMenuItems::class)
            ->hideUnavailable($this->hideUnavailableItems)
            ->handle($filters, $with);
    }
}
