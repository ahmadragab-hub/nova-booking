@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h1 class="mb-3">Staff Dashboard</h1>

    <div class="card">
        <div class="card-body">
            <h5>Welcome, {{ auth()->user()->name }}</h5>

            <p class="mb-1">
                Job title: {{ $staff->job_title ?? 'Not specified' }}
            </p>

            <p class="mb-0">
                Status: {{ $staff->active ? 'Active' : 'Inactive' }}
            </p>
        </div>
    </div>

</div>
@endsection