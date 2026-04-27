<?php

declare(strict_types=1);

use TiPowerUp\OrangeTw\Livewire\Modal;

it('starts hidden by default', function (): void {
    expect((new Modal)->show)->toBeFalse();
});

it('opens and closes the modal', function (): void {
    $modal = new Modal;

    $modal->open();
    expect($modal->show)->toBeTrue();

    $modal->close();
    expect($modal->show)->toBeFalse();
});

it('derives the tailwind max-width class from the configured size', function (string $size, string $expected): void {
    $modal = new Modal;
    $modal->maxWidth = $size;

    expect($modal->maxWidthClass())->toBe($expected);
})->with([
    'sm' => ['sm', 'max-w-sm'],
    'md' => ['md', 'max-w-md'],
    'lg' => ['lg', 'max-w-lg'],
    'xl' => ['xl', 'max-w-xl'],
    '2xl' => ['2xl', 'max-w-2xl'],
    'full' => ['full', 'max-w-full'],
]);

it('defaults to lg width', function (): void {
    $modal = new Modal;

    expect($modal->maxWidth)->toBe('lg');
    expect($modal->maxWidthClass())->toBe('max-w-lg');
});
