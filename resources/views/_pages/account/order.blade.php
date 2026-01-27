---
title: igniter.cart::default.orders.text_heading
layout: default
permalink: /account/order/:hash
security: all

'[tipowerup-orange-tw::order-preview]':
    hideReorderBtn: false
    showCancelButton: true
---
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-6">
        <div class="lg:w-64 flex-shrink-0">
            <x-tipowerup-orange-tw::nav code="account-menu"/>
        </div>

        <div class="flex-1">
            <livewire:tipowerup-orange-tw::order-preview/>
        </div>
    </div>
</div>
