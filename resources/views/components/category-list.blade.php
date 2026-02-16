<nav
    id="navbar-categories"
    class="flex overflow-x-auto py-3 space-x-2 scrollbar-hide"
    x-data="{
        activeCategory: '{{ $selectedCategory?->permalink_slug ?? 'all' }}',
        categories: [],
        headerHeight: 130,

        init() {
            this.setupScrollSpy();
            this.scrollActiveIntoView();
        },

        setupScrollSpy() {
            const sections = document.querySelectorAll('[id].scroll-mt-32');
            if (sections.length === 0) return;

            this.categories = Array.from(sections).map(s => s.id);

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        this.activeCategory = entry.target.id;
                        this.scrollActiveIntoView();
                    }
                });
            }, {
                rootMargin: `-${this.headerHeight}px 0px -70% 0px`,
                threshold: 0
            });

            sections.forEach(section => observer.observe(section));

            // Handle scroll to top = 'all' active
            window.addEventListener('scroll', () => {
                if (window.scrollY < 200) {
                    this.activeCategory = 'all';
                    this.scrollActiveIntoView();
                }
            });
        },

        scrollActiveIntoView() {
            this.$nextTick(() => {
                const el = this.$el.querySelector(`[data-category='${this.activeCategory}']`);
                if (el) {
                    el.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                }
            });
        },

        scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
            this.activeCategory = 'all';
        },

        scrollToCategory(slug) {
            const el = document.getElementById(slug);
            if (el) {
                const offset = this.headerHeight;
                const targetPosition = el.offsetTop - offset;
                window.scrollTo({ top: targetPosition, behavior: 'smooth' });
                this.activeCategory = slug;
            }
        }
    }"
>
    {{-- All Categories Option --}}
    <button
        type="button"
        data-category="all"
        @click="scrollToTop()"
        :class="activeCategory === 'all'
            ? 'bg-primary-600 text-white'
            : 'bg-surface dark:bg-surface text-text dark:text-text hover:bg-primary-50 dark:hover:bg-primary-900/20'"
        class="flex-shrink-0 px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap"
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
                class="flex-shrink-0 px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap"
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
