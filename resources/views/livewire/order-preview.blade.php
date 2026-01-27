<div wire:poll.120s>
    @if (!$order)
        <div class="bg-body dark:bg-surface rounded-lg shadow-sm mb-6">
            <div class="p-6 text-center text-text-muted dark:text-text-muted">
                No order found
            </div>
        </div>
    @else
        <div class="bg-body dark:bg-surface rounded-lg shadow-sm mb-6">
            <div class="p-6 text-center" id="ti-order-status">
                @include('tipowerup-orange-tw::includes.order.status')
            </div>
        </div>

        @auth('igniter-customer')
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-body dark:bg-surface rounded-lg shadow-sm">
                        <div class="p-6">
                            @include('tipowerup-orange-tw::includes.order.restaurant', ['location' => $order->location])
                        </div>
                    </div>

                    <div class="bg-body dark:bg-surface rounded-lg shadow-sm">
                        <div class="p-6">
                            @include('tipowerup-orange-tw::includes.order.items')
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    @include('tipowerup-orange-tw::includes.order.details')
                </div>
            </div>
        @else
            <div class="bg-body dark:bg-surface rounded-lg shadow-sm">
                <div class="p-6 text-center">
                    <a
                        href="{{ $loginUrl }}"
                        class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300"
                        wire:navigate
                    >@lang('igniter.cart::default.orders.text_login_to_view_more')</a>
                </div>
            </div>
        @endauth
    @endif
</div>
