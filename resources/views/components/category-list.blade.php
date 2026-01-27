<nav
    id="navbar-categories"
    class="flex overflow-x-auto py-4 space-x-2 scrollbar-hide"
    x-data="{
        activeCategory: null,
        scrollToActive() {
            if (this.activeCategory) {
                const el = document.querySelector(`[data-category='\${this.activeCategory}']`);
                if (el) {
                    el.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                }
            }
        }
    }"
>
    @foreach($categories as $category)
        @if(!$hideEmpty || $category->menus_count > 0)
            <a
                href="{{ $useLinkAnchor ? '#'.$category->permalink_slug : page_url($menusPage, ['location' => Location::current()?->permalink_slug, 'category' => $category->permalink_slug]) }}"
                data-category="{{ $category->permalink_slug }}"
                @class([
                    'flex-shrink-0 px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap',
                    'bg-primary-600 text-white' => $selectedCategory?->getKey() === $category->getKey(),
                    'bg-surface dark:bg-surface text-text dark:text-text hover:bg-surface dark:hover:bg-surface' => $selectedCategory?->getKey() !== $category->getKey(),
                ])
                {{ $useLinkAnchor ? '' : 'wire:navigate' }}
            >
                {{ $category->name }}
                @if($category->menus_count > 0)
                    <span class="ml-1 opacity-75">({{ $category->menus_count }})</span>
                @endif
            </a>
        @endif
    @endforeach
</nav>

<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
