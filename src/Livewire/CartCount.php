<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\Livewire;

use Igniter\Cart\Facades\Cart;
use Igniter\Main\Traits\ConfigurableComponent;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class CartCount extends Component
{
    use ConfigurableComponent;

    public static function componentMeta(): array
    {
        return [
            'code' => 'tipowerup-orange-tw::cart-count',
            'name' => 'Cart Count Badge',
            'description' => 'Live count of items in the cart',
        ];
    }

    public function defineProperties(): array
    {
        return [];
    }

    #[On('cart-box:add-item')]
    #[On('cart-updated')]
    #[On('hideModal')]
    public function refresh(): void
    {
        // Re-render only.
    }

    public function render(): View
    {
        return view('tipowerup-orange-tw::livewire.cart-count', [
            'count' => Cart::count(),
        ]);
    }
}
