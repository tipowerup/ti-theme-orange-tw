<div class="bg-primary-50 dark:bg-primary-900/20 border border-primary-200 dark:border-primary-800 rounded-lg p-6 mb-6">
    <div class="flex items-start space-x-4">
        <div class="flex-shrink-0">
            <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="flex-1">
            <h3 class="text-lg font-semibold text-primary-900 dark:text-primary-100 mb-2">
                @lang('igniter.reservation::default.text_booking_summary')
            </h3>
            <dl class="space-y-2 text-sm text-primary-800 dark:text-primary-200">
                <div class="flex justify-between">
                    <dt class="font-medium">@lang('igniter.reservation::default.label_date'):</dt>
                    <dd>{{ make_carbon($date)->isoFormat(lang('igniter::system.moment.date_format')) }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="font-medium">@lang('igniter.reservation::default.label_time'):</dt>
                    <dd>{{ $time }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="font-medium">@lang('igniter.reservation::default.label_guest_num'):</dt>
                    <dd>{{ $guest }} {{ str_plural('person', $guest) }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div>
