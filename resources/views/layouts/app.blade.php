<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'NOVA Booking')</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body>

    <nav class="navbar navbar-dark bg-dark">
        <div class="container">

            <a class="navbar-brand" href="{{ url('/') }}">
                NOVA Booking
            </a>

            @auth

                @if(auth()->user()->role === 'admin')

                    <a
                        href="{{ route('dashboard') }}"
                        class="btn btn-outline-light btn-sm"
                    >
                        Dashboard
                    </a>

                    <a
                        href="{{ route('categories.index') }}"
                        class="btn btn-outline-light btn-sm"
                    >
                        Categories
                    </a>

                    <a
                        href="{{ route('services.index') }}"
                        class="btn btn-outline-light btn-sm"
                    >
                        Services
                    </a>

                    <a
                        href="{{ route('customers.index') }}"
                        class="btn btn-outline-light btn-sm"
                    >
                        Customers
                    </a>

                    <a
                        href="{{ route('bookings.index') }}"
                        class="btn btn-outline-light btn-sm"
                    >
                        Bookings
                    </a>

                    <a
                        href="{{ route('availability.index') }}"
                        class="btn btn-outline-light btn-sm"
                    >
                        Availability
                    </a>

                    <a
                        href="{{ route('staff.index') }}"
                        class="btn btn-outline-light btn-sm"
                    >
                        Staff
                    </a>

                @elseif(auth()->user()->role === 'staff')

                    <a
                        href="{{ route('staff.dashboard') }}"
                        class="btn btn-outline-light btn-sm"
                    >
                        Dashboard
                    </a>

                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="btn btn-outline-light btn-sm">
                        Logout
                    </button>
                </form>

            @endauth

        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="text-center text-muted py-4">
        <small>&copy; {{ date('Y') }} NOVA Booking</small>
    </footer>

</body>
</html>