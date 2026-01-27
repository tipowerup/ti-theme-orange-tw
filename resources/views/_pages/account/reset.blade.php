---
title: tipowerup.orange-tw::default.account_reset_title
layout: default
permalink: /forgot-password/:code?
security: guest

'[tipowerup-orange-tw::reset-password]': []
---
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <div class="bg-surface rounded-lg shadow-lg border border-border p-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-text">
                    @lang('tipowerup.orange-tw::default.account_reset_title')
                </h1>
            </div>

            <livewire:tipowerup-orange-tw::reset-password />

            <div class="mt-6 text-center">
                <a
                    href="{{ page_url('account/login') }}"
                    wire:navigate
                    class="text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 font-medium"
                >
                    @lang('tipowerup.orange-tw::default.text_back_to_login')
                </a>
            </div>
        </div>
    </div>
</div>
