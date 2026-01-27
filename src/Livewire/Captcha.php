<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;

class Captcha extends Component
{
    #[Validate('required')]
    public string $captcha = '';

    public string $captchaKey = '';

    public string $apiKey = '';

    public string $lang = 'en';

    public function mount(): void
    {
        $this->apiKey = config('system.recaptchaSettings.site_key', '');
        $this->lang = app()->getLocale();
        $this->captchaKey = uniqid('captcha_', true);
    }

    public function refresh(): void
    {
        $this->captchaKey = uniqid('captcha_', true);
        $this->captcha = '';
    }

    public function render()
    {
        return view('tipowerup-orange-tw::livewire.captcha');
    }
}
