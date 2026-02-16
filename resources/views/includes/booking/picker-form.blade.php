<form wire:submit="onSave" class="space-y-6">
    <div class="flex flex-col lg:flex-row gap-6">
        {{-- Inline Calendar --}}
        <div wire:ignore class="flex-1">
            <input
                wire:model="date"
                type="text"
                name="date"
                class="hidden"
                data-control="datepicker"
                data-inline="true"
                data-static="true"
                x-on:change="$wire.$refresh()"
            />
        </div>

        {{-- Options Panel --}}
        <div class="w-full lg:w-72 space-y-4">
            {{-- Guest Number --}}
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
                            <option value="{{ $i }}">
                                {{ $i }} @lang($i > 1 ? 'igniter.reservation::default.text_people' : 'igniter.reservation::default.text_person')
                            </option>
                        @endfor
                    </select>
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-text-muted pointer-events-none">
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

            {{-- Time Selection --}}
            @unless($hideTimePicker)
                <div>
                    <label for="time" class="block text-sm font-medium text-text dark:text-text mb-2">
                        @lang('igniter.reservation::default.label_time')
                    </label>
                    <div class="relative">
                        <select
                            wire:model="time"
                            id="time"
                            class="w-full px-4 py-3 pl-12 border border-border dark:border-border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-surface dark:text-text transition-colors appearance-none"
                        >
                            <option value="0">@lang('tipowerup.orange-tw::default.booking.select_time')</option>
                            @php($selectedDateIsToday = make_carbon($this->date)->isToday())
                            @foreach ($this->timeslots as $dateTime)
                                <option
                                    value="{{ $dateTime->format('H:i') }}"
                                    @selected($selectedDateIsToday && $loop->first)
                                >{{ $dateTime->isoFormat(lang('system::lang.moment.time_format')) }}</option>
                            @endforeach
                        </select>
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-text-muted pointer-events-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-text-muted pointer-events-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                    @error('time')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            @endunless

            {{-- Find Table Button --}}
            <button
                type="submit"
                class="w-full px-6 py-4 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed text-lg flex items-center justify-center gap-2"
                wire:loading.attr="disabled"
            >
                <svg wire:loading class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>@lang('igniter.reservation::default.button_find_table')</span>
            </button>

            @error('date')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
    </div>
</form>
