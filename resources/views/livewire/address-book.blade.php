<div class="bg-body dark:bg-surface rounded-lg border border-border dark:border-border shadow-sm">
    {{-- Header --}}
    <div class="px-6 py-4 border-b border-border dark:border-border flex items-center justify-between">
        <h2 class="text-xl font-semibold text-text dark:text-text">
            @lang('igniter.user::default.text_address')
        </h2>
        <button
            wire:click="create"
            wire:loading.class="opacity-50 cursor-not-allowed"
            class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors font-medium"
        >
            @lang('igniter.user::default.account.button_add')
        </button>
    </div>

    {{-- Address List --}}
    <div class="p-6">
        @if(count($addresses))
            <div class="space-y-3">
                @foreach ($addresses as $address)
                    <div
                        @class([
                            'p-4 rounded-lg border-2 transition-all cursor-pointer hover:shadow-md',
                            'border-primary-500 bg-primary-50 dark:bg-primary-900/20' => $defaultAddressId == $address->address_id,
                            'border-border dark:border-border hover:border-border dark:hover:border-border' => $defaultAddressId != $address->address_id,
                        ])
                        wire:click="edit({{ $address->address_id }})"
                        wire:loading.class="opacity-50"
                        role="button"
                    >
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 mt-1">
                                <svg class="w-5 h-5 text-text-muted dark:text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <address class="text-text dark:text-text not-italic">
                                    {{ format_address($address, false) }}
                                </address>
                                @if($defaultAddressId == $address->address_id)
                                    <span class="inline-flex items-center mt-2 px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-300">
                                        @lang('tipowerup.orange-tw::default.address_book.default_badge')
                                    </span>
                                @endif
                            </div>
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-text-muted dark:text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $addresses->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-text-muted dark:text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-text dark:text-text">
                    @lang('igniter.user::default.account.text_no_address')
                </h3>
                <p class="mt-1 text-sm text-text-muted dark:text-text-muted">
                    @lang('tipowerup.orange-tw::default.address_book.empty_message')
                </p>
            </div>
        @endif
    </div>

    {{-- Modal Form --}}
    @if($showModal)
        <div
            class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true"
            x-data="{ show: @entangle('showModal') }"
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        >
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                {{-- Background overlay --}}
                <div class="fixed inset-0 bg-surface bg-opacity-75 dark:bg-body dark:bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="$set('showModal', false)"></div>

                {{-- Center modal --}}
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-body dark:bg-surface rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <form wire:submit="save">
                        <div class="bg-body dark:bg-surface px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="mb-4">
                                <h3 class="text-lg leading-6 font-medium text-text dark:text-text" id="modal-title">
                                    {{ $selectAddress ? lang('igniter.user::default.account.button_update') : lang('igniter.user::default.account.button_add') }} @lang('igniter.user::default.text_address')
                                </h3>
                            </div>

                            <input type="hidden" wire:model="form.address_id" />

                            {{-- Address 1 --}}
                            <div class="mb-4">
                                <label for="address1" class="block text-sm font-medium text-text dark:text-text mb-1">
                                    @lang('igniter.user::default.account.label_address_1')
                                </label>
                                <input
                                    id="address1"
                                    wire:model="form.address_1"
                                    type="text"
                                    autocomplete="address-line1"
                                    class="w-full px-3 py-2 border border-border dark:border-border rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-surface dark:text-text"
                                />
                                @error('form.address_1')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Address 2 --}}
                            <div class="mb-4">
                                <label for="address2" class="block text-sm font-medium text-text dark:text-text mb-1">
                                    @lang('igniter.user::default.account.label_address_2')
                                </label>
                                <input
                                    id="address2"
                                    wire:model="form.address_2"
                                    type="text"
                                    autocomplete="address-line2"
                                    class="w-full px-3 py-2 border border-border dark:border-border rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-surface dark:text-text"
                                />
                                @error('form.address_2')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- City, State, Postcode --}}
                            <div class="grid grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label for="city" class="block text-sm font-medium text-text dark:text-text mb-1">
                                        @lang('igniter.user::default.account.label_city')
                                    </label>
                                    <input
                                        id="city"
                                        wire:model="form.city"
                                        type="text"
                                        autocomplete="address-level2"
                                        class="w-full px-3 py-2 border border-border dark:border-border rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-surface dark:text-text"
                                    />
                                    @error('form.city')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="state" class="block text-sm font-medium text-text dark:text-text mb-1">
                                        @lang('igniter.user::default.account.label_state')
                                    </label>
                                    <input
                                        id="state"
                                        wire:model="form.state"
                                        type="text"
                                        autocomplete="address-level1"
                                        class="w-full px-3 py-2 border border-border dark:border-border rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-surface dark:text-text"
                                    />
                                    @error('form.state')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="postcode" class="block text-sm font-medium text-text dark:text-text mb-1">
                                        @lang('igniter.user::default.account.label_postcode')
                                    </label>
                                    <input
                                        id="postcode"
                                        wire:model="form.postcode"
                                        type="text"
                                        autocomplete="postal-code"
                                        class="w-full px-3 py-2 border border-border dark:border-border rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-surface dark:text-text"
                                    />
                                    @error('form.postcode')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Country --}}
                            <div class="mb-4">
                                <label for="country" class="block text-sm font-medium text-text dark:text-text mb-1">
                                    @lang('igniter.user::default.account.label_country')
                                </label>
                                <select
                                    id="country"
                                    wire:model="form.country_id"
                                    autocomplete="country"
                                    class="w-full px-3 py-2 border border-border dark:border-border rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-surface dark:text-text"
                                >
                                    <option value="">@lang('admin::lang.text_select')</option>
                                    @foreach (countries() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('form.country_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Set Default Checkbox --}}
                            <div class="mb-4">
                                <label class="flex items-center">
                                    <input
                                        wire:model="form.is_default"
                                        type="checkbox"
                                        class="rounded border-border dark:border-border text-primary-600 focus:ring-primary-500 dark:bg-surface"
                                    />
                                    <span class="ml-2 text-sm text-text dark:text-text">
                                        @lang('igniter.user::default.text_set_default')
                                    </span>
                                </label>
                                @error('form.is_default')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="bg-surface dark:bg-body px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                            <button
                                type="submit"
                                wire:loading.attr="disabled"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                {{ $selectAddress ? lang('igniter.user::default.account.button_update') : lang('igniter.user::default.account.button_add') }}
                            </button>

                            @if($selectAddress)
                                <button
                                    type="button"
                                    wire:click="delete({{ $selectAddress->address_id }})"
                                    wire:loading.attr="disabled"
                                    wire:confirm="@lang('tipowerup.orange-tw::default.address_book.delete_confirm')"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-surface focus:ring-red-500 sm:w-auto sm:text-sm disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    @lang('igniter.user::default.account.text_delete')
                                </button>
                            @endif

                            <button
                                type="button"
                                wire:click="$set('showModal', false)"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-border dark:border-border shadow-sm px-4 py-2 bg-body dark:bg-surface text-base font-medium text-text dark:text-text hover:bg-surface dark:hover:bg-surface focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:w-auto sm:text-sm"
                            >
                                @lang('igniter::admin.button_close')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
