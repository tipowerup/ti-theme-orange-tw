---
title: 'Reservation'
layout: default
permalink: ':location/reservation'

'[tipowerup-orange-tw::booking]': []
---
<div class="container pt-6 pb-12">
    <div class="mb-6">
        <a
            wire:navigate
            class="inline-flex items-center text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors"
            href="{{ page_url('locations') }}"
        >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            @lang('igniter.orange::default.button_back')
        </a>
    </div>

    <div class="bg-body dark:bg-surface rounded-lg shadow-md overflow-hidden">
        <div class="p-6 border-b border-border dark:border-border">
            <x-tipowerup-orange-tw::local-header current-page="reservation.reservation" />
        </div>
    </div>

    <livewire:tipowerup-orange-tw::booking />
</div>
