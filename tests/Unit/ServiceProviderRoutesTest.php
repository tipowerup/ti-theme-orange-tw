<?php

declare(strict_types=1);

use TiPowerUp\OrangeTw\Http\Controllers\Logout;
use TiPowerUp\OrangeTw\ServiceProvider;

it('declares the logout route as a tuple matching the toolkit contract', function (): void {
    $provider = new ServiceProvider(app());

    $reflection = new ReflectionMethod($provider, 'routes');
    $reflection->setAccessible(true);

    $routes = $reflection->invoke($provider);

    expect($routes)->toBeArray()->toHaveCount(1);

    [$method, $uri, $action, $name] = $routes[0];

    expect($method)->toBe('get');
    expect($uri)->toBe('logout');
    expect($action)->toBe(Logout::class);
    expect($name)->toBe('account.logout');
});
