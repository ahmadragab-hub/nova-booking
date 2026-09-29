@extends('layouts.app')

@section('title', 'Staff Schedule')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">
                Staff Schedule
            </h1>

            <p class="text-muted mb-0">
                {{ $staff->user->name }}
            </p>
        </div>

        <a
            href="{{ route('staff.show', $staff) }}"
            class="btn btn-secondary"
        >
            Back
        </a>

    </div>

    @if (session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    {{-- Working Hours --}}
    <div class="card mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Working Hours
            </h5>
        </div>

        <div class="card-body">

            <form
                method="POST"
                action="{{ route('staff.schedule.working-hours.update', $staff) }}"
            >

                @csrf
                @method('PUT')

                @php
                    $days = [
                        0 => 'Sunday',
                        1 => 'Monday',
                        2 => 'Tuesday',
                        3 => 'Wednesday',
                        4 => 'Thursday',
                        5 => 'Friday',
                        6 => 'Saturday',
                    ];
                @endphp

                @foreach ($days as $dayNumber => $dayName)

                    @php
                        $hours = $workingHours->get($dayNumber);
                    @endphp

                    <div class="row align-items-center mb-3">

                        <div class="col-md-3">

                            <strong>
                                {{ $dayName }}
                            </strong>

                        </div>

                        <input
                            type="hidden"
                            name="working_hours[{{ $dayNumber }}][day_of_week]"
                            value="{{ $dayNumber }}"
                        >

                        <div class="col-md-4">

                            <label
                                for="start_{{ $dayNumber }}"
                                class="form-label"
                            >
                                Start
                            </label>

                            <input
                                type="time"
                                class="form-control @error("working_hours.$dayNumber.start_time") is-invalid @enderror"
                                id="start_{{ $dayNumber }}"
                                name="working_hours[{{ $dayNumber }}][start_time]"
                                value="{{ old(
                                    "working_hours.$dayNumber.start_time",
                                    $hours?->start_time
                                ) }}"
                            >

                            @error("working_hours.$dayNumber.start_time")
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="col-md-4">

                            <label
                                for="end_{{ $dayNumber }}"
                                class="form-label"
                            >
                                End
                            </label>

                            <input
                                type="time"
                                class="form-control @error("working_hours.$dayNumber.end_time") is-invalid @enderror"
                                id="end_{{ $dayNumber }}"
                                name="working_hours[{{ $dayNumber }}][end_time]"
                                value="{{ old(
                                    "working_hours.$dayNumber.end_time",
                                    $hours?->end_time
                                ) }}"
                            >

                            @error("working_hours.$dayNumber.end_time")
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                @endforeach

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Save Working Hours
                </button>

            </form>

        </div>

    </div>


    {{-- Days Off --}}
    <div class="card">

        <div class="card-header">
            <h5 class="mb-0">
                Days Off
            </h5>
        </div>

        <div class="card-body">

            <form
                method="POST"
                action="{{ route('staff.schedule.days-off.store', $staff) }}"
                class="row g-3 mb-4"
            >

                @csrf

                <div class="col-md-4">

                    <label
                        for="date"
                        class="form-label"
                    >
                        Date
                    </label>

                    <input
                        type="date"
                        name="date"
                        id="date"
                        class="form-control @error('date') is-invalid @enderror"
                        value="{{ old('date') }}"
                    >

                    @error('date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="col-md-5">

                    <label
                        for="reason"
                        class="form-label"
                    >
                        Reason
                    </label>

                    <input
                        type="text"
                        name="reason"
                        id="reason"
                        class="form-control @error('reason') is-invalid @enderror"
                        value="{{ old('reason') }}"
                        maxlength="255"
                        placeholder="Optional"
                    >

                    @error('reason')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="col-md-3 d-flex align-items-end">

                    <button
                        type="submit"
                        class="btn btn-primary w-100"
                    >
                        Add Day Off
                    </button>

                </div>

            </form>


            <h6>
                Scheduled Days Off
            </h6>

            @forelse ($staff->daysOff->sortBy('date') as $dayOff)

                <div
                    class="border rounded p-3 mb-2 d-flex justify-content-between align-items-center"
                >

                    <div>

                        <strong>
                            {{ $dayOff->date->format('Y-m-d') }}
                        </strong>

                        @if ($dayOff->reason)

                            <span class="text-muted">
                                — {{ $dayOff->reason }}
                            </span>

                        @endif

                    </div>

                    <form
                        method="POST"
                        action="{{ route(
                            'staff.schedule.days-off.destroy',
                            [$staff, $dayOff]
                        ) }}"
                    >

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-sm btn-outline-danger"
                        >
                            Remove
                        </button>

                    </form>

                </div>

            @empty

                <p class="text-muted mb-0">
                    No days off scheduled.
                </p>

            @endforelse

        </div>

    </div>

</div>

@endsection