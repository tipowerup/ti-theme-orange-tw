<div class="bg-body dark:bg-surface rounded-lg shadow-sm border border-border dark:border-border p-6 sticky top-6">
    <h2 class="text-xl font-semibold text-text dark:text-text mb-4">@lang('tipowerup.orange-tw::default.checkout.order_summary')</h2>

    {{-- Cart items preview --}}
    @if(isset($order))
        <div class="mb-6 pb-6 border-b border-border dark:border-border">
            <livewire:tipowerup-orange-tw::cart-box :preview-mode="true" />
        </div>
    @endif

    {{-- Order details --}}
    <div class="space-y-3">
        @if(isset($locationOrderType))
            <div class="flex justify-between text-sm">
                <span class="text-text-muted dark:text-text-muted">@lang('tipowerup.orange-tw::default.checkout.order_type')</span>
                <span class="font-medium text-text dark:text-text">{{ $locationOrderType->name ?? lang('tipowerup.orange-tw::default.checkout.not_available') }}</span>
            </div>
        @endif

        @if(isset($order->order_date) && isset($order->order_time))
            <div class="flex justify-between text-sm">
                <span class="text-text-muted dark:text-text-muted">@lang('tipowerup.orange-tw::default.checkout.time')</span>
                <span class="font-medium text-text dark:text-text">
                    {{ $order->order_date }} {{ $order->order_time }}
                </span>
            </div>
        @endif
    </div>

    {{-- Total --}}
    @if(isset($order))
        <div class="mt-6 pt-6 border-t border-border dark:border-border">
            <div class="flex justify-between text-lg font-bold text-text dark:text-text">
                <span>@lang('tipowerup.orange-tw::default.checkout.total')</span>
                <span>{{ $this->cartTotal }}</span>
            </div>
        </div>
    @endif

    {{-- Secure checkout badge --}}
    <div class="mt-6 pt-6 border-t border-border dark:border-border">
        <div class="flex items-center justify-center gap-2 text-sm text-text-muted dark:text-text-muted">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
            <span>@lang('tipowerup.orange-tw::default.checkout.secure_checkout')</span>
        </div>
    </div>
</div>
