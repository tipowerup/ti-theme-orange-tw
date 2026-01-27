<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\Livewire;

use Livewire\Component;

class NewsletterSubscribeForm extends Component
{
    public string $email = '';
    public bool $subscribed = false;
    public string $message = '';

    protected function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255'],
        ];
    }

    public function subscribe(): void
    {
        $this->validate();

        // In a real implementation, you would subscribe the email to your newsletter service
        // For now, we'll just show a success message
        $this->subscribed = true;
        $this->message = 'Thank you for subscribing! Please check your email to confirm.';
        $this->reset('email');
    }

    public function render()
    {
        return view('tipowerup-orange-tw::livewire.newsletter-subscribe-form');
    }
}
