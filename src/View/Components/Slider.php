<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\View\Components;

use Igniter\Frontend\Models\Slider as SliderModel;
use Igniter\Main\Traits\ConfigurableComponent;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Override;

final class Slider extends Component
{
    use ConfigurableComponent;

    public array|Collection $slides = [];

    public function __construct(
        public string $code = 'home-slider',
        public string $height = '60vh',
        public int $delayInterval = 5000,
        public bool $hideControls = false,
        public bool $hideIndicators = false,
        public bool $hideCaptions = false,
    ) {}

    public static function componentMeta(): array
    {
        return [
            'code' => 'tipowerup-orange-tw::slider',
            'name' => 'Slider Component',
            'description' => 'Display image carousel with auto-play',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'code' => [
                'label' => 'Slider',
                'type' => 'select',
                'validationRule' => 'required|alpha_dash',
            ],
            'height' => [
                'label' => 'Height',
                'span' => 'left',
                'type' => 'text',
                'validationRule' => 'required|string',
            ],
            'delayInterval' => [
                'label' => 'Interval (ms)',
                'span' => 'right',
                'type' => 'number',
                'validationRule' => 'required|integer',
            ],
            'hideControls' => [
                'label' => 'Hide Controls',
                'span' => 'left',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'hideIndicators' => [
                'label' => 'Hide Indicators',
                'span' => 'left',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'hideCaptions' => [
                'label' => 'Hide Captions',
                'span' => 'right',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
        ];
    }

    public static function getCodeOptions()
    {
        return SliderModel::lists('name', 'code')->all();
    }

    #[Override]
    public function render()
    {
        return view('tipowerup-orange-tw::components.slider', [
            'slides' => $this->slides(),
        ]);
    }

    protected function slides(): Collection|array
    {
        if ($this->code && $slider = SliderModel::whereCode($this->code)->first()) {
            /** @var SliderModel $slider */
            $this->slides = $slider->images;
        }

        return $this->slides;
    }
}
