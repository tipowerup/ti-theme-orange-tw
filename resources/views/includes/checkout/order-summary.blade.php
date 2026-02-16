<div class="bg-body dark:bg-surface rounded-lg shadow-sm border border-border dark:border-border p-6 sticky top-6">
    <h2 class="text-xl font-semibold text-text dark:text-text mb-4">@lang('igniter.cart::default.text_basket')</h2>

    {{-- Cart items --}}
    @if($cart->count())
        <div class="mb-6 pb-6 border-b border-border dark:border-border">
            <ul class="divide-y divide-border dark:divide-border">
                @foreach ($cart->content()->reverse() as $cartItem)
                    <li class="py-3 flex items-start gap-3" wire:key="checkout-cart-item-{{ $cartItem->rowId }}">
                        <div class="flex-1">
                            <div class="mb-1">
                                @if ($cartItem->qty > 1)
                                    <span class="font-bold text-text dark:text-text">{{ $cartItem->qty }} x</span>
                                @endif
                                <span class="text-text dark:text-text">{{ $cartItem->name }}</span>
                            </div>

                            @if($cartItem->hasOptions())
                                <div class="text-sm text-text-muted dark:text-text-muted">
                                    @foreach ($cartItem->options as $option)
                                        <span>{{ $option->name }}@unless($loop->last), @endunless</span>
                                    @endforeach
                                </div>
                            @endif

                            @if (!empty($cartItem->comment))
                                <p class="text-sm text-text-muted dark:text-text-muted mt-1 italic">
                                    "{{ $cartItem->comment }}"
                                </p>
                            @endif
                        </div>

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

        {{-- Totals --}}
        <div class="space-y-2 mb-4">
            {{-- Subtotal --}}
            <div class="flex justify-between text-text dark:text-text">
                <span>@lang('igniter.cart::default.text_sub_total')</span>
                <span>{{ currency_format($cart->subtotal()) }}</span>
            </div>

            {{-- Conditions (discounts, fees, etc.) --}}
            @foreach ($cart->conditions() as $id => $condition)
                <div wire:key="checkout-condition-{{ $id }}" class="flex justify-between text-text dark:text-text">
                    <span>{{ $condition->getLabel() }}</span>
                    <span>{{ is_numeric($result = $condition->getValue()) ? currency_format($result) : $result }}</span>
                </div>
            @endforeach
        </div>

        {{-- Total --}}
        <div class="pt-4 border-t border-border dark:border-border">
            <div class="flex justify-between text-lg font-bold text-text dark:text-text">
                <span>@lang('igniter.cart::default.text_order_total')</span>
                <span>{{ $this->cartTotal }}</span>
            </div>
        </div>
    @endif

    {{-- Secure checkout badge --}}
    <div class="mt-6 pt-6 border-t border-border dark:border-border">
        <div class="flex items-center justify-center gap-2 text-sm text-text-muted dark:text-text-muted">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
            <span>@lang('tipowerup.orange-tw::default.checkout.secure_checkout')</span>
        </div>
    </div>
</div>
