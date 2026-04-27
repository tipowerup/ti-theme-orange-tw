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
            <livewire:tipowerup-orange-tw::local-search />
        </div>
    </div>
</section>

<!-- Featured Items Section -->
<x-tipowerup-orange-tw::featured-items />

<!-- How It Works Section -->
@php($isSingleLocation = \Igniter\Local\Models\Location::whereIsEnabled()->count() === 1)
<section class="py-16 bg-surface dark:bg-surface">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-text dark:text-text mb-4">
                {{ $isSingleLocation ? 'Ordering Made Simple' : 'How It Works' }}
            </h2>
            <p class="text-lg text-text-muted dark:text-text">
                {{ $isSingleLocation ? 'From our kitchen to your table in three easy steps' : 'Great food from nearby restaurants in three simple steps' }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            @if ($isSingleLocation)
                <!-- Step 1: Browse -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa fa-book-open text-3xl text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-text dark:text-text mb-3">
                        Browse the Menu
                    </h3>
                    <p class="text-text-muted dark:text-text-muted">
                        Explore our dishes and add your favorites to the cart
                    </p>
                </div>

                <!-- Step 2: Order -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa fa-receipt text-3xl text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-text dark:text-text mb-3">
                        Place Your Order
                    </h3>
                    <p class="text-text-muted dark:text-text-muted">
                        Choose delivery or pickup and check out in a few taps
                    </p>
                </div>

                <!-- Step 3: Enjoy -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa fa-utensils text-3xl text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-text dark:text-text mb-3">
                        Enjoy Your Meal
                    </h3>
                    <p class="text-text-muted dark:text-text-muted">
                        We'll have it hot and ready, fresh from our kitchen
                    </p>
                </div>
            @else
                <!-- Step 1: Find -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa fa-map-marker-alt text-3xl text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-text dark:text-text mb-3">
                        Find a Restaurant
                    </h3>
                    <p class="text-text-muted dark:text-text-muted">
                        Enter your address to see which restaurants deliver to you
                    </p>
                </div>

                <!-- Step 2: Order -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa fa-book-open text-3xl text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-text dark:text-text mb-3">
                        Browse &amp; Order
                    </h3>
                    <p class="text-text-muted dark:text-text-muted">
                        Pick your dishes, customise them, and place your order
                    </p>
                </div>

                <!-- Step 3: Enjoy -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa fa-utensils text-3xl text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-text dark:text-text mb-3">
                        Delivery or Pickup
                    </h3>
                    <p class="text-text-muted dark:text-text-muted">
                        Get it delivered to your door, or pick it up yourself
                    </p>
                </div>
            @endif
        </div>

        @unless ($isSingleLocation)
            <div class="text-center mt-12">
                <a
                    href="{{ restaurant_url('local.menus') }}"
                    wire:navigate
                    class="inline-flex items-center px-8 py-4 bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white font-semibold rounded-lg transition-colors duration-200 text-lg shadow-lg hover:shadow-xl"
                >
                    Get Started Now
                    <i class="fa fa-arrow-right ml-2"></i>
                </a>
            </div>
        @endunless
    </div>
</section>
