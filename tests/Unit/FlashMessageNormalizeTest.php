<?php

declare(strict_types=1);

use TiPowerUp\OrangeTw\Livewire\FlashMessage;

/**
 * `normalize()` is private. Reflection lets us pin the contract — input
 * shape from `Igniter\Flame\Flash\Message::toArray()`, output shape consumed
 * by the blade.
 */
function invokeNormalize(array $flash): array
{
    $component = new FlashMessage;
    $method = new ReflectionMethod($component, 'normalize');
    $method->setAccessible(true);

    return $method->invoke($component, $flash);
}

it('rewrites danger to error so blade can key off semantic levels', function (): void {
    $result = invokeNormalize(['level' => 'danger', 'message' => 'Boom']);

    expect($result['level'])->toBe('error');
    expect($result['text'])->toBe('Boom');
    expect($result['important'])->toBeFalse();
});

it('passes through non-danger levels unchanged', function (string $level): void {
    expect(invokeNormalize(['level' => $level, 'message' => 'x'])['level'])->toBe($level);
})->with(['success', 'warning', 'info', 'error']);

it('defaults level to info when missing', function (): void {
    expect(invokeNormalize(['message' => 'hi'])['level'])->toBe('info');
});

it('defaults text to empty string when message is missing', function (): void {
    expect(invokeNormalize(['level' => 'info'])['text'])->toBe('');
});

it('coerces important to boolean', function (mixed $input, bool $expected): void {
    $result = invokeNormalize(['level' => 'info', 'message' => 'x', 'important' => $input]);

    expect($result['important'])->toBe($expected);
})->with([
    'truthy 1' => [1, true],
    'truthy string' => ['1', true],
    'falsy 0' => [0, false],
    'falsy empty' => ['', false],
    'literal true' => [true, true],
    'literal false' => [false, false],
]);
