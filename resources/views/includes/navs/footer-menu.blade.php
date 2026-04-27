@if (!empty($menuItems))
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
        @foreach ($menuItems as $navItem)
            <div>
                <h3 class="text-lg font-semibold text-text mb-4">@lang($navItem->title)</h3>
                <ul class="space-y-2">
                    @foreach ($navItem->items as $item)
                        <li>
                            <a
                                href="{{ $item->url }}"
                                class="text-text-muted hover:text-primary transition-colors"
                                {!! $item->extraAttributes !!}
                            >@lang($item->title)</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
@endif
