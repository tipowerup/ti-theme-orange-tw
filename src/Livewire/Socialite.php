<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\Livewire;

use Igniter\Main\Traits\ConfigurableComponent;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Socialite extends Component
{
    use ConfigurableComponent;

    public bool $confirm = false;

    public array $links = [];

    public string $successPage = '';

    public string $errorPage = '';

    #[Validate('required|email')]
    public string $email = '';

    public static function componentMeta(): array
    {
        return [
            'code' => 'tipowerup-orange-tw::socialite',
            'name' => 'Socialite Login',
            'description' => 'Allows customers to login via social media',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'confirm' => [
                'label' => 'Require email confirmation',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
        ];
    }

    public function mount(): void
    {
        $this->confirm = (bool) controller()->property('confirm', false);
        $this->loadSocialLinks();
    }

    protected function loadSocialLinks(): void
    {
        try {
            $socialiteComponent = app('Igniter\Socialite\Components\Socialite');

            if (method_exists($socialiteComponent, 'getProviderLinks')) {
                $this->links = $socialiteComponent->getProviderLinks();
            }

            $this->successPage = $socialiteComponent->property('successPage', 'account/login');
            $this->errorPage = $socialiteComponent->property('errorPage', 'account/login');
        } catch (\Exception $e) {
            $this->links = [];
        }
    }

    public function onConfirmEmail(): void
    {
        $this->validate(['email' => 'required|email']);

        try {
            $data = post();
            $data['email'] = $this->email;

            $socialiteComponent = app('Igniter\Socialite\Components\Socialite');
            $response = $socialiteComponent->onConfirmEmail($data);

            if (isset($response['status']) && $response['status'] === 'success') {
                session()->flash('success', $response['message'] ?? 'Email confirmed successfully.');
                $this->redirect(page_url($this->successPage));
            }
        } catch (\Exception $e) {
            $this->addError('email', $e->getMessage());
        }
    }

    public function render()
    {
        return view('tipowerup-orange-tw::livewire.socialite');
    }
}
