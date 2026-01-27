<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\View\Components;

use Igniter\Cart\Models\Category;
use Igniter\Local\Facades\Location;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

final class CategoryList extends Component
{
    public function __construct(
        public string $menusPage = 'local.menus',
        public bool $hideEmpty = true,
        public bool $useLinkAnchor = true,
    ) {}

    public function render()
    {
        return view('tipowerup-orange-tw::components.category-list', [
            'categories' => $this->loadCategories(),
            'selectedCategory' => $this->findSelectedCategory(),
        ]);
    }

    protected function loadCategories(): Collection
    {
        return once(function (): Collection {
            $location = Location::current();

            $query = Category::query()
                ->with([
                    'children',
                    'children.children',
                ])
                ->withCount([
                    'menus' => function ($query) use ($location): void {
                        if ($location) {
                            $query->whereHasOrDoesntHaveLocation($location->getKey());
                        }
                    },
                ])
                ->whereIsEnabled()->sorted();

            if ($location) {
                $query->whereHasOrDoesntHaveLocation($location->getKey());
            }

            return $query->get();
        });
    }

    protected function findSelectedCategory(): ?Category
    {
        if ((string) ($slug = request()->route()->parameter('category', '')) === '') {
            return null;
        }

        return once(function () use ($slug): ?Category {
            $query = Category::query()->whereIsEnabled()->where('permalink_slug', $slug);
            if ($location = Location::current()) {
                $query->whereHasOrDoesntHaveLocation($location->getKey());
            }

            return $query->first();
        });
    }
}
