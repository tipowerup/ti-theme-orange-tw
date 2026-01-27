@php
    use Igniter\Local\Models\Location;
    $location = Location::getDefault();
@endphp

@if($location)
    <div class="bg-body dark:bg-surface rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-semibold text-text dark:text-text mb-4">
            @lang('tipowerup.orange-tw::default.contact.text_location_info')
        </h3>

        <div class="space-y-4">
            <!-- Restaurant Name -->
            @if($location->getName())
                <div>
                    <h4 class="text-xl font-bold text-text dark:text-text">
                        {{ $location->getName() }}
                    </h4>
                </div>
            @endif

            <!-- Address -->
            @if($location->getAddress())
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h5 class="text-sm font-medium text-text dark:text-text mb-1">Address</h5>
                        <p class="text-sm text-text-muted dark:text-text-muted">
                            {!! format_address($location->getAddress()) !!}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Phone -->
            @if($location->getTelephone())
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h5 class="text-sm font-medium text-text dark:text-text mb-1">Phone</h5>
                        <a
                            href="tel:{{ $location->getTelephone() }}"
                            class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300"
                        >
                            {{ $location->getTelephone() }}
                        </a>
                    </div>
                </div>
            @endif

            <!-- Email -->
            @if($location->getEmail())
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h5 class="text-sm font-medium text-text dark:text-text mb-1">Email</h5>
                        <a
                            href="mailto:{{ $location->getEmail() }}"
                            class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 break-all"
                        >
                            {{ $location->getEmail() }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endif
