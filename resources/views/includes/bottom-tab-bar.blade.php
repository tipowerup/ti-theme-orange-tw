{{-- Mobile Bottom Tab Bar - Only visible on mobile devices --}}
<nav class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-body border-t border-border">
    <div class="flex items-center justify-around h-16">
        {{-- Home --}}
        <a
            href="{{ page_url('home') }}"
            wire:navigate
            class="flex flex-col items-center justify-center flex-1 h-full transition-colors {{ request()->is('/') ? 'text-primary' : 'text-text-muted' }}"
        >
            <x-tipowerup-orange-tw::icon name="home" class="w-6 h-6" />
            <span class="text-xs mt-1">Home</span>
        </a>

        {{-- Locations --}}
        <a
            href="{{ page_url('locations') }}"
            wire:navigate
            class="flex flex-col items-center justify-center flex-1 h-full transition-colors {{ request()->is('locations*') ? 'text-primary' : 'text-text-muted' }}"
        >
            <x-tipowerup-orange-tw::icon name="map-pin" class="w-6 h-6" />
            <span class="text-xs mt-1">Locations</span>
        </a>

        {{-- Menu --}}
        <a
            href="{{ page_url('menus') }}"
            wire:navigate
            class="flex flex-col items-center justify-center flex-1 h-full transition-colors {{ request()->is('menus*') ? 'text-primary' : 'text-text-muted' }}"
        >
            <x-tipowerup-orange-tw::icon name="book-open" class="w-6 h-6" />
            <span class="text-xs mt-1">Menu</span>
        </a>

        {{-- Cart --}}
        <a
            href="{{ page_url('checkout/cart') }}"
            wire:navigate
            class="flex flex-col items-center justify-center flex-1 h-full transition-colors relative {{ request()->is('checkout/cart*') ? 'text-primary' : 'text-text-muted' }}"
        >
            <div class="relative">
                <x-tipowerup-orange-tw::icon name="shopping-cart" class="w-6 h-6" />
                {{-- Cart Badge --}}
                <span class="absolute -top-2 -right-2 bg-primary text-white text-xs rounded-full w-4 h-4 flex items-center justify-center text-[10px]">
                    0
                </span>
            </div>
            <span class="text-xs mt-1">Cart</span>
        </a>

        {{-- Account --}}
        <a
            href="{{ page_url('account/login') }}"
            wire:navigate
            class="flex flex-col items-center justify-center flex-1 h-full transition-colors {{ request()->is('account*') ? 'text-primary' : 'text-text-muted' }}"
        >
            <x-tipowerup-orange-tw::icon name="user" class="w-6 h-6" />
            <span class="text-xs mt-1">Account</span>
        </a>
    </div>
</nav>

{{-- Spacer to prevent content from hiding behind fixed bottom bar --}}
<div class="md:hidden h-16"></div>
