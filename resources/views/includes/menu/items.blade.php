<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    @forelse($menuItems as $menuItemData)
        @include('tipowerup-orange-tw::includes.menu.item-card', [
            'menuItemData' => $menuItemData,
            'showThumb' => $showThumb ?? true,
            'menuThumbWidth' => $menuThumbWidth ?? 95,
            'menuThumbHeight' => $menuThumbHeight ?? 80,
        ])
    @empty
        @include('tipowerup-orange-tw::includes.menu.empty-state')
    @endforelse
</div>
