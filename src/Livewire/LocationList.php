<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\Livewire;

use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Local\Models\ReviewSettings;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\User\Facades\AdminAuth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use TiPowerUp\OrangeTw\Data\LocationData;

final class LocationList extends Component
{
    use ConfigurableComponent;
    use WithPagination;

    public string $distanceUnit = 'mi';

    public string $menusPage = 'local.menus';

    public int $itemPerPage = 20;

    public bool $showThumb = true;

    public int $thumbWidth = 95;

    public int $thumbHeight = 80;

    #[Url]
    public string $search = '';

    #[Url]
    public string $orderBy = 'distance';

    #[Url]
    public string $orderType = LocationModel::DELIVERY;

    #[Url]
    public array $filter = [];

    public string $searchQuery = '';

    public static function componentMeta(): array
    {
        return [
            'code' => 'tipowerup-orange-tw::location-list',
            'name' => 'Location List',
            'description' => 'Displays a list of locations',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'menusPage' => [
                'label' => 'Page to redirect to when viewing location menus.',
                'type' => 'select',
                'options' => [self::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
            'itemPerPage' => [
                'label' => 'Number of locations to display per page.',
                'type' => 'number',
                'validationRule' => 'required|numeric|min:0',
            ],
            'showThumb' => [
                'label' => 'Display location image thumb.',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
        ];
    }

    public function mount(): void
    {
        $this->distanceUnit = setting('distance_unit');
        $this->searchQuery = Location::userPosition()->format() ?? '';
    }

    public function render()
    {
        return view('tipowerup-orange-tw::livewire.location-list', [
            'allowReviews' => ReviewSettings::allowReviews(),
            'searchQueryPosition' => Location::userPosition(),
            'locationsList' => $this->loadList(),
        ]);
    }

    #[Computed]
    public function orderTypes()
    {
        return LocationModel::getOrderTypeOptions();
    }

    #[Computed]
    public function sorters()
    {
        return [
            'distance' => ['name' => 'Distance', 'condition' => 'distance asc'],
            'newest' => ['name' => 'Newest', 'condition' => 'location_id desc'],
            'rating' => ['name' => 'Rating', 'condition' => 'reviews_count desc'],
            'name' => ['name' => 'Name', 'condition' => 'location_name asc'],
        ];
    }

    public function onUpdateSearchQuery(): void
    {
        $this->validate([
            'searchQuery' => 'required|string|min:3',
        ]);

        Location::updateUserPosition($this->searchQuery);
        $this->resetPage();
    }

    protected function loadList()
    {
        $options = [];

        if (! optional(AdminAuth::getUser())->hasPermission('Admin.Locations')) {
            $options['enabled'] = true;
        }

        if ($coordinates = Location::userPosition()->getCoordinates()) {
            $options['position'] = [[
                'latitude' => $coordinates->getLatitude(),
                'longitude' => $coordinates->getLongitude(),
            ]];
        }

        $options['pageLimit'] = $this->itemPerPage;
        $options['search'] = $this->search;
        $options['sort'] = array_get($this->sorters, $this->orderBy.'.condition', 'location_name asc');

        $query = LocationModel::query()->withCount([
            'reviews' => fn ($q) => $q->isApproved(),
        ])->with([
            'media',
            'delivery_areas',
            'settings',
            'working_hours',
            'country',
            'reviews' => fn ($q) => $q->isApproved()->select('delivery', 'service', 'quality'),
        ]);

        unset($options['pageLimit']);

        $results = $query->listFrontEnd($options)->paginate($this->itemPerPage, $this->getPage());
        $collection = $results->getCollection()
            ->filter(fn ($location): bool => array_get($location->getSettings($this->orderType), 'is_enabled', 1) == 1)
            ->map(fn ($location): LocationData => new LocationData($location));

        return $results->setCollection($collection);
    }
}
