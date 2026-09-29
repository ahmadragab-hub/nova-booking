<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Booking Confirmed</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body>

<div class="container py-5">

    <div
        class="card mx-auto"
        style="max-width: 600px;"
    >

        <div class="card-body text-center">

            <h1 class="mb-3">
                Booking Confirmed
            </h1>

            <p class="text-muted">
                Your appointment has been successfully booked.
            </p>

            <hr>

            <p>
                <strong>Service:</strong>
                {{ $booking->service->name }}
            </p>

            <p>
                <strong>Staff:</strong>
                {{ $booking->staffProfile->user->name }}
            </p>

            <p>
                <strong>Date:</strong>
                {{ $booking->booking_date->format('Y-m-d') }}
            </p>

            <p>
                <strong>Time:</strong>
                {{ substr($booking->start_time, 0, 5) }}
                -
                {{ substr($booking->end_time, 0, 5) }}
            </p>

            <a
                href="{{ route('public.booking') }}"
                class="btn btn-primary"
            >
                Book Another Appointment
            </a>

        </div>

    </div>

</div>

</body>
</html>