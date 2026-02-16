<div
    id="menu{{ $menuItemData->id }}"
    @class([
        'bg-body dark:bg-surface border border-border dark:border-border rounded-lg p-4 transition-all h-full',
        'hover:shadow-lg cursor-pointer' => $menuItemData->mealtimeIsAvailable(),
        'opacity-60 cursor-not-allowed' => !$menuItemData->mealtimeIsAvailable(),
    ])
    @if($menuItemData->mealtimeIsAvailable())
        @if($menuItemData->hasOptions())
            wire:click="onAddToCart({{ $menuItemData->id }}, {{ $menuItemData->minimumQuantity }})"
            data-control="menu-item"
        @else
            wire:click="$dispatch('cart-box:add-item', { menuId: {{ $menuItemData->id }}, quantity: {{ $menuItemData->minimumQuantity }} })"
            data-control="menu-item"
        @endif
    @endif
>
    <div class="flex gap-4 h-full">
        <!-- Menu Item Content -->
        <div class="flex-1 min-w-0 flex flex-col">
            <div class="flex items-start justify-between mb-2">
                <h3 class="text-base font-semibold text-text dark:text-text leading-tight">{{ $menuItemData->name }}</h3>
                @unless($showThumb)
                    <button
                        type="button"
                        @class([
                            'flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center transition-colors ml-2',
                            'bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 hover:bg-primary-200 dark:hover:bg-primary-900/50' => $menuItemData->mealtimeIsAvailable(),
                            'bg-surface dark:bg-surface text-text-muted' => !$menuItemData->mealtimeIsAvailable(),
                        ])
                    >
                        <i @class([
                            'fas fa-plus text-sm' => $menuItemData->mealtimeIsAvailable(),
                            'far fa-clock text-sm' => !$menuItemData->mealtimeIsAvailable()
                        ])
                           wire:loading.class="fa-spinner fa-spin"
                        ></i>
                    </button>
                @endunless
            </div>

            <!-- Description - fixed height for 2 lines -->
            <div class="flex-grow mb-3 min-h-[2.5rem]">
                @if($menuItemData->description)
                    <p class="text-sm text-text-muted dark:text-text-muted line-clamp-2 leading-tight">
                        {!! $menuItemData->description !!}
                    </p>
                @endif
            </div>

            <!-- Price and Meta - always at bottom -->
            <div class="flex flex-wrap items-center gap-2 text-sm mt-auto">
                <span class="font-semibold text-text dark:text-text">
                    @if ($menuItemData->specialIsActive())
                        <span class="line-through text-text-muted mr-1">{!! currency_format($menuItemData->priceBeforeSpecial) !!}</span>
                    @endif
                    @if ($menuItemData->price() > 0)
                        {!! currency_format($menuItemData->price()) !!}
                    @else
                        <span class="text-green-600 dark:text-green-400">Free</span>
                    @endif
                </span>

                @if ($menuItemData->specialIsActive() && $menuItemData->specialDaysRemaining())
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300">
                        <i class="fa fa-clock mr-1"></i>
                        {{ $menuItemData->specialDaysRemaining() }} days left
                    </span>
                @endif

                @if (!$menuItemData->mealtimeIsAvailable())
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">
                        <i class="far fa-clock mr-1"></i>
                        Available {{ $menuItemData->mealtimeTitles() }}
                    </span>
                @endif
            </div>

            <!-- Ingredients -->
            @if($menuItemData->hasIngredients())
                <div class="mt-3 pt-3 border-t border-border dark:border-border">
                    @include('tipowerup-orange-tw::includes.menu.ingredients', [
                        'ingredients' => $menuItemData->ingredients()
                    ])
                </div>
            @endif
        </div>

        <!-- Menu Item Image -->
        @if($showThumb && $menuItemData->hasThumb())
            <div class="flex-shrink-0">
                <img
                    src="{{ $menuItemData->getThumb(['width' => 96, 'height' => 96]) }}"
                    srcset="{{ $menuItemData->getThumb(['width' => 96, 'height' => 96]) }} 1x,
                            {{ $menuItemData->getThumb(['width' => 192, 'height' => 192]) }} 2x"
                    alt="{{ $menuItemData->name }}"
                    class="w-24 h-24 object-cover rounded-lg"
                    loading="lazy"
                    width="96"
                    height="96"
                />
            </div>
        @endif
    </div>
</div>
