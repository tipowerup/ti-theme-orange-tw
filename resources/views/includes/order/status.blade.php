<div class="inline-flex items-center px-4 py-2 bg-surface dark:bg-surface rounded-full mb-4">
    <i class="fa fa-clock mr-2 text-text-muted dark:text-text-muted"></i>
    <span class="text-sm font-medium text-text dark:text-text">
        {{ $order->order_datetime->isoFormat(lang('igniter::system.moment.date_time_format_short')) }}
    </span>
</div>

<h5 class="text-xl font-semibold text-text dark:text-text mb-4">
    @lang('igniter.cart::default.checkout.text_order_no'){{$order->order_id}}
</h5>

@if ($order->status)
    <div class="flex justify-center mb-6">
        <div class="w-full max-w-md">
            <div class="flex gap-2">
                @foreach ($this->getStatusWidthForProgressBars() as $group => $width)
                    <div class="flex-1">
                        <div class="h-2 bg-surface dark:bg-surface rounded-full overflow-hidden">
                            <div
                                class="h-full bg-primary-600 transition-all duration-500"
                                data-status-group="{{ $group }}"
                                data-status-width="{{ $width }}"
                                style="width: {{ $width }}%;"
                            ></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <h3 class="text-2xl font-bold text-text dark:text-text mb-2">{{ $order->status->status_name }}</h3>
    <p class="text-lg text-text-muted dark:text-text-muted mb-4">{!! $order->status->status_comment !!}</p>
@else
    <h3 class="text-2xl font-bold text-text dark:text-text mb-2">--</h3>
@endif

<p class="text-text-muted dark:text-text-muted mb-6">@lang('igniter.cart::default.checkout.text_success_message')</p>

@if ($showContinueShopping)
    <div class="mb-6">
        <a
            href="{{ restaurant_url('local/menus') }}"
            class="inline-block px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors"
            wire:navigate
        >
            <i class="fa fa-shopping-cart mr-2"></i>@lang('tipowerup.orange-tw::default.cart.continue_shopping')
        </a>
    </div>
@endif

<div class="flex flex-wrap gap-3 justify-center">
    @if (!$hideReorderBtn)
        <button
            type="button"
            class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-colors disabled:opacity-50"
            wire:click="onReOrder"
            wire:loading.attr="disabled"
        >
            <span wire:loading.remove wire:target="onReOrder">@lang('igniter.cart::default.orders.button_reorder')</span>
            <span wire:loading wire:target="onReOrder">
                <i class="fa fa-spinner fa-spin mr-2"></i>Processing...
            </span>
        </button>
        @error('onReOrder')
            <p class="w-full text-center text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    @endif
    @if ($showCancelButton)
        <button
            class="px-6 py-2.5 bg-surface hover:bg-surface dark:bg-surface dark:hover:bg-surface text-red-600 dark:text-red-400 rounded-md transition-colors disabled:opacity-50"
            wire:click="onCancel"
            wire:loading.attr="disabled"
        >
            <span wire:loading.remove wire:target="onCancel">@lang('igniter.cart::default.orders.button_cancel')</span>
            <span wire:loading wire:target="onCancel">
                <i class="fa fa-spinner fa-spin mr-2"></i>Canceling...
            </span>
        </button>
        @error('onCancel')
            <p class="w-full text-center text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    @endif
</div>
