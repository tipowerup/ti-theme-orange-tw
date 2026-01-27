<div>
    <div class="p-4 lg:p-6">
        @if ($cart->count())
            <h2 class="text-2xl font-bold text-text mb-6">@lang('tipowerup.orange-tw::default.cart.title')</h2>

            {{-- Cart Items --}}
            @include('tipowerup-orange-tw::includes.cartbox.items')

            {{-- Coupon Form --}}
            @include('tipowerup-orange-tw::includes.cartbox.coupon')

            {{-- Tip Selection --}}
            @if ($this->tippingEnabled())
                @include('tipowerup-orange-tw::includes.cartbox.tip')
            @endif

            {{-- Totals --}}
            @include('tipowerup-orange-tw::includes.cartbox.totals')

            {{-- Checkout Buttons --}}
            @include('tipowerup-orange-tw::includes.cartbox.buttons')
        @else
            {{-- Empty State --}}
            @include('tipowerup-orange-tw::includes.cartbox.empty')
        @endif
    </div>
</div>
