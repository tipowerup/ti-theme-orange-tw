import currency from 'currency.js';

/**
 * Currency.js - expose globally for currency formatting
 */
window.currency = currency;

/**
 * Currency Format Helper
 * Formats amounts using TastyIgniter's currency settings from window.app
 * Uses currency.js for proper currency math and formatting
 */
if (typeof app !== 'undefined') {
    app.currencyFormat = function (amount) {
        if (!app.currency) {
            return currency(amount).format();
        }

        return currency(amount, {
            decimal: app.currency.decimal_sign,
            precision: app.currency.decimal_precision,
            separator: app.currency.thousand_sign,
            symbol: app.currency.symbol,
            pattern: app.currency.symbol_position ? '#!' : '!#',
        }).format();
    };
}

/**
 * Cart Item Modal - Alpine component for quantity/total calculation
 * Used by cart-item-modal.blade.php
 */
window.OrangeCartItem = () => {
    return {
        minQuantity: 1,
        quantity: 1,
        price: 0,
        total: 0,
        comment: null,
        incrementQuantity() {
            this.quantity = Math.max(this.minQuantity, this.quantity + this.minQuantity);
            this.$wire.set('quantity', this.quantity, false);
        },
        decrementQuantity() {
            this.quantity = Math.max(this.minQuantity, this.quantity - this.minQuantity);
            this.$wire.set('quantity', this.quantity, false);
        },
        calculateTotal() {
            let menuPrice = parseFloat(this.price);
            [...this.$refs['item-options']?.querySelectorAll('input[data-option-price]:checked:not([disabled]), select:not([disabled]) option[data-option-price]:checked')]
                .forEach((value) => {
                    menuPrice += parseFloat(value.dataset.optionPrice);
                });

            [...this.$refs['item-options']?.querySelectorAll('[data-option-quantity] input[data-option-price]:not([disabled])')]
                .forEach((value) => {
                    const quantity = parseInt(value._x_model?.get());
                    if (quantity > 0) {
                        menuPrice += (quantity * parseFloat(value.dataset.optionPrice));
                    }
                });

            this.total = app.currencyFormat(this.quantity * menuPrice);

            Livewire.dispatch('cartItemTotalCalculated');
        },
        init() {
            this.minQuantity = parseFloat(this.$wire.get('minQuantity'));
            this.price = parseFloat(this.$wire.get('price'));
            this.quantity = parseInt(this.$wire.get('quantity'));
            this.comment = this.$wire.get('comment');

            this.$nextTick(() => {
                this.calculateTotal();
            });

            this.$watch('quantity', () => {
                this.calculateTotal();
            });
        }
    };
};

/**
 * Cart Item Options - Alpine component for option selection limits
 * Used by cart-item-modal.blade.php for checkbox max selection enforcement
 */
window.OrangeCartItemOptions = (min, max) => {
    return {
        minSelection: min,
        maxSelection: max,
        toggleSelection() {
            if (this.maxSelection <= 0) {
                return;
            }

            const selectedCount = this.$el.querySelectorAll('input[type="checkbox"][data-option-price]:checked:not([disabled])').length;

            [...this.$el.querySelectorAll('input[type="checkbox"][data-option-price]:not(:checked)')]
                .forEach(($el) => {
                    selectedCount === this.maxSelection ? $el.setAttribute('disabled', 'disabled') : $el.removeAttribute('disabled');
                });
        },
        init() {
            Livewire.on('cartItemTotalCalculated', () => {
                this.toggleSelection();
            });

            if (typeof $ !== 'undefined') {
                $(this.$el).on('click', '[data-toggle="more-options"], [data-toggle="less-options"]', function (event) {
                    const $el = $(event.currentTarget);
                    const $container = $el.closest('[data-control="item-option"]');

                    if ($el.data('toggle') === 'more-options') {
                        $el.fadeOut();
                        $container.find('[data-toggle="less-options"]').fadeIn();
                        $container.find('.hidden-item-options').fadeIn();
                    } else {
                        $el.fadeOut();
                        $container.find('[data-toggle="more-options"]').fadeIn();
                        $container.find('.hidden-item-options').fadeOut();
                    }
                });
            }
        }
    };
};

/**
 * Register Alpine components with Livewire's bundled Alpine
 * Livewire 3 already includes Alpine.js - do not import it separately
 */
document.addEventListener('alpine:init', () => {
    /**
     * Dark Mode Component
     */
    Alpine.data('darkMode', () => {
        // Initialize isDark immediately to prevent flicker
        const savedMode = localStorage.getItem('darkMode');
        const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const initialDark = savedMode === 'dark' || (!savedMode && systemPrefersDark);

        return {
            isDark: initialDark,

            init() {
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
        };
    });

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
                const wasVisible = this.show;

                // Show header when scrolling up or at top
                if (currentScrollY < this.lastScrollY || currentScrollY < this.scrollThreshold) {
                    this.show = true;
                }
                // Hide header when scrolling down
                else if (currentScrollY > this.lastScrollY && currentScrollY > this.scrollThreshold) {
                    this.show = false;
                }

                // Dispatch events when visibility changes
                if (wasVisible !== this.show) {
                    window.dispatchEvent(new CustomEvent(this.show ? 'navbar-show' : 'navbar-hide'));
                }

                this.lastScrollY = currentScrollY;
            });
        }
    }));
});

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
