---
title: Menu
permalink: '/:location?local/menus/:category?'
description: Browse our delicious menu items
layout: default
hideFooter: 1

'[tipowerup-orange-tw::local-header]': []
'[tipowerup-orange-tw::fulfillment]': []
'[tipowerup-orange-tw::category-list]': []
'[tipowerup-orange-tw::menu-item-list]': []
'[tipowerup-orange-tw::cart-box]': []
'[tipowerup-orange-tw::fulfillment-modal]': []
---

<!-- Header Section -->
<div class="bg-body dark:bg-surface border-b border-border dark:border-border">
    <div class="container mx-auto px-4 py-6">
        <div class="mb-4">
            <a
                href="{{ page_url('locations') }}"
                wire:navigate
                class="inline-flex items-center text-text-muted dark:text-text-muted hover:text-primary-600 dark:hover:text-primary-400 transition-colors"
            >
                <i class="fa fa-arrow-left mr-2"></i>
                Back to Locations
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            <div class="lg:col-span-2">
                <x-tipowerup-orange-tw::local-header/>
            </div>

            <div class="flex justify-end">
                <div class="bg-surface dark:bg-surface border border-border dark:border-border rounded-lg p-4 w-full lg:w-auto">
                    <x-tipowerup-orange-tw::fulfillment/>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Category Navigation (Sticky) -->
<div class="sticky top-0 z-40 bg-body dark:bg-surface border-b border-border dark:border-border shadow-sm">
    <div class="container mx-auto px-4">
        <x-tipowerup-orange-tw::category-list/>
    </div>
</div>

<!-- Main Content -->
<div class="container mx-auto px-4 py-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Menu Items -->
        <div class="lg:col-span-2">
            <livewire:tipowerup-orange-tw::menu-item-list/>
        </div>

        <!-- Cart Sidebar (Desktop Only) -->
        <div class="hidden lg:block">
            <div class="sticky top-32">
                <div class="bg-body dark:bg-surface border border-border dark:border-border rounded-lg overflow-hidden shadow-sm">
                    <livewire:tipowerup-orange-tw::cart-box/>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fulfillment Modal -->
<livewire:tipowerup-orange-tw::fulfillment-modal/>
