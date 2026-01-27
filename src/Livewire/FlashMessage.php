<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\Livewire;

use Livewire\Component;

class FlashMessage extends Component
{
    public array $messages = [];

    public function mount(): void
    {
        $this->loadMessages();
    }

    protected function loadMessages(): void
    {
        $this->messages = [];

        $types = ['success', 'error', 'warning', 'info'];
        foreach ($types as $type) {
            if (session()->has($type)) {
                $this->messages[] = [
                    'type' => $type,
                    'message' => session($type),
                ];
            }
        }
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
