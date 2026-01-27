<div class="bg-surface rounded-lg shadow-sm mb-6">
    <div class="p-6">
        <h5 class="text-lg font-medium text-text mb-0">
            {{ sprintf(lang('igniter.user::default.text_welcome'), $customerName) }}
        </h5>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    <div class="bg-surface rounded-lg shadow-sm">
        <div class="p-6">
            @if ($hasDefaultAddress)
                <div class="flex justify-between items-start mb-3">
                    <h5 class="text-base font-medium text-text">
                        @lang('igniter.user::default.text_default_address')
                    </h5>
                    <a
                        wire:navigate
                        class="px-3 py-1.5 text-sm border border-border rounded-md hover:bg-body text-text"
                        href="{{ page_url('account.address') }}"
                    >@lang('igniter.user::default.text_edit')</a>
                </div>
                <address class="text-text-muted not-italic">{!! $formattedAddress !!}</address>
            @else
                <p class="text-text-muted">@lang('igniter.user::default.text_no_default_address')</p>
            @endif
        </div>
    </div>

    <div class="bg-surface rounded-lg shadow-sm">
        <div class="p-6 text-center">
            <p class="mb-4">
                <i class="fa fa-shopping-basket text-4xl text-text-muted"></i>
            </p>
            @if ($count = $cartCount())
                <p class="text-text-muted mb-4">
                    {{sprintf(lang('igniter.user::default.text_cart_summary'), $count, currency_format($cartTotal))}}
                </p>
            @else
                <p class="text-text-muted mb-4">@lang('igniter.user::default.text_no_cart_items')</p>
            @endif
            <a
                wire:navigate
                class="inline-block px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-colors"
                href="{{ restaurant_url('local/menus') }}"
            >
                @lang('igniter.user::default.text_order')
            </a>
        </div>
    </div>
</div>
