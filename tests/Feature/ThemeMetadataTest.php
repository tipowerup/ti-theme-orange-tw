<?php

declare(strict_types=1);

it('ships a valid composer.json declaring the theme code', function (): void {
    $composer = json_decode(file_get_contents(__DIR__.'/../../composer.json'), true, flags: JSON_THROW_ON_ERROR);

    expect($composer)
        ->toHaveKey('name', 'tipowerup/ti-theme-orange-tw')
        ->toHaveKey('type', 'tastyigniter-package')
        ->and($composer['extra']['tastyigniter-theme'])
        ->toHaveKey('code', 'tipowerup-orange-tw')
        ->toHaveKey('source-path', '/resources/views')
        ->toHaveKey('meta-path', '/resources/meta');
});

it('ships a parseable assets.json', function (): void {
    $assets = json_decode(file_get_contents(__DIR__.'/../../resources/meta/assets.json'), true, flags: JSON_THROW_ON_ERROR);

    expect($assets)->toBeArray();
});

it('ships a fields.php that returns an array', function (): void {
    $fields = require __DIR__.'/../../resources/meta/fields.php';

    expect($fields)->toBeArray()->not->toBeEmpty();
});

it('declares english translations as an array', function (): void {
    $translations = require __DIR__.'/../../resources/lang/en/default.php';

    expect($translations)->toBeArray()->not->toBeEmpty();
});

it('lists all required ti-ext extensions in tastyigniter-theme.require', function (): void {
    $composer = json_decode(file_get_contents(__DIR__.'/../../composer.json'), true, flags: JSON_THROW_ON_ERROR);
    $themeRequire = $composer['extra']['tastyigniter-theme']['require'];

    expect(array_keys($themeRequire))->toContain(
        'igniter.cart',
        'igniter.local',
        'igniter.user',
        'igniter.payregister',
        'igniter.reservation',
    );
});
