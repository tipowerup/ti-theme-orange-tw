/**
 * GDPR cookie banner. Persists the user's choice in localStorage so the
 * banner only appears until they make a decision.
 *
 * Usage in blade: <div x-data="cookieBanner()">
 */
import type { AlpineComponent } from '../types/alpine';

const STORAGE_KEY = 'cookie-consent';

interface CookieBannerState {
    showBanner: boolean;
    init(): void;
    acceptCookies(): void;
    declineCookies(): void;
}

document.addEventListener('alpine:init', () => {
    window.Alpine.data('cookieBanner', (): AlpineComponent<CookieBannerState> => ({
        showBanner: false,

        init() {
            this.showBanner = !localStorage.getItem(STORAGE_KEY);
        },

        acceptCookies() {
            localStorage.setItem(STORAGE_KEY, 'accepted');
            this.showBanner = false;
        },

        declineCookies() {
            localStorage.setItem(STORAGE_KEY, 'declined');
            this.showBanner = false;
        },
    }));
});
