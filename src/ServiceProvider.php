<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw;

use Igniter\Admin\Widgets\Form;
use Igniter\Cart\Http\Middleware\CartMiddleware;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Local\Http\Middleware\CheckLocation;
use Igniter\Main\Classes\MainController;
use Igniter\Main\Classes\ThemeManager;
use Igniter\Main\Template\Page;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\System\Classes\ComponentManager;
use Igniter\User\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Livewire;
use Spatie\GoogleFonts\GoogleFonts;
use Symfony\Component\Finder\Finder;
use TiPowerUp\OrangeTw\Http\Controllers\Logout;
use TiPowerUp\OrangeTw\Livewire\Features\SupportFlashMessages;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register(): void
    {
        if (!$this->app->runningUnitTests()) {
            Livewire::componentHook(SupportFlashMessages::class);
        }
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'tipowerup-orange-tw');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'tipowerup.orange-tw');
        $this->loadBladeComponentsFrom(__DIR__.'/View/Components');
        $this->loadLivewireComponentsFrom(__DIR__.'/Livewire');

        // Define layout aliases
        $this->app['view']->addNamespace('layouts', __DIR__.'/../resources/views/_layouts');

        // Register view composer for theme variables
        ViewFacade::composer('*', function (View $view): void {
            if (!Igniter::runningInAdmin() && controller()) {
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

        $this->configureLivewire();
        $this->configurePageAuthentication();
        $this->configureGoogleFonts();
        $this->defineRoutes();
    }

    protected function loadLivewireComponentsFrom(string|array $path): void
    {
        $configurableComponents = [];

        $components = (new Finder)->files()->in($path)
            ->name('*.php')
            ->notName('*Form.php')
            ->notPath('Concerns')
            ->notPath('Features')
            ->notPath('Forms')
            ->ignoreDotFiles(true)
            ->ignoreVCS(true);

        foreach ($components as $component) {
            $componentName = Str::of($component->getRelativePathname())->before('.php')->kebab()->replace(DIRECTORY_SEPARATOR.'-', '.');
            $componentClass = Str::of($component->getRelativePathname())->before('.php')->replace('/', '\\')->start('TiPowerUp\\OrangeTw\\Livewire\\')->toString();

            if (is_subclass_of($componentClass, Component::class)) {
                if (in_array(ConfigurableComponent::class, class_uses_recursive($componentClass))) {
                    $configurableComponents[] = $componentClass;
                } else {
                    Livewire::component('tipowerup-orange-tw::'.$componentName, $componentClass);
                }
            }
        }

        resolve(ComponentManager::class)->registerCallback(function ($manager) use ($configurableComponents): void {
            foreach ($configurableComponents as $componentClass) {
                if (method_exists($componentClass, 'componentMeta')) {
                    $manager->registerComponent($componentClass, $componentClass::componentMeta());
                }
            }
        });
    }

    protected function loadBladeComponentsFrom(string|array $path): void
    {
        $components = (new Finder)->files()->in($path)
            ->name('*.php')
            ->ignoreDotFiles(true)
            ->ignoreVCS(true);

        resolve(ComponentManager::class)->registerCallback(function ($manager) use ($components): void {
            foreach ($components as $component) {
                $componentName = Str::of($component->getRelativePathname())->before('.php')->kebab()->replace(DIRECTORY_SEPARATOR.'-', '.');
                $componentClass = Str::of($component->getRelativePathname())->before('.php')->replace('/', '\\')->start('TiPowerUp\\OrangeTw\\View\\Components\\')->toString();

                if (in_array(ConfigurableComponent::class, class_uses_recursive($componentClass))) {
                    $manager->registerComponent($componentClass, $componentClass::componentMeta());
                } else {
                    Blade::component('tipowerup-orange-tw::'.$componentName, $componentClass);
                }
            }
        });
    }

    protected function configurePageAuthentication(): void
    {
        if (!Igniter::runningInAdmin()) {
            MainController::extend(function ($controller): void {
                $controller->bindEvent('page.init', function ($page) {
                    if (!isset($page->security) || $page->security == 'all') {
                        return;
                    }

                    $isAuthenticated = Auth::check();
                    if ($page->security == 'customer' && !$isAuthenticated) {
                        return redirect()->guest(page_url('home'));
                    }

                    if ($page->security == 'guest' && $isAuthenticated) {
                        return redirect()->guest(page_url('home'));
                    }
                });
            });
        }

        Event::listen('admin.form.extendFields', function (Form $widget): void {
            if (!isset($widget->data->fileSource)) {
                return;
            }

            if ($widget->data->fileSource instanceof Page) {
                $widget->addFields([
                    'settings[security]' => [
                        'tab' => 'igniter::system.themes.text_tab_meta',
                        'label' => 'tipowerup.orange-tw::default.label_security',
                        'type' => 'checkboxtoggle',
                        'default' => 'all',
                        'span' => 'right',
                        'options' => [
                            'all' => 'tipowerup.orange-tw::default.text_all',
                            'customer' => 'tipowerup.orange-tw::default.text_customer',
                            'guest' => 'tipowerup.orange-tw::default.text_guest',
                        ],
                        'comment' => 'tipowerup.orange-tw::default.help_security',
                    ],
                ], 'primary');
            }
        });
    }

    protected function configureGoogleFonts(): void
    {
        $this->callAfterResolving(GoogleFonts::class, function (GoogleFonts $googleFonts): void {
            $themeData = resolve(ThemeManager::class)->getActiveTheme()?->getCustomData() ?? [];
            if (array_get($themeData, 'font-download')) {
                config()->set('google-fonts.fonts.default', array_get($themeData, 'font-url'));
            }
        });
    }

    protected function defineRoutes(): void
    {
        Route::middleware(config('igniter-routes.middleware', []))
            ->domain(config('igniter-routes.domain'))
            ->name('tipowerup.orange-tw.')
            ->prefix(Igniter::uri())
            ->group(function ($router): void {
                $router->get('logout', Logout::class)->name('account.logout');
            });
    }

    protected function configureLivewire(): void
    {
        Livewire::addPersistentMiddleware([
            CheckLocation::class,
            CartMiddleware::class,
        ]);

        config()->set('livewire.pagination_theme', 'tailwind');
    }
}
