/**
 * Keyboard navigation for the address autocomplete dropdown. Tracks which
 * suggestion is highlighted and lets the user pick with Enter / dismiss with
 * Escape; the blade wires the keydown handlers directly.
 *
 * Usage in blade:
 *   <div x-data="autocompleteSuggestions({ suggestions: @js($placesSuggestions) })">
 */
document.addEventListener('alpine:init', () => {
    window.Alpine.data('autocompleteSuggestions', ({ suggestions = [] } = {}) => ({
        selectedIndex: -1,
        suggestions,

        init() {
            this.$watch('suggestions', () => {
                this.selectedIndex = -1;
            });
        },
    }));
});
