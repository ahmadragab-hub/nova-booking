@extends('layouts.app')

@section('title', 'Staff Details')

@section('content')

<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">
                Staff Details
            </h1>

            <p class="text-muted mb-0">
                {{ $staff->user->name }}
            </p>
        </div>

        <div class="d-flex gap-2">

            <a
                href="{{ route('staff.index') }}"
                class="btn btn-secondary"
            >
                Back
            </a>

            <a
                href="{{ route('staff.edit', $staff) }}"
                class="btn btn-warning"
            >
                Edit
            </a>

            <a
                href="{{ route('staff.services.edit', $staff) }}"
                class="btn btn-primary"
            >
                Manage Services
            </a>
            
            <a
                href="{{ route('staff.schedule.edit', $staff) }}"
                class="btn btn-success"
            >
                Schedule
            </a>
        </div>

    </div>


    {{-- Success Message --}}
    @if (session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    {{-- Staff Information --}}
    <div class="card mb-4">

        <div class="card-header">
            Staff Information
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <strong>Name</strong>

                    <div>
                        {{ $staff->user->name }}
                    </div>

                </div>


                <div class="col-md-6 mb-3">

                    <strong>Email</strong>

                    <div>
                        {{ $staff->user->email }}
                    </div>

                </div>


                <div class="col-md-6 mb-3">

                    <strong>Phone</strong>

                    <div>
                        {{ $staff->phone ?: '—' }}
                    </div>

                </div>


                <div class="col-md-6 mb-3">

                    <strong>Job Title</strong>

                    <div>
                        {{ $staff->job_title ?: '—' }}
                    </div>

                </div>


                <div class="col-md-6 mb-3">

                    <strong>Status</strong>

                    <div>

                        @if ($staff->active)

                            <span class="badge bg-success">
                                Active
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                Inactive
                            </span>

                        @endif

                    </div>

                </div>


                <div class="col-md-6 mb-3">

                    <strong>Created</strong>

                    <div>
                        {{ $staff->created_at->format('Y-m-d H:i') }}
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Assigned Services --}}
    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <span>
                Assigned Services
            </span>

            <a
                href="{{ route('staff.services.edit', $staff) }}"
                class="btn btn-sm btn-primary"
            >
                Manage Services
            </a>

        </div>


        <div class="card-body">

            @forelse ($staff->services as $service)

                <div class="border rounded p-3 mb-3">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h6 class="mb-1">
                                {{ $service->name }}
                            </h6>

                            @if ($service->description)

                                <p class="text-muted mb-1">
                                    {{ $service->description }}
                                </p>

                            @endif

                        </div>


                        <div class="text-end">

                            <div>
                                {{ $service->duration_minutes }} minutes
                            </div>

                            <div>
                                {{ number_format($service->price, 2) }}
                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <p class="text-muted mb-0">
                    No services assigned.
                </p>

            @endforelse

        </div>

    </div>

</div>

@endsection