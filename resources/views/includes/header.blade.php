<header
    x-data="stickyHeader()"
    x-init="init()"
    class="fixed top-0 left-0 right-0 z-50 bg-body/95 backdrop-blur-xs border-b border-border transition-transform duration-300"
    :class="{ '-translate-y-full': !show }"
>
    <nav class="container mx-auto px-4 h-20 flex items-center">
        <div class="flex items-center justify-between w-full">
            {{-- Logo --}}
            <a href="{{ page_url('home') }}" class="flex items-center" wire:navigate>
                @if($theme->logo_image ?? false)
                    <img
                        class="h-14 w-auto object-contain"
                        alt="{{ setting('site_name') }}"
                        src="{{ media_url($theme->logo_image) }}"
                    />
                @elseif($theme->logo_text ?? false)
                    <span class="text-2xl font-bold text-primary leading-none">{{ $theme->logo_text }}</span>
                @else
                    <img
                        class="h-14 w-auto object-contain"
                        alt="{{ $site_name }}"
                        src="{{ ($site_logo ?? '') !== 'no_photo.png'
                            ? media_thumb($site_logo)
                            : asset('vendor/tipowerup-orange-tw/images/favicon.ico') }}"
                    />
                @endif
            </a>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex items-center">
                <x-tipowerup-orange-tw::nav code="main-menu" />

                {{-- Dark Mode Toggle --}}
                @if($themeData['dark_mode']['enabled'] ?? true)
                    <button
                        @click="toggleDarkMode()"
                        class="ml-2 px-3 py-2 rounded-lg text-text hover:text-primary hover:bg-surface transition-colors"
                        aria-label="Toggle dark mode"
                    >
                        <x-tipowerup-orange-tw::icon name="moon" class="w-5 h-5" x-show="!isDark" x-cloak />
                        <x-tipowerup-orange-tw::icon name="sun" class="w-5 h-5" x-show="isDark" x-cloak />
                    </button>
                @endif
            </div>

            {{-- Mobile: Account dropdown (mirrors desktop main-menu's Account
                 dropdown). Signed out → Login / Register; signed in → My
                 Account / Orders / Address / Reservations / Logout. --}}
            @php($isLogged = \Igniter\User\Facades\Auth::isLogged())
            <div class="md:hidden relative" x-data="{ open: false }" @click.outside="open = false">
                <button
                    type="button"
                    @click="open = !open"
                    :class="open ? 'text-primary' : 'text-text hover:text-primary'"
                    class="p-2 -mr-2 transition-colors"
                    aria-label="{{ $isLogged ? 'My account' : 'Sign in' }}"
                    aria-haspopup="true"
                    :aria-expanded="open"
                >
                    <x-tipowerup-orange-tw::icon name="user" class="w-6 h-6" />
                </button>

                <div
                    x-show="open"
                    x-cloak
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    @click="open = false"
                    class="absolute right-0 mt-2 w-56 bg-body border border-border rounded-lg shadow-lg py-2 origin-top-right z-50"
                >
                    @if($isLogged)
                        <a href="{{ page_url('account.account') }}" wire:navigate class="block px-4 py-2 text-sm text-text hover:text-primary hover:bg-surface transition-colors">@lang('tipowerup.orange-tw::default.nav.my_account')</a>
                        <a href="{{ page_url('account.orders') }}" wire:navigate class="block px-4 py-2 text-sm text-text hover:text-primary hover:bg-surface transition-colors">@lang('tipowerup.orange-tw::default.nav.recent_orders')</a>
                        <a href="{{ page_url('account.address') }}" wire:navigate class="block px-4 py-2 text-sm text-text hover:text-primary hover:bg-surface transition-colors">@lang('tipowerup.orange-tw::default.nav.address_book')</a>
                        <a href="{{ page_url('account.reservations') }}" wire:navigate class="block px-4 py-2 text-sm text-text hover:text-primary hover:bg-surface transition-colors">@lang('tipowerup.orange-tw::default.nav.reservations')</a>
                        <div class="my-1 border-t border-border"></div>
                        <a href="{{ page_url('account.logout') }}" class="block px-4 py-2 text-sm text-text hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">@lang('tipowerup.orange-tw::default.nav.logout')</a>
                    @else
                        <a href="{{ page_url('account.login') }}" wire:navigate class="block px-4 py-2 text-sm text-text hover:text-primary hover:bg-surface transition-colors">@lang('tipowerup.orange-tw::default.nav.login')</a>
                        <a href="{{ page_url('account.register') }}" wire:navigate class="block px-4 py-2 text-sm text-text hover:text-primary hover:bg-surface transition-colors">@lang('tipowerup.orange-tw::default.nav.register')</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</header>

{{-- Spacer to prevent content from hiding behind fixed header --}}
<div class="h-20"></div>
