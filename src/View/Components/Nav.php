<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\View\Components;

use Igniter\Pages\Classes\MenuManager;
use Igniter\Pages\Models\Menu;
use Illuminate\View\Component;

class Nav extends Component
{
    public array $menuItems = [];

    public string $activePage;

    public function __construct(public string $code)
    {
        $this->activePage = controller()->getPage()->getId();
    }

    public function render(): \Illuminate\View\View
    {
        return view('tipowerup-orange-tw::includes.navs.'.$this->code, [
            'menuItems' => $this->menuItems(),
        ]);
    }

    protected function menuItems(): array
    {
        $themeCode = controller()->getTheme()->getName();

        if ($menu = Menu::whereCode($this->code)->where('theme_code', $themeCode)->first()) {
            $this->menuItems = resolve(MenuManager::class)->generateReferences($menu, controller()->getLayout());
        }

        return $this->menuItems;
    }
}
