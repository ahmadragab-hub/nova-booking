@extends('layouts.app')

@section('title', 'Availability')

@section('content')

<div class="container py-4">

    <div class="mb-4">

        <h1 class="h3 mb-1">
            Check Availability
        </h1>

        <p class="text-muted mb-0">
            Find available appointment slots.
        </p>

    </div>

    <div class="card mb-4">

        <div class="card-body">

            <form
                method="GET"
                action="{{ route('availability.index') }}"
            >

                <div class="row">

                    <div class="col-md-4 mb-3">

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

                            <option value="">
                                Select staff
                            </option>

                            @foreach ($staff as $member)

                                <option
                                    value="{{ $member->id }}"
                                    @selected(
                                        request('staff_profile_id') == $member->id
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


                    <div class="col-md-4 mb-3">

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

                            <option value="">
                                Select service
                            </option>

                            @foreach ($services as $service)

                                <option
                                    value="{{ $service->id }}"
                                    @selected(
                                        request('service_id') == $service->id
                                    )
                                >
                                    {{ $service->name }}
                                    — {{ $service->duration_minutes }} min
                                </option>

                            @endforeach

                        </select>

                        @error('service_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="col-md-4 mb-3">

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
                            value="{{ request('date') }}"
                            min="{{ now()->format('Y-m-d') }}"
                            required
                        >

                        @error('date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Check Availability
                </button>

            </form>

        </div>

    </div>


    @if (request()->filled([
        'staff_profile_id',
        'service_id',
        'date'
    ]))

        <div class="card">

            <div class="card-header">

                <h5 class="mb-0">
                    Available Slots
                </h5>

            </div>

            <div class="card-body">

                @if (count($slots) > 0)

                    <div class="row">

                        @foreach ($slots as $slot)

                            <div class="col-md-3 mb-3">

                                <div class="border rounded p-3 text-center">

                                    <strong>
                                        {{ $slot['start'] }}
                                    </strong>

                                    <span class="text-muted">
                                        –
                                        {{ $slot['end'] }}
                                    </span>

                                </div>

                            </div>

                        @endforeach

                    </div>

                @else

                    <p class="text-muted mb-0">
                        No available slots for this date.
                    </p>

                @endif

            </div>

        </div>

    @endif

</div>

@endsection