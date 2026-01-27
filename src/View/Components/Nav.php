<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\View\Components;

use Illuminate\View\Component;

class Nav extends Component
{
    public string $href;

    public bool $active;

    public string $class;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $href,
        ?bool $active = null,
        string $class = ''
    ) {
        $this->href = $href;
        $this->active = $active ?? $this->isActive($href);
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Illuminate\View\View
    {
        return view('tipowerup-orange-tw::components.nav');
    }

    /**
     * Determine if the link is active.
     */
    protected function isActive(string $href): bool
    {
        $currentPath = request()->path();
        $linkPath = parse_url($href, PHP_URL_PATH);

        if ($linkPath === '/') {
            return $currentPath === '/';
        }

        return str_starts_with($currentPath, ltrim($linkPath, '/'));
    }

    /**
     * Get the combined classes for the nav link.
     */
    public function getClasses(): string
    {
        $baseClasses = 'transition-colors duration-200';
        $activeClasses = $this->active
            ? 'text-primary font-semibold'
            : 'text-text hover:text-primary';

        return trim("{$baseClasses} {$activeClasses} {$this->class}");
    }
}
