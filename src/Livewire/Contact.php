<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Igniter\Local\Models\Location;

class Contact extends Component
{
    #[Validate('required|max:128')]
    public string $subject = '';

    #[Validate('required|email:filter|max:96')]
    public string $email = '';

    #[Validate('required|min:2|max:255')]
    public string $fullName = '';

    #[Validate('required')]
    public string $telephone = '';

    #[Validate('required|max:1500')]
    public string $message = '';

    public bool $sent = false;

    public array $subjects = [
        'General Enquiry',
        'Comment',
        'Technical Issues',
    ];

    public function send(): void
    {
        $this->validate();

        // TODO: Implement email sending logic
        // This should integrate with TastyIgniter's mail system
        // For now, just show success message

        $this->sent = true;
        $this->reset(['subject', 'email', 'fullName', 'telephone', 'message']);
    }

    public function resetForm(): void
    {
        $this->sent = false;
        $this->reset();
    }

    public function render()
    {
        return view('tipowerup-orange-tw::livewire.contact', [
            'locationDefault' => Location::getDefault(),
        ]);
    }
}
