// MUST be first import — sets window.jQuery/$/flatpickr/intlTelInput before
// any downstream module (including the per-component IIFEs) executes.
import './globals';
import '@tipowerup/ti-theme-toolkit/js/dark-mode';
import './components/index';
import currency from 'currency.js';

import type { AlpineComponent } from './types/alpine';

// Per-component window.Orange* globals and jQuery plugins (formerly loaded
// via Assets::addJs on demand; now always bundled so wire:navigate doesn't
// leave pages without their required JS).
import '../../js/fulfillment';
import '../../js/checkout';
import '../../js/google-maps';
import './jquery-plugins';

window.currency = currency;

if (typeof app !== 'undefined') {
    app.currencyFormat = function (amount: number | string) {
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

interface CartItemWire {
    set(key: string, value: unknown, deferred?: boolean): void;
    get(key: string): any;
    menuOptions: Record<string, { option_values: number[] }>;
}

interface CartItemRefs extends Record<string, HTMLElement> {
    'item-options': HTMLElement;
}

interface CartItemState {
    minQuantity: number;
    quantity: number;
    price: number;
    total: number | string;
    comment: string | null;
    incrementQuantity(): void;
    decrementQuantity(): void;
    calculateTotal(): void;
    init(): void;
}

window.OrangeCartItem = (): AlpineComponent<CartItemState, CartItemWire> & ThisType<CartItemState & {
    $el: HTMLElement;
    $refs: CartItemRefs;
    $wire: CartItemWire;
    $watch: <T>(key: string, callback: (value: T, old: T) => void) => void;
    $nextTick: (callback: () => void) => void;
}> => ({
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
        let menuPrice = this.price;

        const optionInputs = this.$refs['item-options']?.querySelectorAll<HTMLInputElement | HTMLOptionElement>(
            'input[data-option-price]:checked:not([disabled]), select:not([disabled]) option[data-option-price]:checked',
        );
        optionInputs?.forEach((value) => {
            menuPrice += parseFloat(value.dataset.optionPrice ?? '0');
        });

        const quantityInputs = this.$refs['item-options']?.querySelectorAll<HTMLInputElement & { _x_model?: { get(): unknown } }>(
            '[data-option-quantity] input[data-option-price]:not([disabled])',
        );
        quantityInputs?.forEach((value) => {
            const quantity = parseInt(String(value._x_model?.get() ?? '0'));
            if (quantity > 0) {
                menuPrice += quantity * parseFloat(value.dataset.optionPrice ?? '0');
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

        this.$watch<number>('quantity', () => {
            this.calculateTotal();
        });
    },
});

interface CheckboxState {
    key: string;
    id: number;
    init(): void;
    toggle(): void;
}

window.OrangeCartItemCheckbox = (optionKey: string, optionValueId: number): CheckboxState & ThisType<CheckboxState & {
    $el: HTMLInputElement;
    $wire: CartItemWire;
}> => ({
    key: optionKey,
    id: optionValueId,

    init() {
        this.$wire.menuOptions[this.key] ??= { option_values: [] };
        const values = this.$wire.menuOptions[this.key].option_values;
        if (this.$el.checked && !values.includes(this.id)) {
            values.push(this.id);
        }
        this.$wire.set(`menuOptions.${this.key}.option_values`, values, false);
    },

    toggle() {
        const values = this.$wire.menuOptions[this.key]?.option_values ?? [];
        const updated = this.$el.checked
            ? [...new Set([...values, this.id])]
            : values.filter((v) => v !== this.id);
        this.$wire.set(`menuOptions.${this.key}.option_values`, updated, false);
        // Notify the parent OrangeCartItem to recalculate total.
        Livewire.dispatch('cartItemTotalCalculated');
    },
});

interface OptionsState {
    minSelection: number;
    maxSelection: number;
    toggleSelection(): void;
    init(): void;
}

window.OrangeCartItemOptions = (min: number, max: number): AlpineComponent<OptionsState> => ({
    minSelection: min,
    maxSelection: max,

    toggleSelection() {
        if (this.maxSelection <= 0) {
            return;
        }

        const selectedCount = this.$el.querySelectorAll(
            'input[type="checkbox"][data-option-price]:checked:not([disabled])',
        ).length;

        this.$el.querySelectorAll<HTMLInputElement>(
            'input[type="checkbox"][data-option-price]:not(:checked)',
        ).forEach(($el) => {
            if (selectedCount === this.maxSelection) {
                $el.setAttribute('disabled', 'disabled');
            } else {
                $el.removeAttribute('disabled');
            }
        });
    },

    init() {
        Livewire.on('cartItemTotalCalculated', () => {
            this.toggleSelection();
        });

        const $ = window.jQuery;
        if (typeof $ !== 'undefined') {
            $(this.$el).on('click', '[data-toggle="more-options"], [data-toggle="less-options"]', function (this: HTMLElement, event: JQuery.TriggeredEvent) {
                const $el = $(event.currentTarget as HTMLElement);
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
    },
});

interface StickyHeaderState {
    show: boolean;
    lastScrollY: number;
    scrollThreshold: number;
    init(): void;
}

window.stickyHeader = (): AlpineComponent<StickyHeaderState> => ({
    show: true,
    lastScrollY: 0,
    scrollThreshold: 10,

    init() {
        window.addEventListener('scroll', () => {
            const currentScrollY = window.scrollY;
            const wasVisible = this.show;

            if (currentScrollY < this.lastScrollY || currentScrollY < this.scrollThreshold) {
                this.show = true;
            } else if (currentScrollY > this.lastScrollY && currentScrollY > this.scrollThreshold) {
                this.show = false;
            }

            if (wasVisible !== this.show) {
                window.dispatchEvent(new CustomEvent(this.show ? 'navbar-show' : 'navbar-hide'));
            }

            this.lastScrollY = currentScrollY;
        });
    },
});
