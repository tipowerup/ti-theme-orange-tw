<div>
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-text dark:text-text mb-2">
            Checkout - {{ $locationCurrent->getName() }}
        </h1>

        <div class="text-text-muted dark:text-text-muted">
            {!! $customer
                ? sprintf('Welcome back, %s! <a href="%s" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">Logout</a>', e($customer->first_name), url('logout'))
                : sprintf('Have an account? <a href="%s" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300" wire:navigate>Sign in</a>', page_url('account.login'))
            !!}
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Checkout Form --}}
        <div class="lg:col-span-2">
            <div class="bg-body dark:bg-surface rounded-lg shadow-sm border border-border dark:border-border">
                <form
                    id="checkout-form"
                    data-control="checkout"
                    data-partial="checkoutForm"
                    data-payment-input-name="fields.payment"
                    data-validate-event="checkout::validate"
                    data-confirm-event="checkout::confirm"
                    data-choose-payment-event="checkout::choose-payment"
                    data-delete-payment-profile-event="checkout::delete-payment-profile"
                    wire:submit="onConfirm"
                    novalidate
                >
                    @if ($isTwoPageCheckout && $checkoutStep !== $this::STEP_PAY)
                        {{-- Two-page checkout: Step 1 - Details --}}
                        <input type="hidden" wire:model.fill="fields.checkoutStep" name="checkoutStep" value="{{$this::STEP_PAY}}">

                        {{-- Your Details --}}
                        <div class="p-6 border-b border-border dark:border-border">
                            <h2 class="text-xl font-semibold text-text dark:text-text mb-4">Your Details</h2>
                            @include('tipowerup-orange-tw::includes.checkout.fields', [
                                'fields' => $this->formTabFields('details'),
                            ])
                        </div>

                        {{-- Order Type & Delivery --}}
                        <div class="p-6 border-b border-border dark:border-border">
                            <div class="p-4 bg-surface dark:bg-surface/50 rounded-lg mb-4">
                                {{-- Fulfillment component would go here --}}
                                <p class="text-text dark:text-text">
                                    Order Type: <span class="font-semibold">{{ ucfirst($order->order_type) }}</span>
                                </p>
                            </div>

                            @if($order->isDeliveryType())
                                @include('tipowerup-orange-tw::includes.checkout.delivery-address')
                            @endif
                        </div>

                        {{-- Comments --}}
                        <div class="p-6 border-b border-border dark:border-border">
                            @include('tipowerup-orange-tw::includes.checkout.fields', [
                                'fields' => $this->formTabFields('comments'),
                            ])
                        </div>
                    @elseif($isTwoPageCheckout && $checkoutStep === $this::STEP_PAY)
                        {{-- Two-page checkout: Step 2 - Payment --}}
                        <div class="p-6 border-b border-border dark:border-border">
                            <h2 class="text-xl font-semibold text-text dark:text-text mb-4">Payment Method</h2>
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
                            <h2 class="text-xl font-semibold text-text dark:text-text mb-4">Your Details</h2>
                            @include('tipowerup-orange-tw::includes.checkout.fields', [
                                'fields' => $this->formTabFields('details'),
                            ])
                        </div>

                        {{-- Order Type & Delivery --}}
                        <div class="p-6 border-b border-border dark:border-border">
                            <div class="p-4 bg-surface dark:bg-surface/50 rounded-lg mb-4">
                                {{-- Fulfillment component would go here --}}
                                <p class="text-text dark:text-text">
                                    Order Type: <span class="font-semibold">{{ ucfirst($order->order_type) }}</span>
                                </p>
                            </div>

                            @if($order->isDeliveryType())
                                @include('tipowerup-orange-tw::includes.checkout.delivery-address')
                            @endif
                        </div>

                        {{-- Comments --}}
                        <div class="p-6 border-b border-border dark:border-border">
                            @include('tipowerup-orange-tw::includes.checkout.fields', [
                                'fields' => $this->formTabFields('comments'),
                            ])
                        </div>

                        {{-- Payment --}}
                        <div class="p-6 border-b border-border dark:border-border">
                            <h2 class="text-xl font-semibold text-text dark:text-text mb-4">Payment Method</h2>
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

                    {{-- Submit Button --}}
                    <div class="p-6">
                        <button
                            wire:loading.attr="disabled"
                            data-checkout-control="submit"
                            type="submit"
                            class="w-full px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span wire:loading.remove>
                                @lang($isTwoPageCheckout && $checkoutStep === $this::STEP_PAY ? 'igniter.orange::default.button_confirm' : 'igniter.orange::default.button_payment')
                            </span>
                            <span wire:loading class="flex items-center gap-2">
                                <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Order Summary Sidebar --}}
        <div class="lg:col-span-1">
            @include('tipowerup-orange-tw::includes.checkout.order-summary')
        </div>
    </div>
</div>
