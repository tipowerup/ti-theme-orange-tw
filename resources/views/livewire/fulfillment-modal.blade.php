<div
    x-data="{ open: false }"
    @open-modal.window="if ($event.detail === 'fulfillment-modal') open = true"
    @close-modal.window="if ($event.detail === 'fulfillment-modal') open = false"
    @keydown.escape.window="open = false"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
>
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Backdrop -->
        <div
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black bg-opacity-50"
            @click="open = false"
        ></div>

        <!-- Modal -->
        <div
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4"
            class="relative bg-body dark:bg-surface rounded-lg shadow-xl max-w-md w-full p-6"
        >
            <h3 class="text-lg font-semibold text-text dark:text-text mb-4">@lang('tipowerup.orange-tw::default.fulfillment.select_type')</h3>

            <form wire:submit="updateFulfillment">
                <div class="space-y-4">
                    <!-- Order Type -->
                    <div>
                        <label class="block text-sm font-medium text-text dark:text-text mb-2">@lang('tipowerup.orange-tw::default.fulfillment.select_type')</label>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($orderTypes as $code => $label)
                                <label
                                    @class([
                                        'flex items-center justify-center p-3 border-2 rounded-lg cursor-pointer transition-colors',
                                        'border-primary-600 bg-primary-50 dark:bg-primary-900/30' => $orderType === $code,
                                        'border-border dark:border-border hover:border-border dark:hover:border-border' => $orderType !== $code,
                                    ])
                                >
                                    <input
                                        type="radio"
                                        wire:model.live="orderType"
                                        value="{{ $code }}"
                                        class="sr-only"
                                    />
                                    <i @class([
                                        'fa mr-2',
                                        'fa-truck' => $code === 'delivery',
                                        'fa-shopping-bag' => $code === 'collection',
                                        'text-primary-600 dark:text-primary-400' => $orderType === $code,
                                        'text-text-muted' => $orderType !== $code,
                                    ])></i>
                                    <span @class([
                                        'font-medium',
                                        'text-primary-600 dark:text-primary-400' => $orderType === $code,
                                        'text-text dark:text-text' => $orderType !== $code,
                                    ])>{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Order Time -->
                    <div>
                        <label class="block text-sm font-medium text-text dark:text-text mb-2">@lang('tipowerup.orange-tw::default.fulfillment.select_time')</label>
                        <div class="space-y-3">
                            <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer transition-colors
                                {{ $orderTime === 'asap' ? 'border-primary-600 bg-primary-50 dark:bg-primary-900/30' : 'border-border dark:border-border hover:border-border dark:hover:border-border' }}">
                                <input
                                    type="radio"
                                    wire:model.live="orderTime"
                                    value="asap"
                                    class="sr-only"
                                />
                                <i class="far fa-clock mr-2 {{ $orderTime === 'asap' ? 'text-primary-600 dark:text-primary-400' : 'text-text-muted' }}"></i>
                                <span class="{{ $orderTime === 'asap' ? 'text-primary-600 dark:text-primary-400 font-medium' : 'text-text dark:text-text' }}">@lang('tipowerup.orange-tw::default.fulfillment.asap')</span>
                            </label>

                            <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer transition-colors
                                {{ $orderTime === 'later' ? 'border-primary-600 bg-primary-50 dark:bg-primary-900/30' : 'border-border dark:border-border hover:border-border dark:hover:border-border' }}">
                                <input
                                    type="radio"
                                    wire:model.live="orderTime"
                                    value="later"
                                    class="sr-only"
                                />
                                <i class="far fa-calendar mr-2 {{ $orderTime === 'later' ? 'text-primary-600 dark:text-primary-400' : 'text-text-muted' }}"></i>
                                <span class="{{ $orderTime === 'later' ? 'text-primary-600 dark:text-primary-400 font-medium' : 'text-text dark:text-text' }}">@lang('tipowerup.orange-tw::default.fulfillment.schedule')</span>
                            </label>
                        </div>
                    </div>

                    <!-- Date and Time Selection (shown when 'later' is selected) -->
                    @if($orderTime === 'later')
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-text dark:text-text mb-1">Date</label>
                                <input
                                    type="date"
                                    wire:model="orderDate"
                                    class="w-full px-3 py-2 border border-border dark:border-border rounded-lg bg-body dark:bg-surface text-text dark:text-text focus:ring-2 focus:ring-primary-500"
                                    min="{{ now()->format('Y-m-d') }}"
                                />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-text dark:text-text mb-1">Time</label>
                                <select
                                    wire:model="orderTimeSlot"
                                    class="w-full px-3 py-2 border border-border dark:border-border rounded-lg bg-body dark:bg-surface text-text dark:text-text focus:ring-2 focus:ring-primary-500"
                                >
                                    <option value="">@lang('tipowerup.orange-tw::default.fulfillment.select_time')</option>
                                    @foreach($timeSlots as $slot)
                                        <option value="{{ $slot }}">{{ \Carbon\Carbon::parse($slot)->format('g:i A') }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex space-x-3 pt-4">
                        <button
                            type="button"
                            @click="open = false"
                            class="flex-1 px-4 py-2 bg-surface dark:bg-surface text-text dark:text-text rounded-lg hover:bg-surface dark:hover:bg-surface transition-colors"
                        >@lang('tipowerup.orange-tw::default.common.cancel')</button>
                        <button
                            type="submit"
                            class="flex-1 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors"
                            wire:loading.class="opacity-50"
                        >@lang('tipowerup.orange-tw::default.common.confirm')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
