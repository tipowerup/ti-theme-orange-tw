@if ($cart->count())
    <div class="mb-6 pb-6 border-b border-border dark:border-border">
        <div class="flex gap-2">
            <div class="flex-1">
                <input
                    wire:model="couponCode"
                    type="text"
                    placeholder="@lang('tipowerup.orange-tw::default.cart.enter_coupon')"
                    class="w-full px-4 py-2 border border-border dark:border-border rounded-lg bg-body dark:bg-surface text-text dark:text-text placeholder-text-muted dark:placeholder-text-muted focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                />
            </div>
            <button
                wire:click="onApplyCoupon"
                wire:loading.class="opacity-50 pointer-events-none"
                type="button"
                class="px-6 py-2 bg-surface dark:bg-surface text-text dark:text-text font-medium rounded-lg hover:bg-surface dark:hover:bg-surface transition-colors"
            >
                <span wire:loading.remove wire:target="onApplyCoupon">@lang('tipowerup.orange-tw::default.common.apply')</span>
                <span wire:loading wire:target="onApplyCoupon">@lang('tipowerup.orange-tw::default.common.applying')</span>
            </button>
        </div>
    </div>
@endif
