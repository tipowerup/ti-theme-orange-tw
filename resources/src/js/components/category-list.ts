/**
 * Sticky-nav category scrollspy. Watches every `[id].scroll-mt-32` section in
 * the page, highlights the matching category button as the user scrolls, and
 * smooth-scrolls the active button into view when the active category changes.
 *
 * Usage in blade: <nav x-data="categoryList({ initial: 'pizza' })">
 */
import type { AlpineComponent } from '../types/alpine';

interface CategoryListState {
    activeCategory: string;
    categories: string[];
    headerHeight: number;
    init(): void;
    setupScrollSpy(): void;
    scrollActiveIntoView(): void;
    scrollToTop(): void;
    scrollToCategory(slug: string): void;
}

interface CategoryListArgs {
    initial?: string;
    headerHeight?: number;
}

document.addEventListener('alpine:init', () => {
    window.Alpine.data(
        'categoryList',
        ({ initial = 'all', headerHeight = 130 }: CategoryListArgs = {}): AlpineComponent<CategoryListState> => ({
            activeCategory: initial,
            categories: [],
            headerHeight,

            init() {
                this.setupScrollSpy();
                this.scrollActiveIntoView();
            },

            setupScrollSpy() {
                const sections = document.querySelectorAll<HTMLElement>('[id].scroll-mt-32');
                if (sections.length === 0) {
                    return;
                }

                this.categories = Array.from(sections).map((s) => s.id);

                const observer = new IntersectionObserver(
                    (entries) => {
                        entries.forEach((entry) => {
                            if (entry.isIntersecting) {
                                this.activeCategory = entry.target.id;
                                this.scrollActiveIntoView();
                            }
                        });
                    },
                    {
                        rootMargin: `-${this.headerHeight}px 0px -70% 0px`,
                        threshold: 0,
                    },
                );

                sections.forEach((section) => observer.observe(section));

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
                    el?.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                });
            },

            scrollToTop() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
                this.activeCategory = 'all';
            },

            scrollToCategory(slug: string) {
                const el = document.getElementById(slug);
                if (!el) {
                    return;
                }
                window.scrollTo({ top: el.offsetTop - this.headerHeight, behavior: 'smooth' });
                this.activeCategory = slug;
            },
        }),
    );
});
