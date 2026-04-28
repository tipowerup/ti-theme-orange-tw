{{-- Mobile Bottom Tab Bar - Only visible on mobile devices --}}
<div
    x-data="{ moreOpen: false, cartOpen: false }"
    x-effect="document.body.classList.toggle('overflow-hidden', moreOpen || cartOpen)"
    class="md:hidden"
>
    <nav class="fixed bottom-0 left-0 right-0 z-40 bg-body border-t border-border">
        <div class="flex items-center justify-around h-16">
            {{-- Home --}}
            <a
                href="{{ page_url('home') }}"
                wire:navigate
                :class="($store.nav.path === '/' || $store.nav.path === '') ? 'text-primary' : 'text-text-muted'"
                class="relative flex flex-col items-center justify-center flex-1 h-full transition-colors"
            >
                <span x-show="($store.nav.path === '/' || $store.nav.path === '')" x-cloak class="absolute top-0 left-1/2 -translate-x-1/2 w-10 h-0.5 rounded-b-full bg-primary"></span>
                <x-tipowerup-orange-tw::icon name="home" class="w-6 h-6" />
                <span class="text-xs mt-1">Home</span>
            </a>

            {{-- Menu --}}
            <a
                href="{{ restaurant_url('local/menus') }}"
                wire:navigate
                :class="$store.nav.path.includes('menus') ? 'text-primary' : 'text-text-muted'"
                class="relative flex flex-col items-center justify-center flex-1 h-full transition-colors"
            >
                <span x-show="$store.nav.path.includes('menus')" x-cloak class="absolute top-0 left-1/2 -translate-x-1/2 w-10 h-0.5 rounded-b-full bg-primary"></span>
                <x-tipowerup-orange-tw::icon name="book-open" class="w-6 h-6" />
                <span class="text-xs mt-1">Menu</span>
            </a>

            {{-- Cart — opens right-edge drawer --}}
            <button
                type="button"
                @click="cartOpen = true"
                :class="cartOpen ? 'text-primary' : 'text-text-muted'"
                class="relative flex flex-col items-center justify-center flex-1 h-full transition-colors"
                aria-label="Cart"
            >
                <span x-show="cartOpen" x-cloak class="absolute top-0 left-1/2 -translate-x-1/2 w-10 h-0.5 rounded-b-full bg-primary"></span>
                <div class="relative">
                    <x-tipowerup-orange-tw::icon name="shopping-cart" class="w-6 h-6" />
                    <livewire:tipowerup-orange-tw::cart-count />
                </div>
                <span class="text-xs mt-1">Cart</span>
            </button>

            {{-- Reservation --}}
            <a
                href="{{ page_url('reservation.reservation') }}"
                wire:navigate
                :class="$store.nav.path.includes('reservation') ? 'text-primary' : 'text-text-muted'"
                class="relative flex flex-col items-center justify-center flex-1 h-full transition-colors"
            >
                <span x-show="$store.nav.path.includes('reservation')" x-cloak class="absolute top-0 left-1/2 -translate-x-1/2 w-10 h-0.5 rounded-b-full bg-primary"></span>
                <x-tipowerup-orange-tw::icon name="calendar" class="w-6 h-6" />
                <span class="text-xs mt-1">Reserve</span>
            </a>

            {{-- More — overflow tab for everything that doesn't fit the
                 4 primary destinations: locations, admin-defined pages
                 (About, Contact, FAQ…), dark-mode toggle. --}}
            <button
                type="button"
                @click="moreOpen = true"
                :class="moreOpen ? 'text-primary' : 'text-text-muted'"
                class="relative flex flex-col items-center justify-center flex-1 h-full transition-colors"
                aria-label="More"
            >
                <span x-show="moreOpen" x-cloak class="absolute top-0 left-1/2 -translate-x-1/2 w-10 h-0.5 rounded-b-full bg-primary"></span>
                <x-tipowerup-orange-tw::icon name="menu" class="w-6 h-6" />
                <span class="text-xs mt-1">More</span>
            </button>
        </div>
    </nav>

    {{-- More sheet (mobile) — native iOS/Android-style bottom sheet --}}
    <div
        x-show="moreOpen"
        x-cloak
        @keydown.escape.window="moreOpen = false"
        class="fixed inset-0 z-50"
    >
        {{-- Backdrop with blur for depth, like iOS sheets --}}
        <div
            x-show="moreOpen"
            x-transition:enter="transition-opacity duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="moreOpen = false"
            class="absolute inset-0 bg-black/40 backdrop-blur-sm"
        ></div>

        {{-- Sheet --}}
        <div
            x-show="moreOpen"
            x-transition:enter="transition ease-[cubic-bezier(0.32,0.72,0,1)] duration-[400ms]"
            x-transition:enter-start="translate-y-full"
            x-transition:enter-end="translate-y-0"
            x-transition:leave="transition ease-[cubic-bezier(0.32,0.72,0,1)] duration-300"
            x-transition:leave-start="translate-y-0"
            x-transition:leave-end="translate-y-full"
            class="absolute bottom-0 left-0 right-0 bg-body rounded-t-3xl shadow-2xl shadow-black/20 max-h-[85vh] overflow-y-auto overscroll-contain pb-[env(safe-area-inset-bottom)]"
        >
            {{-- Drag handle --}}
            <div class="flex justify-center pt-2.5 pb-2">
                <div class="w-9 h-1 rounded-full bg-text-muted/30"></div>
            </div>

            {{-- Sheet header --}}
            <div class="flex items-center justify-between px-5 pt-2 pb-4">
                <h2 class="text-xl font-bold text-text">More</h2>
                <button
                    type="button"
                    @click="moreOpen = false"
                    class="w-8 h-8 flex items-center justify-center rounded-full bg-surface text-text-muted hover:bg-border transition-colors"
                    aria-label="Close"
                >
                    <x-tipowerup-orange-tw::icon name="x" class="w-4 h-4" />
                </button>
            </div>

            <div class="px-4 pb-6 space-y-6">
                {{-- Section: Admin-defined mobile navigation. Theme seeds this menu
                     (resources/meta/menus/mobile-menu.php) with Locations, Contact,
                     About, Privacy, Terms — admins can edit/extend in the admin. --}}
                <section>
                    <h3 class="px-3 mb-2 text-xs font-semibold uppercase tracking-wider text-text-muted">Browse</h3>
                    <div class="bg-surface rounded-2xl overflow-hidden" @click="moreOpen = false">
                        <x-tipowerup-orange-tw::nav code="mobile-menu" />
                    </div>
                </section>

                {{-- Section: Preferences --}}
                @if($themeData['dark_mode']['enabled'] ?? true)
                    <section>
                        <h3 class="px-3 mb-2 text-xs font-semibold uppercase tracking-wider text-text-muted">Preferences</h3>
                        <div class="bg-surface rounded-2xl overflow-hidden">
                            <button
                                type="button"
                                @click="toggleDarkMode()"
                                class="flex items-center gap-4 w-full px-4 py-3.5 text-text hover:bg-body active:bg-body transition-colors"
                            >
                                <span class="w-9 h-9 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                    <x-tipowerup-orange-tw::icon name="moon" class="w-5 h-5" x-show="!isDark" x-cloak />
                                    <x-tipowerup-orange-tw::icon name="sun" class="w-5 h-5" x-show="isDark" x-cloak />
                                </span>
                                <span class="flex-1 text-left font-medium">
                                    <span x-show="!isDark" x-cloak>@lang('tipowerup.orange-tw::default.nav.dark_mode')</span>
                                    <span x-show="isDark" x-cloak>@lang('tipowerup.orange-tw::default.nav.light_mode')</span>
                                </span>
                                {{-- iOS-style toggle pill --}}
                                <span
                                    :class="isDark ? 'bg-primary' : 'bg-border'"
                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors shrink-0"
                                    aria-hidden="true"
                                >
                                    <span
                                        :class="isDark ? 'translate-x-6' : 'translate-x-1'"
                                        class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform shadow-sm"
                                    ></span>
                                </span>
                            </button>
                        </div>
                    </section>
                @endif
            </div>
        </div>
    </div>

    {{-- Cart drawer (mobile) — slides in from the right with the live cart-box --}}
    <div
        x-show="cartOpen"
        x-cloak
        @keydown.escape.window="cartOpen = false"
        @cart-drawer-close.window="cartOpen = false"
        class="fixed inset-0 z-50"
    >
        {{-- Backdrop --}}
        <div
            x-show="cartOpen"
            x-transition:enter="transition-opacity duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="cartOpen = false"
            class="absolute inset-0 bg-black/40 backdrop-blur-sm"
        ></div>

        {{-- Panel --}}
        <div
            x-show="cartOpen"
            x-transition:enter="transition ease-[cubic-bezier(0.32,0.72,0,1)] duration-[400ms]"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-[cubic-bezier(0.32,0.72,0,1)] duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="absolute top-0 right-0 bottom-0 w-full max-w-sm bg-body shadow-2xl shadow-black/20 flex flex-col pb-[env(safe-area-inset-bottom)]"
        >
            {{-- Cart-box self-manages: sticky header (with mobile close X), scrollable middle, sticky footer --}}
            <livewire:tipowerup-orange-tw::cart-box />
        </div>
    </div>
</div>

{{-- Spacer to prevent content from hiding behind fixed bottom bar --}}
<div class="md:hidden h-16"></div>
