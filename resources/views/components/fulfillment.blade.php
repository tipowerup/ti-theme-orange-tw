<div class="flex items-center text-sm">
    <i class="far fa-clock text-text-muted mr-2"></i>
    <span class="text-text dark:text-text">
        @if (!$activeOrderType || $activeOrderType->isDisabled())
            @lang('igniter.cart::default.text_is_closed')
        @else
            {{ $activeOrderType->getLabel() }} ·
            @if ($isAsap)
                @if ($activeOrderType->getSchedule()->isOpen())
                    @if ($activeOrderType->getLeadTime())
                        {!! sprintf(lang('igniter.local::default.text_in_min'), $activeOrderType->getLeadTime()) !!}
                    @else
                        ASAP
                    @endif
                @elseif ($activeOrderType->getSchedule()->isOpening())
                    {!! sprintf(lang('igniter.local::default.text_starts'), make_carbon($activeOrderType->getSchedule()->getOpenTime())->isoFormat(lang('system::lang.moment.day_time_format_short'))) !!}
                @elseif ($activeOrderType->getSchedule()->isClosed())
                    @lang('igniter.cart::default.text_is_closed')
                @endif
            @elseif ($activeOrderType->getSchedule()->isOpen() || $activeOrderType->getSchedule()->isOpening())
                @if($orderDateTime->isToday())
                    @lang('system::lang.date.today') {{ $orderDateTime->isoFormat(lang('system::lang.moment.time_format')) }}
                @elseif($orderDateTime->isTomorrow())
                    @lang('system::lang.date.tomorrow') {{ $orderDateTime->isoFormat(lang('system::lang.moment.time_format')) }}
                @else
                    {{ $orderDateTime->isoFormat(lang('system::lang.moment.day_time_format')) }}
                @endif
            @endif
        @endif
    </span>
    @unless($previewMode || !$activeOrderType || $activeOrderType->isDisabled())
        <button
            type="button"
            @click="$dispatch('open-modal', 'fulfillment-modal')"
            class="ml-2 text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium"
        >@lang('igniter.local::default.search.text_change')</button>
    @endunless
</div>
