@php
    $statusColor = $reservation->status?->status_color ?? '#6B7280';
    $statusName = $reservation->status?->status_name ?? 'Unknown';

    // Determine badge color based on status
    $badgeClasses = match(strtolower($statusName)) {
        'confirmed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
        'cancelled', 'canceled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
        'completed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
        default => 'bg-surface text-text dark:bg-body dark:text-text',
    };
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeClasses }}">
    <span class="w-1.5 h-1.5 rounded-full mr-1.5" style="background-color: {{ $statusColor }};"></span>
    {{ $statusName }}
</span>
