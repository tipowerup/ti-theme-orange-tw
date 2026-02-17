<div
    x-data="{ show: false }"
    x-on:show-active-modal.window="show = true"
    x-on:hide-modal.window="show = false; $wire.call('resetModal')"
    x-on:close-modal.window="show = false; $wire.call('resetModal')"
>
    <div
        x-show="show"
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;"
    >
        {{-- Backdrop --}}
        <div
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900/75 dark:bg-gray-950/90 backdrop-blur-sm"
            @click="show = false; $dispatch('hide-modal')"
        ></div>

        {{-- Modal Dialog --}}
        <div class="flex min-h-full items-center justify-center p-4">
            <div
                x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                @click.away="show = false; $dispatch('hide-modal')"
                class="relative w-full max-w-lg bg-body dark:bg-surface rounded-lg shadow-xl overflow-hidden"
            >
                @if ($component)
                    @livewire($component, $arguments, key($activeModal))
                @else
                    <div class="p-8 text-center">
                        <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-primary-600"></div>
                        <div class="mt-4 text-text dark:text-text font-medium">Loading...</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
