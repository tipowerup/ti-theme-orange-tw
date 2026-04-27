/**
 * Auto-click an element on its first render. Used by hidden buttons that
 * need to fire a `$dispatch` on mount — e.g. opening a cart-item modal when
 * a menu item is selected via Livewire's `selectedMenuId` redirect.
 *
 * Usage in blade: <button x-data="autoClick" @click="...">
 */
document.addEventListener('alpine:init', () => {
    window.Alpine.data('autoClick', () => ({
        init() {
            this.$nextTick(() => this.$el.click());
        },
    }));
});
