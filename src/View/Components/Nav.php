<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\View\Components;

use Igniter\Pages\Classes\MenuManager;
use Igniter\Pages\Models\Menu;
use Illuminate\View\Component;
use Illuminate\View\View;

class Nav extends Component
{
    public string $activePage;

    public function __construct(public string $code)
    {
        $this->activePage = controller()->getPage()->getId();
    }

    public function render(): View
    {
        return view('tipowerup-orange-tw::includes.navs.'.$this->code, [
            'menuItems' => $this->resolveMenuItems(),
        ]);
    }

    protected function resolveMenuItems(): array
    {
        $themeCode = controller()->getTheme()->getName();

        $menu = Menu::whereCode($this->code)->where('theme_code', $themeCode)->first();

        if (! $menu) {
            return [];
        }

        return resolve(MenuManager::class)->generateReferences($menu, controller()->getLayout());
    }
}
