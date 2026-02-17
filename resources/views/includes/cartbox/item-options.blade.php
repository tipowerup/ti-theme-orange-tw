<ul class="text-xs text-text-muted dark:text-text-muted mt-0.5 space-y-0.5">
    @foreach ($itemOptions as $itemOption)
        <li class="text-text-muted dark:text-text-muted">{{ $itemOption->name }}</li>
        @foreach ($itemOption->values as $optionValue)
            <li>
                @if ($optionValue->qty > 1)
                    {{ $optionValue->qty }} @lang('igniter.cart::default.text_times')
                @endif
                {{ $optionValue->name }}
                @if ($optionValue->price > 0)
                    ({{ currency_format($optionValue->subtotal()) }})
                @endif
            </li>
        @endforeach
    @endforeach
</ul>
