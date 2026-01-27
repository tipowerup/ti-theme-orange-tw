---
title: tipowerup.orange-tw::default.account_reservations_title
layout: default
permalink: /account/reservations
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
            <div class="bg-surface rounded-lg border border-border shadow-sm">
                <div class="px-6 py-4 border-b border-border">
                    <h1 class="text-2xl font-semibold text-text">
                        @lang('tipowerup.orange-tw::default.account_reservations_title')
                    </h1>
                </div>
                <div class="p-6">
                    <livewire:tipowerup-orange-tw::reservation-list />
                </div>
            </div>
        </main>
    </div>
</div>
