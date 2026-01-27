---
title: igniter.user::default.account_title
permalink: /account
layout: default
security: customer

'[tipowerup-orange-tw::account-dashboard]': []
'[tipowerup-orange-tw::account-settings]': []
---
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-6">
        <div class="lg:w-64 flex-shrink-0">
            <x-tipowerup-orange-tw::nav code="account-menu" />
        </div>

        <div class="flex-1 space-y-6">
            <x-tipowerup-orange-tw::account-dashboard />
            <livewire:tipowerup-orange-tw::account-settings />
        </div>
    </div>
</div>
