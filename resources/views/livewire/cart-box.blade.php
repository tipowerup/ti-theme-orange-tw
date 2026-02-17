<div>
    @if ($cart->count())
        {{-- Fixed Header --}}
        <div class="p-4 lg:px-5 lg:pt-5 lg:pb-3 border-b border-border dark:border-border">
            <h2 class="text-lg font-bold text-text">@lang('tipowerup.orange-tw::default.cart.title')</h2>
        </div>

        {{-- Scrollable Content --}}
        <div class="p-4 lg:px-5 lg:py-3 overflow-y-auto" style="max-height: calc(100vh - 340px);">
            {{-- Cart Items --}}
            @include('tipowerup-orange-tw::includes.cartbox.items')

            {{-- Coupon Form --}}
            @include('tipowerup-orange-tw::includes.cartbox.coupon')

            {{-- Tip Selection --}}
            @if ($this->tippingEnabled())
                @include('tipowerup-orange-tw::includes.cartbox.tip')
            @endif
        </div>

        {{-- Fixed Footer --}}
        <div class="p-4 lg:px-5 lg:pb-5 lg:pt-3 border-t border-border dark:border-border">
            {{-- Totals --}}
            @include('tipowerup-orange-tw::includes.cartbox.totals')

            {{-- Checkout Buttons --}}
            @include('tipowerup-orange-tw::includes.cartbox.buttons')
        </div>
    @else
        <div class="p-4 lg:p-5">
            {{-- Empty State --}}
            @include('tipowerup-orange-tw::includes.cartbox.empty')
        </div>
    @endif
</div>
