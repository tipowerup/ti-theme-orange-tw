@auth('igniter-customer')
    @php($defaultAddressId = (int) (\Igniter\User\Facades\Auth::customer()?->address_id ?? 0))
    <div class="mt-8">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-sm font-semibold text-text dark:text-text">
                Or select from your saved addresses
            </h3>
            @if ($this->savedAddresses->isNotEmpty())
                <span class="text-xs text-text-muted dark:text-text-muted">
                    {{ $this->savedAddresses->count() }} {{ str_plural('address', $this->savedAddresses->count()) }}
                </span>
            @endif
        </div>

        @if ($this->savedAddresses->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach ($this->savedAddresses as $address)
                    <button
                        type="button"
                        wire:key="address-{{ $address->address_id }}"
                        wire:click="onSelectAddress({{ $address->address_id }})"
                        class="group relative text-left rounded-lg border border-border dark:border-border bg-body dark:bg-surface p-4 transition-all hover:border-primary-500 hover:shadow-md hover:-translate-y-0.5 focus:outline-hidden focus-visible:ring-2 focus-visible:ring-primary-500 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-body"
                    >
                        <div class="flex items-start gap-3">
                            <i class="fa fa-map-marker-alt text-primary-600 dark:text-primary-400 mt-0.5"></i>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-0.5">
                                    <p class="text-sm font-semibold text-text dark:text-text truncate">
                                        {{ $address->address_1 ? trim($address->address_1.($address->address_2 ? ', '.$address->address_2 : '')) : $address->formatted_address }}
                                    </p>
                                    @if ((int) $address->address_id === $defaultAddressId)
                                        <span class="shrink-0 inline-flex items-center gap-1 px-1.5 py-0.5 text-[10px] font-semibold uppercase tracking-wide bg-primary-100 text-primary-700 dark:bg-primary-900/40 dark:text-primary-300 rounded-sm">
                                            <i class="fa fa-star text-[9px]"></i>
                                            Default
                                        </span>
                                    @endif
                                </div>
                                @if ($rest = trim(collect([$address->city, $address->state, $address->postcode])->filter()->implode(', ')))
                                    <p class="text-xs text-text-muted dark:text-text-muted truncate">
                                        {{ $rest }}
                                    </p>
                                @endif
                            </div>

                            <i class="fa fa-chevron-right text-xs text-text-muted opacity-0 group-hover:opacity-100 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition mt-1"></i>
                        </div>
                    </button>
                @endforeach
            </div>
        @else
            <div class="rounded-lg border border-dashed border-border dark:border-border bg-body dark:bg-surface px-4 py-8 text-center">
                <i class="fa fa-map-marker-alt text-3xl text-text-muted mb-2"></i>
                <p class="text-sm font-medium text-text dark:text-text">No saved addresses yet</p>
                <p class="text-xs text-text-muted dark:text-text-muted mt-1">
                    Save addresses to your account for faster ordering
                </p>
            </div>
        @endif

        @error('savedAddress')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400 font-medium">{{ $message }}</p>
        @enderror
    </div>
@else
    <div class="mt-8 text-center">
        <p class="text-sm text-text-muted dark:text-text-muted">
            <a
                href="{{ page_url('account.login') }}"
                wire:navigate
                class="text-primary-600 dark:text-primary-400 hover:underline font-medium"
            >Sign in</a>
            to access your saved addresses
        </p>
    </div>
@endauth
