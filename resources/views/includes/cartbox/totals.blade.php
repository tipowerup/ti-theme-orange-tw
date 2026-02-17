<div class="mb-3">
    <div class="space-y-2">
        {{-- Subtotal --}}
        <div class="flex justify-between text-text dark:text-text">
            <span>Subtotal</span>
            <span>{{ currency_format($cart->subtotal()) }}</span>
        </div>

        {{-- Conditions (discounts, fees, etc.) --}}
        @foreach ($cart->conditions() as $id => $condition)
            @if (!$previewMode && $id === 'tip' && ($tipConditionValue = $condition->getValue()))
                @continue
            @endif
            <div wire:key="condition-{{ $id }}" class="flex justify-between text-text dark:text-text">
                <span class="flex items-center gap-2">
                    {{ $condition->getLabel() }}
                    @if (!$previewMode && $condition->removeable)
                        <button
                            wire:click="onRemoveCondition('{{ $id }}')"
                            wire:loading.class="opacity-50"
                            type="button"
                            class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300"
                            aria-label="Remove {{ $condition->getLabel() }}"
                        >
                            <svg
                                wire:loading.remove
                                wire:target="onRemoveCondition"
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <svg
                                wire:loading
                                wire:target="onRemoveCondition"
                                class="animate-spin w-4 h-4"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    @endif
                </span>
                <span>{{ is_numeric($result = $condition->getValue()) ? currency_format($result) : $result }}</span>
            </div>
        @endforeach

        {{-- Tip (if enabled and not in preview) --}}
        @if (!$previewMode && $this->tippingEnabled())
            @php $tipCondition = $cart->getCondition('tip') @endphp
            @if ($tipCondition)
                <div class="flex justify-between text-text dark:text-text">
                    <span>{{ $tipCondition->getLabel() }}</span>
                    <span>{{ currency_format($tipConditionValue ?? 0) }}</span>
                </div>
            @endif
        @endif
    </div>

    {{-- Total --}}
    <div class="mt-4 pt-4 border-t border-border dark:border-border">
        <div class="flex justify-between text-lg font-bold text-text dark:text-text">
            <span>Total</span>
            <span>{{ $this->cartTotal }}</span>
        </div>
    </div>
</div>
