<div class="space-y-3">
    <h3 class="text-base font-semibold text-text dark:text-text flex items-center gap-2">
        <i class="fa fa-map-marker-alt text-primary-600 dark:text-primary-400"></i>
        @lang('tipowerup.orange-tw::default.checkout.delivery_address')
    </h3>

    {{-- ================= Saved-address picker ================= --}}
    @if ($this->showSavedAddressPicker)
        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <p class="text-xs font-medium text-text-muted dark:text-text-muted">
                    @lang('tipowerup.orange-tw::default.checkout.saved_addresses')
                    <span class="text-text-muted/70">({{ $this->customerAddresses->count() }})</span>
                </p>
                @if ($this->selectedSavedAddress)
                    <span class="inline-flex items-center gap-1 text-xs font-medium text-green-700 dark:text-green-400">
                        <i class="fa fa-check-circle text-[11px]"></i>
                        Address selected
                    </span>
                @endif
            </div>

            <div class="{{ $this->customerAddresses->count() > 6 ? 'max-h-72 overflow-y-auto pr-1' : '' }}">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    @foreach ($this->sortedSavedAddresses as $address)
                        @php
                            $isSelected = (int) $address->address_id === (int) $selectedAddressId;
                            $isDefault = (int) $address->address_id === $this->defaultAddressId;
                            $lineMain = trim($address->address_1.($address->address_2 ? ', '.$address->address_2 : ''));
                            $lineRest = trim(collect([$address->city, $address->state, $address->postcode])->filter()->implode(', '));
                        @endphp
                        <button
                            type="button"
                            wire:key="sa-{{ $address->address_id }}"
                            wire:click="onSelectSavedAddress({{ $address->address_id }})"
                            wire:loading.attr="disabled"
                            aria-pressed="{{ $isSelected ? 'true' : 'false' }}"
                            @class([
                                'group relative text-left rounded-lg border p-3 transition-all focus:outline-hidden focus-visible:ring-2 focus-visible:ring-primary-500 focus-visible:ring-offset-1 dark:focus-visible:ring-offset-body disabled:opacity-60',
                                'border-primary-500 ring-1 ring-primary-500 bg-primary-50 dark:bg-primary-900/20' => $isSelected,
                                'border-border dark:border-border bg-body dark:bg-surface hover:border-primary-400 dark:hover:border-primary-600 hover:shadow-xs' => !$isSelected,
                            ])
                        >
                            <div class="flex items-start gap-2">
                                <span
                                    @class([
                                        'mt-0.5 shrink-0 w-4 h-4 rounded-full border-2 flex items-center justify-center transition',
                                        'border-primary-600 bg-primary-600' => $isSelected,
                                        'border-border dark:border-border group-hover:border-primary-400' => !$isSelected,
                                    ])
                                    aria-hidden="true"
                                >
                                    @if ($isSelected)
                                        <i class="fa fa-check text-[9px] text-white"></i>
                                    @endif
                                </span>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-1.5 mb-0.5">
                                        <p class="text-sm font-semibold text-text dark:text-text truncate">
                                            {{ $lineMain ?: $address->formatted_address }}
                                        </p>
                                        @if ($isDefault)
                                            <span class="shrink-0 inline-flex items-center gap-0.5 px-1.5 py-0.5 text-[10px] font-semibold uppercase tracking-wide bg-primary-100 text-primary-700 dark:bg-primary-900/40 dark:text-primary-300 rounded-sm">
                                                <i class="fa fa-star text-[9px]"></i>
                                                Default
                                            </span>
                                        @endif
                                    </div>
                                    @if ($lineRest)
                                        <p class="text-xs text-text-muted dark:text-text-muted truncate">{{ $lineRest }}</p>
                                    @endif
                                </div>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>

            <button
                type="button"
                wire:click="onUseNewAddressForm"
                class="inline-flex items-center gap-1.5 text-xs font-medium text-primary-600 dark:text-primary-400 hover:underline"
            >
                <i class="fa fa-plus text-[10px]"></i>
                @lang('tipowerup.orange-tw::default.checkout.or_new_address')
            </button>
        </div>
    @endif

    {{-- ================= Manual new-address form ================= --}}
    @unless ($this->showSavedAddressPicker)
        @if ($this->hasSavedAddresses)
            <button
                type="button"
                wire:click="onUseSavedAddressPicker"
                class="inline-flex items-center gap-1.5 text-xs font-medium text-primary-600 dark:text-primary-400 hover:underline"
            >
                <i class="fa fa-arrow-left text-[10px]"></i>
                Use a saved address
            </button>
        @endif

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

            <div
                x-show="focused && query.length > 0"
                x-transition
                style="display: none;"
                class="absolute z-50 left-0 right-0 mt-1 bg-body dark:bg-surface rounded-lg shadow-lg border border-border dark:border-border overflow-hidden"
            >
                <div wire:loading wire:target="addressSearchQuery" class="px-3 py-3 flex items-center gap-2 text-text-muted dark:text-text-muted">
                    <i class="fa fa-spinner fa-spin text-sm"></i>
                    <span class="text-xs">@lang('tipowerup.orange-tw::default.checkout.searching_address')</span>
                </div>

                <div wire:loading.remove wire:target="addressSearchQuery">
                    @if (!empty($addressSuggestions))
                        <div class="max-h-48 overflow-y-auto">
                            @foreach ($addressSuggestions as $key => $suggestion)
                                <button
                                    type="button"
                                    wire:click="onSelectAddressSuggestion({{ $key }})"
                                    class="w-full text-left px-3 py-2 text-sm hover:bg-surface dark:hover:bg-surface/50 transition-colors border-b border-border dark:border-border last:border-b-0"
                                >
                                    @if ($suggestion['title'])
                                        <div class="font-medium text-text dark:text-text text-xs">{{ $suggestion['title'] }}</div>
                                    @endif
                                    @if ($suggestion['description'])
                                        <div class="text-xs text-text-muted dark:text-text-muted">{{ $suggestion['description'] }}</div>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    @elseif (strlen($addressSearchQuery) >= 5)
                        <div class="px-3 py-3 text-center">
                            <p class="text-xs text-text-muted dark:text-text-muted">@lang('tipowerup.orange-tw::default.checkout.no_address_found')</p>
                        </div>
                    @else
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

        @auth('igniter-customer')
            <label class="flex items-center gap-2 cursor-pointer">
                <input
                    wire:model="saveAddress"
                    type="checkbox"
                    class="w-4 h-4 text-primary-600 border-border dark:border-border rounded-sm focus:ring-primary-500 dark:bg-surface"
                />
                <span class="text-sm text-text dark:text-text">
                    @lang('tipowerup.orange-tw::default.checkout.save_address')
                </span>
            </label>
        @endauth
    @endunless

    @error('delivery_address')
        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
