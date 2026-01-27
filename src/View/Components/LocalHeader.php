<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\View\Components;

use Igniter\Local\Classes\WorkingSchedule;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Review as ReviewModel;
use Igniter\Local\Models\ReviewSettings;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\System\Facades\Assets;
use Illuminate\View\Component;
use Override;
use TiPowerUp\OrangeTw\Data\LocationData;

final class LocalHeader extends Component
{
    use ConfigurableComponent;
    use UsesPage;

    public function __construct(
        public bool $showThumb = true,
        public int $localThumbWidth = 320,
        public int $localThumbHeight = 160,
        public int $reviewPerPage = 10,
        public string $reviewSortOrder = 'created_at desc',
        public string $reviewsPage = 'local.reviews',
        public string $currentPage = 'local.menus',
    ) {}

    public static function componentMeta(): array
    {
        return [
            'code' => 'tipowerup-orange-tw::local-header',
            'name' => 'tipowerup.orange-tw::default.component_local_header_title',
            'description' => 'tipowerup.orange-tw::default.component_local_header_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'showThumb' => [
                'label' => 'Display the location image thumb.',
                'type' => 'switch',
            ],
            'localThumbWidth' => [
                'label' => 'Location thumb width',
                'type' => 'number',
            ],
            'localThumbHeight' => [
                'label' => 'Location thumb height',
                'type' => 'number',
            ],
            'reviewPerPage' => [
                'label' => 'Number of reviews to display per page',
                'type' => 'number',
                'validationRule' => 'integer|min:1',
            ],
            'reviewSortOrder' => [
                'label' => 'Default sort order of reviews.',
                'type' => 'select',
                'options' => self::getSortOrderOptions(...),
                'validationRule' => 'required|string',
            ],
            'reviewsPage' => [
                'label' => 'Page to redirect to when the "see more reviews" link is clicked.',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
        ];
    }

    public static function getSortOrderOptions(): array
    {
        return collect((new ReviewModel)->queryModifierGetSorts())
            ->mapWithKeys(fn ($value, $key): array => [$value => $value])
            ->all();
    }

    #[Override]
    public function shouldRender(): bool
    {
        return ! is_null(resolve('location')->current());
    }

    #[Override]
    public function render()
    {
        Assets::addCss('igniter.local::/css/starrating.css', 'starrating-css');
        Assets::addJs('igniter.local::/js/starrating.js', 'starrating-js');

        Location::current()->loadCount([
            'reviews' => fn ($q) => $q->isApproved(),
        ]);

        $locationInfo = LocationData::current();

        return view('tipowerup-orange-tw::components.local-header', [
            'locationInfo' => $locationInfo,
            'allowReviews' => ReviewSettings::allowReviews(),
            'schedule' => $this->currentSchedule($locationInfo),
        ]);
    }

    public function listReviews()
    {
        if (! $location = Location::current()) {
            return null;
        }

        return ReviewModel::query()
            ->with([
                'customer' => fn ($query) => $query->select('customer_id', 'address_id'),
                'customer.address' => fn ($query) => $query->select('address_id', 'customer_id', 'city'),
            ])
            ->isApproved()
            ->listFrontEnd([
                'page' => 1,
                'pageLimit' => $this->reviewPerPage,
                'sort' => $this->reviewSortOrder,
                'location' => $location->getKey(),
            ]);
    }

    public function currentSchedule($locationInfo): WorkingSchedule
    {
        return $this->currentPage === 'local.menus'
            ? $locationInfo->orderType()->getSchedule()
            : $locationInfo->openingSchedule();
    }
}
