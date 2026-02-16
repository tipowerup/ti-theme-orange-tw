{{-- Location Info Slideout Modal --}}
<div
    x-data="{ open: false }"
    x-show="open"
    x-cloak
    @open-modal.window="if ($event.detail === 'local-info-modal') open = true"
    @keydown.escape.window="open = false"
    x-effect="document.body.classList.toggle('overflow-hidden', open)"
    class="fixed inset-0 z-50 overflow-hidden"
    aria-labelledby="local-info-title"
    role="dialog"
    aria-modal="true"
>
    {{-- Backdrop --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm"
        @click="open = false"
    ></div>

    {{-- Slideout Panel --}}
    <div class="fixed inset-y-0 right-0 flex max-w-full">
        <div
            x-show="open"
            x-transition:enter="transform transition ease-in-out duration-300"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="w-screen max-w-md"
        >
            <div class="flex h-full flex-col bg-body dark:bg-surface shadow-xl">
                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-border dark:border-border">
                    <h2 id="local-info-title" class="text-lg font-semibold text-text dark:text-text">
                        @lang('tipowerup.orange-tw::default.local_header.info_title')
                    </h2>
                    <button
                        type="button"
                        @click="open = false"
                        class="rounded-lg p-2 text-text-muted hover:text-text hover:bg-surface dark:hover:bg-body transition-colors"
                    >
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Body --}}
                <div class="flex-1 overflow-y-auto px-6 py-4 space-y-6">
                    {{-- Description --}}
                    @if(strlen($locationInfo->description ?? ''))
                        <div class="prose prose-sm dark:prose-invert max-w-none text-text-muted dark:text-text-muted">
                            {!! nl2br(e($locationInfo->description)) !!}
                        </div>
                    @endif

                    {{-- Order Types Status --}}
                    <div class="space-y-3">
                        @foreach($locationInfo->orderTypes() as $code => $orderType)
                            <div class="bg-surface dark:bg-body rounded-lg p-4 border border-border dark:border-border">
                                <div class="flex items-center gap-3">
                                    <div @class([
                                        'w-10 h-10 rounded-full flex items-center justify-center',
                                        'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400' => $orderType->getSchedule()->isOpen(),
                                        'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400' => $orderType->getSchedule()->isOpening(),
                                        'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400' => !$orderType->getSchedule()->isOpen() && !$orderType->getSchedule()->isOpening(),
                                    ])>
                                        <i class="fa {{ $code === 'delivery' ? 'fa-motorcycle' : 'fa-shopping-bag' }}"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-medium text-text dark:text-text">{{ $orderType->getLabel() }}</h4>
                                        <p class="text-sm text-text-muted dark:text-text-muted">
                                            @if ($orderType->isDisabled())
                                                {!! $orderType->getDisabledDescription() !!}
                                            @elseif ($orderType->getSchedule()->isOpen())
                                                {!! $orderType->getOpenDescription() !!}
                                            @elseif ($orderType->getSchedule()->isOpening())
                                                {!! $orderType->getOpeningDescription(lang('system::lang.moment.day_time_format_short')) !!}
                                            @else
                                                {!! $orderType->getClosedDescription() !!}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Last Order Time --}}
                    @if($locationInfo->hasDelivery)
                        <div class="bg-surface dark:bg-body rounded-lg p-4 border border-border dark:border-border">
                            <p class="text-sm text-text-muted dark:text-text-muted">
                                @lang('igniter.local::default.text_last_order_time')
                                <span class="font-semibold text-text dark:text-text">
                                    {{ $locationInfo->lastOrderTime()->isoFormat(lang('system::lang.moment.day_time_format')) }}
                                </span>
                            </p>
                        </div>
                    @endif

                    {{-- Payment Methods --}}
                    @if($locationInfo->payments())
                        <div>
                            <h3 class="flex items-center gap-2 text-sm font-semibold text-text dark:text-text mb-3">
                                <i class="fas fa-credit-card text-text-muted"></i>
                                @lang('igniter.local::default.text_payments')
                            </h3>
                            <div class="bg-surface dark:bg-body rounded-lg p-4 border border-border dark:border-border">
                                <p class="text-sm text-text-muted dark:text-text-muted">
                                    {!! implode(', ', $locationInfo->payments()) !!}
                                </p>
                            </div>
                        </div>
                    @endif

                    {{-- Opening Hours --}}
                    @if(!empty($locationInfo->scheduleItems()))
                        <div>
                            <h3 class="flex items-center gap-2 text-sm font-semibold text-text dark:text-text mb-3">
                                <i class="fas fa-clock text-text-muted"></i>
                                @lang('tipowerup.orange-tw::default.local_header.opening_hours')
                            </h3>
                            @foreach($locationInfo->scheduleItems() as $scheduleCode => $schedules)
                                <div class="mb-3">
                                    <p class="text-xs font-medium text-text-muted dark:text-text-muted uppercase tracking-wide mb-2">
                                        @lang($locationInfo->scheduleTypes()[$scheduleCode]['name'] ?? $scheduleCode)
                                    </p>
                                    <div class="bg-surface dark:bg-body rounded-lg divide-y divide-border dark:divide-border border border-border dark:border-border overflow-hidden">
                                        @foreach($schedules as $day => $hours)
                                            <div class="flex justify-between px-4 py-2.5 text-sm">
                                                <span class="font-medium text-text dark:text-text">{{ $day }}</span>
                                                <span class="text-text-muted dark:text-text-muted text-right">
                                                    @forelse($hours as $hour)
                                                        <span>{{ $hour['open'] }} - {{ $hour['close'] }}</span>
                                                        @unless($loop->last)<br>@endunless
                                                    @empty
                                                        @lang('igniter.local::default.text_closed')
                                                    @endforelse
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
