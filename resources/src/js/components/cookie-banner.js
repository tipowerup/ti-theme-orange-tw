/**
 * GDPR cookie banner. Persists the user's choice in localStorage so the
 * banner only appears until they make a decision.
 *
 * Usage in blade: <div x-data="cookieBanner()">
 */
const STORAGE_KEY = 'cookie-consent';

document.addEventListener('alpine:init', () => {
    window.Alpine.data('cookieBanner', () => ({
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
