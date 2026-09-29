@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Services</h1>

        <a href="{{ route('services.create') }}" class="btn btn-primary">
            Add Service
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($services->isEmpty())
        <div class="alert alert-info">
            No services found.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Duration</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($services as $service)
                        <tr>
                            <td>{{ $service->name }}</td>
                            <td>{{ $service->category->name }}</td>
                            <td>
                                {{ $service->duration_minutes }} minutes
                            </td>

                            <td>
                                {{ number_format((float) $service->price, 2) }} KD
                            </td>

                            <td>
                                @if ($service->active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>

                            <td>
                                <a
                                    href="{{ route('services.show', $service) }}"
                                    class="btn btn-sm btn-info"
                                >
                                    View
                                </a>

                                <a
                                    href="{{ route('services.edit', $service) }}"
                                    class="btn btn-sm btn-warning"
                                >
                                    Edit
                                </a>

                                <form action="{{ route('services.destroy', $service) }}" method="POST" 
                                onsubmit="return confirm('Are you sure you want to delete this service?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $services->links() }}
    @endif

</div>
@endsection