<?php

declare(strict_types=1);

use TiPowerUp\OrangeTw\View\Components\Icon;

it('returns a non-empty SVG path for known icon names', function (string $name): void {
    $icon = new Icon($name);

    expect($icon->iconPath())
        ->toBeString()
        ->not->toBeEmpty()
        ->toMatch('/^[MmLlHhVvCcSsQqTtAaZz0-9.,\s\-]+$/');
})->with([
    'home', 'menu', 'x', 'shopping-cart', 'user', 'map-pin',
    'moon', 'sun', 'check-circle', 'x-circle',
    'facebook', 'twitter', 'instagram', 'youtube',
]);

it('falls back to the x icon for unknown names', function (): void {
    $unknown = new Icon('not-a-real-icon');
    $x = new Icon('x');

    expect($unknown->iconPath())->toBe($x->iconPath());
});

it('exposes constructor props', function (): void {
    $icon = new Icon(name: 'home', class: 'w-4 h-4', variant: 'solid');

    expect($icon)
        ->name->toBe('home')
        ->class->toBe('w-4 h-4')
        ->variant->toBe('solid');
});

it('defaults class and variant', function (): void {
    $icon = new Icon('home');

    expect($icon)
        ->class->toBe('w-6 h-6')
        ->variant->toBe('outline');
});
