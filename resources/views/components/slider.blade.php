<div>
    <div
        x-data="slider({ slideCount: {{ $slideCount }}, interval: {{ $delayInterval }} })"
        @mouseenter="stopAutoplay()"
        @mouseleave="autoplay && slides > 1 ? startAutoplay() : null"
        @touchstart="onTouchStart($event)"
        @touchend="onTouchEnd($event)"
        class="relative overflow-hidden bg-body"
        style="max-height: {{ $height }};"
    >
        <!-- Slides -->
        <div class="relative" style="height: {{ $height }};">
            @if($useDemoSlides)
                {{-- Demo Slides --}}
                @foreach ($demoSlides as $index => $slide)
                    <div
                        x-show="currentSlide === {{ $index }}"
                        x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-500"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="absolute inset-0 w-full h-full"
                        @if($index > 0) x-cloak @endif
                    >
                        <img
                            src="{{ $slide['image'] }}"
                            alt="{{ $slide['title'] }}"
                            class="w-full h-full object-cover"
                            loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                        />

                        {{-- Overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent"></div>

                        {{-- Text Content --}}
                        <div class="absolute inset-0 flex items-center">
                            <div class="container mx-auto px-6">
                                <div class="max-w-2xl">
                                    <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-relaxed tracking-wide drop-shadow-lg">
                                        {{ $slide['title'] }}
                                    </h2>
                                    <p class="text-lg md:text-xl text-white/80 mb-8 leading-relaxed drop-shadow-md">
                                        {{ $slide['description'] }}
                                    </p>
                                    @if($slide['cta_text'] !== '')
                                        <a
                                            href="{{ $slide['cta_link'] !== '' ? $slide['cta_link'] : $ctaUrl }}"
                                            @unless($slide['cta_is_external']) wire:navigate @endunless
                                            class="inline-flex items-center px-8 py-4 bg-primary hover:bg-primary-700 text-white font-semibold rounded-lg transition-all shadow-lg hover:shadow-xl hover:scale-105"
                                        >
                                            {{ $slide['cta_text'] }}
                                            <i class="fa fa-arrow-right ml-2"></i>
                                        </a>
                                    @else
                                        <a
                                            href="{{ $ctaUrl }}"
                                            wire:navigate
                                            class="inline-flex items-center px-8 py-4 bg-primary hover:bg-primary-700 text-white font-semibold rounded-lg transition-all shadow-lg hover:shadow-xl hover:scale-105"
                                        >
                                            @lang('tipowerup.orange-tw::default.slider.order_now')
                                            <i class="fa fa-arrow-right ml-2"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                {{-- Database Slides --}}
                @foreach ($slides as $index => $slide)
                    <div
                        x-show="currentSlide === {{ $index }}"
                        x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-500"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="absolute inset-0 w-full h-full"
                        @if($index > 0) x-cloak @endif
                    >
                        <img
                            src="{{ $slide->getThumb(['width' => 1920, 'height' => 800]) }}"
                            srcset="{{ $slide->getThumb(['width' => 1920, 'height' => 800]) }} 1x,
                                    {{ $slide->getThumb(['width' => 3840, 'height' => 1600]) }} 2x"
                            alt="{{ $slide->getCustomProperty('title') }}"
                            class="w-full h-full object-cover"
                            loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                            width="1920"
                            height="800"
                        />

                        @if (!$hideCaptions && strlen($slide->getCustomProperty('description') ?? ''))
                            {{-- Overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent"></div>

                            {{-- Text Content --}}
                            <div class="absolute inset-0 flex items-center">
                                <div class="container mx-auto px-6">
                                    <div class="max-w-xl">
                                        <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4 leading-tight">
                                            {{ $slide->getCustomProperty('title') }}
                                        </h2>
                                        <p class="text-lg md:text-xl text-white/90">
                                            {{ $slide->getCustomProperty('description') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Controls -->
        @if (!$hideControls && $slideCount > 1)
            <button
                @click="prev()"
                type="button"
                class="hidden md:block absolute left-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/30 backdrop-blur-xs text-white rounded-full p-3 transition-all duration-200 hover:scale-110 focus:outline-hidden focus:ring-2 focus:ring-white/50"
                aria-label="Previous slide"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <button
                @click="next()"
                type="button"
                class="hidden md:block absolute right-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/30 backdrop-blur-xs text-white rounded-full p-3 transition-all duration-200 hover:scale-110 focus:outline-hidden focus:ring-2 focus:ring-white/50"
                aria-label="Next slide"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        @endif

        <!-- Indicators -->
        @if(!$hideIndicators && $slideCount > 1)
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2">
                @for ($i = 0; $i < $slideCount; $i++)
                    <button
                        @click="goTo({{ $i }})"
                        type="button"
                        class="w-2.5 h-2.5 rounded-full transition-all duration-300"
                        :class="currentSlide === {{ $i }} ? 'bg-white w-8' : 'bg-white/50 hover:bg-white/75'"
                        aria-label="Go to slide {{ $i + 1 }}"
                    ></button>
                @endfor
            </div>
        @endif
    </div>
</div>
