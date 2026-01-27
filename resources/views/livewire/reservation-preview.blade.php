<div>
    @if ($showCancelButton)
        <div class="mb-6 bg-body dark:bg-surface rounded-lg border border-border dark:border-border shadow-sm">
            <div class="p-6 text-center">
                <button
                    wire:click="cancel"
                    wire:loading.class="opacity-50 cursor-not-allowed"
                    wire:confirm="@lang('tipowerup.orange-tw::default.reservations.cancel_confirm')"
                    class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors font-medium"
                >
                    @lang('igniter.reservation::default.button_cancel')
                </button>
                @error('cancel')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>
    @endif

    <div class="bg-body dark:bg-surface rounded-lg border border-border dark:border-border shadow-sm overflow-hidden">
        @if ($reservation)
            @include('tipowerup-orange-tw::includes.reservation.details', ['reservation' => $reservation])
        @else
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-text-muted dark:text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-text dark:text-text">@lang('igniter.reservation::default.text_empty')</h3>
                <p class="mt-1 text-sm text-text-muted dark:text-text-muted">
                    @lang('igniter.reservation::default.text_no_booking')
                </p>
            </div>
        @endif
    </div>
</div>
