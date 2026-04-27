<?php

declare(strict_types=1);

use TiPowerUp\OrangeTw\Livewire\LocalSearch;

it('reflects the location facade isOpened state in the computed property', function (bool $opened): void {
    $location = Mockery::mock();
    $location->shouldReceive('isOpened')->andReturn($opened);
    app()->instance('location', $location);

    $component = new LocalSearch;

    expect($component->isOpened())->toBe($opened);
})->with([
    'open' => true,
    'closed' => false,
]);

it('exposes component meta with the expected code', function (): void {
    expect(LocalSearch::componentMeta())
        ->toHaveKey('code', 'tipowerup-orange-tw::local-search')
        ->toHaveKey('name')
        ->toHaveKey('description');
});
