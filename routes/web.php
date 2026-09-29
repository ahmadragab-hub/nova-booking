<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicBookingController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\StaffScheduleController;
use App\Http\Controllers\StaffServiceController;


/*
|--------------------------------------------------------------------------
| Public Booking
|--------------------------------------------------------------------------
*/

Route::get('/', [PublicBookingController::class, 'create'])
    ->name('public.booking');

Route::get('/booking/availability', [PublicBookingController::class, 'availability'])
    ->name('public.booking.availability');

Route::post('/booking', [PublicBookingController::class, 'store'])
    ->name('public.booking.store');

Route::get('/booking/confirmation/{booking}', [PublicBookingController::class, 'confirmation'])
    ->name('public.booking.confirmation');


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'create'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'store'])
        ->name('login.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| Staff
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:staff'])->group(function () {

    Route::get('/staff-dashboard', [StaffDashboardController::class, 'index'])
        ->name('staff.dashboard');
});


/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Categories
    Route::resource('categories', CategoryController::class);

    // Services
    Route::resource('services', ServiceController::class);

    Route::patch(
        'services/{service}/toggle-active',
        [ServiceController::class, 'toggleActive']
    )->name('services.toggle-active');

    // Staff
    Route::resource('staff', StaffController::class);

    Route::patch(
        'staff/{staff}/toggle-active',
        [StaffController::class, 'toggleActive']
    )->name('staff.toggle-active');

    // Staff Services
    Route::get(
        'staff/{staff}/services/edit',
        [StaffServiceController::class, 'edit']
    )->name('staff.services.edit');

    Route::put(
        'staff/{staff}/services',
        [StaffServiceController::class, 'update']
    )->name('staff.services.update');

    // Staff Schedule
    Route::get(
        'staff/{staff}/schedule',
        [StaffScheduleController::class, 'edit']
    )->name('staff.schedule.edit');

    Route::put(
        'staff/{staff}/schedule/working-hours',
        [StaffScheduleController::class, 'updateWorkingHours']
    )->name('staff.schedule.working-hours.update');

    Route::post(
        'staff/{staff}/schedule/days-off',
        [StaffScheduleController::class, 'storeDayOff']
    )->name('staff.schedule.days-off.store');

    Route::delete(
        'staff/{staff}/schedule/days-off/{dayOff}',
        [StaffScheduleController::class, 'destroyDayOff']
    )->name('staff.schedule.days-off.destroy');

    // Customers
    Route::resource('customers', CustomerController::class);

    // Bookings
    Route::resource('bookings', BookingController::class);

    // Availability
    Route::get(
        'availability',
        [AvailabilityController::class, 'index']
    )->name('availability.index');
});