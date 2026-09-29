@extends('layouts.app')

@section('title', 'Edit Booking')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="h3 mb-0">
            Edit Booking #{{ $booking->id }}
        </h1>

        <a
            href="{{ route('bookings.show', $booking) }}"
            class="btn btn-secondary"
        >
            Back
        </a>

    </div>

    <div class="card">

        <div class="card-body">

            <form
                method="POST"
                action="{{ route('bookings.update', $booking) }}"
            >

                @csrf
                @method('PUT')


                <div class="mb-3">

                    <label
                        for="customer_id"
                        class="form-label"
                    >
                        Customer
                    </label>

                    <select
                        name="customer_id"
                        id="customer_id"
                        class="form-select @error('customer_id') is-invalid @enderror"
                        required
                    >

                        @foreach ($customers as $customer)

                            <option
                                value="{{ $customer->id }}"
                                @selected(
                                    old(
                                        'customer_id',
                                        $booking->customer_id
                                    ) == $customer->id
                                )
                            >
                                {{ $customer->name }}
                                — {{ $customer->phone }}
                            </option>

                        @endforeach

                    </select>

                    @error('customer_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="mb-3">

                    <label
                        for="service_id"
                        class="form-label"
                    >
                        Service
                    </label>

                    <select
                        name="service_id"
                        id="service_id"
                        class="form-select @error('service_id') is-invalid @enderror"
                        required
                    >

                        @foreach ($services as $service)

                            <option
                                value="{{ $service->id }}"
                                @selected(
                                    old(
                                        'service_id',
                                        $booking->service_id
                                    ) == $service->id
                                )
                            >
                                {{ $service->name }}
                                — {{ $service->duration_minutes }} minutes
                            </option>

                        @endforeach

                    </select>

                    @error('service_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="mb-3">

                    <label
                        for="staff_profile_id"
                        class="form-label"
                    >
                        Staff
                    </label>

                    <select
                        name="staff_profile_id"
                        id="staff_profile_id"
                        class="form-select @error('staff_profile_id') is-invalid @enderror"
                        required
                    >

                        @foreach ($staff as $member)

                            <option
                                value="{{ $member->id }}"
                                @selected(
                                    old(
                                        'staff_profile_id',
                                        $booking->staff_profile_id
                                    ) == $member->id
                                )
                            >
                                {{ $member->user->name }}
                            </option>

                        @endforeach

                    </select>

                    @error('staff_profile_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label
                            for="booking_date"
                            class="form-label"
                        >
                            Date
                        </label>

                        <input
                            type="date"
                            name="booking_date"
                            id="booking_date"
                            class="form-control @error('booking_date') is-invalid @enderror"
                            value="{{ old(
                                'booking_date',
                                $booking->booking_date->format('Y-m-d')
                            ) }}"
                            min="{{ now()->format('Y-m-d') }}"
                            required
                        >

                        @error('booking_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="col-md-6 mb-3">

                        <label
                            for="start_time"
                            class="form-label"
                        >
                            Start Time
                        </label>

                        <input
                            type="time"
                            name="start_time"
                            id="start_time"
                            class="form-control @error('start_time') is-invalid @enderror"
                            value="{{ old(
                                'start_time',
                                substr($booking->start_time, 0, 5)
                            ) }}"
                            required
                        >

                        @error('start_time')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>


                <div class="mb-3">

                    <label
                        for="status"
                        class="form-label"
                    >
                        Status
                    </label>

                    <select
                        name="status"
                        id="status"
                        class="form-select @error('status') is-invalid @enderror"
                        required
                    >

                        @foreach ([
                            'confirmed' => 'Confirmed',
                            'cancelled' => 'Cancelled',
                            'completed' => 'Completed',
                        ] as $value => $label)

                            <option
                                value="{{ $value }}"
                                @selected(
                                    old(
                                        'status',
                                        $booking->status
                                    ) === $value
                                )
                            >
                                {{ $label }}
                            </option>

                        @endforeach

                    </select>

                    @error('status')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="mb-3">

                    <label
                        for="notes"
                        class="form-label"
                    >
                        Notes
                    </label>

                    <textarea
                        name="notes"
                        id="notes"
                        rows="4"
                        maxlength="2000"
                        class="form-control @error('notes') is-invalid @enderror"
                    >{{ old('notes', $booking->notes) }}</textarea>

                    @error('notes')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Save Changes
                </button>

            </form>

        </div>

    </div>

</div>

@endsection