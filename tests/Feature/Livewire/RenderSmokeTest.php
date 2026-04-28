<?php

declare(strict_types=1);

use Igniter\Flame\Flash\Message;
use Illuminate\Support\Collection;
use Livewire\Livewire;
use TiPowerUp\OrangeTw\Livewire\FlashMessage;
use TiPowerUp\ThemeToolkit\Livewire\NewsletterSubscribeForm;

/**
 * Render-level smoke tests — boot each Livewire component and assert it
 * mounts + renders without throwing. Cheaper than browser tests, catches
 * the 80% case (missing facade binding, undefined blade var, broken
 * defineProperties() after a refactor).
 *
 * Components that depend on heavy TI services (Cart, Auth-loaded customer,
 * BookingManager, ThemeManager) are out of scope here — see browser tests.
 */
it('renders the NewsletterSubscribeForm in its initial state', function (): void {
    Livewire::test(NewsletterSubscribeForm::class)
        ->assertOk()
        ->assertSet('subscribed', false)
        ->assertSet('email', '');
});

it('renders the NewsletterSubscribeForm after a successful subscribe', function (): void {
    Livewire::test(NewsletterSubscribeForm::class)
        ->set('email', 'test@example.com')
        ->call('subscribe')
        ->assertOk()
        ->assertSet('subscribed', true);
});

it('renders the FlashMessage component with no flashes', function (): void {
    $flash = Mockery::mock();
    $flash->shouldReceive('all')->andReturn(new Collection);
    app()->instance('flash', $flash);

    Livewire::test(FlashMessage::class)
        ->assertOk()
        ->assertCount('messages', 0);
});

it('renders the FlashMessage component with a single flash of each level', function (string $level): void {
    $flash = Mockery::mock();
    $flash->shouldReceive('all')->andReturn(new Collection([
        new Message(['message' => 'hello', 'level' => $level]),
    ]));
    app()->instance('flash', $flash);

    Livewire::test(FlashMessage::class)
        ->assertOk()
        ->assertCount('messages', 1);
})->with(['info', 'success', 'warning', 'error', 'danger']);
