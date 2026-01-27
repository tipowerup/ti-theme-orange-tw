<button
    type="button"
    @click="$dispatch('open-modal', 'fulfillment-modal')"
    class="w-full text-left hover:bg-surface dark:hover:bg-surface rounded-lg p-2 transition-colors"
>
    <div class="space-y-1">
        <!-- Order Type -->
        <div class="flex items-center space-x-2">
            @if($activeOrderType?->getCode() === 'delivery')
                <i class="fa fa-truck text-primary-600 dark:text-primary-400"></i>
                <span class="font-medium text-text dark:text-text">Delivery</span>
            @else
                <i class="fa fa-shopping-bag text-primary-600 dark:text-primary-400"></i>
                <span class="font-medium text-text dark:text-text">Pickup</span>
            @endif
            <i class="fa fa-chevron-down text-xs text-text-muted ml-auto"></i>
        </div>

        <!-- Time -->
        <div class="text-sm text-text-muted dark:text-text-muted">
            @if($isAsap)
                <span class="flex items-center">
                    <i class="far fa-clock mr-1"></i>
                    ASAP
                </span>
            @else
                <span class="flex items-center">
                    <i class="far fa-clock mr-1"></i>
                    {{ $orderDateTime->format('M d, g:i A') }}
                </span>
            @endif
        </div>
    </div>
</button>
