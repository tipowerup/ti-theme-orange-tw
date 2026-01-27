---
title: Order Confirmation
layout: default
permalink: /checkout/success
---
<div class="container mx-auto px-4 py-8 lg:py-12">
    <div class="max-w-2xl mx-auto">
        {{-- Success Icon --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full mb-4">
                <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-text mb-2">@lang('tipowerup.orange-tw::default.order.confirmed_title')</h1>
            <p class="text-text-muted">@lang('tipowerup.orange-tw::default.order.confirmed_text')</p>
        </div>

        {{-- Order Details Card --}}
        <div class="bg-surface rounded-lg shadow-sm border border-border p-6 mb-6">
            {{-- Order Number --}}
            @if(isset($order))
                <div class="mb-6 pb-6 border-b border-border">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-text-muted mb-1">@lang('tipowerup.orange-tw::default.order.order_number')</p>
                            <p class="text-2xl font-bold text-text">{{ $order->order_id ?? 'N/A' }}</p>
                        </div>
                        @if(isset($order->order_time))
                            <div class="text-right">
                                <p class="text-sm text-text-muted mb-1">@lang('tipowerup.orange-tw::default.order.estimated_time')</p>
                                <p class="text-xl font-semibold text-primary-600 dark:text-primary-400">
                                    {{ $order->order_time }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-text mb-4">@lang('tipowerup.orange-tw::default.checkout.order_summary')</h3>

                    {{-- Order Type --}}
                    <div class="flex justify-between mb-3">
                        <span class="text-text-muted">@lang('tipowerup.orange-tw::default.checkout.order_type')</span>
                        <span class="font-medium text-text">
                            {{ ucfirst($order->order_type ?? 'N/A') }}
                        </span>
                    </div>

                    {{-- Total --}}
                    <div class="flex justify-between text-lg font-bold text-text pt-3 border-t border-border">
                        <span>@lang('tipowerup.orange-tw::default.checkout.total')</span>
                        <span>{{ isset($order->order_total) ? currency_format($order->order_total) : 'N/A' }}</span>
                    </div>
                </div>
            @else
                <p class="text-center text-text-muted">@lang('tipowerup.orange-tw::default.order.no_details')</p>
            @endif
        </div>

        {{-- Action Buttons --}}
        <div class="space-y-3">
            @if(isset($order))
                <a
                    href="{{ page_url('account.orders') }}"
                    class="block w-full px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors text-center"
                    wire:navigate
                >
                    @lang('tipowerup.orange-tw::default.order.track_order')
                </a>
            @endif

            <a
                href="{{ restaurant_url('local/menus') }}"
                class="block w-full px-6 py-3 bg-surface text-text font-semibold rounded-lg border border-border hover:bg-body transition-colors text-center"
                wire:navigate
            >
                @lang('tipowerup.orange-tw::default.cart.continue_shopping')
            </a>
        </div>
    </div>
</div>
