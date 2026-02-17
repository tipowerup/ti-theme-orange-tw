<div x-data="{ showNotes: false }" class="space-y-3">
    <button
        type="button"
        @click="showNotes = !showNotes"
        class="flex items-center gap-2 text-sm text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors"
    >
        <svg
            class="w-4 h-4 transition-transform duration-200"
            :class="{ 'rotate-90': showNotes }"
            fill="none" stroke="currentColor" viewBox="0 0 24 24"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
        <span x-text="showNotes ? '@lang('tipowerup.orange-tw::default.checkout.hide_notes')' : '@lang('tipowerup.orange-tw::default.checkout.add_notes')'"></span>
    </button>

    <div x-cloak x-show="showNotes" x-transition class="space-y-3">
        {{-- Order Note --}}
        <div>
            <label for="field-comment" class="block text-sm font-medium text-text dark:text-text mb-1">
                @lang('igniter.cart::default.checkout.label_comment')
            </label>
            <textarea
                wire:model="fields.comment"
                id="field-comment"
                rows="2"
                class="w-full px-3 py-2 text-sm border border-border dark:border-border rounded-lg bg-body dark:bg-surface text-text dark:text-text placeholder-text-muted focus:ring-2 focus:ring-primary-500 focus:border-transparent"
            ></textarea>
            @error('fields.comment')
                <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Delivery Note (only for delivery orders) --}}
        @if($order->isDeliveryType())
            <div>
                <label for="field-delivery_comment" class="block text-sm font-medium text-text dark:text-text mb-1">
                    @lang('igniter.cart::default.checkout.label_delivery_comment')
                </label>
                <textarea
                    wire:model="fields.delivery_comment"
                    id="field-delivery_comment"
                    rows="2"
                    class="w-full px-3 py-2 text-sm border border-border dark:border-border rounded-lg bg-body dark:bg-surface text-text dark:text-text placeholder-text-muted focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                ></textarea>
                @error('fields.delivery_comment')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        @endif
    </div>
</div>
