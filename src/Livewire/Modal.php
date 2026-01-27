<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\Livewire;

use Livewire\Component;

class Modal extends Component
{
    public bool $show = false;

    public string $maxWidth = 'lg';

    public function open(): void
    {
        $this->show = true;
    }

    public function close(): void
    {
        $this->show = false;
    }

    public function render()
    {
        return view('tipowerup-orange-tw::livewire.modal');
    }
}
