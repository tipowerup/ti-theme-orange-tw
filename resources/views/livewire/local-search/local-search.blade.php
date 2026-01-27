<div>
    @if ($hideSearch)
        <a
            href="{{ restaurant_url('local/menus') }}"
            wire:navigate
            class="block w-full px-6 py-3 bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white text-center font-semibold rounded-lg transition-colors duration-200"
        >
            Find Restaurant
        </a>
    @else
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
                        class="flex-shrink-0 p-3 text-text-muted hover:text-primary hover:bg-surface rounded-lg transition-colors"
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
                        class="flex-1 bg-transparent border-none focus:outline-none focus:ring-0 text-text placeholder-text-muted text-lg"
                        placeholder="Enter your address..."
                        autocomplete="off"
                    />

                    <button
                        type="submit"
                        class="flex-shrink-0 px-6 py-3 bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white font-semibold rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                        wire:loading.class="opacity-50 cursor-not-allowed"
                    >
                        <span wire:loading.remove>Search</span>
                        <span wire:loading class="flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Searching...
                        </span>
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

            @include('tipowerup-orange-tw::includes.local.saved-address-picker')
        </div>
    @endif
</div>
