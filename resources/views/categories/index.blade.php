@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">categories</h1>

        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            Add category
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($categories->isEmpty())
        <div class="alert alert-info">
            No categories found.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>

                            <td>
                                {{ $category->description }}
                            </td>
                            <td>
                                <a
                                    href="{{ route('categories.show', $category) }}"
                                    class="btn btn-sm btn-info"
                                >
                                    View
                                </a>

                                <a
                                    href="{{ route('categories.edit', $category) }}"
                                    class="btn btn-sm btn-warning"
                                >
                                    Edit
                                </a>
                                
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');" class="d-inline">
                                    @csrf
                                    @method('DELETE') <!-- Overrides POST to match the DELETE method in your route list -->
                                    
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

        {{ $categories->links() }}
    @endif

</div>
@endsection