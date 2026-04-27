<?php

declare(strict_types=1);

use Igniter\Flame\Flash\Message;
use Illuminate\Support\Collection;
use Livewire\Livewire;
use TiPowerUp\OrangeTw\Livewire\FlashMessage;

function bindFlashMock(Collection $messages): void
{
    $flash = Mockery::mock();
    $flash->shouldReceive('all')->andReturn($messages);
    app()->instance('flash', $flash);
}

it('hydrates flash messages from the Flash facade on mount', function (): void {
    bindFlashMock(new Collection([
        new Message(['message' => 'Saved!', 'level' => 'success']),
        new Message(['message' => 'Whoops', 'level' => 'danger']),
    ]));

    Livewire::test(FlashMessage::class)
        ->assertSet('messages.0.text', 'Saved!')
        ->assertSet('messages.0.level', 'success')
        ->assertSet('messages.1.text', 'Whoops')
        ->assertSet('messages.1.level', 'error');
});

it('appends new messages via the flashMessageAdded event', function (): void {
    bindFlashMock(new Collection);

    Livewire::test(FlashMessage::class)
        ->dispatch('flashMessageAdded', messages: [
            ['level' => 'info', 'message' => 'Heads up'],
        ])
        ->assertSet('messages.0.text', 'Heads up')
        ->assertSet('messages.0.level', 'info');
});

it('removes a message by index and reindexes the array', function (): void {
    bindFlashMock(new Collection([
        new Message(['message' => 'first', 'level' => 'info']),
        new Message(['message' => 'second', 'level' => 'info']),
        new Message(['message' => 'third', 'level' => 'info']),
    ]));

    Livewire::test(FlashMessage::class)
        ->call('removeMessage', 1)
        ->assertSet('messages.0.text', 'first')
        ->assertSet('messages.1.text', 'third')
        ->assertCount('messages', 2);
});
