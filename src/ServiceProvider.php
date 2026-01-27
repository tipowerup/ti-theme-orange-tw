<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw;

use Igniter\Flame\Support\Facades\Igniter;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\View;
use Livewire\Livewire;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'tipowerup-orange-tw');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'tipowerup.orange-tw');

        // Register Livewire components
        Livewire::component('tipowerup-orange-tw::location-list', \TiPowerUp\OrangeTw\Livewire\LocationList::class);
        Livewire::component('tipowerup-orange-tw::menu-item-list', \TiPowerUp\OrangeTw\Livewire\MenuItemList::class);
        Livewire::component('tipowerup-orange-tw::account-settings', \TiPowerUp\OrangeTw\Livewire\AccountSettings::class);
        Livewire::component('tipowerup-orange-tw::order-preview', \TiPowerUp\OrangeTw\Livewire\OrderPreview::class);
        Livewire::component('tipowerup-orange-tw::booking', \TiPowerUp\OrangeTw\Livewire\Booking::class);
        Livewire::component('tipowerup-orange-tw::local-search', \TiPowerUp\OrangeTw\Livewire\LocalSearch::class);
        Livewire::component('tipowerup-orange-tw::newsletter-subscribe-form', \TiPowerUp\OrangeTw\Livewire\NewsletterSubscribeForm::class);
        Livewire::component('tipowerup-orange-tw::address-book', \TiPowerUp\OrangeTw\Livewire\AddressBook::class);
        Livewire::component('tipowerup-orange-tw::reservation-list', \TiPowerUp\OrangeTw\Livewire\ReservationList::class);
        Livewire::component('tipowerup-orange-tw::leave-review', \TiPowerUp\OrangeTw\Livewire\LeaveReview::class);
        Livewire::component('tipowerup-orange-tw::captcha', \TiPowerUp\OrangeTw\Livewire\Captcha::class);
        Livewire::component('tipowerup-orange-tw::contact', \TiPowerUp\OrangeTw\Livewire\Contact::class);
        Livewire::component('tipowerup-orange-tw::reservation-preview', \TiPowerUp\OrangeTw\Livewire\ReservationPreview::class);
        Livewire::component('tipowerup-orange-tw::review-list', \TiPowerUp\OrangeTw\Livewire\ReviewList::class);
        Livewire::component('tipowerup-orange-tw::reset-password', \TiPowerUp\OrangeTw\Livewire\ResetPassword::class);
        Livewire::component('tipowerup-orange-tw::socialite', \TiPowerUp\OrangeTw\Livewire\Socialite::class);
        Livewire::component('tipowerup-orange-tw::flash-message', \TiPowerUp\OrangeTw\Livewire\FlashMessage::class);
        Livewire::component('tipowerup-orange-tw::fulfillment-modal', \TiPowerUp\OrangeTw\Livewire\FulfillmentModal::class);
        Livewire::component('tipowerup-orange-tw::modal', \TiPowerUp\OrangeTw\Livewire\Modal::class);

        // Auto-load Blade components
        Blade::componentNamespace('TiPowerUp\\OrangeTw\\View\\Components', 'tipowerup-orange-tw');

        // Define layout aliases
        $this->app['view']->addNamespace('layouts', __DIR__.'/../resources/views/_layouts');

        // Register view composer for theme variables
        ViewFacade::composer('*', function (View $view): void {
            if (! Igniter::runningInAdmin() && controller()) {
                $theme = controller()->getTheme();
                $page = controller()->getPage();

                $view->with([
                    'theme' => $theme,
                    'page' => $page,
                    'site_logo' => setting('site_logo'),
                    'site_name' => setting('site_name'),
                    'themeConfig' => $theme?->config ?? [],
                ]);
            }
        });
    }
}
