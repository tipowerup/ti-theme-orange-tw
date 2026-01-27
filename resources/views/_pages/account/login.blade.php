---
title: tipowerup.orange-tw::default.account_login_title
layout: default
permalink: /login
security: guest

'[tipowerup-orange-tw::login]': []
---
<div class="container mx-auto px-4 py-8 lg:py-16">
    <div class="flex justify-center">
        <div class="w-full max-w-md">
            <div class="bg-surface rounded-lg border border-border shadow-sm">
                {{-- Login Component --}}
                <div class="p-6 lg:p-8">
                    <livewire:tipowerup-orange-tw::login/>
                </div>

                {{-- Social Login --}}
                <div class="px-6 pb-6 lg:px-8 lg:pb-8 border-t border-border pt-6">
                    <livewire:tipowerup-orange-tw::socialite />
                </div>
            </div>
        </div>
    </div>
</div>
