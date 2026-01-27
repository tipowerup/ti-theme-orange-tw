<a
    href="{{ $locationData->url($menusPage) }}"
    wire:navigate
    class="block bg-body dark:bg-surface border border-border dark:border-border rounded-lg p-4 hover:shadow-lg transition-shadow group"
>
    <div class="flex flex-col sm:flex-row gap-4">
        <!-- Left Section: Image and Info -->
        <div class="flex-1 flex flex-col sm:flex-row gap-4">
            @if($showThumb && $locationData->hasThumb())
                <div class="w-full sm:w-24 h-32 sm:h-20 flex-shrink-0">
                    <img
                        src="{{ $locationData->getThumb(['width' => 128, 'height' => 128]) }}"
                        srcset="{{ $locationData->getThumb(['width' => 128, 'height' => 128]) }} 1x,
                                {{ $locationData->getThumb(['width' => 256, 'height' => 256]) }} 2x"
                        alt="{{ $locationData->name }}"
                        class="w-full h-full object-cover rounded-lg"
                        loading="lazy"
                        width="128"
                        height="128"
                    />
                </div>
            @endif

            <div class="flex-1 min-w-0">
                <h3 class="text-lg font-semibold text-text dark:text-text mb-1 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                    {{ $locationData->name }}
                </h3>

                @if($allowReviews && $locationData->reviewsCount() > 0)
                    <div class="flex items-center space-x-2 mb-2">
                        <div class="flex items-center">
                            @php
                                $score = $locationData->reviewsScore();
                                $fullStars = floor($score);
                                $halfStar = $score - $fullStars >= 0.5;
                            @endphp
                            @for($i = 0; $i < 5; $i++)
                                @if($i < $fullStars)
                                    <i class="fas fa-star text-yellow-400 text-sm"></i>
                                @elseif($i == $fullStars && $halfStar)
                                    <i class="fas fa-star-half-alt text-yellow-400 text-sm"></i>
                                @else
                                    <i class="far fa-star text-text-muted dark:text-text-muted text-sm"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="text-sm text-text-muted dark:text-text-muted">({{ $locationData->reviewsCount() }})</span>
                    </div>
                @endif

                <p class="text-sm text-text-muted dark:text-text-muted truncate">
                    {{ format_address($locationData->address, false) }}
                </p>

                @if($locationData->distance())
                    <div class="mt-1 flex items-center space-x-1 text-sm text-text-muted dark:text-text-muted">
                        <i class="fa fa-map-marker text-primary-600 dark:text-primary-400"></i>
                        <span>{{ number_format($locationData->distance(), 1) }} {{ $distanceUnit }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Section: Status -->
        <div class="sm:text-right space-y-1 flex-shrink-0">
            <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                @if($locationData->openingSchedule()->isOpen())
                    bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300
                @else
                    bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300
                @endif
            ">
                @if ($locationData->openingSchedule()->isOpen())
                    <i class="fa fa-circle text-xs mr-1"></i>
                    Open Now
                @elseif ($locationData->openingSchedule()->isOpening())
                    <i class="fa fa-clock text-xs mr-1"></i>
                    Opens {{ make_carbon($locationData->openingSchedule()->getOpenTime())->format('g:i A') }}
                @else
                    <i class="fa fa-circle text-xs mr-1"></i>
                    Closed
                @endif
            </div>

            @foreach($locationData->orderTypes() as $code => $orderType)
                <div class="text-xs text-text-muted dark:text-text-muted">
                    @if($orderType->isDisabled())
                        <span class="text-red-600 dark:text-red-400">{!! $orderType->getDisabledDescription() !!}</span>
                    @elseif($orderType->getSchedule()->isOpen())
                        <span class="text-green-600 dark:text-green-400">{!! $orderType->getOpenDescription() !!}</span>
                    @elseif($orderType->getSchedule()->isOpening())
                        {!! $orderType->getOpeningDescription('g:i A') !!}
                    @else
                        {!! $orderType->getClosedDescription() !!}
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</a>
