<div class="h-full flex flex-col">
    @if ($cart->count())
        {{-- Fixed Header --}}
        <div class="shrink-0 flex items-center justify-between p-4 lg:px-5 lg:pt-5 lg:pb-3 border-b border-border dark:border-border">
            <h2 class="text-lg font-bold text-text">@lang('tipowerup.orange-tw::default.cart.title')</h2>
            {{-- Mobile-only close button — dispatches event for the drawer wrapper --}}
            <button
                type="button"
                @click="$dispatch('cart-drawer-close')"
                class="md:hidden w-8 h-8 flex items-center justify-center rounded-full bg-surface text-text-muted hover:bg-border transition-colors"
                aria-label="Close cart"
            >
                <x-tipowerup-orange-tw::icon name="x" class="w-4 h-4" />
            </button>
        </div>

        {{-- Scrollable Content --}}
        <div class="flex-1 min-h-0 overflow-y-auto overscroll-contain p-4 lg:px-5 lg:py-3">
            {{-- Cart Items --}}
            @include('tipowerup-orange-tw::includes.cartbox.items')

            {{-- Tip Selection --}}
            @if ($this->tippingEnabled())
                @include('tipowerup-orange-tw::includes.cartbox.tip')
            @endif
        </div>

        {{-- Fixed Footer --}}
        <div class="shrink-0 p-4 lg:px-5 lg:pb-5 lg:pt-3 border-t border-border dark:border-border space-y-3">
            {{-- Coupon Form --}}
            @include('tipowerup-orange-tw::includes.cartbox.coupon')

            {{-- Totals --}}
            @include('tipowerup-orange-tw::includes.cartbox.totals')

            {{-- Checkout Buttons --}}
            @include('tipowerup-orange-tw::includes.cartbox.buttons')
        </div>
    @else
        <div class="shrink-0 flex items-center justify-end p-2 md:hidden">
            <button
                type="button"
                @click="$dispatch('cart-drawer-close')"
                class="w-8 h-8 flex items-center justify-center rounded-full bg-surface text-text-muted hover:bg-border transition-colors"
                aria-label="Close cart"
            >
                <x-tipowerup-orange-tw::icon name="x" class="w-4 h-4" />
            </button>
        </div>
        <div class="flex-1 flex items-center justify-center p-4 lg:p-5">
            {{-- Empty State --}}
            @include('tipowerup-orange-tw::includes.cartbox.empty')
        </div>
    @endif
</div>
