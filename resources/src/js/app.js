import Alpine from 'alpinejs';

// Make Alpine available globally
window.Alpine = Alpine;

/**
 * Dark Mode Component
 */
Alpine.data('darkMode', () => ({
    isDark: false,

    init() {
        // Check for saved preference or system preference
        const savedMode = localStorage.getItem('darkMode');
        const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        if (savedMode === 'dark' || (!savedMode && systemPrefersDark)) {
            this.isDark = true;
        }

        // Watch for system preference changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (!localStorage.getItem('darkMode')) {
                this.isDark = e.matches;
            }
        });
    },

    toggleDarkMode() {
        this.isDark = !this.isDark;
        localStorage.setItem('darkMode', this.isDark ? 'dark' : 'light');
    }
}));

/**
 * Smart Sticky Header Component
 */
Alpine.data('stickyHeader', () => ({
    show: true,
    lastScrollY: 0,
    scrollThreshold: 10,

    init() {
        window.addEventListener('scroll', () => {
            const currentScrollY = window.scrollY;

            // Show header when scrolling up or at top
            if (currentScrollY < this.lastScrollY || currentScrollY < this.scrollThreshold) {
                this.show = true;
            }
            // Hide header when scrolling down
            else if (currentScrollY > this.lastScrollY && currentScrollY > this.scrollThreshold) {
                this.show = false;
            }

            this.lastScrollY = currentScrollY;
        });
    }
}));

/**
 * View Transitions API Helper
 */
if ('startViewTransition' in document) {
    document.addEventListener('livewire:navigate', (event) => {
        document.startViewTransition(() => {
            // Livewire will handle the navigation
        });
    });
}

// Initialize Alpine
Alpine.start();
