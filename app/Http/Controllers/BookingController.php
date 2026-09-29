<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Service;
use App\Models\StaffProfile;
use App\Services\BookingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function __construct(
        private BookingService $bookingService
    ) {
    }

    public function index(): View
    {
        $bookings = Booking::query()
            ->with([
                'customer',
                'service',
                'staffProfile.user',
            ])
            ->latest('booking_date')
            ->latest('start_time')
            ->paginate(10);

        return view(
            'bookings.index',
            compact('bookings')
        );
    }

    public function create(): View
    {
        $customers = Customer::query()
            ->orderBy('name')
            ->get();

        $services = Service::query()
            ->where('active', true)
            ->with('staff.user')
            ->orderBy('name')
            ->get();

        $staff = StaffProfile::query()
            ->where('active', true)
            ->with('user')
            ->orderBy('id')
            ->get();

        return view(
            'bookings.create',
            compact(
                'customers',
                'services',
                'staff'
            )
        );
    }

    public function store(
        StoreBookingRequest $request
    ): RedirectResponse {
        $booking = $this->bookingService->create(
            $request->validated()
        );

        return redirect()
            ->route('bookings.show', $booking)
            ->with(
                'success',
                'Booking created successfully.'
            );
    }

    public function show(
        Booking $booking
    ): View {
        $booking->load([
            'customer',
            'service',
            'staffProfile.user',
        ]);

        return view(
            'bookings.show',
            compact('booking')
        );
    }

    public function edit(
        Booking $booking
    ): View {
        $booking->load([
            'customer',
            'service',
            'staffProfile',
        ]);

        $customers = Customer::query()
            ->orderBy('name')
            ->get();

        $services = Service::query()
            ->with('staff.user')
            ->orderBy('name')
            ->get();

        $staff = StaffProfile::query()
            ->with('user')
            ->orderBy('id')
            ->get();

        return view(
            'bookings.edit',
            compact(
                'booking',
                'customers',
                'services',
                'staff'
            )
        );
    }

    public function update(
        UpdateBookingRequest $request,
        Booking $booking
    ): RedirectResponse {
        $this->bookingService->update(
            $booking,
            $request->validated()
        );

        return redirect()
            ->route('bookings.show', $booking)
            ->with(
                'success',
                'Booking updated successfully.'
            );
    }

    public function destroy(
        Booking $booking
    ): RedirectResponse {
        $this->bookingService->delete($booking);

        return redirect()
            ->route('bookings.index')
            ->with(
                'success',
                'Booking deleted successfully.'
            );
    }
}