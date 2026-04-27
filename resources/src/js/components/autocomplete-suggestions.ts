/**
 * Keyboard navigation for the address autocomplete dropdown. Tracks which
 * suggestion is highlighted and lets the user pick with Enter / dismiss with
 * Escape; the blade wires the keydown handlers directly.
 *
 * Usage in blade:
 *   <div x-data="autocompleteSuggestions({ suggestions: @js($placesSuggestions) })">
 */
import type { AlpineComponent } from '../types/alpine';

interface Suggestion {
    placeId?: string;
    description?: string;
    [key: string]: unknown;
}

interface AutocompleteState {
    selectedIndex: number;
    suggestions: Suggestion[];
    init(): void;
}

document.addEventListener('alpine:init', () => {
    window.Alpine.data(
        'autocompleteSuggestions',
        ({ suggestions = [] }: { suggestions?: Suggestion[] } = {}): AlpineComponent<AutocompleteState> => ({
            selectedIndex: -1,
            suggestions,

            init() {
                this.$watch<Suggestion[]>('suggestions', () => {
                    this.selectedIndex = -1;
                });
            },
        }),
    );
});
