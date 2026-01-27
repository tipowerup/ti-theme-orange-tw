@if ($order->isDeliveryType())
    <div class="bg-body dark:bg-surface rounded-lg shadow-sm mb-4">
        <div class="p-6">
            <h6 class="text-sm font-semibold text-text-muted dark:text-text-muted uppercase tracking-wide mb-3">
                @lang('igniter.cart::default.checkout.text_delivery_address')
            </h6>
            <div class="text-text dark:text-text">
                <p class="font-semibold mb-1">{{ $order->customer_name }}</p>
                <div class="text-text-muted dark:text-text">
                    {!! $order->address ? format_address($order->address) : '' !!}
                </div>
            </div>
        </div>
    </div>
@endif

<div class="bg-body dark:bg-surface rounded-lg shadow-sm mb-4">
    <div class="p-6">
        <h6 class="text-sm font-semibold text-text-muted dark:text-text-muted uppercase tracking-wide mb-3">
            @lang('igniter.cart::default.checkout.text_comment')
        </h6>
        <p class="text-text-muted dark:text-text">
            {{ !empty($order->comment) ? $order->comment : lang('igniter.cart::default.checkout.text_no_comment') }}
        </p>
    </div>
</div>

<div class="bg-body dark:bg-surface rounded-lg shadow-sm">
    <div class="p-6">
        <h6 class="text-sm font-semibold text-text-muted dark:text-text-muted uppercase tracking-wide mb-3">
            @lang('igniter.cart::default.checkout.label_payment_method')
        </h6>
        <p class="text-text-muted dark:text-text">
            {{ $order->payment_method
                ? $order->payment_method->name
                : lang('igniter.cart::default.checkout.text_no_payment') }}
        </p>
    </div>
</div>
