<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\Livewire;

use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Livewire\Attributes\Computed;
use Livewire\Component;
use TiPowerUp\OrangeTw\Livewire\Concerns\SearchesNearby;

class LocalSearch extends Component
{
    use SearchesNearby;

    public bool $hideSearch = false;

    public function mount(): void
    {
        $this->mountSearchesNearby();
    }

    #[Computed]
    public function enabledLocationCount(): int
    {
        return LocationModel::whereIsEnabled()->count();
    }

    #[Computed]
    public function isSingleLocation(): bool
    {
        return $this->enabledLocationCount === 1;
    }

    #[Computed]
    public function defaultLocation(): ?LocationModel
    {
        return LocationModel::whereIsEnabled()->first();
    }

    #[Computed]
    public function isOpened(): bool
    {
        return Location::isOpened();
    }

    public static function componentMeta(): array
    {
        return [
            'code' => 'tipowerup-orange-tw::local-search',
            'name' => 'Local Search Component',
            'description' => 'Search for nearby restaurant locations',
        ];
    }

    public function defineProperties(): array
    {
        return array_merge([
            'hideSearch' => [
                'label' => 'Hide the search field and display a view menu button.',
                'type' => 'switch',
            ],
        ], $this->definePropertiesSearchNearby());
    }

    public function render()
    {
        return view('tipowerup-orange-tw::livewire.local-search.local-search');
    }
}
