<div class="mb-6 pb-6 border-b border-border dark:border-border">
    <h3 class="text-sm font-semibold text-text dark:text-text mb-3">@lang('tipowerup.orange-tw::default.tip.title')</h3>

    <div class="grid grid-cols-4 gap-2 mb-3">
        @foreach ($this->tippingAmounts() as $amount)
            <button
                wire:click="onApplyTip({{ $amount }}, false)"
                type="button"
                @class([
                    'px-4 py-2 text-sm font-medium rounded-lg transition-colors',
                    'bg-primary-600 text-white' => !$isCustomTip && $tipAmount == $amount,
                    'bg-surface dark:bg-surface text-text dark:text-text hover:bg-surface dark:hover:bg-surface' => $isCustomTip || $tipAmount != $amount,
                ])
            >
                {{ currency_format($amount) }}
            </button>
        @endforeach
    </div>

    <div class="flex gap-2">
        <div class="flex-1">
            <input
                wire:model="tipAmount"
                type="number"
                step="0.01"
                min="0"
                placeholder="@lang('tipowerup.orange-tw::default.tip.custom_amount')"
                class="w-full px-4 py-2 border border-border dark:border-border rounded-lg bg-body dark:bg-surface text-text dark:text-text placeholder-text-muted dark:placeholder-text-muted focus:ring-2 focus:ring-primary-500 focus:border-transparent"
            />
        </div>
        <button
            wire:click="onApplyTip({{ $tipAmount }}, true)"
            type="button"
            @class([
                'px-6 py-2 text-sm font-medium rounded-lg transition-colors',
                'bg-primary-600 text-white' => $isCustomTip,
                'bg-surface dark:bg-surface text-text dark:text-text hover:bg-surface dark:hover:bg-surface' => !$isCustomTip,
            ])
        >
            @lang('tipowerup.orange-tw::default.tip.apply')
        </button>
    </div>
</div>
