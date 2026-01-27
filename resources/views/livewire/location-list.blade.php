<div class="space-y-6">
    <!-- Search and Filters -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Filters Sidebar -->
        <div class="lg:col-span-1 space-y-4">
            <!-- Current Location -->
            <div class="bg-body dark:bg-surface border border-border dark:border-border rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2 flex-1">
                        <i class="fa fa-map-marker text-primary-600 dark:text-primary-400"></i>
                        <span class="text-sm font-medium text-text dark:text-text truncate">
                            @if ($searchQueryPosition->isValid())
                                {{ $searchQueryPosition->getLocality() }}
                            @else
                                <span class="text-text-muted">@lang('tipowerup.orange-tw::default.locations.no_location_set')</span>
                            @endif
                        </span>
                    </div>
                    <button
                        type="button"
                        class="text-primary-600 dark:text-primary-400 text-sm hover:underline"
                        @click="$dispatch('open-modal', 'address-picker')"
                    >@lang('tipowerup.orange-tw::default.locations.change')</button>
                </div>
            </div>

            <!-- Order Type Filter -->
            <div class="bg-body dark:bg-surface border border-border dark:border-border rounded-lg p-4">
                <h3 class="font-semibold text-text dark:text-text mb-3">@lang('tipowerup.orange-tw::default.locations.order_type')</h3>
                <div class="space-y-2">
                    @foreach($this->orderTypes as $key => $label)
                        <label wire:key="order-type-{{ $key }}" class="flex items-center cursor-pointer">
                            <input
                                type="radio"
                                wire:model.live.debounce.300ms="orderType"
                                value="{{ $key }}"
                                class="w-4 h-4 text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600"
                            />
                            <span class="ml-2 text-sm text-text dark:text-text">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Sort Filter -->
            <div class="bg-body dark:bg-surface border border-border dark:border-border rounded-lg p-4">
                <h3 class="font-semibold text-text dark:text-text mb-3">@lang('tipowerup.orange-tw::default.locations.sort_by')</h3>
                <div class="space-y-2">
                    @foreach($this->sorters as $key => $sorter)
                        <label wire:key="sorter-{{ $key }}" class="flex items-center cursor-pointer">
                            <input
                                type="radio"
                                wire:model.live.debounce.300ms="orderBy"
                                value="{{ $key }}"
                                class="w-4 h-4 text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600"
                            />
                            <span class="ml-2 text-sm text-text dark:text-text">{{ $sorter['name'] }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Locations List -->
        <div class="lg:col-span-3 space-y-6">
            <!-- Search Bar -->
            <div class="bg-body dark:bg-surface border border-border dark:border-border rounded-lg p-2">
                <div class="flex items-center space-x-2">
                    <input
                        wire:model.live.debounce.500ms="search"
                        wire:loading.attr="disabled"
                        type="search"
                        class="flex-1 bg-transparent border-none focus:ring-0 text-text dark:text-text placeholder-text-muted"
                        placeholder="@lang('tipowerup.orange-tw::default.locations.search_locations')"
                    />
                    <button
                        type="button"
                        class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors"
                    >
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>

            <!-- Loading State -->
            <div wire:loading wire:target="search,orderType,orderBy" class="text-center py-8">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
                <p class="mt-2 text-sm text-text-muted dark:text-text-muted">@lang('tipowerup.orange-tw::default.locations.loading_locations')</p>
            </div>

            <!-- Locations Grid -->
            @if (count($locationsList))
                <div class="grid grid-cols-1 gap-4" wire:loading.remove wire:target="search,orderType,orderBy">
                    @foreach ($locationsList as $locationData)
                        <div wire:key="location-{{ $locationData->id }}">
                            @include('tipowerup-orange-tw::includes.local.location-card', [
                                'locationData' => $locationData,
                                'showThumb' => $showThumb,
                                'menusPage' => $menusPage,
                                'allowReviews' => $allowReviews,
                                'distanceUnit' => $distanceUnit,
                            ])
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $locationsList->links() }}
                </div>
            @else
                <div class="bg-body dark:bg-surface border border-border dark:border-border rounded-lg p-8 text-center" wire:loading.remove wire:target="search,orderType,orderBy">
                    <i class="fa fa-map-marker-slash text-4xl text-text-muted mb-4"></i>
                    <h3 class="text-lg font-semibold text-text dark:text-text mb-2">@lang('tipowerup.orange-tw::default.locations.no_locations_found')</h3>
                    <p class="text-text-muted dark:text-text-muted">@lang('tipowerup.orange-tw::default.locations.try_different_search')</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Address Picker Modal -->
    <div
        x-data="{ open: false }"
        @open-modal.window="if ($event.detail === 'address-picker') open = true"
        @close-modal.window="if ($event.detail === 'address-picker') open = false"
        @keydown.escape.window="open = false"
        x-show="open"
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;"
    >
        <div class="flex items-center justify-center min-h-screen px-4">
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
                <h3 class="text-lg font-semibold text-text dark:text-text mb-4">Change Location</h3>

                <form wire:submit="onUpdateSearchQuery">
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2 bg-surface dark:bg-surface border border-border dark:border-border rounded-lg p-2">
                            <input
                                wire:model="searchQuery"
                                type="text"
                                class="flex-1 bg-transparent border-none focus:ring-0 text-text dark:text-text placeholder-text-muted"
                                placeholder="Enter address or postal code"
                            />
                            <button
                                type="button"
                                class="p-2 hover:bg-surface dark:hover:bg-surface rounded"
                                wire:loading.class="opacity-50"
                            >
                                <i class="fa fa-location-arrow text-primary-600 dark:text-primary-400"></i>
                            </button>
                        </div>

                        @error('searchQuery')
                            <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror

                        <div class="flex space-x-3">
                            <button
                                type="button"
                                @click="open = false"
                                class="flex-1 px-4 py-2 bg-surface dark:bg-surface text-text dark:text-text rounded-lg hover:bg-surface dark:hover:bg-surface transition-colors"
                            >Cancel</button>
                            <button
                                type="submit"
                                class="flex-1 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors"
                                wire:loading.class="opacity-50"
                            >Update Location</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
