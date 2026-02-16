<nav class="space-y-1">
    <a
        href="{{ page_url('account.account') }}"
        wire:navigate
        @class([
            'flex items-center px-4 py-3 rounded-lg font-medium transition-colors',
            'text-primary bg-primary/10' => $activePage == 'account-account',
            'text-text hover:text-primary hover:bg-surface' => $activePage != 'account-account',
        ])
    >
        <svg class="w-5 h-5 mr-3 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        @lang('tipowerup.orange-tw::default.nav.my_account')
    </a>

    <a
        href="{{ page_url('account.address') }}"
        wire:navigate
        @class([
            'flex items-center px-4 py-3 rounded-lg font-medium transition-colors',
            'text-primary bg-primary/10' => $activePage == 'account-address',
            'text-text hover:text-primary hover:bg-surface' => $activePage != 'account-address',
        ])
    >
        <svg class="w-5 h-5 mr-3 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        @lang('tipowerup.orange-tw::default.nav.address_book')
    </a>

    <a
        href="{{ page_url('account.orders') }}"
        wire:navigate
        @class([
            'flex items-center px-4 py-3 rounded-lg font-medium transition-colors',
            'text-primary bg-primary/10' => in_array($activePage, ['account-order', 'account-orders']),
            'text-text hover:text-primary hover:bg-surface' => !in_array($activePage, ['account-order', 'account-orders']),
        ])
    >
        <svg class="w-5 h-5 mr-3 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
        </svg>
        @lang('tipowerup.orange-tw::default.nav.recent_orders')
    </a>

    <a
        href="{{ page_url('account.reservations') }}"
        wire:navigate
        @class([
            'flex items-center px-4 py-3 rounded-lg font-medium transition-colors',
            'text-primary bg-primary/10' => in_array($activePage, ['account-reservation', 'account-reservations']),
            'text-text hover:text-primary hover:bg-surface' => !in_array($activePage, ['account-reservation', 'account-reservations']),
        ])
    >
        <svg class="w-5 h-5 mr-3 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        @lang('tipowerup.orange-tw::default.nav.reservations')
    </a>

    <a
        href="{{ page_url('account.logout') }}"
        @class([
            'flex items-center px-4 py-3 rounded-lg font-medium transition-colors',
            'text-text hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20',
        ])
    >
        <svg class="w-5 h-5 mr-3 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
        </svg>
        @lang('tipowerup.orange-tw::default.nav.logout')
    </a>
</nav>
