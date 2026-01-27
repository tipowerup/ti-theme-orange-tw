<div class="space-y-6">
    @unless($hideMenuSearch)
        <div class="mb-6">
            @include('tipowerup-orange-tw::includes.menu.search')
        </div>
    @endunless

    <div class="space-y-8" data-bs-spy="scroll" data-bs-target="#navbar-categories" data-bs-smooth-scroll="true">
        @if (!$selectedCategorySlug && $isGrouped)
            @include('tipowerup-orange-tw::includes.menu.grouped', ['groupedMenuItems' => $menuList])
        @else
            @include('tipowerup-orange-tw::includes.menu.items', ['menuItems' => $menuList])
        @endif

        @if($itemsPerPage > 0 && method_exists($menuList, 'links'))
            <div class="flex justify-center mt-8">
                {{ $menuList->links() }}
            </div>
        @endif
    </div>

    @if($selectedMenuId)
        <button
            x-data="{
                init() {
                    this.$nextTick(() => {
                        this.$el.click();
                    });
                }
            }"
            type="button"
            class="hidden"
            @click="$dispatch('open-modal', 'cart-item-modal-{{ $selectedMenuId }}')"
        ></button>
    @endif
</div>

@script
<script>
    document.addEventListener('livewire:initialized', () => {
        // Handle menu item click states
        document.querySelectorAll('[data-control="menu-item"]').forEach((el) => {
            el.addEventListener('click', (event) => {
                if (el.classList.contains('disabled')) {
                    event.preventDefault();
                    return;
                } else {
                    el.classList.add('disabled');
                }

                el.querySelectorAll('i').forEach((icon) => {
                    if (icon.hasAttribute('wire:loading.class')) {
                        icon.classList.add('fa-spinner', 'fa-spin');
                    }
                });
            });
        });

        // Smooth scroll to category sections
        document.querySelectorAll('a[href*="#"]:not([href="#"])').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);

                if (targetElement) {
                    e.preventDefault();
                    const offset = 120; // Account for sticky header
                    const targetPosition = targetElement.offsetTop - offset;

                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    });

    Livewire.hook('commit', ({respond}) => {
        respond(() => {
            document.querySelectorAll('[data-control="menu-item"]').forEach((el) => {
                el.classList.remove('disabled');
                el.querySelectorAll('i.fa-spin').forEach((icon) => {
                    if (icon.hasAttribute('wire:loading.class')) {
                        icon.classList.remove('fa-spinner', 'fa-spin');
                    }
                });
            });
        });
    });
</script>
@endscript
