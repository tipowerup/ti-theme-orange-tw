<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\View\Components;

use Igniter\Local\Classes\WorkingSchedule;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\ReviewSettings;
use Illuminate\View\Component;
use TiPowerUp\OrangeTw\Data\LocationData;

final class LocalHeader extends Component
{
    public function __construct(
        public bool $showThumb = true,
        public int $localThumbWidth = 320,
        public int $localThumbHeight = 160,
        public int $reviewPerPage = 10,
        public string $reviewSortOrder = 'created_at desc',
        public string $reviewsPage = 'local.reviews',
        public string $currentPage = 'local.menus',
    ) {}

    public function render()
    {
        if (! Location::current()) {
            return '';
        }

        Location::current()->loadCount([
            'reviews' => fn ($q) => $q->isApproved(),
        ]);

        return view('tipowerup-orange-tw::components.local-header', [
            'locationInfo' => LocationData::current(),
            'allowReviews' => ReviewSettings::allowReviews(),
        ]);
    }

    public function currentSchedule($locationInfo): WorkingSchedule
    {
        return $this->currentPage === 'local.menus'
            ? $locationInfo->orderType()->getSchedule()
            : $locationInfo->openingSchedule();
    }
}
