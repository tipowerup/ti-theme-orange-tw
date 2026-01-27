<form wire:submit="onSave" class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label for="date-inline" class="block text-sm font-medium text-text dark:text-text mb-2">
                @lang('igniter.reservation::default.label_date')
            </label>
            <div class="relative">
                <select
                    wire:model="date"
                    id="date-inline"
                    class="w-full px-4 py-3 border border-border dark:border-border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-surface dark:text-text transition-colors appearance-none"
                    required
                >
                    @foreach($dates as $availableDate)
                        <option value="{{ $availableDate->format('Y-m-d') }}">
                            {{ $availableDate->isoFormat(lang('igniter::system.moment.date_format')) }}
                        </option>
                    @endforeach
                </select>
                <div class="absolute right-4 top-1/2 -translate-y-1/2 text-text-muted pointer-events-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
            @error('date')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        @unless($hideTimePicker)
            <div>
                <label for="time-inline" class="block text-sm font-medium text-text dark:text-text mb-2">
                    @lang('igniter.reservation::default.label_time')
                </label>
                <div class="relative">
                    <input
                        wire:model="time"
                        type="text"
                        id="time-inline"
                        data-control="timepicker"
                        class="w-full px-4 py-3 border border-border dark:border-border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-surface dark:text-text transition-colors"
                        placeholder="@lang('igniter.reservation::default.label_time')"
                    />
                </div>
                @error('time')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        @endunless

        <div>
            <label for="guest-inline" class="block text-sm font-medium text-text dark:text-text mb-2">
                @lang('igniter.reservation::default.label_guest_num')
            </label>
            <div class="relative">
                <select
                    wire:model="guest"
                    id="guest-inline"
                    class="w-full px-4 py-3 border border-border dark:border-border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-surface dark:text-text transition-colors appearance-none"
                    required
                >
                    @for($i = $minGuestSize; $i <= $maxGuestSize; $i++)
                        <option value="{{ $i }}">{{ $i }} {{ str_plural('person', $i) }}</option>
                    @endfor
                </select>
                <div class="absolute right-4 top-1/2 -translate-y-1/2 text-text-muted pointer-events-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
            @error('guest')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <button
        type="submit"
        class="w-full px-6 py-4 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed text-lg"
        wire:loading.attr="disabled"
    >
        <span wire:loading.remove>@lang('igniter.reservation::default.button_find_table')</span>
        <span wire:loading>@lang('igniter.local::default.text_please_wait')</span>
    </button>
</form>
