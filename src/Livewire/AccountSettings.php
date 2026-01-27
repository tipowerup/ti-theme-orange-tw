<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\Livewire;

use Igniter\Cart\Facades\Cart;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\User\Actions\LogoutCustomer;
use Igniter\User\Facades\Auth;
use Livewire\Component;
use TiPowerUp\OrangeTw\Livewire\Forms\SettingsForm;

final class AccountSettings extends Component
{
    use ConfigurableComponent;

    public SettingsForm $form;

    public string $loginPage = 'account.login';

    public static function componentMeta(): array
    {
        return [
            'code' => 'tipowerup-orange-tw::account-settings',
            'name' => 'Account Settings',
            'description' => 'Allows customers to manage their account settings and profile information',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'loginPage' => [
                'label' => 'Login page',
                'type' => 'select',
                'options' => [self::class, 'getThemePageOptions'],
            ],
        ];
    }

    public function render()
    {
        return view('tipowerup-orange-tw::livewire.account-settings');
    }

    public function mount(): void
    {
        $this->form->fillFrom(Auth::customer());
    }

    public function cartCount(): int
    {
        return Cart::count();
    }

    public function cartTotal(): string
    {
        return Cart::total();
    }

    public function onUpdate()
    {
        throw_unless($customer = Auth::customer(),
            new ApplicationException('You must be logged in to update your account settings'),
        );

        $oldEmail = $customer->email;

        $this->form->validate();

        $customer->fill($this->form->except(['old_password', 'password_confirmation']));
        $customer->save();

        if ($this->form->old_password || $customer->email !== $oldEmail) {
            Cart::keepSession(function (): void {
                resolve(LogoutCustomer::class)->handle();
            });

            return redirect()->to(page_url($this->loginPage));
        }

        flash()->success(lang('igniter.user::default.settings.alert_updated_success'));

        return null;
    }
}
