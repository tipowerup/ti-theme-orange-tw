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
            <div class="hidden md:flex items-center">
                <x-tipowerup-orange-tw::nav code="main-menu" />

                {{-- Dark Mode Toggle --}}
                @if($theme->dark_mode['enabled'] ?? true)
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
            class="md:hidden mt-4"
            x-show="mobileMenuOpen"
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
        >
            @include('tipowerup-orange-tw::includes.navs.mobile-menu')

            @if($theme->dark_mode['enabled'] ?? true)
                <button
                    @click="toggleDarkMode()"
                    class="flex items-center w-full px-4 py-2 mt-1 rounded-lg text-text hover:text-primary hover:bg-surface transition-colors"
                >
                    <x-tipowerup-orange-tw::icon name="moon" class="w-5 h-5 mr-2" x-show="!isDark" x-cloak />
                    <x-tipowerup-orange-tw::icon name="sun" class="w-5 h-5 mr-2" x-show="isDark" x-cloak />
                    <span x-show="isDark" x-cloak>@lang('tipowerup.orange-tw::default.nav.light_mode')</span>
                    <span x-show="!isDark" x-cloak>@lang('tipowerup.orange-tw::default.nav.dark_mode')</span>
                </button>
            @endif
        </div>
    </nav>
</header>

{{-- Spacer to prevent content from hiding behind fixed header --}}
<div class="h-20"></div>
