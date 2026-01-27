@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        {{-- Mobile View --}}
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-text-muted bg-surface border border-border cursor-default rounded-lg">
                    Previous
                </span>
            @else
                <a
                    href="{{ $paginator->previousPageUrl() }}"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-text bg-surface hover:bg-body border border-border rounded-lg transition-colors"
                    rel="prev"
                >
                    Previous
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a
                    href="{{ $paginator->nextPageUrl() }}"
                    class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-text bg-surface hover:bg-body border border-border rounded-lg transition-colors"
                    rel="next"
                >
                    Next
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-text-muted bg-surface border border-border cursor-default rounded-lg">
                    Next
                </span>
            @endif
        </div>

        {{-- Desktop View --}}
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-text-muted">
                    Showing
                    <span class="font-medium text-text">{{ $paginator->firstItem() }}</span>
                    to
                    <span class="font-medium text-text">{{ $paginator->lastItem() }}</span>
                    of
                    <span class="font-medium text-text">{{ $paginator->total() }}</span>
                    results
                </p>
            </div>

            <div>
                <ul class="flex items-center gap-1" role="list">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li>
                            <span
                                class="relative inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-text-muted bg-surface border border-border cursor-not-allowed rounded-lg"
                                aria-disabled="true"
                                aria-label="Previous page"
                            >
                                <x-tipowerup-orange-tw::icon name="chevron-left" class="w-4 h-4" />
                            </span>
                        </li>
                    @else
                        <li>
                            <a
                                href="{{ $paginator->previousPageUrl() }}"
                                rel="prev"
                                class="relative inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-text bg-surface hover:bg-body border border-border rounded-lg transition-colors"
                                aria-label="Previous page"
                            >
                                <x-tipowerup-orange-tw::icon name="chevron-left" class="w-4 h-4" />
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li>
                                <span class="relative inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-text-muted bg-surface border border-border cursor-default rounded-lg">
                                    {{ $element }}
                                </span>
                            </li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li>
                                        <span
                                            class="relative inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-white bg-primary border border-primary rounded-lg"
                                            aria-current="page"
                                        >
                                            {{ $page }}
                                        </span>
                                    </li>
                                @else
                                    <li>
                                        <a
                                            href="{{ $url }}"
                                            class="relative inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-text bg-surface hover:bg-body border border-border rounded-lg transition-colors"
                                            aria-label="Go to page {{ $page }}"
                                        >
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li>
                            <a
                                href="{{ $paginator->nextPageUrl() }}"
                                rel="next"
                                class="relative inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-text bg-surface hover:bg-body border border-border rounded-lg transition-colors"
                                aria-label="Next page"
                            >
                                <x-tipowerup-orange-tw::icon name="chevron-right" class="w-4 h-4" />
                            </a>
                        </li>
                    @else
                        <li>
                            <span
                                class="relative inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-text-muted bg-surface border border-border cursor-not-allowed rounded-lg"
                                aria-disabled="true"
                                aria-label="Next page"
                            >
                                <x-tipowerup-orange-tw::icon name="chevron-right" class="w-4 h-4" />
                            </span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@endif
