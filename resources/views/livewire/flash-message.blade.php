<div class="fixed top-20 right-4 z-50 space-y-4" style="max-width: 400px;">
    @foreach($messages as $index => $flash)
        @php(['level' => $level, 'text' => $text, 'important' => $important] = $flash)
        <div
            wire:key="flash-{{ $index }}-{{ $level }}"
            x-data="{ show: true }"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-4"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-4"
            @if (! $important)
                x-init="setTimeout(() => { show = false; setTimeout(() => $wire.removeMessage({{ $index }}), 200) }, 5000)"
            @endif
            class="flex items-start gap-3 p-4 rounded-lg shadow-lg border
                @if($level === 'success') bg-success/10 border-success text-success
                @elseif($level === 'error') bg-danger/10 border-danger text-danger
                @elseif($level === 'warning') bg-warning/10 border-warning text-warning
                @else bg-info/10 border-info text-info
                @endif"
        >
            {{-- Icon --}}
            <div class="shrink-0 mt-0.5">
                @if($level === 'success')
                    <x-tipowerup-orange-tw::icon name="check-circle" class="w-5 h-5" />
                @elseif($level === 'error')
                    <x-tipowerup-orange-tw::icon name="x-circle" class="w-5 h-5" />
                @elseif($level === 'warning')
                    <x-tipowerup-orange-tw::icon name="exclamation-triangle" class="w-5 h-5" />
                @else
                    <x-tipowerup-orange-tw::icon name="information-circle" class="w-5 h-5" />
                @endif
            </div>

            {{-- Message --}}
            <div class="flex-1 text-sm font-medium">
                {!! $text !!}
            </div>

            {{-- Close Button --}}
            <button
                @click="show = false; setTimeout(() => $wire.removeMessage({{ $index }}), 200)"
                class="shrink-0 hover:opacity-70 transition-opacity"
                aria-label="Dismiss"
            >
                <x-tipowerup-orange-tw::icon name="x" class="w-4 h-4" />
            </button>
        </div>
    @endforeach
</div>
