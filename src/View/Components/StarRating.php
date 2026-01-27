<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\View\Components;

use Igniter\Local\Models\Review as ReviewModel;
use Illuminate\View\Component;
use Override;

final class StarRating extends Component
{
    protected static ?array $hints = null;

    public function __construct(
        public string $name = '',
        public float $score = 0,
        public float $max = 5,
        public bool $readOnly = true,
    ) {
        $this->max = max(1, count($this->getHints()));
    }

    #[Override]
    public function render()
    {
        return view('tipowerup-orange-tw::components.star-rating', [
            'hints' => $this->getHints(),
        ]);
    }

    protected function getHints()
    {
        return self::$hints ??= (new ReviewModel)->getRatingOptions();
    }
}
