<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\Livewire;

use Livewire\Component;
use TiPowerUp\OrangeTw\Livewire\Concerns\WithReviews;

class ReviewList extends Component
{
    use WithReviews;

    public function mount(): void
    {
        $this->mountListReviews();
    }

    public function render()
    {
        return view('tipowerup-orange-tw::livewire.review-list');
    }
}
