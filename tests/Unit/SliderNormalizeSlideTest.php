<?php

declare(strict_types=1);

use TiPowerUp\OrangeTw\View\Components\Slider;

/**
 * `normalizeSlide()` is protected. Reflection lets us pin the contract that
 * the blade template depends on — every slide passed to the view has the
 * full, typed shape regardless of which source produced it (theme banners,
 * configured frontend slider, or demo fallback).
 */
function normalizeSlide(array $input): array
{
    $slider = new Slider;
    $method = new ReflectionMethod($slider, 'normalizeSlide');
    $method->setAccessible(true);

    return $method->invoke($slider, $input);
}

it('returns the canonical shape with every key present', function (): void {
    $result = normalizeSlide([]);

    expect($result)->toHaveKeys(['image', 'title', 'description', 'cta_text', 'cta_link', 'cta_is_external']);
    foreach (['image', 'title', 'description', 'cta_text', 'cta_link'] as $stringKey) {
        expect($result[$stringKey])->toBeString();
    }
    expect($result['cta_is_external'])->toBeBool();
});

it('flags absolute http(s) cta links as external', function (string $link): void {
    expect(normalizeSlide(['cta_link' => $link])['cta_is_external'])->toBeTrue();
})->with([
    'http://example.com',
    'https://example.com/path',
    'https://sub.example.com/page?q=1',
]);

it('treats relative and empty cta links as internal', function (string $link): void {
    expect(normalizeSlide(['cta_link' => $link])['cta_is_external'])->toBeFalse();
})->with([
    'empty' => '',
    'root-relative' => '/menus',
    'page-name' => 'locations',
    'hash' => '#section',
]);

it('trims whitespace around cta fields', function (): void {
    $result = normalizeSlide([
        'cta_text' => '  Order Now  ',
        'cta_link' => "  https://example.com\n",
    ]);

    expect($result['cta_text'])->toBe('Order Now');
    expect($result['cta_link'])->toBe('https://example.com');
    expect($result['cta_is_external'])->toBeTrue();
});

it('coerces non-string inputs to strings', function (): void {
    $result = normalizeSlide([
        'image' => null,
        'title' => 123,
    ]);

    expect($result['image'])->toBe('');
    expect($result['title'])->toBe('123');
});
