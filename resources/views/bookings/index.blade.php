@extends('layouts.app')

@section('title', 'Bookings')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">
                Bookings
            </h1>

            <p class="text-muted mb-0">
                Manage appointments.
            </p>
        </div>

        <a
            href="{{ route('bookings.create') }}"
            class="btn btn-primary"
        >
            Add Booking
        </a>

    </div>

    @if (session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    <div class="card">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead>

                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Customer</th>
                            <th>Service</th>
                            <th>Staff</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($bookings as $booking)

                            <tr>

                                <td>
                                    {{ $booking->booking_date->format('Y-m-d') }}
                                </td>

                                <td>
                                    {{ substr($booking->start_time, 0, 5) }}
                                    –
                                    {{ substr($booking->end_time, 0, 5) }}
                                </td>

                                <td>
                                    {{ $booking->customer->name }}
                                </td>

                                <td>
                                    {{ $booking->service->name }}
                                </td>

                                <td>
                                    {{ $booking->staffProfile->user->name }}
                                </td>

                                <td>

                                    @php
                                        $statusClass = match ($booking->status) {
                                            'confirmed' => 'bg-success',
                                            'cancelled' => 'bg-danger',
                                            'completed' => 'bg-primary',
                                            default => 'bg-secondary',
                                        };
                                    @endphp

                                    <span class="badge {{ $statusClass }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>

                                </td>

                                <td class="text-end">

                                    <a
                                        href="{{ route(
                                            'bookings.show',
                                            $booking
                                        ) }}"
                                        class="btn btn-sm btn-info"
                                    >
                                        View
                                    </a>

                                    <a
                                        href="{{ route(
                                            'bookings.edit',
                                            $booking
                                        ) }}"
                                        class="btn btn-sm btn-warning"
                                    >
                                        Edit
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center text-muted py-4"
                                >
                                    No bookings found.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <div class="mt-3">
        {{ $bookings->links() }}
    </div>

</div>

@endsection