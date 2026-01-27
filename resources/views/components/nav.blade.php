<a
    href="{{ $href }}"
    {{ $attributes->merge(['class' => $getClasses()]) }}
    wire:navigate
>
    {{ $slot }}
</a>
