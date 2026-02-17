{{-- TastyIgniter JS Variables (creates window.app object) --}}
{!! Assets::getJsVars() !!}

{{-- jQuery - Required by TastyIgniter extensions --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

{{-- Flatpickr Date Picker --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

{{-- jQuery render plugin - Required for Livewire integration --}}
<script>
(function($) {
    "use strict";
    app.requestTimeout = 150;
    $(document).on('livewire:init', () => {
        setTimeout(() => { $(document).trigger('render'); }, app.requestTimeout);
        Livewire.hook('request', ({respond, succeed, fail}) => {
            respond(({status, response}) => {
                setTimeout(() => {
                    $(document).trigger('render');
                    $(window).trigger('ajaxAlways', [status, response]);
                }, app.requestTimeout);
            });
            succeed(({status, json}) => {
                setTimeout(() => { $(window).trigger('ajaxDone', [status, json]); }, app.requestTimeout);
            });
            fail(({status, content, preventDefault}) => {
                setTimeout(() => { $(window).trigger('ajaxFail', [status, content, preventDefault]); }, app.requestTimeout);
            });
        });
    });
    $.fn.render = function(callback) { $(document).on('render', callback); };
    $.ajaxPrefilter(function(options) {
        var token = $('meta[name="csrf-token"]').attr('content');
        if (token) {
            if (!options.headers) options.headers = {};
            options.headers['X-CSRF-TOKEN'] = token;
        }
    });
})(window.jQuery);
</script>

{{-- Country Code Picker Initialization --}}
<script>
(function($) {
    "use strict";

    $(document).render(function() {
        $(document).find('[data-control="country-code-picker"]').each(function() {
            var $el = $(this);

            // Skip if already initialized
            if ($el.data('iti-initialized')) return;
            $el.data('iti-initialized', true);

            var $telephoneInput = $('#' + $el.data('hiddenInputId'));
            var $feedbackEl = $('<div>').attr('class', 'text-red-600 dark:text-red-400 text-sm mt-1');
            var errorMessages = $el.data('errorMessages') || {
                0: 'Invalid number',
                1: 'Invalid country code',
                2: 'Number too short',
                3: 'Number too long',
                4: 'Invalid number'
            };

            var options = {
                initialCountry: (app.country && app.country.iso_code_2 || 'us').toLowerCase(),
                separateDialCode: true,
                nationalMode: true,
                dropdownContainer: document.body,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.5.3/js/utils.js"
            };

            $telephoneInput.after($feedbackEl);

            var telephonePicker = intlTelInput($el.get(0), options);

            $el.on('keyup change', function() {
                var event = new Event('telephoneChange', { bubbles: true });

                if ($el.val() && telephonePicker.isValidNumber()) {
                    $feedbackEl.text('');
                    $telephoneInput.val(telephonePicker.getNumber());
                } else if ($el.val()) {
                    var errorCode = telephonePicker.getValidationError();
                    $feedbackEl.text(errorMessages[errorCode] || 'Invalid number');
                    $telephoneInput.val($el.val());
                } else {
                    $feedbackEl.text('');
                    $telephoneInput.val('');
                }

                $telephoneInput.get(0).dispatchEvent(event);
            });

            // Trigger change on country change
            $el.on('countrychange', function() {
                $el.trigger('change');
            });
        });
    });
})(window.jQuery);
</script>

{{-- Booking Calendar Initialization --}}
<script>
(function($) {
    "use strict";

    var Booking = function(element, options) {
        this.$el = $(element);
        this.options = options || {};
        this.$datePicker = this.$el.find('[data-control="datepicker"]');
        this.$datePickerValue = null;
        this.init();
    };

    Booking.prototype.init = function() {
        if (this.$datePicker.length) {
            this.initDatePicker();
        }
    };

    Booking.prototype.initDatePicker = function() {
        var self = this;
        var $el = this.$el;
        this.$datePickerValue = this.$datePicker.data('startDate');

        var options = $.extend({
            static: true,
            mode: 'single',
            dateFormat: 'Y-m-d',
            inline: $el.data('inline') || this.$datePicker.data('inline') || false,
            todayHighlight: true,
            minDate: $el.data('minDate'),
            maxDate: $el.data('maxDate'),
            disable: $el.data('disable') || [],
            locale: { firstDayOfWeek: $el.data('weekStart') || 0 },
            onChange: function(selectedDates, dateStr) {
                self.$datePickerValue = dateStr;
                self.$datePicker.val(dateStr);
                self.$datePicker.trigger('change');
            }
        }, $el.data());

        // Handle disabled days of week
        var disabledDaysOfWeek = $el.data('daysOfWeekDisabled');
        if (disabledDaysOfWeek && disabledDaysOfWeek.length) {
            options.disable = options.disable || [];
            options.disable.push(function(date) {
                return disabledDaysOfWeek.includes(date.getDay());
            });
        }

        this.$datePicker.flatpickr(options);
    };

    $.fn.booking = function(option) {
        return this.each(function() {
            var $this = $(this);
            var data = $this.data('ti.booking');
            if (!data) {
                $this.data('ti.booking', (data = new Booking(this, $this.data())));
            }
        });
    };

    $(document).render(function() {
        $('[data-control="booking"]').booking();
    });
})(window.jQuery);
</script>

{{-- Theme JavaScript - Uses TastyIgniter's native asset system via assets.json --}}
@themeScripts

@stack('scripts')

{{-- GA Tracking Code --}}
{!! $theme->ga_tracking_code ?? '' !!}

{{-- Custom JS from theme settings --}}
@if (!empty($theme->custom_js))
    <script type="text/javascript">{!! $theme->custom_js !!}</script>
@endif
