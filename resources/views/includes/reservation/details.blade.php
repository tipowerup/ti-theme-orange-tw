{{-- Reservation Details Grid --}}
<div class="divide-y divide-border dark:divide-border">
    {{-- Row 1: ID and Status --}}
    <div class="grid grid-cols-1 md:grid-cols-2">
        <div class="p-6 border-r border-border dark:border-border">
            <h6 class="text-xs font-medium text-text-muted dark:text-text-muted uppercase tracking-wider mb-2">
                @lang('admin::lang.column_id')
            </h6>
            <span class="text-2xl font-semibold text-text dark:text-text">
                #{{ $reservation->reservation_id }}
            </span>
        </div>
        <div class="p-6">
            <h6 class="text-xs font-medium text-text-muted dark:text-text-muted uppercase tracking-wider mb-2">
                @lang('igniter.reservation::default.column_status')
            </h6>
            <div class="flex items-center gap-2">
                @include('tipowerup-orange-tw::includes.reservation.status-badge', ['reservation' => $reservation])
            </div>
        </div>
    </div>

    {{-- Row 2: Date and Guests --}}
    <div class="grid grid-cols-1 md:grid-cols-2">
        <div class="p-6 border-r border-border dark:border-border">
            <h6 class="text-xs font-medium text-text-muted dark:text-text-muted uppercase tracking-wider mb-2">
                @lang('igniter.reservation::default.column_date')
            </h6>
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-text-muted dark:text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-lg font-medium text-text dark:text-text">
                    {{ $reservation->reserve_date->setTimeFromTimeString($reservation->reserve_time)->isoFormat(lang('system::lang.moment.date_time_format_short')) }}
                </span>
            </div>
        </div>
        <div class="p-6">
            <h6 class="text-xs font-medium text-text-muted dark:text-text-muted uppercase tracking-wider mb-2">
                @lang('igniter.reservation::default.column_guest')
            </h6>
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-text-muted dark:text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span class="text-lg font-medium text-text dark:text-text">
                    {{ $reservation->guest_num }}
                </span>
            </div>
        </div>
    </div>

    {{-- Row 3: Table and Comment --}}
    <div class="grid grid-cols-1 md:grid-cols-2">
        <div class="p-6 border-r border-border dark:border-border">
            <h6 class="text-xs font-medium text-text-muted dark:text-text-muted uppercase tracking-wider mb-2">
                @lang('igniter.reservation::default.column_table')
            </h6>
            <span class="text-lg font-medium text-text dark:text-text">
                {{ $reservation->tables->pluck('name')->join(', ') ?: 'Not assigned' }}
            </span>
        </div>
        <div class="p-6">
            <h6 class="text-xs font-medium text-text-muted dark:text-text-muted uppercase tracking-wider mb-2">
                @lang('igniter.reservation::default.column_comment')
            </h6>
            <span class="text-sm text-text dark:text-text">
                {{ $reservation->comment ?: 'No comments' }}
            </span>
        </div>
    </div>

    {{-- Row 4: Location and Customer --}}
    <div class="grid grid-cols-1 md:grid-cols-2">
        <div class="p-6 border-r border-border dark:border-border">
            <h6 class="text-xs font-medium text-text-muted dark:text-text-muted uppercase tracking-wider mb-2">
                @lang('igniter.reservation::default.column_location')
            </h6>
            <div class="flex items-start gap-2">
                <svg class="w-5 h-5 text-text-muted dark:text-text-muted mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <div>
                    <span class="text-lg font-medium text-text dark:text-text block">
                        {{ $reservation->location->location_name }}
                    </span>
                    <address class="mt-2 text-sm text-text-muted dark:text-text-muted not-italic">
                        {{ html(format_address($reservation->location->getAddress(), false)) }}
                    </address>
                </div>
            </div>
        </div>
        <div class="p-6">
            <h6 class="text-xs font-medium text-text-muted dark:text-text-muted uppercase tracking-wider mb-2">
                @lang('igniter.reservation::default.column_customer_name')
            </h6>
            <div class="flex items-start gap-2">
                <svg class="w-5 h-5 text-text-muted dark:text-text-muted mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <div>
                    <span class="text-lg font-medium text-text dark:text-text block">
                        {{ $reservation->first_name }} {{ $reservation->last_name }}
                    </span>
                    <div class="mt-2 space-y-1">
                        <p class="text-sm text-text-muted dark:text-text-muted flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ $reservation->email }}
                        </p>
                        <p class="text-sm text-text-muted dark:text-text-muted flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            {{ $reservation->telephone }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
