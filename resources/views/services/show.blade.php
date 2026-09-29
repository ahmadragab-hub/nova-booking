@extends('layouts.app')

@section('title', $service->name)

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ $service->name }}</h1>

        <div>
            <a
                href="{{ route('services.edit', $service) }}"
                class="btn btn-warning"
            >
                Edit
            </a>

            <a
                href="{{ route('services.index') }}"
                class="btn btn-secondary"
            >
                Back
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <dl class="row mb-0">

                <dt class="col-sm-3">Name</dt>
                <dd class="col-sm-9">
                    {{ $service->name }}
                </dd>

                <dt class="col-sm-3">Category</dt>
                <dd class="col-sm-9">
                    {{ $service->category->name }}
                </dd>

                <dt class="col-sm-3">Description</dt>
                <dd class="col-sm-9">
                    {{ $service->description ?: 'No description' }}
                </dd>

                <dt class="col-sm-3">Duration</dt>
                <dd class="col-sm-9">
                    {{ $service->duration_minutes }} minutes
                </dd>

                <dt class="col-sm-3">Price</dt>
                <dd class="col-sm-9">
                    {{ number_format((float) $service->price, 2) }} KD
                </dd>

                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9">
                    @if ($service->active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </dd>

            </dl>

        </div>
    </div>

</div>
@endsection