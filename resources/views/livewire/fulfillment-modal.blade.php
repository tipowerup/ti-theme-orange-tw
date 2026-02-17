<div
    x-data='OrangeFulfillment(@json($timeslotTimes))'
    @open-modal.window="if ($event.detail === 'fulfillment-modal') open = true"
    @close-modal.window="if ($event.detail === 'fulfillment-modal') open = false"
    @keydown.escape.window="open = false"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
    data-map-key="{{ $mapKey }}"
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

            <form wire:submit="onConfirm">
                <div class="space-y-4">
                    <!-- Order Type -->
                    <div>
                        <label class="block text-sm font-medium text-text dark:text-text mb-2">@lang('tipowerup.orange-tw::default.fulfillment.select_type')</label>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($orderTypes as $type)
                                <div wire:key="order-type-{{ $type->getCode() }}">
                                <label
                                    @class([
                                        'flex items-center justify-center p-3 border rounded-lg cursor-pointer transition-colors',
                                        'border-primary-600 bg-primary-50 dark:bg-primary-900/30' => $orderType === $type->getCode(),
                                        'border-border dark:border-border hover:border-border dark:hover:border-border' => $orderType !== $type->getCode(),
                                    ])
                                >
                                    <input
                                        type="radio"
                                        wire:model.live="orderType"
                                        value="{{ $type->getCode() }}"
                                        class="sr-only"
                                    />
                                    <i @class([
                                        'fa mr-2',
                                        'fa-truck' => $type->getCode() === 'delivery',
                                        'fa-shopping-bag' => $type->getCode() === 'collection',
                                        'text-primary-600 dark:text-primary-400' => $orderType === $type->getCode(),
                                        'text-text-muted' => $orderType !== $type->getCode(),
                                    ])></i>
                                    <span @class([
                                        'font-medium',
                                        'text-primary-600 dark:text-primary-400' => $orderType === $type->getCode(),
                                        'text-text dark:text-text' => $orderType !== $type->getCode(),
                                    ])>{{ $type->getLabel() }}</span>
                                </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Order Time -->
                    <div id="local-timeslot">
                        <label class="block text-sm font-medium text-text dark:text-text mb-2">@lang('tipowerup.orange-tw::default.fulfillment.select_time')</label>
                        <div class="space-y-3">
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer transition-colors
                                {{ $isAsap ? 'border-primary-600 bg-primary-50 dark:bg-primary-900/30' : 'border-border dark:border-border hover:border-border dark:hover:border-border' }}">
                                <input
                                    type="radio"
                                    wire:model="isAsap"
                                    value="1"
                                    class="sr-only"
                                />
                                <i class="far fa-clock mr-2 {{ $isAsap ? 'text-primary-600 dark:text-primary-400' : 'text-text-muted' }}"></i>
                                <span class="{{ $isAsap ? 'text-primary-600 dark:text-primary-400 font-medium' : 'text-text dark:text-text' }}">@lang('tipowerup.orange-tw::default.fulfillment.asap')</span>
                            </label>

                            <label class="flex items-center p-3 border rounded-lg cursor-pointer transition-colors
                                {{ !$isAsap ? 'border-primary-600 bg-primary-50 dark:bg-primary-900/30' : 'border-border dark:border-border hover:border-border dark:hover:border-border' }}">
                                <input
                                    type="radio"
                                    wire:model="isAsap"
                                    value="0"
                                    class="sr-only"
                                />
                                <i class="far fa-calendar mr-2 {{ !$isAsap ? 'text-primary-600 dark:text-primary-400' : 'text-text-muted' }}"></i>
                                <span class="{{ !$isAsap ? 'text-primary-600 dark:text-primary-400 font-medium' : 'text-text dark:text-text' }}">@lang('tipowerup.orange-tw::default.fulfillment.schedule')</span>
                            </label>
                        </div>

                        <!-- Date and Time Selection (Alpine-controlled, no server roundtrip) -->
                        <div x-cloak x-show="showTimePicker" class="grid grid-cols-2 gap-3 mt-3">
                            <div>
                                <label class="block text-sm font-medium text-text dark:text-text mb-1">@lang('igniter.local::default.label_date')</label>
                                <select
                                    wire:model="orderDate"
                                    x-model="orderDate"
                                    class="w-full px-3 py-2 border border-border dark:border-border rounded-lg bg-body dark:bg-surface text-text dark:text-text focus:ring-2 focus:ring-primary-500"
                                >
                                    <option disabled></option>
                                    @foreach($timeslotDates as $dateKey => $dateValue)
                                        <option value="{{ $dateKey }}">{{ $dateValue }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-text dark:text-text mb-1">@lang('igniter.local::default.label_time')</label>
                                <select
                                    wire:model="orderTime"
                                    x-model="orderTime"
                                    class="w-full px-3 py-2 border border-border dark:border-border rounded-lg bg-body dark:bg-surface text-text dark:text-text focus:ring-2 focus:ring-primary-500"
                                >
                                    <template x-for="(value, key) in timeslot[orderDate]" :key="key">
                                        <option x-bind:value="key" x-bind:selected="key == orderTime" x-text="value"></option>
                                    </template>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Address Section -->
                    @unless($hideDeliveryAddress)
                        <div x-cloak x-show="!hideDeliveryAddress" class="mt-4">
                            <div class="flex items-center justify-between mb-2">
                                <label class="flex items-center text-sm font-medium text-text dark:text-text">
                                    <i class="fa fa-map-pin mr-2"></i>
                                    @lang('tipowerup.orange-tw::default.fulfillment.delivering_to')
                                </label>
                                @unless($previewMode)
                                    <button
                                        type="button"
                                        wire:click="onChangeDeliveryAddress"
                                        class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors"
                                    >
                                        @lang('tipowerup.orange-tw::default.fulfillment.change_address')
                                    </button>
                                @endunless
                            </div>

                            @if(!$previewMode && $showAddressPicker)
                                <div class="space-y-3">
                                    <div class="relative">
                                        <div class="flex items-center gap-2 bg-body dark:bg-surface rounded-lg border border-border dark:border-border p-1">
                                            <input
                                                @if($searchAutocompleteEnabled)
                                                    wire:model.live.debounce.500ms="searchQuery"
                                                @else
                                                    wire:model="searchQuery"
                                                @endif
                                                type="text"
                                                id="search-query"
                                                class="flex-1 bg-transparent border-0 focus:ring-0 text-text dark:text-text placeholder-text-muted dark:placeholder-text-muted"
                                                placeholder="@lang('igniter.local::default.label_search_query')"
                                            />
                                            <button
                                                type="button"
                                                data-control="user-position"
                                                class="px-3 py-2 text-primary-600 dark:text-primary-400 hover:bg-surface dark:hover:bg-surface rounded-md transition-colors"
                                                title="@lang('tipowerup.orange-tw::default.fulfillment.mark_your_location')"
                                            >
                                                <i class="fa fa-location-arrow"></i>
                                            </button>
                                        </div>

                                        @if($isSearching && $searchAutocompleteEnabled)
                                            @include('tipowerup-orange-tw::includes.local.autocomplete-suggestions')
                                        @endif
                                    </div>

                                    @error('searchQuery')
                                        <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror

                                    @if($searchPoint && $searchAutocompleteEnabled)
                                        <div wire:ignore class="mt-3">
                                            <h6 class="text-sm font-medium text-text dark:text-text mb-2">
                                                @lang('tipowerup.orange-tw::default.fulfillment.mark_your_location')
                                            </h6>
                                            <div id="map" class="h-64 rounded-lg border border-border dark:border-border overflow-hidden"></div>
                                        </div>
                                    @else
                                        @include('tipowerup-orange-tw::includes.local.saved-address-picker')
                                    @endif
                                </div>
                            @else
                                <div class="p-3 border border-border dark:border-border rounded-lg bg-body dark:bg-surface">
                                    <p class="text-text dark:text-text truncate mb-0">
                                        {{ $searchQuery ?? $deliveryAddress ?? lang('igniter.local::default.alert_no_search_query') }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endunless

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
