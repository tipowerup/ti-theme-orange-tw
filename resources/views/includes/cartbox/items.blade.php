<div
    class="cart-items mb-6"
    wire:loading.class="opacity-50"
>
    <ul class="divide-y divide-border dark:divide-border">
        @foreach ($cart->content()->reverse() as $cartItem)
            <li
                class="py-4 flex items-start gap-4"
                wire:key="cart-item-{{ $cartItem->rowId }}"
            >
                {{-- Quantity Controls --}}
                @unless($previewMode)
                    <div class="flex items-center gap-2 shrink-0">
                        <button
                            wire:click="onUpdateItemQuantity('{{ $cartItem->rowId }}', 'minus')"
                            wire:loading.class="opacity-50 pointer-events-none"
                            type="button"
                            class="w-8 h-8 flex items-center justify-center rounded-full border-2 border-border dark:border-border text-text dark:text-text hover:border-primary-500 hover:text-primary-500 transition-colors"
                            aria-label="@lang('tipowerup.orange-tw::default.cart.decrease_quantity')"
                        >
                            <svg
                                wire:loading.class="hidden"
                                wire:target="onUpdateItemQuantity('{{ $cartItem->rowId }}', 'minus')"
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                            <svg
                                wire:loading
                                wire:target="onUpdateItemQuantity('{{ $cartItem->rowId }}', 'minus')"
                                class="animate-spin w-4 h-4"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                        <button
                            wire:click="onUpdateItemQuantity('{{ $cartItem->rowId }}', 'plus')"
                            wire:loading.class="opacity-50 pointer-events-none"
                            type="button"
                            class="w-8 h-8 flex items-center justify-center rounded-full border-2 border-border dark:border-border text-text dark:text-text hover:border-primary-500 hover:text-primary-500 transition-colors"
                            aria-label="@lang('tipowerup.orange-tw::default.cart.increase_quantity')"
                        >
                            <svg
                                wire:loading.class="hidden"
                                wire:target="onUpdateItemQuantity('{{ $cartItem->rowId }}', 'plus')"
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <svg
                                wire:loading
                                wire:target="onUpdateItemQuantity('{{ $cartItem->rowId }}', 'plus')"
                                class="animate-spin w-4 h-4"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>

                    {{-- Item Details (Clickable) --}}
                    <button
                        class="flex-1 text-left"
                        data-toggle="orange-modal"
                        data-component="tipowerup-orange-tw::cart-item-modal"
                        data-arguments='{"menuId": {{ $cartItem->id }}, "rowId": "{{ $cartItem->rowId }}"}'
                    >
                        <div class="mb-1">
                            @if ($cartItem->qty > 1)
                                <span class="font-bold text-text dark:text-text">{{ $cartItem->qty }} x</span>
                            @endif
                            <span class="text-text dark:text-text">{{ $cartItem->name }}</span>
                        </div>

                        @includeWhen($cartItem->hasOptions(), 'tipowerup-orange-tw::includes.cartbox.item-options', ['itemOptions' => $cartItem->options])

                        @if (!empty($cartItem->comment))
                            <p class="text-sm text-text-muted dark:text-text-muted mt-2 italic">
                                "{{ $cartItem->comment }}"
                            </p>
                        @endif
                    </button>
                @else
                    {{-- Preview Mode (Non-clickable) --}}
                    <div class="flex-1">
                        <div class="mb-1">
                            @if ($cartItem->qty > 1)
                                <span class="font-bold text-text dark:text-text">{{ $cartItem->qty }} x</span>
                            @endif
                            <span class="text-text dark:text-text">{{ $cartItem->name }}</span>
                        </div>

                        @includeWhen($cartItem->hasOptions(), 'tipowerup-orange-tw::includes.cartbox.item-options', ['itemOptions' => $cartItem->options])

                        @if (!empty($cartItem->comment))
                            <p class="text-sm text-text-muted dark:text-text-muted mt-2 italic">
                                "{{ $cartItem->comment }}"
                            </p>
                        @endif
                    </div>
                @endunless

                {{-- Price --}}
                <div class="text-right shrink-0">
                    @if ($cartItem->hasConditions())
                        <div class="text-sm text-text-muted line-through">
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
