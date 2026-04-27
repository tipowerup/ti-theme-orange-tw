<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw;

use TiPowerUp\OrangeTw\Http\Controllers\Logout;
use TiPowerUp\ThemeToolkit\AbstractThemeServiceProvider;

class ServiceProvider extends AbstractThemeServiceProvider
{
    protected function themeCode(): string
    {
        return 'tipowerup-orange-tw';
    }

    /**
     * @return array<int, array{0: string, 1: string, 2: class-string, 3: string}>
     */
    protected function routes(): array
    {
        return [
            ['get', 'logout', Logout::class, 'account.logout'],
        ];
    }
}
