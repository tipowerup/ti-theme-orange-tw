<nav class="container mx-auto px-4 py-4" x-data="{ mobileMenuOpen: false }">
    <div class="flex items-center justify-between">
        <a href="{{ page_url('home') }}" class="flex items-center">
            @if($theme->logo_image ?? false)
                <img
                    class="h-10"
                    alt="{{ setting('site_name') }}"
                    src="{{ media_url($theme->logo_image) }}"
                />
            @elseif($theme->logo_text ?? false)
                <span class="text-2xl font-bold text-primary-600">{{ $theme->logo_text }}</span>
            @else
                <img
                    class="h-10"
                    alt="{{ $site_name }}"
                    src="{{ $site_logo !== 'no_photo.png'
                        ? media_thumb($site_logo)
                        : asset('vendor/tipowerup-orange-tw/images/favicon.ico') }}"
                />
            @endif
        </a>

        <div class="hidden md:flex items-center space-x-6">
            {{-- Add your navigation menu here --}}
        </div>

        <button
            class="md:hidden text-gray-700"
            type="button"
            aria-label="Toggle navigation"
            @click="mobileMenuOpen = !mobileMenuOpen"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!mobileMenuOpen">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="mobileMenuOpen" x-cloak>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <div class="md:hidden mt-4" x-show="mobileMenuOpen" x-cloak>
        {{-- Add your mobile navigation menu here --}}
    </div>
</nav>
