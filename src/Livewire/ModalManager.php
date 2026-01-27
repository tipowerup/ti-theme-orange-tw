<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

final class ModalManager extends Component
{
    public ?string $component = null;

    public array $arguments = [];

    public ?string $activeModal = null;

    #[On('openModal')]
    public function openModal(?string $component, array $arguments = []): void
    {
        $this->component = $component;
        $this->arguments = $arguments;

        $this->activeModal = 'modal-'.md5($component.serialize($arguments));

        $this->dispatch('showActiveModal', id: $this->activeModal);
    }

    #[On('resetModal')]
    public function resetModal(): void
    {
        $this->reset();
    }

    public function render()
    {
        return view('tipowerup-orange-tw::livewire.modal-manager');
    }
}
