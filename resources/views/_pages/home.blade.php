---
title: tipowerup.orange-tw::default.home_title
description: ''
permalink: /
layout: default

'[tipowerup-orange-tw::slider]':
    code: home-slider
'[tipowerup-orange-tw::featured-items]': []
---

<!-- Hero Slider -->
<x-tipowerup-orange-tw::slider />

<!-- Local Search Section -->
<section class="bg-gradient-to-b from-body to-surface dark:from-body dark:to-surface border-b border-border dark:border-border">
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-3xl mx-auto">
            <livewire:local-search.local-search />
        </div>
    </div>
</section>

<!-- Featured Items Section -->
<x-tipowerup-orange-tw::featured-items />

<!-- How It Works Section -->
<section class="py-16 bg-surface dark:bg-surface">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-text dark:text-text mb-4">
                How It Works
            </h2>
            <p class="text-lg text-text-muted dark:text-text">
                Order your favorite food in three simple steps
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <!-- Step 1 -->
            <div class="text-center">
                <div class="w-20 h-20 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-text dark:text-text mb-3">
                    Search Location
                </h3>
                <p class="text-text-muted dark:text-text-muted">
                    Enter your address to find nearby restaurants
                </p>
            </div>

            <!-- Step 2 -->
            <div class="text-center">
                <div class="w-20 h-20 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-text dark:text-text mb-3">
                    Choose Your Meal
                </h3>
                <p class="text-text-muted dark:text-text-muted">
                    Browse the menu and add items to your cart
                </p>
            </div>

            <!-- Step 3 -->
            <div class="text-center">
                <div class="w-20 h-20 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-text dark:text-text mb-3">
                    Enjoy Your Food
                </h3>
                <p class="text-text-muted dark:text-text-muted">
                    Get your food delivered or pick it up yourself
                </p>
            </div>
        </div>

        <div class="text-center mt-12">
            <a
                href="{{ restaurant_url('local.menus') }}"
                wire:navigate
                class="inline-flex items-center px-8 py-4 bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white font-semibold rounded-lg transition-colors duration-200 text-lg shadow-lg hover:shadow-xl"
            >
                Get Started Now
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</section>
