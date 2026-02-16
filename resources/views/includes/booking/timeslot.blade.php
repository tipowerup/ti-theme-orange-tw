<div class="space-y-6">
    {{-- Summary Message --}}
    <div class="bg-primary-50 dark:bg-primary-900/20 border border-primary-200 dark:border-primary-800 rounded-lg p-4">
        <p class="text-primary-800 dark:text-primary-200">
            {{ sprintf(lang('igniter.reservation::default.text_time_msg'),
                make_carbon($date.' '.$time)->isoFormat(lang('system::lang.moment.date_time_format_long')),
                $guest
            ) }}
        </p>
    </div>

    {{-- Time Slots Grid --}}
    <div>
        <h3 class="text-lg font-semibold text-text dark:text-text mb-4">
            @lang('igniter.reservation::default.text_select_time')
        </h3>
        <div class="flex flex-wrap gap-3">
            @forelse($this->reducedTimeslots as $key => $slot)
                <button
                    type="button"
                    wire:click="onSelectTime('{{ $slot->dateTime->format('H:i') }}')"
                    id="time{{ $key }}"
                    @class([
                        'px-5 py-3 rounded-lg font-medium transition-all',
                        'bg-primary-600 hover:bg-primary-700 text-white shadow-lg scale-105' => $slot->isSelected,
                        'bg-primary-100 dark:bg-primary-900/30 hover:bg-primary-200 dark:hover:bg-primary-900/50 text-primary-700 dark:text-primary-300' => !$slot->isSelected && !$slot->fullyBooked,
                        'bg-surface dark:bg-surface text-text-muted dark:text-text-muted cursor-not-allowed opacity-50' => $slot->fullyBooked,
                    ])
                    @if($slot->fullyBooked) disabled @endif
                >
                    {{ $slot->dateTime->isoFormat(lang('system::lang.moment.time_format')) }}
                </button>
            @empty
                <div class="w-full">
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 text-center">
                        <p class="text-yellow-800 dark:text-yellow-200">
                            @lang('igniter.reservation::default.text_no_time_slot')
                        </p>
                    </div>
                </div>
            @endforelse
        </div>

        @error('time')
            <p class="mt-3 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
</div>
