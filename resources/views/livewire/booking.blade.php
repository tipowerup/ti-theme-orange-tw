<div>
    <div class="auth-session-banner text-right text-xs text-text-muted dark:text-text-muted mt-6 mb-2">
        {!! $customer
            ? sprintf(lang('igniter.orange::default.text_logged_out'), e($customer->first_name), url('logout'))
            : sprintf(lang('igniter.orange::default.text_logged_in'), page_url('account.login'))
        !!}
    </div>

    <div class="bg-body dark:bg-surface rounded-lg shadow-md">
        <div class="p-6">
            <div
                data-control="booking"
                data-min-date="{{ $startDate->format('Y-m-d') }}"
                data-max-date="{{ $endDate->format('Y-m-d') }}"
                data-days-of-week-disabled='@json($this->disabledDaysOfWeek)'
                data-disable='@json($disabledDates)'
                data-week-start="{{ $weekStartOn }}"
                data-date-format="Y-m-d"
                data-locale="{{ $calendarLocale }}"
            >
                @if ($pickerStep == $this::STEP_BOOKING)
                    @include('tipowerup-orange-tw::includes.booking.info')
                    @include('tipowerup-orange-tw::includes.booking.booking-form')

                @elseif ($pickerStep == $this::STEP_TIMESLOT)
                    <h1 class="text-2xl font-bold text-text dark:text-text mb-6">
                        @lang('igniter.reservation::default.text_time_heading')
                    </h1>

                    @include('tipowerup-orange-tw::includes.booking.timeslot')
                @else
                    <h1 class="text-2xl font-bold text-text dark:text-text mb-6">
                        @lang('igniter.reservation::default.text_booking_title')
                    </h1>

                    @includeWhen($useCalendarView, 'tipowerup-orange-tw::includes.booking.picker-form')
                    @includeWhen(!$useCalendarView, 'tipowerup-orange-tw::includes.booking.picker-inline-form')
                @endif
            </div>
        </div>
    </div>

    @if ($pickerStep == $this::STEP_TIMESLOT)
        <div class="bg-body dark:bg-surface rounded-lg shadow-md mt-6">
            <div class="p-6">
                <a
                    wire:navigate
                    href="{{ page_url('reservation.reservation') }}"
                    class="inline-flex items-center gap-2 text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors"
                >
                    <i class="fa fa-arrow-left"></i>
                    @lang('tipowerup.orange-tw::default.booking.start_again')
                </a>
            </div>
        </div>
    @endif

    @include('tipowerup-orange-tw::includes.booking.alert-modal')
</div>
