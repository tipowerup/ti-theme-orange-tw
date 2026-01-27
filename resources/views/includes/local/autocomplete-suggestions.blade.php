<div
    x-data="{
        selectedIndex: -1,
        suggestions: @js($placesSuggestions),
        init() {
            this.$watch('suggestions', value => {
                this.selectedIndex = -1;
            });
        }
    }"
    @keydown.arrow-down.prevent="selectedIndex = Math.min(selectedIndex + 1, suggestions.length - 1)"
    @keydown.arrow-up.prevent="selectedIndex = Math.max(selectedIndex - 1, -1)"
    @keydown.enter.prevent="selectedIndex >= 0 && $wire.onSelectSuggestion(selectedIndex)"
    @keydown.escape="$wire.set('isSearching', false)"
    class="absolute z-50 left-0 right-0 mt-2 bg-body dark:bg-surface rounded-lg shadow-lg border border-border dark:border-border overflow-hidden"
>
    <div class="max-h-64 overflow-y-auto">
        @forelse($placesSuggestions as $key => $suggestion)
            <button
                type="button"
                wire:click="onSelectSuggestion({{ $key }})"
                :class="selectedIndex === {{ $key }} ? 'bg-primary-50 dark:bg-primary-900/20' : 'hover:bg-surface dark:hover:bg-surface'"
                class="w-full text-left px-4 py-3 transition-colors duration-150 border-b border-border dark:border-border last:border-b-0"
            >
                @if($suggestion['title'])
                    <div class="font-semibold text-text dark:text-text">
                        {{ $suggestion['title'] }}
                    </div>
                @endif
                @if($suggestion['description'])
                    <div class="text-sm text-text-muted dark:text-text-muted mt-1">
                        {{ $suggestion['description'] }}
                    </div>
                @endif
            </button>
        @empty
            <div class="px-4 py-6 text-center text-text-muted dark:text-text-muted">
                <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <p>No suggestions found</p>
                <p class="text-sm mt-1">Try a different search term</p>
            </div>
        @endforelse
    </div>

    <div class="px-4 py-2 bg-surface dark:bg-body border-t border-border dark:border-border">
        <div class="flex items-center justify-end text-xs text-text-muted dark:text-text-muted">
            @if($geocoder === 'nominatim')
                <span class="mr-1">Powered by</span>
                <a
                    href="https://www.openstreetmap.org/copyright"
                    target="_blank"
                    rel="noopener"
                    class="text-primary-600 dark:text-primary-400 hover:underline"
                >
                    OpenStreetMap
                </a>
            @else
                <a href="https://maps.google.com" target="_blank" rel="noopener">
                    <img
                        src="{{ asset('vendor/igniter-orange/images/powered-by-google.png') }}"
                        alt="Powered by Google"
                        class="h-3"
                    />
                </a>
            @endif
        </div>
    </div>
</div>
