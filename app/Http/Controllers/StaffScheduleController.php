<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStaffDayOffRequest;
use App\Http\Requests\UpdateWorkingHoursRequest;
use App\Models\StaffDayOff;
use App\Models\StaffProfile;
use App\Services\StaffService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StaffScheduleController extends Controller
{
    public function __construct(
        private StaffService $staffService
    ) {
    }

    public function edit(
        StaffProfile $staff
    ): View {
        $staff->load([
            'user',
            'workingHours',
            'daysOff',
        ]);

        $workingHours = $staff->workingHours
            ->keyBy('day_of_week');

        return view(
            'staff.schedule',
            compact('staff', 'workingHours')
        );
    }

    public function updateWorkingHours(
        UpdateWorkingHoursRequest $request,
        StaffProfile $staff
    ): RedirectResponse {
        $this->staffService->updateWorkingHours(
            $staff,
            $request->validated()['working_hours']
        );

        return redirect()
            ->route('staff.schedule.edit', $staff)
            ->with(
                'success',
                'Working hours updated successfully.'
            );
    }

    public function storeDayOff(
        StoreStaffDayOffRequest $request,
        StaffProfile $staff
    ): RedirectResponse {
        $this->staffService->addDayOff(
            $staff,
            $request->validated()
        );

        return redirect()
            ->route('staff.schedule.edit', $staff)
            ->with(
                'success',
                'Day off added successfully.'
            );
    }

    public function destroyDayOff(
        StaffProfile $staff,
        StaffDayOff $dayOff
    ): RedirectResponse
    {
        abort_unless(
            $dayOff->staff_profile_id === $staff->id,
            404
        );

        $this->staffService->deleteDayOff($dayOff);

        return redirect()
            ->route('staff.schedule.edit', $staff)
            ->with('success', 'Day off removed successfully.');
    }
}