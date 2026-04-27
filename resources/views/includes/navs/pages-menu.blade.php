@if (!empty($menuItems))
    <nav class="bg-surface border border-border rounded-lg overflow-hidden" aria-label="Static pages">
        <ul class="divide-y divide-border">
            @foreach ($menuItems as $topItem)
                @foreach ($topItem->items as $item)
                    @php($isActive = $item->isActive || $item->isChildActive)
                    <li>
                        <a
                            href="{{ $item->url }}"
                            class="flex items-center px-4 py-3 text-sm transition-colors {{ $isActive ? 'bg-primary-50 dark:bg-primary-900/20 text-primary font-semibold border-l-4 border-primary' : 'text-text hover:bg-body hover:text-primary' }}"
                            {!! $item->extraAttributes !!}
                        >
                            <i class="fa fa-file-text-o w-4 mr-2 text-text-muted"></i>
                            <span>@lang($item->title)</span>
                        </a>
                    </li>
                @endforeach
            @endforeach
        </ul>
    </nav>
@endif
