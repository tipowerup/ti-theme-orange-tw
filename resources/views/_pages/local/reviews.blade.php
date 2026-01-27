---
title: 'Reviews'
permalink: '/:location?local/reviews'
description: ''
layout: default

'[tipowerup-orange-tw::local-header]': []
'[tipowerup-orange-tw::review-list]': []
'[tipowerup-orange-tw::cart-box]': []
---
<?php
function onStart()
{
    if (request()->route()->parameter('location') !== \Igniter\Local\Facades\Location::current()->permalink_slug) {
        return redirect()->to(page_url('home'));
    }

    if (!\Igniter\Local\Models\ReviewSettings::allowReviews()) {
        flash()->error(lang('igniter.local::default.review.alert_review_disabled'));
        return redirect()->to(page_url('home'));
    }

    return null;
}
?>
---
<div class="bg-body dark:bg-surface border-b border-border dark:border-border">
    <div class="container py-6">
        <div class="mb-6">
            <a
                wire:navigate
                class="inline-flex items-center text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors"
                href="{{ restaurant_url('local/menus') }}"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                @lang('igniter.orange::default.button_back')
            </a>
        </div>
        <div class="flex flex-col md:flex-row md:items-end md:justify-between">
            <div class="flex-1">
                <x-tipowerup-orange-tw::local-header />
            </div>
        </div>
    </div>
</div>

<div class="container pt-6 pb-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <livewire:tipowerup-orange-tw::review-list />
        </div>

        <div class="hidden lg:block">
            <div class="sticky top-6">
                <livewire:tipowerup-orange-tw::cart-box />
            </div>
        </div>
    </div>
</div>
