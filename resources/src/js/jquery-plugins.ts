// @ts-nocheck — legacy jQuery-IIFE plugins (Livewire ajax bridge, country
// picker, booking calendar). Typing them properly requires rewriting the
// jQuery-plugin idiom; not worth the cost while the rest of the JS stays.
import $ from './globals';

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

    document.addEventListener('livewire:navigated', () => {
        setTimeout(() => { $(document).trigger('render'); }, requestTimeout);
    });

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
