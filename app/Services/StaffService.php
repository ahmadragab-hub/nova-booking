<?php

namespace App\Services;

use App\Models\StaffProfile;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\StaffDayOff;

class StaffService
{
    public function create(array $data): StaffProfile
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => 'staff',
            ]);

            return StaffProfile::create([
                'user_id' => $user->id,
                'phone' => $data['phone'] ?? null,
                'job_title' => $data['job_title'] ?? null,
                'active' => $data['active'] ?? true,
            ]);
        });
    }

    public function update(
        StaffProfile $staff,
        array $data
    ): StaffProfile {
        return DB::transaction(function () use ($staff, $data) {
            $staff->user->update([
                'name' => $data['name'],
                'email' => $data['email'],
            ]);

            $staff->update([
                'phone' => $data['phone'] ?? null,
                'job_title' => $data['job_title'] ?? null,
                'active' => $data['active'] ?? false,
            ]);

            if (! empty($data['password'])) {
                $staff->user->update([
                    'password' => $data['password'],
                ]);
            }

            return $staff->refresh();
        });
    }

    public function delete(StaffProfile $staff): void
    {
        DB::transaction(function () use ($staff) {
            $user = $staff->user;

            $staff->delete();

            $user?->delete();
        });
    }

    public function toggleActive(
        StaffProfile $staff
    ): StaffProfile {
        $staff->update([
            'active' => ! $staff->active,
        ]);

        return $staff->refresh();
    }

    public function updateServices(
        StaffProfile $staff,
        array $serviceIds
    ): StaffProfile {
        $staff->services()->sync($serviceIds);

        return $staff->load('services');
    }

    public function updateWorkingHours(
        StaffProfile $staff,
        array $workingHours
    ): StaffProfile {
        return DB::transaction(function () use ($staff, $workingHours) {
            $staff->workingHours()->delete();

            foreach ($workingHours as $hours) {
                $staff->workingHours()->create([
                    'day_of_week' => $hours['day_of_week'],
                    'start_time' => $hours['start_time'],
                    'end_time' => $hours['end_time'],
                ]);
            }

            return $staff->load('workingHours');
        });
    }

    public function addDayOff(
        StaffProfile $staff,
        array $data
    ): StaffProfile {
        $staff->daysOff()->create([
            'date' => $data['date'],
            'reason' => $data['reason'] ?? null,
        ]);

        return $staff->load('daysOff');
    }

    public function deleteDayOff(
        StaffDayOff $dayOff
    ): void {
        $dayOff->delete();
    }
}