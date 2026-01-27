<header
    x-data="stickyHeader()"
    x-init="init()"
    class="fixed top-0 left-0 right-0 z-50 bg-body/95 backdrop-blur-sm border-b border-border transition-transform duration-300"
    :class="{ '-translate-y-full': !show }"
>
    <nav class="container mx-auto px-4 py-4" x-data="{ mobileMenuOpen: false }">
        <div class="flex items-center justify-between">
            {{-- Logo --}}
            <a href="{{ page_url('home') }}" class="flex items-center" wire:navigate>
                @if($theme->logo_image ?? false)
                    <img
                        class="h-10"
                        alt="{{ setting('site_name') }}"
                        src="{{ media_url($theme->logo_image) }}"
                    />
                @elseif($theme->logo_text ?? false)
                    <span class="text-2xl font-bold text-primary">{{ $theme->logo_text }}</span>
                @else
                    <img
                        class="h-10"
                        alt="{{ $site_name }}"
                        src="{{ ($site_logo ?? '') !== 'no_photo.png'
                            ? media_thumb($site_logo)
                            : asset('vendor/tipowerup-orange-tw/images/favicon.ico') }}"
                    />
                @endif
            </a>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ page_url('home') }}" class="text-text hover:text-primary transition-colors" wire:navigate>
                    Home
                </a>
                <a href="{{ page_url('locations') }}" class="text-text hover:text-primary transition-colors" wire:navigate>
                    Locations
                </a>
                <a href="{{ restaurant_url('local/menus') }}" class="text-text hover:text-primary transition-colors" wire:navigate>
                    Menu
                </a>

                {{-- Cart Icon --}}
                <a href="{{ page_url('checkout/cart') }}" class="relative text-text hover:text-primary transition-colors" wire:navigate>
                    <x-tipowerup-orange-tw::icon name="shopping-cart" class="w-6 h-6" />
                    <span class="absolute -top-2 -right-2 bg-primary text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                        0
                    </span>
                </a>

                {{-- Dark Mode Toggle --}}
                @if($theme->dark_mode['enabled'] ?? true)
                    <button
                        @click="toggleDarkMode()"
                        class="text-text hover:text-primary transition-colors"
                        aria-label="Toggle dark mode"
                    >
                        <x-tipowerup-orange-tw::icon name="moon" class="w-6 h-6" x-show="!isDark" />
                        <x-tipowerup-orange-tw::icon name="sun" class="w-6 h-6" x-show="isDark" />
                    </button>
                @endif
            </div>

            {{-- Mobile Menu Button --}}
            <button
                class="md:hidden text-text"
                type="button"
                aria-label="Toggle navigation"
                @click="mobileMenuOpen = !mobileMenuOpen"
            >
                <x-tipowerup-orange-tw::icon name="menu" class="w-6 h-6" x-show="!mobileMenuOpen" />
                <x-tipowerup-orange-tw::icon name="x" class="w-6 h-6" x-show="mobileMenuOpen" x-cloak />
            </button>
        </div>

        {{-- Mobile Navigation --}}
        <div
            class="md:hidden mt-4 space-y-4"
            x-show="mobileMenuOpen"
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
        >
            <a href="{{ page_url('home') }}" class="block text-text hover:text-primary transition-colors" wire:navigate>
                Home
            </a>
            <a href="{{ page_url('locations') }}" class="block text-text hover:text-primary transition-colors" wire:navigate>
                Locations
            </a>
            <a href="{{ restaurant_url('local/menus') }}" class="block text-text hover:text-primary transition-colors" wire:navigate>
                Menu
            </a>
            <a href="{{ page_url('checkout/cart') }}" class="block text-text hover:text-primary transition-colors" wire:navigate>
                Cart
            </a>

            @if($theme->dark_mode['enabled'] ?? true)
                <button
                    @click="toggleDarkMode()"
                    class="flex items-center space-x-2 text-text hover:text-primary transition-colors"
                >
                    <x-tipowerup-orange-tw::icon name="moon" class="w-5 h-5" x-show="!isDark" />
                    <x-tipowerup-orange-tw::icon name="sun" class="w-5 h-5" x-show="isDark" />
                    <span x-text="isDark ? 'Light Mode' : 'Dark Mode'"></span>
                </button>
            @endif
        </div>
    </nav>
</header>

{{-- Spacer to prevent content from hiding behind fixed header --}}
<div class="h-20"></div>
