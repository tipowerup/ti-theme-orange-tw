<div class="space-y-6">
    <div class="bg-surface dark:bg-surface rounded-lg p-6">
        <h3 class="text-lg font-semibold text-text dark:text-text mb-4">
            @lang('igniter.reservation::default.text_selected_date')
        </h3>
        <p class="text-text dark:text-text">
            {{ make_carbon($date)->isoFormat(lang('igniter::system.moment.date_format_long')) }}
        </p>
    </div>

    <div>
        <h3 class="text-lg font-semibold text-text dark:text-text mb-4">
            @lang('igniter.reservation::default.text_select_time')
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            @forelse($this->reducedTimeslots as $slot)
                <button
                    type="button"
                    wire:click="onSelectTime('{{ $slot->dateTime->format('H:i') }}')"
                    @class([
                        'px-4 py-3 rounded-lg border-2 font-medium transition-all',
                        'border-primary-600 bg-primary-600 text-white shadow-md' => $slot->isSelected,
                        'border-border dark:border-border hover:border-primary-500 hover:bg-primary-50 dark:hover:bg-primary-900/20 text-text dark:text-text' => !$slot->isSelected && !$slot->fullyBooked,
                        'border-border dark:border-border bg-surface dark:bg-surface text-text-muted dark:text-text-muted cursor-not-allowed' => $slot->fullyBooked,
                    ])
                    @if($slot->fullyBooked) disabled @endif
                >
                    {{ $slot->dateTime->format('H:i') }}
                    @if($slot->fullyBooked)
                        <span class="block text-xs mt-1">@lang('igniter.reservation::default.text_fully_booked')</span>
                    @endif
                </button>
            @empty
                <div class="col-span-full">
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 text-center">
                        <p class="text-yellow-800 dark:text-yellow-200">
                            @lang('igniter.reservation::default.text_no_time_slots')
                        </p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    @if($this->timeslots->count() > $this->reducedTimeslots->count())
        <div class="text-center">
            <p class="text-sm text-text-muted dark:text-text-muted mb-3">
                @lang('igniter.reservation::default.text_more_times_available')
            </p>
            <button
                type="button"
                wire:click="$set('noOfSlots', {{ $this->timeslots->count() }})"
                class="px-6 py-2 bg-body dark:bg-surface border border-border dark:border-border text-text dark:text-text rounded-lg hover:bg-surface dark:hover:bg-surface transition-colors"
            >
                @lang('igniter.reservation::default.button_show_all_times')
            </button>
        </div>
    @endif
</div>
