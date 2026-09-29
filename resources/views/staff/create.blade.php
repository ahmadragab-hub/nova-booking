@extends('layouts.app')

@section('title', 'Add Staff')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Add Staff</h1>

        <a
            href="{{ route('staff.index') }}"
            class="btn btn-secondary"
        >
            Back
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('staff.store') }}"
    >
        @csrf

        <div class="mb-3">
            <label
                for="name"
                class="form-label"
            >
                Name
            </label>

            <input
                type="text"
                id="name"
                name="name"
                class="form-control"
                value="{{ old('name') }}"
                required
            >
        </div>

        <div class="mb-3">
            <label
                for="email"
                class="form-label"
            >
                Email
            </label>

            <input
                type="email"
                id="email"
                name="email"
                class="form-control"
                value="{{ old('email') }}"
                required
            >
        </div>

        <div class="mb-3">
            <label
                for="password"
                class="form-label"
            >
                Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
                class="form-control"
                required
            >
        </div>

        <div class="mb-3">
            <label
                for="password_confirmation"
                class="form-label"
            >
                Confirm Password
            </label>

            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                class="form-control"
                required
            >
        </div>

        <div class="mb-3">
            <label
                for="phone"
                class="form-label"
            >
                Phone
            </label>

            <input
                type="text"
                id="phone"
                name="phone"
                class="form-control"
                value="{{ old('phone') }}"
            >
        </div>

        <div class="mb-3">
            <label
                for="job_title"
                class="form-label"
            >
                Job Title
            </label>

            <input
                type="text"
                id="job_title"
                name="job_title"
                class="form-control"
                value="{{ old('job_title') }}"
            >
        </div>

        <div class="form-check mb-4">

            <input
                type="checkbox"
                id="active"
                name="active"
                value="1"
                class="form-check-input"
                {{ old('active', true) ? 'checked' : '' }}
            >

            <label
                for="active"
                class="form-check-label"
            >
                Active
            </label>

        </div>

        <button
            type="submit"
            class="btn btn-primary"
        >
            Create Staff
        </button>

    </form>

</div>
@endsection