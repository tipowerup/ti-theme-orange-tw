---
title: tipowerup.orange-tw::default.account_address_title
layout: default
permalink: /account/address/:addressId?
security: customer

'[tipowerup-orange-tw::account-menu]': []
---
<div class="container mx-auto px-4 py-8 lg:py-16">
    <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
        {{-- Account Menu Sidebar --}}
        <aside class="w-full lg:w-64 flex-shrink-0">
            <x-tipowerup-orange-tw::nav code="account-menu" />
        </aside>

        {{-- Main Content --}}
        <main class="flex-1">
            <livewire:tipowerup-orange-tw::address-book />
        </main>
    </div>
</div>
