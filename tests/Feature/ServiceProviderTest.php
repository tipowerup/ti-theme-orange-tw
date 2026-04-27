<?php

declare(strict_types=1);

use TiPowerUp\OrangeTw\ServiceProvider;

it('boots without errors', function (): void {
    $provider = app()->getProvider(ServiceProvider::class);

    expect($provider)->toBeInstanceOf(ServiceProvider::class);
});

it('registers the logout route', function (): void {
    $route = collect(app('router')->getRoutes())
        ->first(fn ($r) => $r->getName() === 'tipowerup.orange-tw.account.logout');

    expect($route)->not->toBeNull();
    expect($route->methods())->toContain('GET');
    expect($route->uri())->toEndWith('logout');
});

it('exposes the expected theme code', function (): void {
    $provider = app()->getProvider(ServiceProvider::class);
    $reflection = new ReflectionMethod($provider, 'themeCode');
    $reflection->setAccessible(true);

    expect($reflection->invoke($provider))->toBe('tipowerup-orange-tw');
});
