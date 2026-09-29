@extends('layouts.app')

@section('title', 'Customers')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">
                Customers
            </h1>

            <p class="text-muted mb-0">
                Manage NOVA customers.
            </p>
        </div>

        <a
            href="{{ route('customers.create') }}"
            class="btn btn-primary"
        >
            Add Customer
        </a>

    </div>

    @if (session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    <div class="card">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead>

                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Created</th>
                            <th class="text-end">Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($customers as $customer)

                            <tr>

                                <td>
                                    {{ $customer->name }}
                                </td>

                                <td>
                                    {{ $customer->email ?: '—' }}
                                </td>

                                <td>
                                    {{ $customer->phone }}
                                </td>

                                <td>
                                    {{ $customer->created_at->format('Y-m-d') }}
                                </td>

                                <td class="text-end">

                                    <a
                                        href="{{ route(
                                            'customers.show',
                                            $customer
                                        ) }}"
                                        class="btn btn-sm btn-info"
                                    >
                                        View
                                    </a>

                                    <a
                                        href="{{ route(
                                            'customers.edit',
                                            $customer
                                        ) }}"
                                        class="btn btn-sm btn-warning"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'customers.destroy',
                                            $customer
                                        ) }}"
                                        class="d-inline"
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

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="text-center text-muted py-4"
                                >
                                    No customers found.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <div class="mt-3">
        {{ $customers->links() }}
    </div>

</div>

@endsection