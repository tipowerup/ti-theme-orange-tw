@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation">
        <ul class="flex items-center justify-between gap-4">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="flex-1">
                    <span
                        class="flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-text-muted bg-surface border border-border cursor-not-allowed rounded-lg"
                        aria-disabled="true"
                    >
                        <x-tipowerup-orange-tw::icon name="chevron-left" class="w-4 h-4" />
                        <span class="hidden sm:inline">Previous</span>
                    </span>
                </li>
            @else
                <li class="flex-1">
                    <a
                        href="{{ $paginator->previousPageUrl() }}"
                        rel="prev"
                        class="flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-text bg-surface hover:bg-body border border-border rounded-lg transition-colors"
                    >
                        <x-tipowerup-orange-tw::icon name="chevron-left" class="w-4 h-4" />
                        <span class="hidden sm:inline">Previous</span>
                    </a>
                </li>
            @endif

            {{-- Page Indicator --}}
            <li>
                <span class="text-sm text-text-muted whitespace-nowrap">
                    Page {{ $paginator->currentPage() }}
                </span>
            </li>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="flex-1">
                    <a
                        href="{{ $paginator->nextPageUrl() }}"
                        rel="next"
                        class="flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-text bg-surface hover:bg-body border border-border rounded-lg transition-colors"
                    >
                        <span class="hidden sm:inline">Next</span>
                        <x-tipowerup-orange-tw::icon name="chevron-right" class="w-4 h-4" />
                    </a>
                </li>
            @else
                <li class="flex-1">
                    <span
                        class="flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-text-muted bg-surface border border-border cursor-not-allowed rounded-lg"
                        aria-disabled="true"
                    >
                        <span class="hidden sm:inline">Next</span>
                        <x-tipowerup-orange-tw::icon name="chevron-right" class="w-4 h-4" />
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
