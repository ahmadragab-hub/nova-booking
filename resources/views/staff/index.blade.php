@extends('layouts.app')

@section('title', 'Staff')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Staff</h1>

        <a
            href="{{ route('staff.create') }}"
            class="btn btn-primary"
        >
            Add Staff
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($staff->isEmpty())
        <div class="alert alert-info">
            No staff members found.
        </div>
    @else

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">

                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Job Title</th>
                        <th>Status</th>
                        <th width="320">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($staff as $member)

                        <tr>
                            <td>
                                {{ $member->user->name }}
                            </td>

                            <td>
                                {{ $member->user->email }}
                            </td>

                            <td>
                                {{ $member->phone ?: '-' }}
                            </td>

                            <td>
                                {{ $member->job_title ?: '-' }}
                            </td>

                            <td>
                                @if ($member->active)
                                    <span class="badge bg-success">
                                        Active
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <td>

                                <a
                                    href="{{ route('staff.show', $member) }}"
                                    class="btn btn-sm btn-info"
                                >
                                    View
                                </a>

                                <a
                                    href="{{ route('staff.edit', $member) }}"
                                    class="btn btn-sm btn-warning"
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('staff.toggle-active', $member) }}"
                                    class="d-inline"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-secondary"
                                    >
                                        {{ $member->active
                                            ? 'Deactivate'
                                            : 'Activate' }}
                                    </button>
                                </form>

                                <form
                                    method="POST"
                                    action="{{ route('staff.destroy', $member) }}"
                                    class="d-inline"
                                    onsubmit="return confirm('Delete this staff member?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-danger"
                                    >
                                        Delete
                                    </button>
                                </form>

                            </td>
                        </tr>

                    @endforeach
                </tbody>

            </table>
        </div>

        {{ $staff->links() }}

    @endif

</div>
@endsection