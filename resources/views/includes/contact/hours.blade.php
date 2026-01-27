@php
    use Igniter\Local\Models\Location;
    $location = Location::getDefault();
    $workingHours = $location?->workingHours ?? [];
@endphp

@if($location && count($workingHours) > 0)
    <div class="bg-body dark:bg-surface rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-semibold text-text dark:text-text mb-4">
            @lang('tipowerup.orange-tw::default.contact.text_business_hours')
        </h3>

        <div class="space-y-3">
            @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                @php
                    $dayHours = $workingHours->get($day);
                    $isToday = strtolower(now()->format('l')) === $day;
                    $isOpen = $dayHours?->isOpen ?? false;
                @endphp

                <div @class([
                    'flex items-center justify-between py-2 px-3 rounded-lg',
                    'bg-primary-50 dark:bg-primary-900/20 border-l-4 border-primary-600 dark:border-primary-400' => $isToday,
                ])>
                    <span @class([
                        'text-sm font-medium',
                        'text-text dark:text-text' => $isToday,
                        'text-text-muted dark:text-text-muted' => !$isToday,
                    ])>
                        {{ ucfirst($day) }}
                        @if($isToday)
                            <span class="ml-2 text-xs text-primary-600 dark:text-primary-400">(Today)</span>
                        @endif
                    </span>

                    <span @class([
                        'text-sm',
                        'font-semibold text-text dark:text-text' => $isToday,
                        'text-text-muted dark:text-text-muted' => !$isToday && $isOpen,
                        'text-text-muted dark:text-text-muted' => !$isOpen,
                    ])>
                        @if($isOpen && $dayHours)
                            {{ $dayHours->getOpenTime() }} - {{ $dayHours->getCloseTime() }}
                        @else
                            <span class="text-red-500 dark:text-red-400">Closed</span>
                        @endif
                    </span>
                </div>
            @endforeach
        </div>

        <!-- Current Status -->
        @if($location->isOpen())
            <div class="mt-4 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-sm font-medium text-green-700 dark:text-green-300">
                        Currently Open
                    </span>
                </div>
            </div>
        @else
            <div class="mt-4 p-3 bg-surface dark:bg-surface/50 border border-border dark:border-border rounded-lg">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-surface dark:bg-surface rounded-full"></div>
                    <span class="text-sm font-medium text-text dark:text-text">
                        Currently Closed
                    </span>
                </div>
            </div>
        @endif
    </div>
@endif
