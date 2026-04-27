<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\Livewire;

use Igniter\Flame\Flash\Facades\Flash;
use Igniter\Flame\Flash\Message;
use Livewire\Attributes\On;
use Livewire\Component;

class FlashMessage extends Component
{
    /** @var array<int, array<string, mixed>> */
    public array $messages = [];

    public function mount(): void
    {
        $this->messages = Flash::all()
            ->map(fn (Message $message): array => $this->normalize($message->toArray()))
            ->all();
    }

    /**
     * @param  array<int, array<string, mixed>>  $messages
     */
    #[On('flashMessageAdded')]
    public function updateMessages(array $messages): void
    {
        $this->messages = array_merge(
            $this->messages,
            array_map(fn (array $flash): array => $this->normalize($flash), $messages),
        );
    }

    /**
     * @param  array<string, mixed>  $flash
     * @return array<string, mixed>
     */
    private function normalize(array $flash): array
    {
        $level = $flash['level'] ?? 'info';

        return [
            'level' => $level === 'danger' ? 'error' : $level,
            'text' => $flash['message'] ?? '',
            'important' => (bool) ($flash['important'] ?? false),
        ];
    }

    public function removeMessage(int $index): void
    {
        unset($this->messages[$index]);
        $this->messages = array_values($this->messages);
    }

    public function render()
    {
        return view('tipowerup-orange-tw::livewire.flash-message');
    }
}
