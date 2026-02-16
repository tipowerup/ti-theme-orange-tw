@php
    use Igniter\User\Facades\Auth;
@endphp

<ul class="flex items-center space-x-1">
    @foreach ($menuItems as $navItem)
        @continue(Auth::isLogged() && in_array($navItem->code, ['login', 'register']))
        @continue(!Auth::isLogged() && in_array($navItem->code, ['account', 'recent-orders']))

        <li class="relative" @if($navItem->items) x-data="{ open: false }" @endif>
            @if($navItem->items)
                {{-- Dropdown Menu --}}
                <button
                    id="navbar-{{ $navItem->code }}"
                    @class([
                        'px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-1',
                        'text-primary font-bold' => $navItem->isActive || $navItem->isChildActive,
                        'text-text hover:text-primary hover:bg-surface' => !$navItem->isActive && !$navItem->isChildActive,
                    ])
                    @click="open = !open"
                    @click.outside="open = false"
                    {!! $navItem->extraAttributes !!}
                >
                    @lang($navItem->title)
                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                {{-- Dropdown Items --}}
                <div
                    x-show="open"
                    x-cloak
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute left-0 mt-2 w-56 bg-body dark:bg-surface border border-border dark:border-border rounded-lg shadow-lg py-2 z-50 whitespace-nowrap"
                >
                    @foreach ($navItem->items as $item)
                        <a
                            href="{{ $item->url }}"
                            @class([
                                'block px-4 py-2 text-sm transition-colors',
                                'text-primary font-medium bg-primary/10' => $item->isActive,
                                'text-text hover:text-primary hover:bg-surface' => !$item->isActive,
                            ])
                            wire:navigate
                            {!! $item->extraAttributes !!}
                        >@lang($item->title)</a>
                    @endforeach
                </div>
            @else
                {{-- Regular Link --}}
                <a
                    id="navbar-{{ $navItem->code }}"
                    href="{{ $navItem->url }}"
                    @class([
                        'px-4 py-2 rounded-lg font-medium transition-colors block',
                        'text-primary font-bold' => $navItem->isActive || $navItem->isChildActive,
                        'text-text hover:text-primary hover:bg-surface' => !$navItem->isActive && !$navItem->isChildActive,
                    ])
                    wire:navigate
                    {!! $navItem->extraAttributes !!}
                >@lang($navItem->title)</a>
            @endif
        </li>
    @endforeach
</ul>
