<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\View\Components;

use Igniter\Cart\Facades\Cart;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\User\Facades\Auth;
use Illuminate\View\Component;
use Override;

final class AccountDashboard extends Component
{
    use ConfigurableComponent;

    public bool $hasDefaultAddress;

    public ?int $defaultAddressId;

    public string $formattedAddress = '';

    public string $customerName = '';

    public function __construct()
    {
        $customer = Auth::getUser();
        $this->customerName = $customer->full_name ?? '';
        $this->hasDefaultAddress = ! is_null($customer?->address);
        $this->defaultAddressId = $customer?->address?->getKey();
        $this->formattedAddress = $this->hasDefaultAddress ? format_address($customer?->address) : '';
    }

    public static function componentMeta(): array
    {
        return [
            'code' => 'tipowerup-orange-tw::account-dashboard',
            'name' => 'Account Dashboard',
            'description' => 'Displays account dashboard with user info and quick stats',
        ];
    }

    public function cartCount(): int
    {
        return Cart::count();
    }

    public function cartTotal(): float
    {
        return Cart::total();
    }

    #[Override]
    public function render()
    {
        return view('tipowerup-orange-tw::components.account-dashboard');
    }
}
