<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use TiPowerUp\OrangeTw\View\Components\Icon;

/**
 * Compile-level tests for the theme's error pages. We don't fully render
 * them (the layout pulls `@vite()`, `setting()`, and a `$theme` variable
 * that only exist inside a fully booted host) — but compiling them catches
 * the regressions that actually break in production:
 *
 * - syntax errors in the Blade template
 * - references to icons that don't exist in the Icon component
 * - missing helper directives
 *
 * For end-to-end "page actually opens" coverage, see `tests/Browser/`.
 */
function errorPageRaw(string $name): string
{
    $path = __DIR__.'/../../resources/views/errors/'.$name.'.blade.php';

    expect($path)->toBeReadableFile();

    return file_get_contents($path);
}

function compilesCleanly(string $name): void
{
    $raw = errorPageRaw($name);

    // Throws on syntax errors (unmatched directives, malformed @yield, etc.)
    $compiled = Blade::compileString($raw);

    expect($compiled)->toBeString()->not->toBeEmpty();
}

function iconsReferenced(string $name): array
{
    $raw = errorPageRaw($name);

    preg_match_all('/<x-tipowerup-orange-tw::icon\s+name="([^"]+)"/', $raw, $matches);

    return array_unique($matches[1] ?? []);
}

function knownIconNames(): array
{
    $component = new Icon('home');
    $reflection = new ReflectionMethod($component, 'iconPath');
    $reflection->setAccessible(true);

    // Re-extract the keys from the iconPath method's local map.
    $source = file_get_contents((new ReflectionClass($component))->getFileName());
    preg_match_all("/'([a-z\-]+)'\s*=>/", $source, $matches);

    return array_unique($matches[1] ?? []);
}

it('compiles each error page without Blade errors', function (string $page): void {
    compilesCleanly($page);
})->with([
    '403',
    '404',
    '419',
    '500',
    '503',
    'minimal',
    'layout',
]);

it('only references icons that exist in the Icon component', function (string $page): void {
    $referenced = iconsReferenced($page);
    $known = knownIconNames();

    $missing = array_diff($referenced, $known);

    expect($missing)
        ->toBe([], 'Error page '.$page.'.blade.php references icon(s) not defined in Icon::iconPath(): '.implode(', ', $missing));
})->with([
    '403',
    '404',
    '419',
    '500',
    '503',
    'minimal',
]);

it('every error page has a back-to-home navigation link', function (string $page): void {
    $raw = errorPageRaw($page);

    expect($raw)->toContain("page_url('home')");
})->with([
    '403',
    '404',
    '419',
    '500',
    '503',
    'minimal',
]);

it('extends the shared error layout', function (string $page): void {
    $raw = errorPageRaw($page);

    expect($raw)->toContain("@extends('tipowerup-orange-tw::errors.layout')");
})->with([
    '403',
    '404',
    '419',
    '500',
    '503',
    'minimal',
]);

it('declares a friendly title for each error page', function (string $page): void {
    $raw = errorPageRaw($page);

    expect($raw)->toMatch("/@section\(['\"]title['\"]/");
})->with([
    '403',
    '404',
    '419',
    '500',
    '503',
    'minimal',
]);

it('the 404 page surfaces the main navigation destinations', function (): void {
    $raw = errorPageRaw('404');

    expect($raw)
        ->toContain("page_url('home')")
        ->toContain("page_url('locations')")
        ->toContain("page_url('contact')");
});

it('the 500 page offers retry and contact paths', function (): void {
    $raw = errorPageRaw('500');

    expect($raw)
        ->toContain('window.location.reload()')
        ->toContain("page_url('contact')");
});

it('the 503 page surfaces the upstream exception message when present', function (): void {
    $raw = errorPageRaw('503');

    expect($raw)->toContain('$exception->getMessage()');
});
