<div>
    <div
        x-data="{
            currentSlide: 0,
            slides: {{ count($slides) }},
            autoplay: true,
            interval: {{ $delayInterval }},
            timer: null,
            init() {
                if (this.autoplay && this.slides > 1) {
                    this.startAutoplay();
                }
            },
            startAutoplay() {
                this.timer = setInterval(() => {
                    this.next();
                }, this.interval);
            },
            stopAutoplay() {
                if (this.timer) {
                    clearInterval(this.timer);
                    this.timer = null;
                }
            },
            next() {
                this.currentSlide = (this.currentSlide + 1) % this.slides;
            },
            prev() {
                this.currentSlide = (this.currentSlide - 1 + this.slides) % this.slides;
            },
            goTo(index) {
                this.currentSlide = index;
            }
        }"
        @mouseenter="stopAutoplay()"
        @mouseleave="autoplay && slides > 1 ? startAutoplay() : null"
        class="relative overflow-hidden bg-body"
        style="max-height: {{ $height }};"
    >
        <!-- Slides -->
        <div class="relative" style="height: {{ $height }};">
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
                    x-cloak
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

                    @if (!$hideCaptions && strlen($slide->getCustomProperty('description')))
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-8">
                            <div class="container mx-auto text-white">
                                <h2 class="text-3xl md:text-4xl font-bold mb-2">
                                    {{ $slide->getCustomProperty('title') }}
                                </h2>
                                <p class="text-lg md:text-xl opacity-90">
                                    {{ $slide->getCustomProperty('description') }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Controls -->
        @if (!$hideControls && count($slides) > 1)
            <button
                @click="prev()"
                type="button"
                class="absolute left-4 top-1/2 -translate-y-1/2 bg-surface/90 hover:bg-surface text-text rounded-full p-3 shadow-lg transition-all duration-200 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-primary-500"
                aria-label="Previous slide"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <button
                @click="next()"
                type="button"
                class="absolute right-4 top-1/2 -translate-y-1/2 bg-surface/90 hover:bg-surface text-text rounded-full p-3 shadow-lg transition-all duration-200 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-primary-500"
                aria-label="Next slide"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        @endif

        <!-- Indicators -->
        @unless ($hideIndicators)
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
                @foreach ($slides as $index => $slide)
                    <button
                        @click="goTo({{ $index }})"
                        type="button"
                        class="w-3 h-3 rounded-full transition-all duration-200"
                        :class="currentSlide === {{ $index }} ? 'bg-primary w-8' : 'bg-surface/50 hover:bg-surface/75'"
                        aria-label="Go to slide {{ $index + 1 }}"
                    ></button>
                @endforeach
            </div>
        @endunless
    </div>
</div>
