@extends('layouts.app')

@section('title', 'Manage Staff Services')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">
                Manage Services
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


    <div class="card">

        <div class="card-body">

            <h5 class="card-title">
                Available Services
            </h5>

            <p class="text-muted">
                Select the services this staff member can provide.
            </p>


            <form
                method="POST"
                action="{{ route('staff.services.update', $staff) }}"
            >

                @csrf

                @method('PUT')


                @forelse ($services as $service)

                    <div class="form-check mb-3">

                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="service_ids[]"
                            value="{{ $service->id }}"
                            id="service_{{ $service->id }}"
                            @checked(
                                $staff->services->contains($service->id)
                            )
                        >

                        <label
                            class="form-check-label"
                            for="service_{{ $service->id }}"
                        >

                            <strong>
                                {{ $service->name }}
                            </strong>

                            <span class="text-muted">
                                —
                                {{ $service->duration_minutes }}
                                minutes
                                —
                                {{ number_format($service->price, 2) }}
                            </span>

                        </label>

                    </div>

                @empty

                    <div class="alert alert-warning">
                        No active services are available.
                    </div>

                @endforelse


                @error('service_ids')
                    <div class="text-danger mb-3">
                        {{ $message }}
                    </div>
                @enderror


                @error('service_ids.*')
                    <div class="text-danger mb-3">
                        {{ $message }}
                    </div>
                @enderror


                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Save Services
                </button>

            </form>

        </div>

    </div>

</div>

@endsection