<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw;

use Igniter\Main\Models\Theme;
use Illuminate\Support\Facades\View;
use Override;
use TiPowerUp\OrangeTw\Http\Controllers\Logout;
use TiPowerUp\ThemeToolkit\AbstractThemeServiceProvider;
use TiPowerUp\ThemeToolkit\Support\ThemePayloadResolver;

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

    #[Override]
    public function boot(): void
    {
        parent::boot();

        // Push the theme's views path into `config('view.paths')` so
        // Laravel's `RegisterErrorViewPaths` (invoked lazily by the
        // exception handler) sees `<viewsPath>/errors/` and resolves
        // `errors::404` / `errors::500` etc. to the theme's friendly
        // templates instead of TastyIgniter core's minimal fallback.
        $paths = $this->app['config']['view.paths'] ?? [];
        if (! in_array($this->viewsPath(), $paths, true)) {
            array_unshift($paths, $this->viewsPath());
            $this->app['config']->set('view.paths', $paths);
        }

        // Inject admin-customised theme colours into error pages. The
        // toolkit's wildcard view composer early-returns when there's no
        // active TI controller — which is exactly the case Laravel's
        // exception handler renders error views in. Resolve theme data
        // directly from the active Theme row so the error layout picks up
        // the same `themeBrandStyle` / `themeNeutralStyle` payload the
        // main theme uses.
        View::composer($this->viewNamespace().'::errors.layout', function ($view): void {
            $themeData = Theme::where('code', $this->themeCode())->value('data') ?? [];

            $resolver = resolve(ThemePayloadResolver::class);

            $view->with([
                'themeBrandStyle' => $resolver->buildBrandStyle($themeData),
                'themeNeutralStyle' => $resolver->buildNeutralStyle($themeData),
            ]);
        });
    }
}
