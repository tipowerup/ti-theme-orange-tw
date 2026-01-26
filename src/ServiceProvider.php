<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw;

use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\View;
use Igniter\Flame\Support\Facades\Igniter;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'tipowerup-orange-tw');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'tipowerup.orange-tw');

        ViewFacade::composer('*', function(View $view): void {
            if (!Igniter::runningInAdmin() && controller()) {
                $view->with([
                    'theme' => controller()->getTheme(),
                    'page' => controller()->getPage(),
                    'site_logo' => setting('site_logo'),
                    'site_name' => setting('site_name'),
                ]);
            }
        });
    }
}
