<div class="mt-4 flex items-start gap-3 text-sm text-text dark:text-text">
    <svg class="w-5 h-5 text-primary-600 dark:text-primary-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
    </svg>
    @php($deliveryAddress = array_filter(array_only($fields, ['address_1', 'city', 'state', 'postcode'])))
    @if($deliveryAddress)
        <span>{{ html(format_address($deliveryAddress, false)) }}</span>
    @else
        <span class="text-text-muted dark:text-text-muted">@lang('tipowerup.orange-tw::default.checkout.no_delivery_address')</span>
    @endif
</div>
@error('delivery_address')
    <p class="text-red-600 dark:text-red-400 text-sm mt-2">{{ $message }}</p>
@enderror
