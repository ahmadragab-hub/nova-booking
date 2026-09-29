<?php

namespace App\Http\Controllers;

use App\Http\Requests\AvailabilityRequest;
use App\Models\Service;
use App\Models\StaffProfile;
use App\Services\AvailabilityService;
use Illuminate\View\View;

class AvailabilityController extends Controller
{
    public function __construct(
        private AvailabilityService $availabilityService
    ) {
    }

    public function index(
        AvailabilityRequest $request
    ): View {
        $staff = StaffProfile::query()
            ->where('active', true)
            ->with('user')
            ->orderBy('id')
            ->get();

        $services = Service::query()
            ->where('active', true)
            ->orderBy('name')
            ->get();

        $slots = [];

        if ($request->validated()) {

            $staffMember = StaffProfile::findOrFail(
                $request->integer('staff_profile_id')
            );

            $service = Service::findOrFail(
                $request->integer('service_id')
            );

            $slots = $this->availabilityService
                ->getAvailableSlots(
                    $staffMember,
                    $service,
                    $request->string('date')->toString()
                );
        }

        return view(
            'availability.index',
            compact(
                'staff',
                'services',
                'slots'
            )
        );
    }
}