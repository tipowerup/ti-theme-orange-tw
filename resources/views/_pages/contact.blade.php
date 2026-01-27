---
title: tipowerup.orange-tw::default.contact_title
description: ''
permalink: /contact
layout: default

'[tipowerup-orange-tw::contact]': []
---

<!-- Page Header -->
<section class="bg-gradient-to-b from-primary-50 to-white dark:from-body dark:to-surface border-b border-border dark:border-border">
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-text dark:text-text mb-4">
                @lang('tipowerup.orange-tw::default.contact.text_contact_us')
            </h1>
            <p class="text-lg text-text-muted dark:text-text">
                @lang('tipowerup.orange-tw::default.contact.text_summary')
            </p>
        </div>
    </div>
</section>

<!-- Contact Content -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Contact Form (2/3 width) -->
            <div class="lg:col-span-2">
                <div class="bg-body dark:bg-surface rounded-lg shadow-lg p-6 md:p-8">
                    <h2 class="text-2xl font-bold text-text dark:text-text mb-6">
                        @lang('tipowerup.orange-tw::default.contact.text_get_in_touch')
                    </h2>
                    <livewire:tipowerup-orange-tw::contact />
                </div>
            </div>

            <!-- Contact Info Sidebar (1/3 width) -->
            <div class="space-y-6">
                <!-- Location Info -->
                @include('tipowerup-orange-tw::includes.contact.info')

                <!-- Business Hours -->
                @include('tipowerup-orange-tw::includes.contact.hours')

                <!-- Social Links -->
                @if($theme->social_icons ?? false)
                    <div class="bg-body dark:bg-surface rounded-lg shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-text dark:text-text mb-4">
                            Follow Us
                        </h3>
                        <div class="flex gap-3">
                            @foreach($theme->social_icons as $icon)
                                <a
                                    href="{{ $icon['url'] }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="w-10 h-10 rounded-full bg-surface dark:bg-surface hover:bg-primary-600 dark:hover:bg-primary-600 text-text-muted dark:text-text hover:text-white transition-colors duration-200 flex items-center justify-center"
                                    title="{{ $icon['title'] ?? '' }}"
                                >
                                    <i class="fa fa-{{ $icon['icon'] }}"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Map Section -->
        @include('tipowerup-orange-tw::includes.contact.map')
    </div>
</section>
