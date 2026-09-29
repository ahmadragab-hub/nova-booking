@extends('layouts.app')

@section('title', 'Booking Details')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">
                Booking Details
            </h1>

            <p class="text-muted mb-0">
                Booking #{{ $booking->id }}
            </p>
        </div>

        <div class="d-flex gap-2">

            <a
                href="{{ route('bookings.index') }}"
                class="btn btn-secondary"
            >
                Back
            </a>

            <a
                href="{{ route('bookings.edit', $booking) }}"
                class="btn btn-warning"
            >
                Edit
            </a>

        </div>

    </div>

    @if (session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    <div class="card">

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <strong>Customer</strong>

                    <div>
                        {{ $booking->customer->name }}
                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>Phone</strong>

                    <div>
                        {{ $booking->customer->phone }}
                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>Service</strong>

                    <div>
                        {{ $booking->service->name }}
                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>Staff</strong>

                    <div>
                        {{ $booking->staffProfile->user->name }}
                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>Date</strong>

                    <div>
                        {{ $booking->booking_date->format('Y-m-d') }}
                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>Time</strong>

                    <div>
                        {{ substr($booking->start_time, 0, 5) }}
                        –
                        {{ substr($booking->end_time, 0, 5) }}
                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>Status</strong>

                    <div>
                        {{ ucfirst($booking->status) }}
                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>Created</strong>

                    <div>
                        {{ $booking->created_at->format('Y-m-d H:i') }}
                    </div>

                </div>

                <div class="col-12">

                    <strong>Notes</strong>

                    <div>
                        {{ $booking->notes ?: '—' }}
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection