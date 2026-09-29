<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublicAvailabilityRequest;
use App\Http\Requests\StorePublicBookingRequest;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Service;
use App\Models\StaffProfile;
use App\Services\AvailabilityService;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PublicBookingController extends Controller
{
    public function __construct(
        private AvailabilityService $availabilityService,
        private BookingService $bookingService
    ) {}

    public function create(): View
    {
        $services = Service::query()
            ->where('active', true)
            ->with('staff.user')
            ->orderBy('name')
            ->get();

        return view('public.booking', compact('services'));
    }

    public function availability(
        PublicAvailabilityRequest $request
    ): JsonResponse {
        $staff = StaffProfile::query()
            ->where('active', true)
            ->findOrFail($request->integer('staff_profile_id'));

        $service = Service::query()
            ->where('active', true)
            ->findOrFail($request->integer('service_id'));

        $slots = $this->availabilityService->getAvailableSlots(
            $staff,
            $service,
            $request->validated('date')
        );

        return response()->json([
            'slots' => $slots,
        ]);
    }

    public function store(
        StorePublicBookingRequest $request
    ): RedirectResponse {
        $data = $request->validated();

        $customer = Customer::firstOrCreate(
            ['phone' => $data['phone']],
            [
                'name' => $data['name'],
                'email' => $data['email'] ?? null,
            ]
        );

        $booking = $this->bookingService->create([
            'customer_id' => $customer->id,
            'service_id' => $data['service_id'],
            'staff_profile_id' => $data['staff_profile_id'],
            'booking_date' => $data['booking_date'],
            'start_time' => $data['start_time'],
            'notes' => $data['notes'] ?? null,
        ]);

        return redirect()->route(
            'public.booking.confirmation',
            $booking
        );
    }

    public function confirmation(Booking $booking): View
    {
        $booking->load([
            'customer',
            'service',
            'staffProfile.user',
        ]);

        return view(
            'public.booking-confirmation',
            compact('booking')
        );
    }
}