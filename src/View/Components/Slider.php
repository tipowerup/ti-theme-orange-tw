<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\View\Components;

use Igniter\Frontend\Models\Slider as SliderModel;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Main\Classes\ThemeManager;
use Igniter\Main\Traits\ConfigurableComponent;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Override;

final class Slider extends Component
{
    use ConfigurableComponent;

    public array|Collection $slides = [];

    public bool $useDemoSlides = false;

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

    public static function getCodeOptions(): array
    {
        return SliderModel::lists('name', 'code')->all();
    }

    #[Override]
    public function shouldRender(): bool
    {
        return count($this->slides()) > 0 || $this->useDemoSlides;
    }

    #[Override]
    public function render()
    {
        // Populate $this->slides + $this->useDemoSlides from the configured
        // frontend slider code, if any.
        $this->slides();

        // Theme-level banners from the Customize "Banners" tab take precedence.
        // They render through the same code path as demo slides (plain arrays
        // with image / title / description).
        $themeBanners = $this->themeBanners();
        $useDemoSlides = ! empty($themeBanners) || $this->useDemoSlides;
        $demoSlides = $themeBanners ?: $this->demoSlides();

        $slideItems = $useDemoSlides ? $demoSlides : $this->slides;
        $slideCount = count($slideItems);

        return view('tipowerup-orange-tw::components.slider', [
            'slides' => $this->slides,
            'useDemoSlides' => $useDemoSlides,
            'demoSlides' => $demoSlides,
            'slideItems' => $slideItems,
            'slideCount' => $slideCount,
            'ctaUrl' => $this->resolveCtaUrl(),
        ]);
    }

    /**
     * Build slide payloads from the theme's admin-uploaded banner images.
     * CTA fields are pre-normalized (trimmed, external-link detected) so the
     * blade template doesn't have to do its own string handling.
     *
     * @return array<int, array{image: string, title: string, description: string, cta_text: string, cta_link: string, cta_is_external: bool}>
     */
    protected function themeBanners(): array
    {
        $theme = resolve(ThemeManager::class)->getActiveTheme();
        $banners = $theme?->banners ?? [];

        if (! is_array($banners) || $banners === []) {
            return [];
        }

        $slides = [];
        foreach ($banners as $banner) {
            $image = $banner['image'] ?? null;
            if (empty($image)) {
                continue;
            }

            $slides[] = $this->normalizeSlide([
                'image' => media_url($image),
                'title' => $banner['title'] ?? '',
                'description' => $banner['description'] ?? '',
                'cta_text' => $banner['cta_text'] ?? '',
                'cta_link' => $banner['cta_link'] ?? '',
            ]);
        }

        return $slides;
    }

    /**
     * Normalize a slide array into the shape the blade expects:
     * - `cta_text` / `cta_link` are trimmed strings
     * - `cta_is_external` is true when `cta_link` is an absolute http(s) URL.
     *   The blade uses it to decide whether to add `wire:navigate` (skipped
     *   on external links so the browser does a full navigation).
     *
     * @param  array<string, mixed>  $slide
     * @return array{image: string, title: string, description: string, cta_text: string, cta_link: string, cta_is_external: bool}
     */
    protected function normalizeSlide(array $slide): array
    {
        $ctaText = trim((string) ($slide['cta_text'] ?? ''));
        $ctaLink = trim((string) ($slide['cta_link'] ?? ''));

        return [
            'image' => (string) ($slide['image'] ?? ''),
            'title' => (string) ($slide['title'] ?? ''),
            'description' => (string) ($slide['description'] ?? ''),
            'cta_text' => $ctaText,
            'cta_link' => $ctaLink,
            'cta_is_external' => $ctaLink !== '' && (bool) preg_match('#^https?://#', $ctaLink),
        ];
    }

    protected function resolveCtaUrl(): string
    {
        return LocationModel::whereIsEnabled()->count() === 1
            ? restaurant_url('local/menus')
            : page_url('locations');
    }

    protected function slides(): Collection|array
    {
        if ($this->code && $slider = SliderModel::whereCode($this->code)->first()) {
            /** @var SliderModel $slider */
            $this->slides = $slider->images;
        }

        if (empty($this->slides) || count($this->slides) === 0) {
            $this->useDemoSlides = true;
        }

        return $this->slides;
    }

    /**
     * Get demo slides when no slider is configured. Each slide is normalized
     * through the same shape as theme banners so the blade reads a single
     * structure regardless of source.
     *
     * @return array<int, array{image: string, title: string, description: string, cta_text: string, cta_link: string, cta_is_external: bool}>
     */
    protected function demoSlides(): array
    {
        $raw = [];
        for ($i = 1; $i <= 5; $i++) {
            $raw[] = [
                'image' => asset("vendor/tipowerup-orange-tw/images/slides/slide-{$i}.jpg"),
                'title' => lang("tipowerup.orange-tw::default.slider.demo_slide_{$i}_title"),
                'description' => lang("tipowerup.orange-tw::default.slider.demo_slide_{$i}_text"),
            ];
        }

        return array_map(fn (array $slide): array => $this->normalizeSlide($slide), $raw);
    }
}
