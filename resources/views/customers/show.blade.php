@extends('layouts.app')

@section('title', 'Customer Details')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">
                Customer Details
            </h1>

            <p class="text-muted mb-0">
                {{ $customer->name }}
            </p>
        </div>

        <div class="d-flex gap-2">

            <a
                href="{{ route('customers.index') }}"
                class="btn btn-secondary"
            >
                Back
            </a>

            <a
                href="{{ route('customers.edit', $customer) }}"
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

    <div class="card mb-4">

        <div class="card-header">
            Customer Information
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">

                    <strong>Name</strong>

                    <div>
                        {{ $customer->name }}
                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <strong>Email</strong>

                    <div>
                        {{ $customer->email ?: '—' }}
                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <strong>Phone</strong>

                    <div>
                        {{ $customer->phone }}
                    </div>

                </div>

            </div>

        </div>

    </div>


    <div class="card">

        <div class="card-header">
            Booking History
        </div>

        <div class="card-body p-0">

            @forelse ($customer->bookings as $booking)

                <div class="border-bottom p-3">

                    <div class="row align-items-center">

                        <div class="col-md-3">

                            <strong>
                                {{ $booking->booking_date->format('Y-m-d') }}
                            </strong>

                            <div class="text-muted">
                                {{ $booking->start_time }}
                                –
                                {{ $booking->end_time }}
                            </div>

                        </div>

                        <div class="col-md-3">

                            {{ $booking->service->name }}

                        </div>

                        <div class="col-md-3">

                            {{ $booking->staffProfile->user->name }}

                        </div>

                        <div class="col-md-3 text-md-end">

                            <span class="badge bg-secondary">
                                {{ ucfirst($booking->status) }}
                            </span>

                        </div>

                    </div>

                </div>

            @empty

                <p class="text-muted p-3 mb-0">
                    No bookings yet.
                </p>

            @endforelse

        </div>

    </div>

</div>

@endsection