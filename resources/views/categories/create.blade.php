@extends('layouts.app')

@section('title', 'Add category')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Add category</h1>

        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
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

    <form method="POST" action="{{ route('categories.store') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">
                category Name
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

        <button type="submit" class="btn btn-primary">
            Create category
        </button>
    </form>

</div>
@endsection