---
title: tipowerup.orange-tw::default.account_orders_title
layout: default
permalink: /account/orders
security: customer

'[tipowerup-orange-tw::order-list]': []
---
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-6">
        <div class="lg:w-64 shrink-0">
            <x-tipowerup-orange-tw::nav code="account-menu"/>
        </div>

        <div class="flex-1">
            <div class="bg-surface rounded-lg shadow-xs">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-text mb-6">
                        @lang('tipowerup.orange-tw::default.account_orders_title')
                    </h2>
                    <x-tipowerup-orange-tw::order-list/>
                </div>
            </div>
        </div>
    </div>
</div>
