@extends('layouts.app')

@section('title', 'Add Service')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Add Service</h1>

        <a href="{{ route('services.index') }}" class="btn btn-secondary">
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

    <form method="POST" action="{{ route('services.store') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">
                Service Name
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
            <label for="category" class="form-label">
                Category
            </label>
            <select id="category_id" name="category_id" class="form-select" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('categpry_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">
                Description
            </label>

            <textarea
                id="description"
                name="description"
                class="form-control"
                rows="4"
            >{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="duration_minutes" class="form-label">
                Duration (minutes)
            </label>

            <input
                type="number"
                id="duration_minutes"
                name="duration_minutes"
                class="form-control"
                value="{{ old('duration_minutes') }}"
                min="1"
                max="1440"
                required
            >
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">
                Price (KD)
            </label>

            <input
                type="number"
                id="price"
                name="price"
                class="form-control"
                value="{{ old('price') }}"
                min="0"
                step="0.01"
                required
            >
        </div>

        <div class="form-check mb-4">
            <input
                type="checkbox"
                id="active"
                name="active"
                value="1"
                class="form-check-input"
                @checked(old('active', true))
            >

            <label for="active" class="form-check-label">
                Active
            </label>
        </div>

        <button type="submit" class="btn btn-primary">
            Create Service
        </button>
    </form>

</div>
@endsection