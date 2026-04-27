<?php

declare(strict_types=1);

use Igniter\User\Actions\LogoutCustomer;
use Illuminate\Http\RedirectResponse;
use TiPowerUp\OrangeTw\Http\Controllers\Logout;

beforeEach(function (): void {
    // Cart facade resolves through `'cart'` — bind a mock so the facade
    // doesn't try to construct the real CartManager (which depends on the
    // cart extension's full bootstrap).
    $cart = Mockery::mock();
    $cart->shouldReceive('keepSession')->andReturnUsing(fn ($cb) => $cb());
    app()->instance('cart', $cart);
});

it('redirects home and runs logout under Cart::keepSession', function (): void {
    $logout = Mockery::mock(LogoutCustomer::class);
    $logout->shouldReceive('handle')->once();
    app()->instance(LogoutCustomer::class, $logout);

    $response = (new Logout)();

    expect($response)->toBeInstanceOf(RedirectResponse::class);
    expect($response->getTargetUrl())->toBe(url('/'));
});

it('preserves the cart session by routing logout through Cart::keepSession', function (): void {
    $logout = Mockery::mock(LogoutCustomer::class);
    $logout->shouldReceive('handle')->once();
    app()->instance(LogoutCustomer::class, $logout);

    $callbackInvoked = false;
    $cart = Mockery::mock();
    $cart->shouldReceive('keepSession')
        ->once()
        ->andReturnUsing(function ($cb) use (&$callbackInvoked) {
            $callbackInvoked = true;
            $cb();
        });
    app()->instance('cart', $cart);

    (new Logout)();

    expect($callbackInvoked)->toBeTrue();
});
