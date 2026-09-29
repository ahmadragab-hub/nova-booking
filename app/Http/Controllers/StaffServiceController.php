<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateStaffServicesRequest;
use App\Models\Service;
use App\Models\StaffProfile;
use App\Services\StaffService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StaffServiceController extends Controller
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
            'services',
        ]);

        $services = Service::query()
            ->where('active', true)
            ->orderBy('name')
            ->get();

        return view(
            'staff.services',
            compact('staff', 'services')
        );
    }

    public function update(
        UpdateStaffServicesRequest $request,
        StaffProfile $staff
    ): RedirectResponse {
        $this->staffService->updateServices(
            $staff,
            $request->validated()['service_ids'] ?? []
        );

        return redirect()
            ->route('staff.show', $staff)
            ->with(
                'success',
                'Staff services updated successfully.'
            );
    }
}