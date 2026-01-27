<form wire:submit="onSave" class="space-y-6">
    <div>
        <label for="date" class="block text-sm font-medium text-text dark:text-text mb-2">
            @lang('igniter.reservation::default.label_date')
        </label>
        <div class="relative">
            <input
                wire:model="date"
                type="text"
                id="date"
                data-control="datepicker"
                class="w-full px-4 py-3 pl-12 border border-border dark:border-border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-surface dark:text-text transition-colors"
                placeholder="@lang('igniter.reservation::default.label_date')"
                required
            />
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-text-muted">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
        @error('date')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    @unless($hideTimePicker)
        <div>
            <label for="time" class="block text-sm font-medium text-text dark:text-text mb-2">
                @lang('igniter.reservation::default.label_time')
            </label>
            <div class="relative">
                <input
                    wire:model="time"
                    type="text"
                    id="time"
                    data-control="timepicker"
                    class="w-full px-4 py-3 pl-12 border border-border dark:border-border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-surface dark:text-text transition-colors"
                    placeholder="@lang('igniter.reservation::default.label_time')"
                />
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-text-muted">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            @error('time')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
    @endunless

    <div>
        <label for="guest" class="block text-sm font-medium text-text dark:text-text mb-2">
            @lang('igniter.reservation::default.label_guest_num')
        </label>
        <div class="relative">
            <select
                wire:model="guest"
                id="guest"
                class="w-full px-4 py-3 pl-12 border border-border dark:border-border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-surface dark:text-text transition-colors appearance-none"
                required
            >
                @for($i = $minGuestSize; $i <= $maxGuestSize; $i++)
                    <option value="{{ $i }}">{{ $i }} {{ str_plural('person', $i) }}</option>
                @endfor
            </select>
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-text-muted">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
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

    <button
        type="submit"
        class="w-full px-6 py-4 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed text-lg"
        wire:loading.attr="disabled"
    >
        <span wire:loading.remove>@lang('igniter.reservation::default.button_find_table')</span>
        <span wire:loading>@lang('igniter.local::default.text_please_wait')</span>
    </button>
</form>
