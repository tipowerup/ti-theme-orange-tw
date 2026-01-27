<div class="space-y-4">
    <!-- Location Name and Info -->
    <div class="flex items-start space-x-4">
        @if($showThumb && $locationInfo->hasThumb())
            <img
                src="{{ $locationInfo->getThumb(['width' => $localThumbWidth, 'height' => $localThumbHeight]) }}"
                alt="{{ $locationInfo->name }}"
                class="w-20 h-20 rounded-lg object-cover"
            />
        @endif

        <div class="flex-1">
            <h1 class="text-2xl font-bold text-text dark:text-text mb-1">{{ $locationInfo->name }}</h1>

            @if($allowReviews && $locationInfo->reviewsCount() > 0)
                <div class="flex items-center space-x-2 mb-2">
                    <div class="flex items-center">
                        @php
                            $score = $locationInfo->reviewsScore();
                            $fullStars = floor($score);
                            $halfStar = $score - $fullStars >= 0.5;
                        @endphp
                        @for($i = 0; $i < 5; $i++)
                            @if($i < $fullStars)
                                <i class="fas fa-star text-yellow-400"></i>
                            @elseif($i == $fullStars && $halfStar)
                                <i class="fas fa-star-half-alt text-yellow-400"></i>
                            @else
                                <i class="far fa-star text-text-muted dark:text-text-muted"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="text-sm text-text-muted dark:text-text-muted">
                        {{ number_format($score, 1) }} ({{ $locationInfo->reviewsCount() }} reviews)
                    </span>
                </div>
            @endif

            <!-- Address -->
            <p class="text-sm text-text-muted dark:text-text-muted flex items-center">
                <i class="fa fa-map-marker-alt mr-2"></i>
                {{ format_address($locationInfo->address, false) }}
            </p>
        </div>
    </div>

    <!-- Status and Hours -->
    <div class="flex flex-wrap gap-2">
        @php
            $schedule = $this->currentSchedule($locationInfo);
        @endphp

        <span @class([
            'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium',
            'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' => $schedule->isOpen(),
            'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300' => !$schedule->isOpen(),
        ])>
            <i class="fa fa-circle text-xs mr-2"></i>
            @if ($schedule->isOpen())
                Open until {{ make_carbon($schedule->getCloseTime())->format('g:i A') }}
            @elseif ($schedule->isOpening())
                Opens at {{ make_carbon($schedule->getOpenTime())->format('g:i A') }}
            @else
                Closed
            @endif
        </span>

        @if($locationInfo->hasDelivery)
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                <i class="fa fa-truck mr-2"></i>
                Delivery Available
            </span>
        @endif

        @if($locationInfo->hasCollection)
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300">
                <i class="fa fa-shopping-bag mr-2"></i>
                Pickup Available
            </span>
        @endif
    </div>
</div>
