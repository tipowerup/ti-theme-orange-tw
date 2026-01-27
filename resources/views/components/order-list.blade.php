@if (count($orders))
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="border-b border-border">
                <tr>
                    <th class="text-left py-3 px-4 text-sm font-semibold text-text">
                        @lang('igniter.cart::default.orders.column_id')
                    </th>
                    <th class="text-left py-3 px-4 text-sm font-semibold text-text">
                        @lang('igniter.cart::default.orders.column_location')
                    </th>
                    <th class="text-left py-3 px-4 text-sm font-semibold text-text">
                        @lang('igniter.cart::default.orders.column_status')
                    </th>
                    <th class="text-left py-3 px-4 text-sm font-semibold text-text">
                        @lang('igniter.cart::default.orders.column_date')
                    </th>
                    <th class="text-left py-3 px-4 text-sm font-semibold text-text">
                        @lang('igniter.cart::default.orders.column_total')
                    </th>
                </tr>
            </thead>
            <tbody>
            @foreach ($orders as $order)
                <tr
                    wire:key="order-{{ $order->order_id }}"
                    @class([
                        'border-t border-border' => !$loop->first,
                        'hover:bg-body transition-colors'
                    ])
                >
                    <td class="py-4 px-4">
                        <a
                            class="inline-flex items-center px-3 py-1.5 bg-body hover:bg-surface rounded-md text-text transition-colors"
                            href="{{ page_url($orderPage, ['orderId' => $order->order_id, 'hash' => $order->hash]) }}"
                            wire:navigate
                        >#{{ $order->order_id }}</a>
                    </td>
                    <td class="py-4 px-4 text-text-muted">
                        {{ $order->location ? $order->location->location_name : '' }}
                    </td>
                    <td class="py-4 px-4">
                        <span class="font-medium text-text">
                            {{ $order->status ? $order->status->status_name : '' }}
                        </span>
                    </td>
                    <td class="py-4 px-4 text-text-muted">
                        {{ $order->order_date->setTimeFromTimeString($order->order_time)->isoFormat(lang('system::lang.moment.date_time_format_short')) }}
                    </td>
                    <td class="py-4 px-4 text-text-muted">
                        {{ currency_format($order->order_total) }}
                        ({!! $order->total_items.' '.lang('igniter.cart::default.orders.column_items') !!})
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex justify-end">
        <div class="links">{!! $orders->links() !!}</div>
    </div>
@else
    <div class="text-center py-12">
        <i class="fa fa-shopping-bag text-5xl text-text-muted mb-4"></i>
        <p class="text-text-muted">@lang('igniter.cart::default.orders.text_empty')</p>
    </div>
@endif
