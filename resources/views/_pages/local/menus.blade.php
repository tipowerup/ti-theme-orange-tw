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
                class="inline-flex items-center text-sm font-medium text-text-muted dark:text-text-muted hover:text-primary dark:hover:text-primary transition-colors"
            >
                <i class="fa fa-exchange-alt mr-2"></i>
                @lang('tipowerup.orange-tw::default.local_header.switch_location')
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            <div class="lg:col-span-2">
                <x-tipowerup-orange-tw::local-header/>
            </div>

            <div class="flex items-center justify-end">
                <x-tipowerup-orange-tw::fulfillment/>
            </div>
        </div>
    </div>
</div>

<!-- Category Navigation (Sticky - dynamic position based on navbar) -->
<div
    x-data="{ navbarVisible: true }"
    @navbar-show.window="navbarVisible = true"
    @navbar-hide.window="navbarVisible = false"
    class="sticky z-40 bg-body/95 dark:bg-surface/95 backdrop-blur-sm border-b border-border dark:border-border shadow-sm transition-[top] duration-300"
    :class="navbarVisible ? 'top-[72px]' : 'top-0'"
>
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
        <div
            class="hidden lg:block"
            x-data="{ navbarVisible: true }"
            @navbar-show.window="navbarVisible = true"
            @navbar-hide.window="navbarVisible = false"
        >
            <div
                class="sticky transition-[top] duration-300 flex flex-col"
                :style="{ top: navbarVisible ? '140px' : '68px', maxHeight: navbarVisible ? 'calc(100vh - 156px)' : 'calc(100vh - 84px)' }"
            >
                <div class="bg-body dark:bg-surface border border-border dark:border-border rounded-lg shadow-sm overflow-hidden">
                    <livewire:tipowerup-orange-tw::cart-box/>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fulfillment Modal -->
<livewire:tipowerup-orange-tw::fulfillment-modal/>
