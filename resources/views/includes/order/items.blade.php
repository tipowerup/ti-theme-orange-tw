<h6 class="text-sm font-semibold text-text-muted dark:text-text-muted uppercase tracking-wide mb-4">
    @lang('igniter.cart::default.checkout.text_order_details')
</h6>

<div class="cart-items">
    <ul class="space-y-4">
        @foreach ($order->getOrderMenusWithOptions() as $orderItem)
            <li class="border-b border-border dark:border-border pb-4 last:border-0 last:pb-0">
                <div class="flex justify-between items-start mb-2">
                    <div class="flex-1">
                        <span class="font-semibold text-text dark:text-text">
                            @if ($orderItem->quantity > 1)
                                <span class="inline-flex items-center justify-center w-6 h-6 bg-primary-100 dark:bg-primary-900 text-primary-600 dark:text-primary-400 rounded-full text-xs font-bold mr-2">
                                    {{ $orderItem->quantity }}
                                </span>
                            @endif
                            {{ $orderItem->name }}
                        </span>
                    </div>
                    <span class="font-semibold text-text dark:text-text ml-4">
                        {{ currency_format($orderItem->subtotal) }}
                    </span>
                </div>

                @if ($orderItem->menu_options->isNotEmpty())
                    <ul class="ml-8 space-y-1">
                        @foreach ($orderItem->menu_options as $itemOptionGroupName => $itemOptions)
                            <li class="text-sm">
                                <span class="text-text-muted dark:text-text-muted font-medium">{{ $itemOptionGroupName }}:</span>
                                <ul class="ml-4 space-y-0.5">
                                    @foreach ($itemOptions as $itemOption)
                                        <li class="text-text-muted dark:text-text">
                                            @if ($itemOption->quantity > 1)
                                                <span class="text-xs text-text-muted dark:text-text-muted">
                                                    {{ $itemOption->quantity }}x
                                                </span>
                                            @endif
                                            {{ $itemOption->order_option_name }}
                                            @if ($itemOption->order_option_price > 0)
                                                <span class="text-text-muted dark:text-text-muted">
                                                    ({{ currency_format($itemOption->quantity * $itemOption->order_option_price) }})
                                                </span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if (!empty($orderItem->comment))
                    <p class="mt-2 ml-8 text-sm text-text-muted dark:text-text-muted italic">
                        {!! $orderItem->comment !!}
                    </p>
                @endif
            </li>
        @endforeach
    </ul>
</div>

<div class="cart-totals mt-6 pt-6 border-t border-border dark:border-border">
    <table class="w-full">
        <tbody>
            @foreach ($order->getOrderTotals() as $orderTotal)
                @continue($order->isCollectionType() && $orderTotal->code == 'delivery')
                @php($thickLine = in_array($orderTotal->code, ['order_total', 'total']))
                @continue(!$thickLine && (!$orderTotal->is_summable && $orderTotal->code !== 'subtotal'))
                <tr>
                    <td @class([
                        'py-2 text-left',
                        'text-lg font-bold text-text dark:text-text border-t-2 border-border dark:border-border pt-4' => $thickLine,
                        'text-sm text-text-muted dark:text-text-muted' => !$thickLine
                    ])>
                        {{ $orderTotal->title }}
                    </td>
                    <td @class([
                        'py-2 text-right',
                        'text-lg font-bold text-text dark:text-text border-t-2 border-border dark:border-border pt-4' => $thickLine,
                        'text-sm text-text dark:text-text' => !$thickLine
                    ])>
                        {{ currency_format($orderTotal->value) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
