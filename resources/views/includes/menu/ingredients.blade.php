<div class="flex flex-wrap gap-2">
    @foreach($ingredients as $ingredient)
        <span
            wire:key="ingredient-{{ $ingredient->getKey() }}"
            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-surface dark:bg-surface text-text dark:text-text"
            title="{{ $ingredient->description }}"
        >
            @if($ingredient->hasMedia('thumb'))
                <img
                    src="{{ $ingredient->getThumbOrBlank(['width' => 16, 'height' => 16]) }}"
                    alt="{{ $ingredient->name }}"
                    class="w-4 h-4 rounded-full mr-1"
                />
            @endif
            {{ $ingredient->name }}
        </span>
    @endforeach
</div>
