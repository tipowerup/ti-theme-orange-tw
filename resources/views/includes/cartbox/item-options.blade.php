<div class="text-sm text-text-muted dark:text-text-muted mt-1">
    @foreach ($itemOptions as $option)
        @if ($option->values->isNotEmpty())
            <div class="flex flex-wrap gap-1">
                @foreach ($option->values as $value)
                    <span class="inline-flex items-center">
                        {{ $value->name }}
                        @if ($value->price > 0)
                            <span class="ml-1">(+{{ currency_format($value->price) }})</span>
                        @endif
                        @unless($loop->last)
                            <span class="mx-1">,</span>
                        @endunless
                    </span>
                @endforeach
            </div>
        @endif
    @endforeach
</div>
