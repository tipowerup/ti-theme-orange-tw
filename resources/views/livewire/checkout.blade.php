<div>
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-text dark:text-text mb-2">
            @lang('tipowerup.orange-tw::default.checkout.title') - {{ $locationCurrent->getName() }}
        </h1>

        <div class="text-text-muted dark:text-text-muted">
            {!! $customer
                ? sprintf(lang('tipowerup.orange-tw::default.checkout.text_logged_out'), e($customer->first_name), url('logout'))
                : sprintf(lang('tipowerup.orange-tw::default.checkout.text_logged_in'), page_url('account.login'))
            !!}
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Checkout Form --}}
        <div class="lg:col-span-2">
            <div
                class="bg-body dark:bg-surface rounded-lg shadow-sm border border-border dark:border-border"
                data-control="checkout"
                data-partial="checkoutForm"
                data-payment-input-name="fields.payment"
                data-validate-event="checkout::validate"
                data-confirm-event="checkout::confirm"
                data-choose-payment-event="checkout::choose-payment"
                data-delete-payment-profile-event="checkout::delete-payment-profile"
            >
                <form
                    id="checkout-form"
                    novalidate
                >
                    @if ($isTwoPageCheckout && $checkoutStep !== $this::STEP_PAY)
                        {{-- Two-page checkout: Step 1 - Details --}}
                        <input type="hidden" wire:model.fill="fields.checkoutStep" name="checkoutStep" value="{{$this::STEP_PAY}}">

                        {{-- Your Details --}}
                        <div class="p-6 border-b border-border dark:border-border">
                            <h2 class="text-xl font-semibold text-text dark:text-text mb-4">@lang('tipowerup.orange-tw::default.checkout.your_details')</h2>
                            @include('tipowerup-orange-tw::includes.checkout.fields', [
                                'fields' => $this->formTabFields('details'),
                            ])
                        </div>

                        {{-- Order Type & Time --}}
                        <div class="p-6 border-b border-border dark:border-border">
                            @include('tipowerup-orange-tw::includes.checkout.fulfillment')
                        </div>

                        {{-- Delivery Address --}}
                        @if($order->isDeliveryType())
                            <div class="p-6 border-b border-border dark:border-border">
                                @include('tipowerup-orange-tw::includes.checkout.delivery-address')
                            </div>
                        @endif

                        {{-- Notes (Collapsible) --}}
                        <div class="p-6 border-b border-border dark:border-border">
                            @include('tipowerup-orange-tw::includes.checkout.notes')
                        </div>
                    @elseif($isTwoPageCheckout && $checkoutStep === $this::STEP_PAY)
                        {{-- Two-page checkout: Step 2 - Payment --}}
                        <div class="p-6 border-b border-border dark:border-border">
                            <h2 class="text-xl font-semibold text-text dark:text-text mb-4">@lang('tipowerup.orange-tw::default.checkout.payment_method')</h2>
                            @include('tipowerup-orange-tw::includes.checkout.fields', [
                                'fields' => $this->formTabFields('payments'),
                            ])
                        </div>

                        {{-- Terms --}}
                        <div class="p-6 border-b border-border dark:border-border">
                            @include('tipowerup-orange-tw::includes.checkout.fields', [
                                'fields' => $this->formTabFields('terms'),
                            ])
                        </div>
                    @else
                        {{-- One-page checkout --}}
                        {{-- Your Details --}}
                        <div class="p-6 border-b border-border dark:border-border">
                            <h2 class="text-xl font-semibold text-text dark:text-text mb-4">@lang('tipowerup.orange-tw::default.checkout.your_details')</h2>
                            @include('tipowerup-orange-tw::includes.checkout.fields', [
                                'fields' => $this->formTabFields('details'),
                            ])
                        </div>

                        {{-- Order Type & Time --}}
                        <div class="p-6 border-b border-border dark:border-border">
                            @include('tipowerup-orange-tw::includes.checkout.fulfillment')
                        </div>

                        {{-- Delivery Address --}}
                        @if($order->isDeliveryType())
                            <div class="p-6 border-b border-border dark:border-border">
                                @include('tipowerup-orange-tw::includes.checkout.delivery-address')
                            </div>
                        @endif

                        {{-- Notes (Collapsible) --}}
                        <div class="p-6 border-b border-border dark:border-border">
                            @include('tipowerup-orange-tw::includes.checkout.notes')
                        </div>

                        {{-- Payment --}}
                        <div class="p-6 border-b border-border dark:border-border">
                            <h2 class="text-xl font-semibold text-text dark:text-text mb-4">@lang('tipowerup.orange-tw::default.checkout.payment_method')</h2>
                            @include('tipowerup-orange-tw::includes.checkout.fields', [
                                'fields' => $this->formTabFields('payments'),
                            ])
                        </div>

                        {{-- Terms --}}
                        <div class="p-6 border-b border-border dark:border-border">
                            @include('tipowerup-orange-tw::includes.checkout.fields', [
                                'fields' => $this->formTabFields('terms'),
                            ])
                        </div>
                    @endif

                    {{-- No Payment Gateways Warning --}}
                    @if($noPaymentGateways)
                        <div class="p-6 border-b border-border dark:border-border">
                            <div class="flex items-center gap-3 p-4 bg-warning/10 border border-warning/30 rounded-lg">
                                <i class="fa fa-exclamation-triangle text-warning text-lg"></i>
                                <p class="text-sm text-text dark:text-text">
                                    @lang('tipowerup.orange-tw::default.checkout.no_payment_gateways')
                                </p>
                            </div>
                        </div>
                    @endif

                    {{-- Submit Button --}}
                    <div class="p-6">
                        <button
                            wire:loading.attr="disabled"
                            data-checkout-control="submit"
                            type="submit"
                            @if($noPaymentGateways)
                                disabled
                            @endif
                            @if($requiresTerms)
                                x-data="{ agreed: @entangle('fields.termsAgreed') }"
                                x-bind:disabled="!agreed"
                            @endif
                            class="w-full px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span wire:loading.remove>
                                @lang($isTwoPageCheckout && $checkoutStep !== $this::STEP_PAY ? 'tipowerup.orange-tw::default.checkout.button_payment' : 'tipowerup.orange-tw::default.checkout.button_confirm')
                            </span>
                            <span wire:loading class="inline-flex items-center gap-2">
                                <i class="fa fa-spinner fa-spin"></i>
                                <span>@lang('tipowerup.orange-tw::default.common.processing')</span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Order Summary Sidebar --}}
        <div
            class="lg:col-span-1"
            x-data="{ navVisible: true }"
            @navbar-show.window="navVisible = true"
            @navbar-hide.window="navVisible = false"
        >
            <div
                class="sticky transition-[top] duration-300"
                :style="'top: ' + (navVisible ? '5.5rem' : '1.5rem')"
            >
                @include('tipowerup-orange-tw::includes.checkout.order-summary')
            </div>
        </div>
    </div>
</div>
