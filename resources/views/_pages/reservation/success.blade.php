---
title: 'Reservation Confirmed'
layout: default
permalink: ':location/reservation/success/:hash'

'[tipowerup-orange-tw::reservation-preview]':
    redirectPage: reservation.reservation
---
<?php
function onStart()
{
    if (!request()->route()->parameter('hash')) {
        return redirect()->to(page_url('home'));
    }

    return null;
}
?>
---
<div class="container pt-12 pb-24">
    <div class="max-w-2xl mx-auto">
        <div class="bg-surface rounded-lg shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-primary-600 to-primary-700 p-6 text-white">
                <div class="flex items-center justify-center mb-4">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-center">@lang('tipowerup.orange-tw::default.reservations.confirmed_title')</h1>
                <p class="text-center mt-2 text-primary-100">@lang('tipowerup.orange-tw::default.reservations.confirmed_text')</p>
            </div>

            <div class="p-8">
                <livewire:tipowerup-orange-tw::reservation-preview />

                <div class="mt-8 space-y-4">
                    <div class="bg-body rounded-lg p-4">
                        <h3 class="font-semibold text-text mb-2">@lang('tipowerup.orange-tw::default.reservations.whats_next')</h3>
                        <ul class="space-y-2 text-sm text-text-muted">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-primary-600 dark:text-primary-400 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>@lang('tipowerup.orange-tw::default.reservations.confirmation_email')</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-primary-600 dark:text-primary-400 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>@lang('tipowerup.orange-tw::default.reservations.arrive_early')</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-primary-600 dark:text-primary-400 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>@lang('tipowerup.orange-tw::default.reservations.manage_reservation')</span>
                            </li>
                        </ul>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a
                            wire:navigate
                            href="{{ page_url('account.reservations') }}"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors"
                        >
                            @lang('tipowerup.orange-tw::default.reservations.view_my_reservations')
                        </a>
                        <a
                            wire:navigate
                            href="{{ page_url('home') }}"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-surface border border-border text-text hover:bg-body font-medium rounded-lg transition-colors"
                        >
                            @lang('tipowerup.orange-tw::default.reservations.return_home')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
