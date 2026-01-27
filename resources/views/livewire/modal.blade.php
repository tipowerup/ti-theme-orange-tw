<div>
    {{-- Backdrop --}}
    <div
        x-show="$wire.show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 bg-body/50 backdrop-blur-sm"
        @click="$wire.close()"
        style="display: none;"
    ></div>

    {{-- Modal --}}
    <div
        x-show="$wire.show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;"
    >
        <div class="flex min-h-full items-center justify-center p-4">
            <div
                @click.away="$wire.close()"
                class="relative w-full bg-body rounded-lg shadow-xl"
                :class="{
                    'max-w-sm': $wire.maxWidth === 'sm',
                    'max-w-md': $wire.maxWidth === 'md',
                    'max-w-lg': $wire.maxWidth === 'lg',
                    'max-w-xl': $wire.maxWidth === 'xl',
                    'max-w-2xl': $wire.maxWidth === '2xl',
                    'max-w-4xl': $wire.maxWidth === '4xl',
                    'max-w-6xl': $wire.maxWidth === '6xl',
                }"
            >
                {{-- Close Button --}}
                <button
                    @click="$wire.close()"
                    class="absolute top-4 right-4 text-text-muted hover:text-text transition-colors"
                    aria-label="Close modal"
                >
                    <x-tipowerup-orange-tw::icon name="x" class="w-6 h-6" />
                </button>

                {{-- Modal Header --}}
                @if(isset($header))
                    <div class="px-6 py-4 border-b border-border">
                        {{ $header }}
                    </div>
                @endif

                {{-- Modal Body --}}
                <div class="px-6 py-4">
                    {{ $slot }}
                </div>

                {{-- Modal Footer --}}
                @if(isset($footer))
                    <div class="px-6 py-4 border-t border-border bg-surface rounded-b-lg">
                        {{ $footer }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
