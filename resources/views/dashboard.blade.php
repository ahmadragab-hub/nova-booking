@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<div class="container py-4">

    <h1 class="mb-4">Admin Dashboard</h1>

    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6>Services</h6>
                    <h2>{{ $stats['services'] }}</h2>
                    <small class="text-muted">
                        {{ $stats['active_services'] }} active
                    </small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6>Staff</h6>
                    <h2>{{ $stats['staff'] }}</h2>
                    <small class="text-muted">
                        {{ $stats['active_staff'] }} active
                    </small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6>Customers</h6>
                    <h2>{{ $stats['customers'] }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6>Today's Bookings</h6>
                    <h2>{{ $stats['today_bookings'] }}</h2>
                </div>
            </div>
        </div>

    </div>

    <div class="card">

        <div class="card-header">
            <h5 class="mb-0">Upcoming Bookings</h5>
        </div>

        <div class="card-body p-0">

            @if($upcomingBookings->isEmpty())

                <p class="p-3 mb-0 text-muted">
                    No upcoming bookings.
                </p>

            @else

                <div class="table-responsive">

                    <table class="table table-striped mb-0">

                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Customer</th>
                                <th>Service</th>
                                <th>Staff</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($upcomingBookings as $booking)

                                <tr>
                                    <td>
                                        {{ $booking->booking_date->format('Y-m-d') }}
                                    </td>

                                    <td>
                                        {{ substr($booking->start_time, 0, 5) }}
                                        -
                                        {{ substr($booking->end_time, 0, 5) }}
                                    </td>

                                    <td>{{ $booking->customer->name }}</td>

                                    <td>{{ $booking->service->name }}</td>

                                    <td>{{ $booking->staffProfile->user->name }}</td>
                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection