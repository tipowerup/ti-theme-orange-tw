{{-- Generic field renderer for checkout form fields --}}
@foreach ($fields as $field)
    <div class="mb-4">
        @if ($field->type === 'text' || $field->type === 'email' || $field->type === 'telephone')
            <label for="field-{{ $field->fieldName }}" class="block text-sm font-medium text-text dark:text-text mb-1">
                {{ $field->label }}
                @if($field->required)
                    <span class="text-red-600 dark:text-red-400">*</span>
                @endif
            </label>
            <input
                wire:model="fields.{{ $field->fieldName }}"
                type="{{ $field->type === 'telephone' ? 'tel' : $field->type }}"
                id="field-{{ $field->fieldName }}"
                placeholder="{{ $field->placeholder ?? '' }}"
                @if($field->required) required @endif
                @if($field->type === 'email')
                    autocomplete="email"
                @elseif($field->type === 'telephone')
                    autocomplete="tel"
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

        @elseif ($field->type === 'textarea')
            <label for="field-{{ $field->fieldName }}" class="block text-sm font-medium text-text dark:text-text mb-1">
                {{ $field->label }}
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
                    {!! $field->placeholder ?? $field->label !!}
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
                {{ $field->label }}
                @if($field->required)
                    <span class="text-red-600 dark:text-red-400">*</span>
                @endif
            </label>
            <select
                wire:model="fields.{{ $field->fieldName }}"
                id="field-{{ $field->fieldName }}"
                @if($field->required) required @endif
                class="w-full px-4 py-2 border border-border dark:border-border rounded-lg bg-body dark:bg-surface text-text dark:text-text focus:ring-2 focus:ring-primary-500 focus:border-transparent"
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

        @endif
    </div>
@endforeach
