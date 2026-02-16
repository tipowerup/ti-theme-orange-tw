@php
    use Igniter\User\Facades\Auth;
    use Igniter\Pages\Classes\MenuManager;
    use Igniter\Pages\Models\Menu;

    $themeCode = controller()->getTheme()->getName();
    $menuItems = [];

    if ($menu = Menu::whereCode('main-menu')->where('theme_code', $themeCode)->first()) {
        $menuItems = resolve(MenuManager::class)->generateReferences($menu, controller()->getLayout());
    }
@endphp

<div class="space-y-1">
    @foreach ($menuItems as $navItem)
        @continue(Auth::isLogged() && in_array($navItem->code, ['login', 'register']))
        @continue(!Auth::isLogged() && in_array($navItem->code, ['account', 'recent-orders']))

        @if($navItem->items)
            {{-- Dropdown Menu (Mobile) --}}
            <div x-data="{ open: false }">
                <button
                    @class([
                        'flex items-center justify-between w-full px-4 py-2 rounded-lg font-medium transition-colors',
                        'text-primary font-bold bg-primary/10' => $navItem->isActive || $navItem->isChildActive,
                        'text-text hover:text-primary hover:bg-surface' => !$navItem->isActive && !$navItem->isChildActive,
                    ])
                    @click="open = !open"
                >
                    @lang($navItem->title)
                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div
                    x-show="open"
                    x-cloak
                    x-collapse
                    class="pl-4 mt-1 space-y-1"
                >
                    @foreach ($navItem->items as $item)
                        <a
                            href="{{ $item->url }}"
                            @class([
                                'block px-4 py-2 rounded-lg text-sm transition-colors',
                                'text-primary font-medium bg-primary/10' => $item->isActive,
                                'text-text hover:text-primary hover:bg-surface' => !$item->isActive,
                            ])
                            wire:navigate
                            {!! $item->extraAttributes !!}
                        >@lang($item->title)</a>
                    @endforeach
                </div>
            </div>
        @else
            {{-- Regular Link --}}
            <a
                href="{{ $navItem->url }}"
                @class([
                    'block px-4 py-2 rounded-lg font-medium transition-colors',
                    'text-primary font-bold bg-primary/10' => $navItem->isActive || $navItem->isChildActive,
                    'text-text hover:text-primary hover:bg-surface' => !$navItem->isActive && !$navItem->isChildActive,
                ])
                wire:navigate
                {!! $navItem->extraAttributes !!}
            >@lang($navItem->title)</a>
        @endif
    @endforeach
</div>
