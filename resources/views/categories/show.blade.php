@extends('layouts.app')
@section('title', $category->name)
@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ $category->name }}</h1>

        <div>
            <a
                href="{{ route('categories.edit', $category) }}"
                class="btn btn-warning"
            >
                Edit
            </a>

            <a
                href="{{ route('categories.index') }}"
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
                    {{ $category->name }}
                </dd>

                <dt class="col-sm-3">Description</dt>
                <dd class="col-sm-9">
                    {{ $category->description ?: 'No description' }}
                </dd>

            </dl>

        </div>
    </div>

</div>
@endsection
