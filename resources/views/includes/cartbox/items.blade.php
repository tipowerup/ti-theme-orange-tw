<div
    class="cart-items mb-4"
    wire:loading.class="opacity-50"
>
    <ul class="divide-y divide-border dark:divide-border">
        @foreach ($cart->content()->reverse() as $cartItem)
            <li
                class="py-3 flex items-start gap-3"
                wire:key="cart-item-{{ $cartItem->rowId }}"
            >
                {{-- Quantity Controls --}}
                @unless($previewMode)
                    <div class="flex items-center gap-2 shrink-0">
                        <button
                            wire:click="onUpdateItemQuantity('{{ $cartItem->rowId }}', 'minus')"
                            wire:loading.class="opacity-50 pointer-events-none"
                            type="button"
                            class="w-6 h-6 flex items-center justify-center rounded-full border border-border dark:border-border text-text dark:text-text hover:border-primary-500 hover:text-primary-500 transition-colors text-md font-medium leading-none"
                            aria-label="@lang('tipowerup.orange-tw::default.cart.decrease_quantity')"
                        >&minus;</button>
                        <button
                            wire:click="onUpdateItemQuantity('{{ $cartItem->rowId }}', 'plus')"
                            wire:loading.class="opacity-50 pointer-events-none"
                            type="button"
                            class="w-6 h-6 flex items-center justify-center rounded-full border border-border dark:border-border text-text dark:text-text hover:border-primary-500 hover:text-primary-500 transition-colors text-md font-medium leading-none"
                            aria-label="@lang('tipowerup.orange-tw::default.cart.increase_quantity')"
                        >+</button>
                    </div>

                    {{-- Item Details (Clickable - opens modal for update) --}}
                    <button
                        class="flex-1 text-left"
                        data-toggle="orange-modal"
                        data-component="tipowerup-orange-tw::cart-item-modal"
                        data-arguments='{"menuId": {{ $cartItem->id }}, "rowId": "{{ $cartItem->rowId }}"}'
                    >
                        <div class="mb-0.5 text-sm">
                            @if ($cartItem->qty > 1)
                                <span class="font-bold text-text dark:text-text">{{ $cartItem->qty }} @lang('igniter.cart::default.text_times')</span>
                            @endif
                            <span class="text-text dark:text-text">{{ $cartItem->name }}</span>
                        </div>

                        @includeWhen($cartItem->hasOptions(), 'tipowerup-orange-tw::includes.cartbox.item-options', ['itemOptions' => $cartItem->options])

                        @if (!empty($cartItem->comment))
                            <p class="text-xs text-text-muted dark:text-text-muted mt-1 italic">
                                "{{ $cartItem->comment }}"
                            </p>
                        @endif
                    </button>
                @else
                    {{-- Preview Mode (Non-clickable) --}}
                    <div class="flex-1">
                        <div class="mb-0.5 text-sm">
                            @if ($cartItem->qty > 1)
                                <span class="font-bold text-text dark:text-text">{{ $cartItem->qty }} @lang('igniter.cart::default.text_times')</span>
                            @endif
                            <span class="text-text dark:text-text">{{ $cartItem->name }}</span>
                        </div>

                        @includeWhen($cartItem->hasOptions(), 'tipowerup-orange-tw::includes.cartbox.item-options', ['itemOptions' => $cartItem->options])

                        @if (!empty($cartItem->comment))
                            <p class="text-xs text-text-muted dark:text-text-muted mt-1 italic">
                                "{{ $cartItem->comment }}"
                            </p>
                        @endif
                    </div>
                @endunless

                {{-- Price --}}
                <div class="text-right shrink-0 text-sm">
                    @if ($cartItem->hasConditions())
                        <div class="text-xs text-text-muted line-through">
                            {{ currency_format($cartItem->subtotalWithoutConditions()) }}
                        </div>
                    @endif
                    <div class="font-semibold text-text dark:text-text">
                        {{ currency_format($cartItem->subtotal) }}
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
