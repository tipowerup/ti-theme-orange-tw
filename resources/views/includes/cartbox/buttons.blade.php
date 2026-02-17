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
            <span wire:loading wire:target="onProceedToCheckout" class="inline-flex items-center gap-2">
                <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>@lang('tipowerup.orange-tw::default.common.processing')</span>
            </span>
        </button>

    </div>
@endif
