<div>
    <div class="bg-body dark:bg-surface rounded-lg shadow-md mt-6">
        <div class="p-6 border-b border-border dark:border-border">
            {!! $customer
                ? sprintf(lang('igniter.orange::default.text_logged_out'), e($customer->first_name), url('logout'))
                : sprintf(lang('igniter.orange::default.text_logged_in'), page_url('account.login'))
            !!}
        </div>

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

    @if (in_array($pickerStep, [$this::STEP_BOOKING, $this::STEP_TIMESLOT]))
        <div class="bg-body dark:bg-surface rounded-lg shadow-md mt-6">
            <div class="p-6">
                <a
                    wire:navigate
                    href="{{ page_url('reservation.reservation') }}"
                    class="inline-flex items-center text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Start again
                </a>
            </div>
        </div>
    @endif

    @include('tipowerup-orange-tw::includes.booking.alert-modal')
</div>
