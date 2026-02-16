<div class="space-y-3">
    <!-- Location Name and Info -->
    <div class="flex items-start gap-4">
        @if($showThumb && $locationInfo->hasThumb())
            <img
                src="{{ $locationInfo->getThumb(['width' => $localThumbWidth, 'height' => $localThumbHeight]) }}"
                alt="{{ $locationInfo->name }}"
                class="w-20 h-20 rounded-lg object-cover flex-shrink-0"
            />
        @endif

        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold text-text dark:text-text mb-1">{{ $locationInfo->name }}</h1>

            <!-- Status Row -->
            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-sm mb-2">
                <span @class([
                    'font-semibold',
                    'text-green-600 dark:text-green-400' => $schedule->isOpen(),
                    'text-red-600 dark:text-red-400' => !$schedule->isOpen(),
                ])>
                    @if ($schedule->isOpen())
                        @lang('igniter.local::default.text_is_opened')
                    @elseif ($schedule->isOpening())
                        {!! sprintf(lang('igniter.local::default.text_opening_time'), make_carbon($schedule->getOpenTime())->isoFormat(lang('igniter::system.moment.day_time_format_short'))) !!}
                    @else
                        @lang('igniter.local::default.text_closed')
                    @endif
                </span>
                <span class="text-border">|</span>
                <button
                    type="button"
                    class="font-semibold text-primary hover:text-primary-700 dark:hover:text-primary-400 transition-colors"
                    @click="$dispatch('open-modal', 'local-info-modal')"
                >
                    @lang('igniter.local::default.text_more_info')
                </button>
            </div>

            <!-- Address -->
            <p class="text-sm text-text-muted dark:text-text-muted">
                {{ format_address($locationInfo->address, false) }}
            </p>

            <!-- Reviews -->
            @if($allowReviews && $locationInfo->reviewsCount() > 0)
                <button
                    type="button"
                    class="flex items-center gap-2 mt-2 group"
                    @click="$dispatch('open-modal', 'reviews-modal')"
                >
                    <div class="flex items-center">
                        @php
                            $score = $locationInfo->reviewsScore();
                            $fullStars = floor($score);
                            $halfStar = $score - $fullStars >= 0.5;
                        @endphp
                        @for($i = 0; $i < 5; $i++)
                            @if($i < $fullStars)
                                <i class="fas fa-star text-yellow-400 text-sm"></i>
                            @elseif($i == $fullStars && $halfStar)
                                <i class="fas fa-star-half-alt text-yellow-400 text-sm"></i>
                            @else
                                <i class="far fa-star text-text-muted text-sm"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="text-sm text-primary group-hover:text-primary-700 dark:group-hover:text-primary-400 transition-colors">
                        ({{ $locationInfo->reviewsCount() }}) @lang('tipowerup.orange-tw::default.local_header.reviews')
                    </span>
                </button>
            @endif
        </div>
    </div>

    <!-- Badges -->
    <div class="flex flex-wrap gap-2">
        @if($locationInfo->hasDelivery)
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                <i class="fa fa-motorcycle mr-1.5"></i>
                @lang('tipowerup.orange-tw::default.local_header.delivery_available')
            </span>
        @endif

        @if($locationInfo->hasCollection)
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300">
                <i class="fa fa-shopping-bag mr-1.5"></i>
                @lang('tipowerup.orange-tw::default.local_header.pickup_available')
            </span>
        @endif
    </div>
</div>

{{-- Location Info Modal --}}
@include('tipowerup-orange-tw::includes.local.info-modal')

{{-- Reviews Modal --}}
@if($allowReviews)
    @include('tipowerup-orange-tw::includes.local.reviews-modal')
@endif
