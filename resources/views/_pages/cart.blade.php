---
title: Cart
layout: default
permalink: /cart

'[tipowerup-orange-tw::cart-box]': []
---
<div class="container mx-auto px-4 py-8 lg:py-12">
    <div class="max-w-3xl mx-auto">
        {{-- Back button --}}
        <div class="mb-6" wire:ignore>
            <a
                href="{{ restaurant_url('local/menus') }}"
                class="inline-flex items-center text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors"
                wire:navigate
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                @lang('tipowerup.orange-tw::default.cart.back_to_menu')
            </a>
        </div>

        {{-- Cart box component --}}
        <div class="bg-surface rounded-lg shadow-sm border border-border">
            <livewire:tipowerup-orange-tw::cart-box />
        </div>
    </div>
</div>
