@php
    use Igniter\Local\Models\Location;
    $location = Location::getDefault();
    $hasCoordinates = $location && $location->getLatLng();
@endphp

@if($hasCoordinates)
    <div class="mt-12">
        <div class="bg-body dark:bg-surface rounded-lg shadow-lg overflow-hidden">
            <div class="p-6 border-b border-border dark:border-border">
                <h3 class="text-2xl font-bold text-text dark:text-text">
                    @lang('tipowerup.orange-tw::default.contact.text_find_us')
                </h3>
            </div>

            <div class="relative">
                @if($location->hasMedia('thumb'))
                    <!-- Map Image Preview (if location has a map image) -->
                    <div class="aspect-video w-full">
                        <img
                            src="{{ $location->getThumb() }}"
                            alt="Location Map"
                            class="w-full h-full object-cover"
                        />
                    </div>
                @else
                    <!-- Google Maps Embed or Placeholder -->
                    @php
                        [$lat, $lng] = $location->getLatLng();
                        $mapUrl = "https://www.google.com/maps/embed/v1/place?key=" . config('services.google.maps_api_key', '')
                                . "&q={$lat},{$lng}"
                                . "&zoom=15";
                    @endphp

                    @if(config('services.google.maps_api_key'))
                        <!-- Google Maps Embed -->
                        <div class="aspect-video w-full">
                            <iframe
                                src="{{ $mapUrl }}"
                                width="100%"
                                height="100%"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                class="w-full h-full"
                            ></iframe>
                        </div>
                    @else
                        <!-- Map Placeholder with Link to Google Maps -->
                        <div class="aspect-video w-full bg-gradient-to-br from-surface to-surface dark:from-surface dark:to-surface relative group">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center space-y-4">
                                    <svg class="w-20 h-20 mx-auto text-text-muted dark:text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <div>
                                        <p class="text-lg font-semibold text-text dark:text-text mb-2">
                                            View on Map
                                        </p>
                                        <a
                                            href="https://www.google.com/maps/search/?api=1&query={{ $lat }},{{ $lng }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white font-semibold rounded-lg transition-colors duration-200 shadow-lg hover:shadow-xl"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                            Open in Google Maps
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

                <!-- Get Directions Link -->
                @if($location->getAddress())
                    <div class="absolute bottom-4 right-4">
                        <a
                            href="https://www.google.com/maps/dir/?api=1&destination={{ urlencode($location->getAddress()->format()) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-body dark:bg-surface hover:bg-surface dark:hover:bg-surface text-text dark:text-text font-medium rounded-lg shadow-lg border border-border dark:border-border transition-colors duration-200"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            Get Directions
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif
