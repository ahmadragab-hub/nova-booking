<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Service;
use App\Models\StaffProfile;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'services' => Service::count(),
            'active_services' => Service::where('active', true)->count(),
            'staff' => StaffProfile::count(),
            'active_staff' => StaffProfile::where('active', true)->count(),
            'customers' => Customer::count(),
            'today_bookings' => Booking::whereDate('booking_date', today())->count(),
        ];

        $upcomingBookings = Booking::query()
            ->with(['customer', 'service', 'staffProfile.user'])
            ->whereDate('booking_date', '>=', today())
            ->where('status', 'confirmed')
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->limit(10)
            ->get();

        return view('dashboard', compact('stats', 'upcomingBookings'));
    }
}