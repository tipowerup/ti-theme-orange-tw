<h6 class="text-sm font-semibold text-text-muted dark:text-text-muted uppercase tracking-wide mb-3">
    @lang('igniter.cart::default.orders.text_restaurant')
</h6>

<div class="text-text dark:text-text">
    <p class="font-semibold text-lg mb-2">{{ $location->location_name }}</p>
    <div class="text-text-muted dark:text-text space-y-1">
        <p>{!! format_address($location->getAddress(), false) !!}</p>
        @if ($location->location_telephone)
            <p class="flex items-center">
                <i class="fa fa-phone mr-2 text-text-muted"></i>
                <a href="tel:{{ $location->location_telephone }}" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                    {{ $location->location_telephone }}
                </a>
            </p>
        @endif
        @if ($location->location_email)
            <p class="flex items-center">
                <i class="fa fa-envelope mr-2 text-text-muted"></i>
                <a href="mailto:{{ $location->location_email }}" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                    {{ $location->location_email }}
                </a>
            </p>
        @endif
    </div>
</div>
