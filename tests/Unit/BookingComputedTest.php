<?php

declare(strict_types=1);

use Illuminate\Support\Carbon;
use TiPowerUp\OrangeTw\Livewire\Booking;

afterEach(function (): void {
    Carbon::setTestNow();
});

it('returns true when the selected date is today', function (): void {
    Carbon::setTestNow(Carbon::parse('2026-04-27 10:00:00'));

    $component = new Booking;
    $component->date = '2026-04-27';

    expect($component->selectedDateIsToday())->toBeTrue();
});

it('returns false when the selected date is in the past', function (): void {
    Carbon::setTestNow(Carbon::parse('2026-04-27 10:00:00'));

    $component = new Booking;
    $component->date = '2026-04-26';

    expect($component->selectedDateIsToday())->toBeFalse();
});

it('returns false when the selected date is in the future', function (): void {
    Carbon::setTestNow(Carbon::parse('2026-04-27 10:00:00'));

    $component = new Booking;
    $component->date = '2026-04-28';

    expect($component->selectedDateIsToday())->toBeFalse();
});

it('honours the test clock at end-of-day boundary', function (): void {
    Carbon::setTestNow(Carbon::parse('2026-04-27 23:59:59'));

    $component = new Booking;
    $component->date = '2026-04-27';

    expect($component->selectedDateIsToday())->toBeTrue();
});

it('exposes component meta with the expected code', function (): void {
    expect(Booking::componentMeta())
        ->toHaveKey('code', 'tipowerup-orange-tw::booking')
        ->toHaveKey('name', 'Booking');
});

it('declares step constants matching the picker state machine', function (): void {
    expect(Booking::STEP_PICKER)->toBe('picker')
        ->and(Booking::STEP_TIMESLOT)->toBe('timeslot')
        ->and(Booking::STEP_BOOKING)->toBe('booking');
});
