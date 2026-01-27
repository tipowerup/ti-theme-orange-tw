<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\Livewire;

use Carbon\Carbon;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Support\Facades\File;
use Igniter\Local\Facades\Location;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\Orange\Actions\EnsureUniqueProcess;
use Igniter\Reservation\Classes\BookingManager;
use Igniter\Reservation\Models\Concerns\LocationAction;
use Igniter\System\Facades\Assets;
use Igniter\User\Facades\Auth;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\Component;
use Throwable;
use TiPowerUp\OrangeTw\Livewire\Forms\BookingForm;

/**
 * Booking component
 *
 * @property-read Collection $timeslots
 */
final class Booking extends Component
{
    use ConfigurableComponent;
    use UsesPage;

    public const string STEP_PICKER = 'picker';

    public const string STEP_TIMESLOT = 'timeslot';

    public const string STEP_BOOKING = 'booking';

    private const int DEFAULT_TIME_SLOTS_SHOWN = 6;

    private const int WEEK_START_SUNDAY = 0;

    private const int DEFAULT_MIN_GUESTS = 2;

    private const int DEFAULT_MAX_GUESTS = 20;

    private const int TIME_SLOT_INTERVAL_MINUTES = 15;

    public BookingForm $form;

    /** Enable to display a calendar view for date selection */
    public bool $useCalendarView = true;

    /** Whether the telephone field should be required */
    public bool $telephoneIsRequired = true;

    /** Whether to hide the time picker */
    public bool $hideTimePicker = false;

    /** Day of the week start the calendar. 0 (Sunday) to 6 (Saturday). */
    public int $weekStartOn = self::WEEK_START_SUNDAY;

    /** The minimum guest size */
    public int $minGuestSize = self::DEFAULT_MIN_GUESTS;

    /** The maximum guest size */
    public int $maxGuestSize = self::DEFAULT_MAX_GUESTS;

    public int $noOfSlots = self::DEFAULT_TIME_SLOTS_SHOWN;

    /** Page to redirect to when checkout is successful */
    #[Locked]
    public string $successPage = 'reservation.success';

    public ?string $calendarLocale = null;

    #[Url(as: 'step')]
    public string $pickerStep = 'start';

    #[Url(history: true)]
    public ?string $date = null;

    #[Url(history: true)]
    public ?int $guest = null;

    #[Url(history: true)]
    public ?string $time = null;

    public ?\Carbon\Carbon $startDate = null;

    public ?\Carbon\Carbon $endDate = null;

    public array $dates = [];

    public array $disabledDates = [];

    protected BookingManager $manager;

    public static function componentMeta(): array
    {
        return [
            'code' => 'tipowerup-orange-tw::booking',
            'name' => 'Booking',
            'description' => 'Displays a reservation booking form',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'useCalendarView' => [
                'label' => 'Use the calendar view for date selection.',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'hideTimePicker' => [
                'label' => 'Hide the time picker.',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'weekStartOn' => [
                'label' => 'Day of the week to start on. 0 (Sunday) to 6 (Saturday).',
                'type' => 'number',
                'validationRule' => 'required|integer|between:0,6',
            ],
            'minGuestSize' => [
                'label' => 'Minimum number of guests allowed for a reservation',
                'type' => 'number',
                'validationRule' => 'required|integer',
            ],
            'maxGuestSize' => [
                'label' => 'Maximum number of guests allowed for a reservation.',
                'type' => 'number',
                'validationRule' => 'required|integer',
            ],
            'noOfSlots' => [
                'label' => 'Number of time slots to display in the reduced timeslots view',
                'type' => 'number',
                'validationRule' => 'required|integer',
            ],
            'telephoneIsRequired' => [
                'label' => 'Require telephone number for booking.',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'successPage' => [
                'label' => 'Page to redirect to when the booking is successful',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
        ];
    }

    public function render()
    {
        return view('tipowerup-orange-tw::livewire.booking', [
            'customer' => Auth::customer(),
            'locationCurrent' => Location::current(),
        ]);
    }

    public function mount(): void
    {
        Assets::addCss('$/igniter/css/vendor.css', 'vendor-css');

        $this->calendarLocale = strtolower(str_before(str_before(app()->getLocale(), '_'), '-'));
        if ($this->calendarLocale !== 'en' && File::symbolizePath($localPath = '$/igniter-orange/js/locales/flatpickr/'.$this->calendarLocale.'.js')) {
            Assets::addJs($localPath, 'flatpickr-locale-js');
        }

        Assets::addCss('igniter.admin::css/formwidgets/datepicker.css', 'datepicker-css');
        Assets::addJs('igniter-orange::/js/booking.js', 'booking-js');
        Assets::addCss('igniter-orange::/css/booking.css', 'booking-css');

        $this->prepareDates();
        $this->prepareProps();
    }

    public function boot(): void
    {
        $this->manager = resolve(BookingManager::class);
        $this->manager->useLocation(Location::current());
    }

    public function updating($name, $value): void
    {
        if ($name === 'date') {
            unset($this->timeslots);
        }
    }

    public function onSave(): void
    {
        $this->pickerStep = self::STEP_PICKER;

        $this->validate([
            'guest' => ['required', 'integer', 'min:'.$this->minGuestSize, 'max:'.$this->maxGuestSize],
            'date' => ['required', 'date_format:Y-m-d'],
            'time' => ['nullable', 'date_format:H:i'],
        ], [], [
            'guest' => lang('igniter.reservation::default.label_guest_num'),
            'date' => lang('igniter.reservation::default.label_date'),
            'time' => lang('igniter.reservation::default.label_time'),
        ]);

        $this->pickerStep = self::STEP_TIMESLOT;
    }

    public function onSelectTime(string $time): void
    {
        $this->time = $time;

        $this->onSave();

        if ($this->pickerStep === self::STEP_TIMESLOT) {
            $this->pickerStep = self::STEP_BOOKING;
        }
    }

    public function onComplete()
    {
        $customer = Auth::customer();

        try {
            $this->form->withValidator(function ($validator): void {
                $validator->after(function ($validator): void {
                    if ($this->guest && ($this->guest < $this->minGuestSize || $this->guest > $this->maxGuestSize)) {
                        $validator->errors()->add('guest', sprintf('Number of guests must be between %s and %s',
                            $this->minGuestSize, $this->maxGuestSize,
                        ));
                    }

                    if ($this->date) {
                        $date = make_carbon($this->date);
                        if ($date->lt($this->startDate) || $date->gt($this->endDate)) {
                            $validator->errors()->add('date', sprintf('Date must be between %s and %s',
                                $this->startDate->isoFormat(lang('igniter::system.moment.date_format')),
                                $this->endDate->isoFormat(lang('igniter::system.moment.date_format')),
                            ));
                        }
                    }

                    if ($this->time && ! preg_match('/^\d{2}:\d{2}$/', $this->time)) {
                        $validator->errors()->add('time', 'Time must be in HH:MM format.');
                    }
                });
            });

            $this->form->validate();

            $reservation = $this->manager->loadReservation();

            $data = [
                'sdateTime' => make_carbon($this->date.' '.$this->time)->format('Y-m-d H:i'),
                'guest' => $this->guest,
                'first_name' => $this->form->first_name,
                'last_name' => $this->form->last_name,
                'email' => $customer ? $customer->email : $this->form->email,
                'telephone' => $this->form->telephone ?? $customer->telephone ?? '',
                'comment' => $this->form->comment,
            ];

            $lockKey = 'booking-reservation-lock-'.md5($this->date.$this->time);
            resolve(EnsureUniqueProcess::class)->attemptWithLock($lockKey, function () use ($reservation, $data): void {
                $this->manager->saveReservation($reservation, $data);
            });

            $this->reset();

            return $this->redirect(page_url($this->successPage, [
                'hash' => $reservation->hash,
                'location' => Location::current()->permalink_slug,
            ]));
        } catch (ApplicationException $ex) {
            $this->dispatch(
                'booking::alert',
                show: true,
                message: lang('igniter.orange::default.alert_reservation_process_failed'),
                exception: $ex->getMessage(),
            );
        } catch (Throwable $ex) {
            $this->dispatch('booking::alert', show: false);

            throw $ex;
        }

        return null;
    }

    #[Computed]
    public function timeslots(): Collection
    {
        return $this->manager->makeTimeSlots(make_carbon($this->date))
            ->map(fn ($dateTime): Carbon => make_carbon($dateTime));
    }

    /**
     * Get a reduced set of available time slots for display.
     *
     * Limits the number of slots shown to prevent overwhelming the UI.
     * Centers the display around the currently selected time slot.
     * Checks table availability when auto-allocation is enabled.
     *
     * Uses the noOfSlots property to determine the maximum number of slots to show.
     * Defaults to showing all available slots if noOfSlots is not set.
     *
     * @return \Illuminate\Support\Collection<int, object{dateTime: Carbon, fullyBooked: bool, isSelected: bool}>
     */
    #[Computed]
    public function reducedTimeslots()
    {
        $timeslots = $this->timeslots->values();
        $selectedDate = make_carbon($this->date);
        $selectedDateTime = make_carbon($this->date.' '.$this->time);
        $numberOfSlots = $this->noOfSlots ?: $timeslots->count();
        $autoAllocateTable = (bool) Location::current()->getSettings('booking.auto_allocate_table', 1);

        // Find the index of the currently selected time slot
        $selectedIndex = $timeslots->search(fn (Carbon $slot): bool => $slot->isSameAs('Y-m-d H:i', $selectedDateTime));

        // Calculate the starting index for the slice, centered around the selected slot
        $startIndex = max(0, $selectedIndex - (int) ($numberOfSlots / 2) - 1);

        $reducedTimeslots = $timeslots->slice($startIndex, $numberOfSlots);

        $timeslotsBookedStatus = $autoAllocateTable
            ? $this->manager->isTimeslotsFullyBookedOn($reducedTimeslots, $selectedDate, $this->guest)
            : [];

        return $reducedTimeslots->map(fn ($dateTime, $index) => (object) [
            'dateTime' => $dateTime,
            'fullyBooked' => in_array($dateTime->format('Y-m-d H:i'), $timeslotsBookedStatus),
            'isSelected' => $selectedIndex === $index,
        ]);
    }

    #[Computed]
    public function disabledDaysOfWeek(): array
    {
        return [];
    }

    protected function prepareProps(): void
    {
        /** @var LocationAction $location */
        $location = Location::current();

        $this->minGuestSize = $location->getMinReservationGuestCount() ?: $this->minGuestSize;
        $this->maxGuestSize = $location->getMaxReservationGuestCount() ?: $this->maxGuestSize;
        $this->guest ??= $this->minGuestSize;
        $this->date ??= $this->startDate->format('Y-m-d');

        if ($customer = Auth::customer()) {
            $this->form->first_name = $customer->first_name;
            $this->form->last_name = $customer->last_name;
            $this->form->email = $customer->email;
            $this->form->telephone = $customer->telephone;
        }
    }

    protected function prepareDates(): void
    {
        /** @var LocationAction $location */
        $location = Location::current();

        $start = now()->addDays($location->getMinReservationAdvanceTime())->startOfDay();
        $end = now()->addDays($location->getMaxReservationAdvanceTime())->endOfDay();

        $schedule = $this->manager->getSchedule();
        for ($date = $start; $date->lte($end); $date->addDay()) {
            if (count($schedule->forDate($date)) > 0) {
                $this->dates[] = $date->copy();
            } else {
                $this->disabledDates[] = $date->toDateString();
            }
        }

        $this->startDate = $this->dates ? collect($this->dates)->first()?->copy() : $start;
        $this->endDate = $this->dates ? collect($this->dates)->last()?->copy() : $end;
    }
}
