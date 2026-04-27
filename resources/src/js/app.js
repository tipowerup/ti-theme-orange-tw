// MUST be first import — sets window.jQuery/$/flatpickr/intlTelInput before
// any downstream module (including the per-component IIFEs) executes.
import $ from './globals.js';
import '@tipowerup/ti-theme-toolkit/js/dark-mode';
import './components/index.js';
import currency from 'currency.js';

// Per-component window.Orange* globals and jQuery plugins (formerly loaded
// via Assets::addJs on demand; now always bundled so wire:navigate doesn't
// leave pages without their required JS).
import '../../js/fulfillment.js';
import '../../js/checkout.js';
import '../../js/google-maps.js';

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
 * Cart Item Checkbox Option - Alpine component for syncing checkbox values with Livewire
 * Used by cart-item-modal.blade.php for checkbox option types
 */
window.OrangeCartItemCheckbox = (optionKey, optionValueId) => {
    return {
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
                : values.filter(v => v !== this.id);
            this.$wire.set(`menuOptions.${this.key}.option_values`, updated, false);
            calculateTotal();
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

window.stickyHeader = () => ({
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

/**
 * jQuery render plugin + Livewire integration
 * Triggers a document-wide `render` event after Livewire requests complete so
 * jQuery-based init code (country picker, booking) can re-bind to fresh DOM.
 */
(function ($) {
    'use strict';

    if (typeof app !== 'undefined') {
        app.requestTimeout = 150;
    }
    const requestTimeout = (typeof app !== 'undefined' && app.requestTimeout) || 150;

    $(document).on('livewire:init', () => {
        setTimeout(() => { $(document).trigger('render'); }, requestTimeout);
        Livewire.hook('request', ({ respond, succeed, fail }) => {
            respond(({ status, response }) => {
                setTimeout(() => {
                    $(document).trigger('render');
                    $(window).trigger('ajaxAlways', [status, response]);
                }, requestTimeout);
            });
            succeed(({ status, json }) => {
                setTimeout(() => { $(window).trigger('ajaxDone', [status, json]); }, requestTimeout);
            });
            fail(({ status, content, preventDefault }) => {
                setTimeout(() => { $(window).trigger('ajaxFail', [status, content, preventDefault]); }, requestTimeout);
            });
        });
    });

    // wire:navigate swaps the whole page DOM without going through the
    // Livewire request hook — so re-trigger `render` after navigation so
    // flatpickr / intl-tel-input pick up the new [data-control=*] nodes.
    document.addEventListener('livewire:navigated', () => {
        setTimeout(() => { $(document).trigger('render'); }, requestTimeout);
    });

    // $.fn.render is defined in globals.js (earlier in the module graph).

    $.ajaxPrefilter(function (options) {
        const token = $('meta[name="csrf-token"]').attr('content');
        if (token) {
            if (!options.headers) { options.headers = {}; }
            options.headers['X-CSRF-TOKEN'] = token;
        }
    });
})($);

/**
 * Country Code Picker — binds intl-tel-input to [data-control="country-code-picker"]
 */
(function ($) {
    'use strict';

    $(document).render(function () {
        $(document).find('[data-control="country-code-picker"]').each(function () {
            const $el = $(this);

            if ($el.data('iti-initialized')) { return; }
            $el.data('iti-initialized', true);

            const $telephoneInput = $('#' + $el.data('hiddenInputId'));
            const $feedbackEl = $('<div>').attr('class', 'text-red-600 dark:text-red-400 text-sm mt-1');
            const errorMessages = $el.data('errorMessages') || {
                0: 'Invalid number',
                1: 'Invalid country code',
                2: 'Number too short',
                3: 'Number too long',
                4: 'Invalid number',
            };

            const options = {
                initialCountry: (typeof app !== 'undefined' && app.country && app.country.iso_code_2 || 'us').toLowerCase(),
                separateDialCode: true,
                nationalMode: true,
                dropdownContainer: document.body,
                utilsScript: window.intlTelInputUtilsUrl,
            };

            $telephoneInput.after($feedbackEl);

            const telephonePicker = intlTelInput($el.get(0), options);

            $el.on('keyup change', function () {
                const event = new Event('telephoneChange', { bubbles: true });

                if ($el.val() && telephonePicker.isValidNumber()) {
                    $feedbackEl.text('');
                    $telephoneInput.val(telephonePicker.getNumber());
                } else if ($el.val()) {
                    const errorCode = telephonePicker.getValidationError();
                    $feedbackEl.text(errorMessages[errorCode] || 'Invalid number');
                    $telephoneInput.val($el.val());
                } else {
                    $feedbackEl.text('');
                    $telephoneInput.val('');
                }

                $telephoneInput.get(0).dispatchEvent(event);
            });

            $el.on('countrychange', function () { $el.trigger('change'); });
        });
    });
})($);

/**
 * Booking Calendar — binds Flatpickr to [data-control="booking"] / [data-control="datepicker"]
 */
(function ($) {
    'use strict';

    const Booking = function (element, options) {
        this.$el = $(element);
        this.options = options || {};
        this.$datePicker = this.$el.find('[data-control="datepicker"]');
        this.$datePickerValue = null;
        this.init();
    };

    Booking.prototype.init = function () {
        if (this.$datePicker.length) { this.initDatePicker(); }
    };

    Booking.prototype.initDatePicker = function () {
        const self = this;
        const $el = this.$el;
        this.$datePickerValue = this.$datePicker.data('startDate');

        // Input lives inside a wire:ignore wrapper so it survives Livewire
        // re-renders, but the outer [data-control="booking"] div does not.
        // On re-init we'd otherwise mount a second flatpickr on the same
        // input — producing two stacked inline calendars. Destroy any
        // existing instance first.
        const inputEl = this.$datePicker.get(0);
        if (inputEl && inputEl._flatpickr) {
            inputEl._flatpickr.destroy();
        }

        const options = $.extend({
            static: true,
            mode: 'single',
            dateFormat: 'Y-m-d',
            inline: $el.data('inline') || this.$datePicker.data('inline') || false,
            todayHighlight: true,
            minDate: $el.data('minDate'),
            maxDate: $el.data('maxDate'),
            disable: $el.data('disable') || [],
            locale: { firstDayOfWeek: $el.data('weekStart') || 0 },
            onChange: function (selectedDates, dateStr) {
                self.$datePickerValue = dateStr;
                self.$datePicker.val(dateStr);
                self.$datePicker.trigger('change');
            },
        }, $el.data());

        const disabledDaysOfWeek = $el.data('daysOfWeekDisabled');
        if (disabledDaysOfWeek && disabledDaysOfWeek.length) {
            options.disable = options.disable || [];
            options.disable.push(function (date) {
                return disabledDaysOfWeek.includes(date.getDay());
            });
        }

        flatpickr(this.$datePicker.get(0), options);
    };

    $.fn.booking = function () {
        return this.each(function () {
            const $this = $(this);
            let data = $this.data('ti.booking');
            if (!data) {
                $this.data('ti.booking', (data = new Booking(this, $this.data())));
            }
        });
    };

    $(document).render(function () {
        $('[data-control="booking"]').booking();
    });
})($);
