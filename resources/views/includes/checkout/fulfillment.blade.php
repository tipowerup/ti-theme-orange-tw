<div
    x-data="{
        isAsap: @js($isAsap),
        orderDate: @js($orderDate),
        orderTime: @js($orderTime),
        showTimePicker: @js(!$isAsap),
        timeslot: @js($timeslotTimes),
        init() {
            this.$wire.$watch('orderDate', value => { this.orderDate = value; });
            this.$wire.$watch('isAsap', value => {
                this.isAsap = value == 1;
                this.showTimePicker = value == 0;
            });
        },
        setAsap(value) {
            this.isAsap = value == 1;
            this.showTimePicker = value == 0;
            this.$wire.set('isAsap', value == 1);
        }
    }"
    class="space-y-4"
>
    {{-- Order Type Toggle --}}
    <div>
        <h3 class="text-base font-semibold text-text dark:text-text mb-2">
            @lang('tipowerup.orange-tw::default.fulfillment.select_type')
        </h3>
        <div class="grid grid-cols-2 gap-2">
            @foreach($orderTypes as $type)
                <label
                    wire:key="ot-{{ $type->getCode() }}"
                    @class([
                        'flex items-center justify-center gap-2 px-3 py-2.5 border rounded-lg cursor-pointer transition-colors text-sm',
                        'border-primary-500 bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300' => $orderType === $type->getCode(),
                        'border-border dark:border-border hover:border-primary-300 dark:hover:border-primary-600 text-text dark:text-text' => $orderType !== $type->getCode(),
                    ])
                >
                    <input
                        type="radio"
                        wire:model.live="orderType"
                        value="{{ $type->getCode() }}"
                        class="sr-only"
                    />
                    <i @class([
                        'fa',
                        'fa-truck' => $type->getCode() === 'delivery',
                        'fa-shopping-bag' => $type->getCode() === 'collection',
                    ])></i>
                    <span class="font-medium">{{ $type->getLabel() }}</span>
                </label>
            @endforeach
        </div>
        @error('orderType')
            <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Time Selection --}}
    <div>
        <h3 class="text-base font-semibold text-text dark:text-text mb-2">
            @lang('tipowerup.orange-tw::default.fulfillment.select_time')
        </h3>
        <div class="grid grid-cols-2 gap-2">
            <label
                @click="setAsap(1)"
                :class="isAsap
                    ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300'
                    : 'border-border dark:border-border hover:border-primary-300 dark:hover:border-primary-600 text-text dark:text-text'"
                class="flex items-center justify-center gap-2 px-3 py-2.5 border rounded-lg cursor-pointer transition-colors text-sm"
            >
                <input type="radio" wire:model="isAsap" value="1" class="sr-only" />
                <i class="far fa-clock"></i>
                <span class="font-medium">@lang('tipowerup.orange-tw::default.fulfillment.asap')</span>
            </label>
            <label
                @click="setAsap(0)"
                :class="!isAsap
                    ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300'
                    : 'border-border dark:border-border hover:border-primary-300 dark:hover:border-primary-600 text-text dark:text-text'"
                class="flex items-center justify-center gap-2 px-3 py-2.5 border rounded-lg cursor-pointer transition-colors text-sm"
            >
                <input type="radio" wire:model="isAsap" value="0" class="sr-only" />
                <i class="far fa-calendar"></i>
                <span class="font-medium">@lang('tipowerup.orange-tw::default.fulfillment.schedule')</span>
            </label>
        </div>
        @error('isAsap')
            <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror

        {{-- Date & Time Pickers (Alpine-controlled) --}}
        <div x-cloak x-show="showTimePicker" x-transition class="grid grid-cols-2 gap-2 mt-2">
            <div>
                <select
                    wire:model="orderDate"
                    x-model="orderDate"
                    class="w-full px-3 py-2 text-sm border border-border dark:border-border rounded-lg bg-body dark:bg-surface text-text dark:text-text focus:ring-2 focus:ring-primary-500"
                >
                    <option disabled></option>
                    @foreach($timeslotDates as $dateKey => $dateValue)
                        <option value="{{ $dateKey }}">{{ $dateValue }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select
                    wire:model="orderTime"
                    x-model="orderTime"
                    class="w-full px-3 py-2 text-sm border border-border dark:border-border rounded-lg bg-body dark:bg-surface text-text dark:text-text focus:ring-2 focus:ring-primary-500"
                >
                    <template x-for="(value, key) in timeslot[orderDate]" :key="key">
                        <option x-bind:value="key" x-bind:selected="key == orderTime" x-text="value"></option>
                    </template>
                </select>
            </div>
        </div>
    </div>
</div>
