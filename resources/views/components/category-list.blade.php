<nav
    id="navbar-categories"
    class="flex overflow-x-auto py-3 space-x-2 scrollbar-hide"
    x-data="categoryList({ initial: @js($selectedCategory?->permalink_slug ?? 'all') })"
>
    {{-- All Categories Option --}}
    <button
        type="button"
        data-category="all"
        @click="scrollToTop()"
        :class="activeCategory === 'all'
            ? 'bg-primary-600 text-white'
            : 'bg-surface dark:bg-surface text-text dark:text-text hover:bg-primary-50 dark:hover:bg-primary-900/20'"
        class="shrink-0 px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap"
    >
        @lang('tipowerup.orange-tw::default.menu.all_categories')
    </button>

    @foreach($categories as $category)
        @if(!$hideEmpty || $category->menus_count > 0)
            <button
                type="button"
                data-category="{{ $category->permalink_slug }}"
                @click="scrollToCategory('{{ $category->permalink_slug }}')"
                :class="activeCategory === '{{ $category->permalink_slug }}'
                    ? 'bg-primary-600 text-white'
                    : 'bg-surface dark:bg-surface text-text dark:text-text hover:bg-primary-50 dark:hover:bg-primary-900/20'"
                class="shrink-0 px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap"
            >
                {{ $category->name }}
                @if($category->menus_count > 0)
                    <span class="ml-1 opacity-75">({{ $category->menus_count }})</span>
                @endif
            </button>
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
