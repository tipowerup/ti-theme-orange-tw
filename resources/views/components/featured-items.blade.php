<div>
    @if (count($featuredItems))
        <section class="py-16 bg-body" id="featured-menu-box">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-text mb-4">
                        @lang($title)
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-{{ $itemsPerRow }} gap-6">
                    @foreach ($featuredItems as $featuredItem)
                        <a
                            wire:key="featured-{{ $featuredItem->menu_id }}"
                            href="{{ $featuredItem->getUrl() }}"
                            wire:navigate
                            class="group block bg-surface rounded-lg shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden"
                        >
                            @if ($showThumb)
                                <div class="aspect-[4/3] overflow-hidden">
                                    <img
                                        src="{{ $featuredItem->getThumb([
                                            'width' => $itemWidth,
                                            'height' => $itemHeight,
                                        ]) }}"
                                        srcset="{{ $featuredItem->getThumb([
                                            'width' => $itemWidth,
                                            'height' => $itemHeight,
                                        ]) }} 1x,
                                                {{ $featuredItem->getThumb([
                                            'width' => $itemWidth * 2,
                                            'height' => $itemHeight * 2,
                                        ]) }} 2x"
                                        alt="{{ $featuredItem->name }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                        loading="lazy"
                                        width="{{ $itemWidth }}"
                                        height="{{ $itemHeight }}"
                                    />
                                </div>
                            @endif

                            <div class="p-6">
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="text-xl font-semibold text-text group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                        {{ $featuredItem->name }}
                                    </h3>
                                    <span class="text-lg font-bold text-primary-600 dark:text-primary-400 ml-2 flex-shrink-0">
                                        {{ currency_format($featuredItem->price()) }}
                                    </span>
                                </div>

                                @if ($featuredItem->description)
                                    <p class="text-text-muted dark:text-text-muted text-sm line-clamp-2 mb-4">
                                        {!! $featuredItem->description !!}
                                    </p>
                                @endif

                                @if ($featuredItem->specialIsActive())
                                    <div class="flex items-center gap-2 text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd" />
                                            </svg>
                                            Special
                                        </span>
                                        @if($featuredItem->priceBeforeSpecial > $featuredItem->price())
                                            <span class="text-text-muted dark:text-text-muted line-through">
                                                {{ currency_format($featuredItem->priceBeforeSpecial) }}
                                            </span>
                                        @endif
                                    </div>
                                @endif

                                <div class="mt-4 flex items-center justify-between">
                                    <span class="text-primary-600 dark:text-primary-400 text-sm font-medium group-hover:underline">
                                        View Details
                                    </span>
                                    <svg class="w-5 h-5 text-primary-600 dark:text-primary-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="text-center mt-12">
                    <a
                        href="{{ restaurant_url('local.menus') }}"
                        wire:navigate
                        class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white font-semibold rounded-lg transition-colors duration-200"
                    >
                        View Full Menu
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    @endif
</div>
