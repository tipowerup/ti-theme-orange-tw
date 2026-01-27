<div class="py-12 text-center">
    <svg class="mx-auto w-24 h-24 text-text-muted dark:text-text-muted mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
    </svg>
    <h3 class="text-lg font-semibold text-text dark:text-text mb-2">@lang('tipowerup.orange-tw::default.cart.empty_title')</h3>
    <p class="text-text-muted dark:text-text-muted mb-6">@lang('tipowerup.orange-tw::default.cart.empty_text')</p>
    <a
        href="{{ restaurant_url('local/menus') }}"
        class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-colors"
        wire:navigate
    >
        @lang('tipowerup.orange-tw::default.cart.browse_menu')
    </a>
</div>
