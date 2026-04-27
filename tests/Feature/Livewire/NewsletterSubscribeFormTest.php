<?php

declare(strict_types=1);

use Livewire\Livewire;
use TiPowerUp\OrangeTw\Livewire\NewsletterSubscribeForm;

it('rejects an empty email', function (): void {
    Livewire::test(NewsletterSubscribeForm::class)
        ->set('email', '')
        ->call('subscribe')
        ->assertHasErrors(['email' => 'required']);
});

it('rejects a malformed email', function (): void {
    Livewire::test(NewsletterSubscribeForm::class)
        ->set('email', 'not-an-email')
        ->call('subscribe')
        ->assertHasErrors(['email' => 'email']);
});

it('rejects an email longer than 255 characters', function (): void {
    Livewire::test(NewsletterSubscribeForm::class)
        ->set('email', str_repeat('a', 250).'@b.com')
        ->call('subscribe')
        ->assertHasErrors(['email' => 'max']);
});

it('flags subscribed and clears the email on success', function (): void {
    Livewire::test(NewsletterSubscribeForm::class)
        ->set('email', 'user@example.com')
        ->call('subscribe')
        ->assertSet('subscribed', true)
        ->assertSet('email', '')
        ->assertHasNoErrors();
});
