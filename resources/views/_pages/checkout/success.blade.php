---
title: Order Confirmation
layout: default
permalink: /checkout/success/:hash?

'[tipowerup-orange-tw::order-preview]':
    hideReorderBtn: true
    showContinueShopping: true
---
<div class="container mx-auto px-4 py-8 lg:py-12">
    <div class="max-w-3xl mx-auto">
        {{-- Success Icon --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full mb-4 animate-pulse">
                <i class="fa fa-check text-3xl text-green-600 dark:text-green-400"></i>
            </div>
            <h1 class="text-3xl font-bold text-text mb-2">@lang('tipowerup.orange-tw::default.order.confirmed_title')</h1>
            <p class="text-text-muted">@lang('tipowerup.orange-tw::default.order.confirmed_text')</p>
        </div>

        {{-- Order Details via Livewire Component --}}
        <livewire:tipowerup-orange-tw::order-preview />
    </div>
</div>
