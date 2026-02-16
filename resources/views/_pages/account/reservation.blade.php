---
title: tipowerup.orange-tw::default.account_reservation_title
layout: default
permalink: /account/reservation/:hash
security: customer

'[tipowerup-orange-tw::leave-review]':
    type: reservation
---
<div class="container mx-auto px-4 py-8 lg:py-16">
    <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
        {{-- Account Menu Sidebar --}}
        <aside class="w-full lg:w-64 flex-shrink-0">
            <x-tipowerup-orange-tw::nav code="account-menu" />
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 space-y-6">
            {{-- Location Header --}}
            <div class="bg-surface rounded-lg border border-border shadow-sm">
                <div class="p-6">
                    <x-tipowerup-orange-tw::local-header/>
                </div>
            </div>

            {{-- Reservation Preview --}}
            <livewire:tipowerup-orange-tw::reservation-preview />

            {{-- Leave Review Component --}}
            <livewire:tipowerup-orange-tw::leave-review />
        </main>
    </div>
</div>
