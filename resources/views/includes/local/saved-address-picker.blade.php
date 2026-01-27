@auth('igniter-customer')
    <div class="mt-8">
        <p class="text-text dark:text-text mb-4 font-medium">
            Or select from your saved addresses
        </p>

        <div class="bg-body dark:bg-surface rounded-lg border border-border dark:border-border overflow-hidden">
            @forelse ($this->savedAddresses as $address)
                <button
                    type="button"
                    wire:key="address-{{ $address->address_id }}"
                    wire:click="onSelectAddress({{ $address->address_id }})"
                    class="w-full flex items-center gap-3 px-4 py-3 hover:bg-surface dark:hover:bg-surface transition-colors duration-150 border-b border-border dark:border-border last:border-b-0"
                >
                    <div class="flex-shrink-0 w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>

                    <span class="flex-1 text-left text-text dark:text-text">
                        {{ $address->formatted_address }}
                    </span>

                    <svg class="w-5 h-5 text-text-muted dark:text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            @empty
                <div class="px-4 py-6 text-center">
                    <svg class="w-12 h-12 mx-auto mb-2 text-text-muted dark:text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <p class="text-text-muted dark:text-text-muted font-medium">
                        No saved addresses yet
                    </p>
                    <p class="text-sm text-text-muted dark:text-text-muted mt-1">
                        Save addresses to your account for faster ordering
                    </p>
                </div>
            @endforelse
        </div>

        @error('savedAddress')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400 font-medium">
                {{ $message }}
            </p>
        @enderror
    </div>
@else
    <div class="mt-8 text-center">
        <p class="text-text-muted dark:text-text-muted">
            <a
                href="{{ page_url('account.login') }}"
                wire:navigate
                class="text-primary-600 dark:text-primary-400 hover:underline font-medium"
            >
                Sign in
            </a>
            to access your saved addresses
        </p>
    </div>
@endauth
