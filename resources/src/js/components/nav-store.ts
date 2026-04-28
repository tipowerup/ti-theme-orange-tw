/**
 * Global Alpine store tracking the current pathname. Updates on
 * `livewire:navigated` (SPA navigation) and `popstate` (back/forward).
 *
 * Used by the mobile bottom-tab-bar so the active indicator follows the URL
 * across wire:navigate transitions, where server-rendered class strings on
 * morphed elements may not refresh.
 */
interface NavStore {
    path: string;
    init(): void;
    sync(): void;
}

document.addEventListener('alpine:init', () => {
    window.Alpine.store('nav', {
        path: window.location.pathname,

        init() {
            const sync = (): void => this.sync();
            document.addEventListener('livewire:navigated', sync);
            window.addEventListener('popstate', sync);
        },

        sync() {
            this.path = window.location.pathname;
        },
    } satisfies NavStore);
});
