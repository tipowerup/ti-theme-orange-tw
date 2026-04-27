<div>
    @if ($hideSearch)
        <a
            href="{{ restaurant_url('local/menus') }}"
            wire:navigate
            class="block w-full px-6 py-3 bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white text-center font-semibold rounded-lg transition-colors duration-200"
        >
            Find Restaurant
        </a>
    @elseif ($this->isSingleLocation && ($location = $this->defaultLocation))
        {{-- Single-location: compact horizontal "ready to order" strip --}}
        <div class="bg-body dark:bg-surface border border-border dark:border-border rounded-2xl shadow-xs hover:shadow-md transition-shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center gap-5 md:gap-6 p-5 md:p-6">

                {{-- Icon badge --}}
                <div class="shrink-0 mx-auto md:mx-0">
                    <div class="relative w-14 h-14 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                        <i class="fa fa-utensils text-xl text-primary-600 dark:text-primary-400"></i>
                        <span class="absolute -top-1 -right-1 flex h-3.5 w-3.5">
                            @if ($this->isOpened)
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-green-500 ring-2 ring-body dark:ring-surface"></span>
                            @else
                                <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-red-500 ring-2 ring-body dark:ring-surface"></span>
                            @endif
                        </span>
                    </div>
                </div>

                {{-- Details --}}
                <div class="flex-1 text-center md:text-left min-w-0">
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-x-2 gap-y-1 mb-1">
                        <h2 class="text-xl md:text-2xl font-bold text-text">
                            {{ $location->getName() }}
                        </h2>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold {{ $this->isOpened ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300' }}">
                            {{ $this->isOpened ? 'Open Now' : 'Closed' }}
                        </span>
                    </div>

                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-x-4 gap-y-1 text-sm text-text-muted">
                        @if ($address = trim(format_address($location->getAddress(), false)))
                            <span class="inline-flex items-center gap-1.5 truncate max-w-full">
                                <i class="fa fa-map-marker-alt text-primary-500 text-xs shrink-0"></i>
                                <span class="truncate">{{ $address }}</span>
                            </span>
                        @endif

                        @if ($phone = $location->getTelephone())
                            <a href="tel:{{ $phone }}" class="inline-flex items-center gap-1.5 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                                <i class="fa fa-phone text-primary-500 text-xs"></i>
                                {{ $phone }}
                            </a>
                        @endif
                    </div>
                </div>

                {{-- CTA --}}
                <div class="shrink-0">
                    <a
                        href="{{ restaurant_url('local/menus') }}"
                        wire:navigate
                        class="block w-full md:w-auto text-center px-6 py-3 bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white font-semibold rounded-lg transition-colors duration-200 whitespace-nowrap"
                    >
                        Start Your Order
                        <i class="fa fa-arrow-right text-sm ml-1.5 opacity-80"></i>
                    </a>
                </div>

            </div>
        </div>
    @else
        {{-- Multi-location search --}}
        <div class="text-center mb-8">
            <h2 class="text-3xl md:text-4xl font-bold text-text mb-3">
                Find Food Near You
            </h2>
            <p class="text-text-muted text-lg">
                Enter your address to discover nearby restaurants
            </p>
        </div>

        <div id="local-search-container">
            <form wire:submit="onSearchNearby" id="location-search" class="relative">
                <div class="flex items-center gap-2 bg-body rounded-lg border-2 border-border p-2 focus-within:border-primary transition-colors">
                    <button
                        type="button"
                        @click="$dispatch('userPositionUpdated', { position: null, updateMap: false })"
                        class="shrink-0 p-3 text-text-muted hover:text-primary hover:bg-surface rounded-lg transition-colors"
                        wire:loading.class="opacity-50 cursor-not-allowed"
                        title="Use my location"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>

                    <input
                        @if($searchAutocompleteEnabled)
                            wire:model.live.debounce.500ms="searchQuery"
                        @else
                            wire:model="searchQuery"
                        @endif
                        type="text"
                        id="search-query"
                        class="flex-1 bg-transparent border-none focus:outline-hidden focus:ring-0 text-text placeholder-text-muted text-lg"
                        placeholder="Enter your address..."
                        autocomplete="off"
                    />

                    <button
                        type="submit"
                        class="shrink-0 px-6 py-3 bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white font-semibold rounded-lg transition-colors duration-200 inline-flex flex-nowrap items-center justify-center gap-2 whitespace-nowrap disabled:opacity-50 disabled:cursor-not-allowed"
                        wire:loading.class="opacity-50 cursor-not-allowed"
                    >
                        <i wire:loading class="fa fa-spinner fa-spin"></i>
                        <span wire:loading.remove>Search</span>
                        <span wire:loading>Searching...</span>
                    </button>
                </div>

                @if($isSearching && $searchAutocompleteEnabled)
                    @include('tipowerup-orange-tw::includes.local.autocomplete-suggestions')
                @endif

                @error('searchQuery')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 font-medium">
                        {{ $message }}
                    </p>
                @enderror
            </form>

            {{-- "Browse all locations" divider link --}}
            <div class="mt-5 flex items-center gap-3">
                <span class="flex-1 h-px bg-border dark:bg-border"></span>
                <a
                    href="{{ page_url('locations') }}"
                    wire:navigate
                    class="shrink-0 inline-flex items-center gap-2 px-4 py-2 rounded-full border border-border dark:border-border bg-body dark:bg-surface text-sm font-medium text-text-muted hover:text-primary-600 dark:hover:text-primary-400 hover:border-primary-300 dark:hover:border-primary-600 transition-colors duration-200"
                >
                    <i class="fa fa-list-ul text-xs"></i>
                    Browse all locations
                </a>
                <span class="flex-1 h-px bg-border dark:bg-border"></span>
            </div>

            @include('tipowerup-orange-tw::includes.local.saved-address-picker')
        </div>
    @endif
</div>
