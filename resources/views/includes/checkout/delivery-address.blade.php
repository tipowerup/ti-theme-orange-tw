<div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
    <h3 class="text-sm font-semibold text-text dark:text-text mb-2">Delivery Address</h3>

    @if(isset($fields['address_1']))
        <div class="text-sm text-text dark:text-text">
            <p>{{ $fields['address_1'] ?? '' }}</p>
            @if(isset($fields['city']) || isset($fields['state']) || isset($fields['postcode']))
                <p>
                    {{ $fields['city'] ?? '' }}
                    {{ $fields['state'] ?? '' }}
                    {{ $fields['postcode'] ?? '' }}
                </p>
            @endif
        </div>
    @else
        <p class="text-sm text-text-muted dark:text-text-muted">
            Your delivery address will be determined from your location.
        </p>
    @endif

    @error('delivery_address')
        <p class="text-red-600 dark:text-red-400 text-sm mt-2">{{ $message }}</p>
    @enderror
</div>
