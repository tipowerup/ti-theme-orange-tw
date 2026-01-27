---
title: tipowerup.orange-tw::default.account_register_title
permalink: /register
description: ''
layout: default
security: guest

'[tipowerup-orange-tw::register]':
    agreeTermsSlug: terms-and-conditions
---
<div class="container mx-auto px-4 py-8 lg:py-16">
    <div class="flex justify-center">
        <div class="w-full max-w-2xl">
            {{-- Register Component --}}
            <livewire:tipowerup-orange-tw::register />

            {{-- Social Login (if available) --}}
            @if (class_exists('Igniter\Socialite\Livewire\Socialite'))
                <div class="mt-6">
                    <div class="bg-surface rounded-lg border border-border shadow-sm p-6 lg:p-8">
                        <div class="text-center mb-4">
                            <span class="text-sm text-text-muted">@lang('tipowerup.orange-tw::default.text_or_register_with')</span>
                        </div>
                        <livewire:igniter-socialite::socialite/>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
