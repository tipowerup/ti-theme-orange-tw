<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\Livewire;

use Igniter\Main\Traits\ConfigurableComponent;
use Livewire\Component;
use TiPowerUp\OrangeTw\Livewire\Concerns\WithReviews;

class ReviewList extends Component
{
    use ConfigurableComponent;
    use WithReviews;

    public static function componentMeta(): array
    {
        return [
            'code' => 'tipowerup-orange-tw::review-list',
            'name' => 'Review List',
            'description' => 'Displays a list of reviews',
        ];
    }

    public function defineProperties(): array
    {
        return [];
    }

    public function mount(): void
    {
        $this->mountListReviews();
    }

    public function render()
    {
        return view('tipowerup-orange-tw::livewire.review-list');
    }
}
