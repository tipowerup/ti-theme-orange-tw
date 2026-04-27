@if ($cart->count())
    <div class="space-y-3">
        {{-- Minimum order notice --}}
        @if($minOrderTotal = $location->minimumOrderTotal())
            <p class="text-sm text-center text-text-muted dark:text-text-muted">
                @lang('tipowerup.orange-tw::default.cart.minimum_order', ['amount' => currency_format($minOrderTotal)])
            </p>
        @endif

        {{-- Checkout button --}}
        <button
            wire:click="onProceedToCheckout({{ $this->getLocationId() }})"
            wire:loading.attr="disabled"
            type="button"
            @disabled($this->locationIsClosed() || $this->hasMinimumOrder())
            @class([
                'w-full px-6 py-3 font-semibold rounded-lg transition-colors flex items-center justify-center gap-2',
                'bg-primary-600 text-white hover:bg-primary-700 disabled:opacity-50 disabled:cursor-not-allowed' => !$this->locationIsClosed() && !$this->hasMinimumOrder(),
                'bg-surface dark:bg-surface text-text-muted dark:text-text-muted cursor-not-allowed' => $this->locationIsClosed() || $this->hasMinimumOrder(),
            ])
        >
            <span wire:loading.remove wire:target="onProceedToCheckout">
                {{ $this->buttonLabel() }}
            </span>
            <i wire:loading wire:target="onProceedToCheckout" class="fa fa-spinner fa-spin"></i>
            <span wire:loading wire:target="onProceedToCheckout">
                @lang('tipowerup.orange-tw::default.common.processing')
            </span>
        </button>

    </div>
@endif
