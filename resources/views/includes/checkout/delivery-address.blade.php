<div class="space-y-3">
    <h3 class="text-base font-semibold text-text dark:text-text flex items-center gap-2">
        <i class="fa fa-map-marker-alt text-primary-600 dark:text-primary-400"></i>
        @lang('tipowerup.orange-tw::default.checkout.delivery_address')
    </h3>

    {{-- Saved Addresses --}}
    @auth('igniter-customer')
        @if($this->customerAddresses->isNotEmpty())
            <div>
                <p class="text-xs font-medium text-text-muted dark:text-text-muted mb-1.5">
                    @lang('tipowerup.orange-tw::default.checkout.saved_addresses')
                </p>
                <div class="flex flex-wrap gap-1.5">
                    @foreach($this->customerAddresses as $address)
                        @php
                            $isSelected = ($fields['address_1'] ?? '') === $address->address_1
                                && ($fields['city'] ?? '') === $address->city
                                && ($fields['postcode'] ?? '') === $address->postcode;
                        @endphp
                        <button
                            type="button"
                            wire:key="sa-{{ $address->address_id }}"
                            wire:click="onSelectSavedAddress({{ $address->address_id }})"
                            @class([
                                'inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-full text-xs transition-colors',
                                'bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 border border-primary-300 dark:border-primary-700' => $isSelected,
                                'bg-surface dark:bg-surface text-text dark:text-text border border-border dark:border-border hover:border-primary-300 dark:hover:border-primary-600' => !$isSelected,
                            ])
                        >
                            <i class="fa fa-map-marker-alt text-[0.6rem]"></i>
                            {{ Str::limit($address->formatted_address, 35) }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-border dark:border-border"></div>
                </div>
                <div class="relative flex justify-center text-xs">
                    <span class="px-2 bg-body dark:bg-surface text-text-muted dark:text-text-muted">
                        @lang('tipowerup.orange-tw::default.checkout.or_new_address')
                    </span>
                </div>
            </div>
        @endif
    @endauth

    {{-- Autocomplete Search --}}
    <div
        class="relative"
        x-data="{ focused: false, query: @entangle('addressSearchQuery') }"
        @click.outside="focused = false"
    >
        <div class="flex items-center border border-border dark:border-border rounded-lg bg-body dark:bg-surface overflow-hidden">
            <span class="pl-3 text-text-muted">
                <i class="fa fa-search text-sm" wire:loading.remove wire:target="addressSearchQuery"></i>
                <i class="fa fa-spinner fa-spin text-sm" wire:loading wire:target="addressSearchQuery"></i>
            </span>
            <input
                wire:model.live.debounce.500ms="addressSearchQuery"
                type="text"
                class="flex-1 bg-transparent border-0 focus:ring-0 text-sm py-2 px-2 text-text dark:text-text placeholder-text-muted"
                placeholder="@lang('tipowerup.orange-tw::default.checkout.search_address')"
                @focus="focused = true"
                autocomplete="off"
            />
        </div>

        {{-- Dropdown --}}
        <div
            x-cloak
            x-show="focused && query.length > 0"
            x-transition
            class="absolute z-50 left-0 right-0 mt-1 bg-body dark:bg-surface rounded-lg shadow-lg border border-border dark:border-border overflow-hidden"
        >
            {{-- Loading state --}}
            <div wire:loading wire:target="addressSearchQuery" class="px-3 py-3 flex items-center gap-2 text-text-muted dark:text-text-muted">
                <i class="fa fa-spinner fa-spin text-sm"></i>
                <span class="text-xs">@lang('tipowerup.orange-tw::default.checkout.searching_address')</span>
            </div>

            <div wire:loading.remove wire:target="addressSearchQuery">
                @if(!empty($addressSuggestions))
                    {{-- Results --}}
                    <div class="max-h-48 overflow-y-auto">
                        @foreach($addressSuggestions as $key => $suggestion)
                            <button
                                type="button"
                                wire:click="onSelectAddressSuggestion({{ $key }})"
                                class="w-full text-left px-3 py-2 text-sm hover:bg-surface dark:hover:bg-surface/50 transition-colors border-b border-border dark:border-border last:border-b-0"
                            >
                                @if($suggestion['title'])
                                    <div class="font-medium text-text dark:text-text text-xs">{{ $suggestion['title'] }}</div>
                                @endif
                                @if($suggestion['description'])
                                    <div class="text-xs text-text-muted dark:text-text-muted">{{ $suggestion['description'] }}</div>
                                @endif
                            </button>
                        @endforeach
                    </div>
                @elseif(strlen($addressSearchQuery) >= 5)
                    {{-- No results --}}
                    <div class="px-3 py-3 text-center">
                        <p class="text-xs text-text-muted dark:text-text-muted">@lang('tipowerup.orange-tw::default.checkout.no_address_found')</p>
                    </div>
                @else
                    {{-- Keep typing hint --}}
                    <div class="px-3 py-3 flex items-center gap-2 text-text-muted dark:text-text-muted">
                        <i class="fa fa-info-circle text-sm"></i>
                        <span class="text-xs">@lang('tipowerup.orange-tw::default.checkout.keep_typing')</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Address Fields --}}
    <div class="grid grid-cols-1 sm:grid-cols-6 gap-2">
        <div class="sm:col-span-6">
            <input
                wire:model="fields.address_1"
                type="text"
                placeholder="@lang('tipowerup.orange-tw::default.checkout.placeholder_address')"
                class="w-full px-3 py-2 text-sm border border-border dark:border-border rounded-lg bg-body dark:bg-surface text-text dark:text-text placeholder-text-muted focus:ring-2 focus:ring-primary-500 focus:border-transparent"
            />
        </div>
        <div class="sm:col-span-2">
            <input
                wire:model="fields.city"
                type="text"
                placeholder="@lang('tipowerup.orange-tw::default.checkout.placeholder_city')"
                class="w-full px-3 py-2 text-sm border border-border dark:border-border rounded-lg bg-body dark:bg-surface text-text dark:text-text placeholder-text-muted focus:ring-2 focus:ring-primary-500 focus:border-transparent"
            />
        </div>
        <div class="sm:col-span-2">
            <input
                wire:model="fields.state"
                type="text"
                placeholder="@lang('tipowerup.orange-tw::default.checkout.placeholder_state')"
                class="w-full px-3 py-2 text-sm border border-border dark:border-border rounded-lg bg-body dark:bg-surface text-text dark:text-text placeholder-text-muted focus:ring-2 focus:ring-primary-500 focus:border-transparent"
            />
        </div>
        <div class="sm:col-span-2">
            <input
                wire:model="fields.postcode"
                type="text"
                placeholder="@lang('tipowerup.orange-tw::default.checkout.placeholder_postcode')"
                class="w-full px-3 py-2 text-sm border border-border dark:border-border rounded-lg bg-body dark:bg-surface text-text dark:text-text placeholder-text-muted focus:ring-2 focus:ring-primary-500 focus:border-transparent"
            />
        </div>
    </div>

    {{-- Save Address Checkbox --}}
    @auth('igniter-customer')
        <label class="flex items-center gap-2 cursor-pointer">
            <input
                wire:model="saveAddress"
                type="checkbox"
                class="w-4 h-4 text-primary-600 border-border dark:border-border rounded focus:ring-primary-500 dark:bg-surface"
            />
            <span class="text-sm text-text dark:text-text">
                @lang('tipowerup.orange-tw::default.checkout.save_address')
            </span>
        </label>
    @endauth

    @error('delivery_address')
        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
