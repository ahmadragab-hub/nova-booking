<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Service;
use App\Models\StaffProfile;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Validation\ValidationException;

class AvailabilityService
{
    public function getAvailableSlots(
        StaffProfile $staff,
        Service $service,
        string $date
    ): array {
        $dateObject = Carbon::parse($date);

        if ($dateObject->isPast() && ! $dateObject->isToday()) {
            return [];
        }

        // Staff must be active.
        if (! $staff->active) {
            return [];
        }

        // Staff must be assigned to the service.
        if (! $service->staff()
            ->whereKey($staff->id)
            ->exists()) {
            return [];
        }

        // Check whether this date is a staff day off.
        $isDayOff = $staff->daysOff()
            ->whereDate('date', $dateObject->toDateString())
            ->exists();

        if ($isDayOff) {
            return [];
        }

        // Find working hours for this day.
        $dayOfWeek = $dateObject->dayOfWeek;

        $workingHours = $staff->workingHours()
            ->where('day_of_week', $dayOfWeek)
            ->first();

        if (! $workingHours) {
            return [];
        }

        $workStart = Carbon::createFromFormat(
            'Y-m-d H:i',
            $dateObject->toDateString() . ' ' . substr(
                $workingHours->start_time,
                0,
                5
            )
        );

        $workEnd = Carbon::createFromFormat(
            'Y-m-d H:i',
            $dateObject->toDateString() . ' ' . substr(
                $workingHours->end_time,
                0,
                5
            )
        );

        // Get bookings that can block the schedule.
        $bookings = Booking::query()
            ->where('staff_profile_id', $staff->id)
            ->whereDate(
                'booking_date',
                $dateObject->toDateString()
            )
            ->whereNotIn('status', ['cancelled'])
            ->orderBy('start_time')
            ->get();

        $slots = [];

        $slotStart = $workStart->copy();
        $duration = $service->duration_minutes;

        while (
            $slotStart->copy()->addMinutes($duration)
                ->lte($workEnd)
        ) {
            $slotEnd = $slotStart
                ->copy()
                ->addMinutes($duration);

            if (
                $this->slotIsAvailable(
                    $slotStart,
                    $slotEnd,
                    $bookings
                )
            ) {
                $slots[] = [
                    'start' => $slotStart->format('H:i'),
                    'end' => $slotEnd->format('H:i'),
                ];
            }

            $slotStart->addMinutes($duration);
        }

        // For today, don't offer slots that have already started.
        if ($dateObject->isToday()) {
            $now = Carbon::now();

            $slots = array_values(
                array_filter(
                    $slots,
                    fn (array $slot) =>
                        Carbon::createFromFormat(
                            'Y-m-d H:i',
                            $dateObject->toDateString()
                                . ' '
                                . $slot['start']
                        )->isAfter($now)
                )
            );
        }

        return $slots;
    }

    private function slotIsAvailable(
        Carbon $slotStart,
        Carbon $slotEnd,
        $bookings
    ): bool {
        foreach ($bookings as $booking) {

            $bookingStart = Carbon::createFromFormat(
                'Y-m-d H:i',
                $slotStart->toDateString()
                    . ' '
                    . substr($booking->start_time, 0, 5)
            );

            $bookingEnd = Carbon::createFromFormat(
                'Y-m-d H:i',
                $slotStart->toDateString()
                    . ' '
                    . substr($booking->end_time, 0, 5)
            );

            if (
                $bookingStart->lt($slotEnd) &&
                $bookingEnd->gt($slotStart)
            ) {
                return false;
            }
        }

        return true;
    }
}