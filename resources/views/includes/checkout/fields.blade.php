{{-- Generic field renderer for checkout form fields --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    @foreach ($fields as $field)
        @php
            // Determine if field should span full width
            $isFullWidth = in_array($field->type, ['textarea', 'checkbox', 'payments'])
                || str_contains($field->cssClass ?? '', 'col-sm-12')
                || in_array($field->fieldName, ['address_1', 'comment', 'delivery_comment']);
        @endphp
        <div @class([
            'sm:col-span-2' => $isFullWidth,
        ])>
            @if ($field->type === 'text' || $field->type === 'email')
                <label for="field-{{ $field->fieldName }}" class="block text-sm font-medium text-text dark:text-text mb-1">
                    @lang($field->label)
                    @if($field->required)
                        <span class="text-red-600 dark:text-red-400">*</span>
                    @endif
                </label>
                <input
                    wire:model="fields.{{ $field->fieldName }}"
                    type="{{ $field->type }}"
                    id="field-{{ $field->fieldName }}"
                    placeholder="{{ $field->placeholder ?? '' }}"
                    @if($field->required) required @endif
                    @if($field->type === 'email')
                        autocomplete="email"
                    @elseif(str_contains($field->fieldName, 'first_name'))
                        autocomplete="given-name"
                    @elseif(str_contains($field->fieldName, 'last_name'))
                        autocomplete="family-name"
                    @elseif(str_contains($field->fieldName, 'address'))
                        autocomplete="street-address"
                    @elseif(str_contains($field->fieldName, 'city'))
                        autocomplete="address-level2"
                    @elseif(str_contains($field->fieldName, 'state'))
                        autocomplete="address-level1"
                    @elseif(str_contains($field->fieldName, 'postcode') || str_contains($field->fieldName, 'zip'))
                        autocomplete="postal-code"
                    @endif
                    class="w-full px-4 py-2 border border-border dark:border-border rounded-lg bg-body dark:bg-surface text-text dark:text-text placeholder-text-muted dark:placeholder-text-muted focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                />
                @error('fields.'.$field->fieldName)
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror

            @elseif ($field->type === 'telephone')
                <label for="field-{{ $field->fieldName }}" class="block text-sm font-medium text-text dark:text-text mb-1">
                    @lang($field->label)
                    @if($field->required)
                        <span class="text-red-600 dark:text-red-400">*</span>
                    @endif
                </label>
                <div wire:ignore>
                    <input
                        data-control="country-code-picker"
                        data-hidden-input-id="hidden-field-{{ $field->fieldName }}"
                        data-container-class="w-full"
                        type="text"
                        id="field-{{ $field->fieldName }}"
                        value="{{ $field->value ?? '' }}"
                        @if($field->required) required @endif
                        class="w-full pr-4 py-2 border border-border dark:border-border rounded-lg bg-body dark:bg-surface text-text dark:text-text placeholder-text-muted dark:placeholder-text-muted focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    />
                    <input
                        type="hidden"
                        id="hidden-field-{{ $field->fieldName }}"
                        value="{{ $field->value ?? '' }}"
                    />
                </div>
                @error('fields.'.$field->fieldName)
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
                @script
                <script>
                    document.addEventListener('telephoneChange', (event) => {
                        if (event.target.matches('#hidden-field-{{ $field->fieldName }}')) {
                            $wire.$set('fields.{{ $field->fieldName }}', event.target.value, false);
                        }
                    });
                </script>
                @endscript

            @elseif ($field->type === 'textarea')
                <label for="field-{{ $field->fieldName }}" class="block text-sm font-medium text-text dark:text-text mb-1">
                    @lang($field->label)
                    @if($field->required)
                        <span class="text-red-600 dark:text-red-400">*</span>
                    @endif
                </label>
                <textarea
                    wire:model="fields.{{ $field->fieldName }}"
                    id="field-{{ $field->fieldName }}"
                    rows="3"
                    placeholder="{{ $field->placeholder ?? '' }}"
                    @if($field->required) required @endif
                    class="w-full px-4 py-2 border border-border dark:border-border rounded-lg bg-body dark:bg-surface text-text dark:text-text placeholder-text-muted dark:placeholder-text-muted focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                ></textarea>
                @error('fields.'.$field->fieldName)
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror

            @elseif ($field->type === 'checkbox')
                <label class="flex items-start">
                    <input
                        wire:model="fields.{{ $field->fieldName }}"
                        type="checkbox"
                        id="field-{{ $field->fieldName }}"
                        @if($field->required) required @endif
                        class="w-4 h-4 mt-1 text-primary-600 border-border dark:border-border rounded focus:ring-primary-500 dark:bg-surface"
                    />
                    <span class="ml-3 text-sm text-text dark:text-text">
                        {!! $field->placeholder ?? lang($field->label) !!}
                        @if($field->required)
                            <span class="text-red-600 dark:text-red-400">*</span>
                        @endif
                    </span>
                </label>
                @error('fields.'.$field->fieldName)
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror

            @elseif ($field->type === 'select')
                <label for="field-{{ $field->fieldName }}" class="block text-sm font-medium text-text dark:text-text mb-1">
                    @lang($field->label)
                    @if($field->required)
                        <span class="text-red-600 dark:text-red-400">*</span>
                    @endif
                </label>
                <select
                    wire:model="fields.{{ $field->fieldName }}"
                    id="field-{{ $field->fieldName }}"
                    @if($field->required) required @endif
                    class="w-full px-4 py-2 border border-border dark:border-border rounded-lg bg-body dark:bg-surface text-text dark:text-text focus:ring-2 focus:ring-primary-500 focus:border-transparent appearance-none"
                >
                    @if($field->placeholder)
                        <option value="">{{ $field->placeholder }}</option>
                    @endif
                    @foreach($field->options ?? [] as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
                @error('fields.'.$field->fieldName)
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror

            @elseif ($field->type === 'payments')
                @if($this->paymentGateways->isNotEmpty())
                    <div data-toggle="payments" class="space-y-3">
                        @foreach ($this->paymentGateways as $paymentMethod)
                            @php
                                $paymentIsSelected = ($field->value == $paymentMethod->code);
                                $paymentIsNotApplicable = !$paymentMethod->isApplicable($order->order_total, $paymentMethod);
                            @endphp
                            <div
                                @class([
                                    'border rounded-lg p-4 transition-colors',
                                    'border-primary-500 bg-primary-50 dark:bg-primary-900/20 selected' => $paymentIsSelected,
                                    'border-border dark:border-border hover:border-primary-300 dark:hover:border-primary-700' => !$paymentIsSelected,
                                ])
                                data-checkout-payment
                            >
                                <label class="flex items-start cursor-pointer">
                                    <input
                                        data-checkout-control="{{ $field->fieldName }}"
                                        data-payment-code="{{ $paymentMethod->code }}"
                                        data-pre-validate-checkout="{{ $paymentMethod->completesPaymentOnClient() ? 'true' : 'false' }}"
                                        type="radio"
                                        name="{{ $field->getName() }}"
                                        id="payment-{{ $paymentMethod->code }}"
                                        class="w-4 h-4 mt-1 text-primary-600 border-border dark:border-border focus:ring-primary-500"
                                        value="{{ $paymentMethod->code }}"
                                        @checked($paymentIsSelected)
                                        @disabled($paymentIsNotApplicable)
                                        autocomplete="off"
                                    />
                                    <div class="ml-3 flex-1" data-checkout-control="payment-label">
                                        <div class="font-medium text-text dark:text-text">{{ $paymentMethod->name }}</div>
                                        @if(strlen($paymentMethod->description))
                                            <div class="text-sm text-text-muted dark:text-text-muted mt-1">
                                                {!! $paymentMethod->description !!}
                                            </div>
                                        @endif
                                        @if($paymentIsNotApplicable)
                                            <div class="text-sm text-text-muted dark:text-text-muted mt-1 italic">
                                                {!! sprintf(
                                                    lang('igniter.payregister::default.alert_min_order_total'),
                                                    currency_format($paymentMethod->order_total),
                                                    lang('igniter.payregister::default.text_this_payment')
                                                ) !!}
                                            </div>
                                        @endif
                                        @if($paymentMethod->hasApplicableFee())
                                            <div class="text-sm text-text-muted dark:text-text-muted mt-1 italic">
                                                {!! sprintf(
                                                    lang('igniter.payregister::default.alert_order_fee'),
                                                    $paymentMethod->getFormattedApplicableFee(),
                                                    lang('igniter.payregister::default.text_this_payment')
                                                ) !!}
                                            </div>
                                        @endif
                                    </div>
                                </label>
                                @if($paymentIsSelected && ($viewName = $paymentMethod->getPaymentFormViewName()))
                                    @include($viewName)
                                @endif
                            </div>
                        @endforeach
                    </div>
                    @error('fields.'.$field->fieldName)
                        <p class="text-red-600 dark:text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                @endif

            @endif
        </div>
    @endforeach
</div>
