@foreach($groupedMenuItems as $categoryId => $categoryMenuItems)
    @php
        $category = $menuListCategories[$categoryId] ?? null;
        $categoryName = $category ? $category->name : 'Uncategorized';
        $categorySlug = $category ? $category->permalink_slug : 'uncategorized';
    @endphp

    <div wire:key="category-{{ $categoryId }}" id="{{ $categorySlug }}" class="scroll-mt-32">
        <!-- Category Header -->
        <div class="mb-4">
            <h2 class="text-2xl font-bold text-text dark:text-text">{{ $categoryName }}</h2>
            @if($category && $category->description)
                <p class="text-text-muted dark:text-text-muted mt-1">{{ $category->description }}</p>
            @endif
        </div>

        <!-- Menu Items Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            @foreach($categoryMenuItems as $menuItemData)
                <div wire:key="menu-item-{{ $menuItemData->id }}">
                    @include('tipowerup-orange-tw::includes.menu.item-card', [
                        'menuItemData' => $menuItemData,
                        'showThumb' => $showThumb ?? true,
                        'menuThumbWidth' => $menuThumbWidth ?? 95,
                        'menuThumbHeight' => $menuThumbHeight ?? 80,
                    ])
                </div>
            @endforeach
        </div>
    </div>
@endforeach
