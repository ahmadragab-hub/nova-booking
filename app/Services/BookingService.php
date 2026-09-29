<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Service;
use App\Models\StaffProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BookingService
{
public function create(array $data): Booking
{
    return DB::transaction(function () use ($data) {

        $service = Service::query()
            ->where('active', true)
            ->findOrFail($data['service_id']);

        $staff = StaffProfile::query()
            ->where('active', true)
            ->findOrFail($data['staff_profile_id']);

        if (! $service->staff()->whereKey($staff->id)->exists()) {
            throw ValidationException::withMessages([
                'staff_profile_id' =>
                    'This staff member cannot provide the selected service.',
            ]);
        }

        $date = Carbon::parse($data['booking_date']);

        if ($staff->daysOff()
            ->whereDate('date', $date->toDateString())
            ->exists()) {
            throw ValidationException::withMessages([
                'booking_date' => 'The selected staff member is off on this date.',
            ]);
        }

        $workingHours = $staff->workingHours()
            ->where('day_of_week', $date->dayOfWeek)
            ->first();

        if (! $workingHours) {
            throw ValidationException::withMessages([
                'booking_date' =>
                    'The selected staff member does not work on this day.',
            ]);
        }

        $start = Carbon::createFromFormat(
            'Y-m-d H:i',
            $date->toDateString() . ' ' . $data['start_time']
        );

        $end = $start->copy()->addMinutes($service->duration_minutes);

        $workStart = Carbon::createFromFormat(
            'Y-m-d H:i',
            $date->toDateString() . ' ' . substr($workingHours->start_time, 0, 5)
        );

        $workEnd = Carbon::createFromFormat(
            'Y-m-d H:i',
            $date->toDateString() . ' ' . substr($workingHours->end_time, 0, 5)
        );

        if ($start->lt($workStart) || $end->gt($workEnd)) {
            throw ValidationException::withMessages([
                'start_time' => 'The selected time is outside working hours.',
            ]);
        }

        $this->ensureAvailable(
            $staff->id,
            $data['booking_date'],
            $data['start_time'],
            $end->format('H:i:s')
        );

        return Booking::create([
            'customer_id' => $data['customer_id'],
            'service_id' => $service->id,
            'staff_profile_id' => $staff->id,
            'booking_date' => $data['booking_date'],
            'start_time' => $data['start_time'],
            'end_time' => $end->format('H:i:s'),
            'status' => 'confirmed',
            'notes' => $data['notes'] ?? null,
        ]);
    });
}

    public function update(
        Booking $booking,
        array $data
    ): Booking {
        return DB::transaction(function () use ($booking, $data) {

            $service = Service::findOrFail(
                $data['service_id']
            );

            $endTime = Carbon::createFromFormat(
                'H:i',
                $data['start_time']
            )->addMinutes(
                $service->duration_minutes
            );

            $this->ensureAvailable(
                $data['staff_profile_id'],
                $data['booking_date'],
                $data['start_time'],
                $endTime->format('H:i:s'),
                $booking
            );

            $booking->update([
                'customer_id' => $data['customer_id'],
                'staff_profile_id' => $data['staff_profile_id'],
                'service_id' => $data['service_id'],
                'booking_date' => $data['booking_date'],
                'start_time' => $data['start_time'],
                'end_time' => $endTime->format('H:i:s'),
                'status' => $data['status'],
                'notes' => $data['notes'] ?? null,
            ]);

            return $booking->refresh();
        });
    }

    public function delete(Booking $booking): void
    {
        $booking->delete();
    }

    private function ensureAvailable(
        int $staffProfileId,
        string $bookingDate,
        string $startTime,
        string $endTime,
        ?Booking $ignoreBooking = null
    ): void {
        $query = Booking::query()
            ->where('staff_profile_id', $staffProfileId)
            ->whereDate('booking_date', $bookingDate)
            ->whereNotIn('status', ['cancelled'])
            ->where('start_time', '<', $endTime)
            ->where('end_time', '>', $startTime);

        if ($ignoreBooking) {
            $query->where('id', '<>', $ignoreBooking->id);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages([
                'start_time' => 'This staff member already has a booking during this time.',
            ]);
        }
    }
}