<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>NOVA Booking</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body>

<div class="container py-5">

    <div class="text-center mb-5">
        <h1>NOVA Booking</h1>
        <p class="text-muted">
            Book your appointment
        </p>
    </div>

    <div class="card mx-auto" style="max-width: 700px;">

        <div class="card-body">

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('public.booking.store') }}"
            >

                @csrf

                <h5 class="mb-3">Appointment</h5>

                <div class="mb-3">
                    <label for="service_id" class="form-label">
                        Service
                    </label>

                    <select
                        name="service_id"
                        id="service_id"
                        class="form-select"
                        required
                    >
                        <option value="">
                            Choose a service
                        </option>

                        @foreach($services as $service)

                            <option
                                value="{{ $service->id }}"
                                {{ old('service_id') == $service->id ? 'selected' : '' }}
                            >
                                {{ $service->name }}
                                — {{ number_format($service->price, 2) }}
                            </option>

                        @endforeach

                    </select>
                </div>

                <div class="mb-3">
                    <label for="staff_profile_id" class="form-label">
                        Staff
                    </label>

                    <select
                        name="staff_profile_id"
                        id="staff_profile_id"
                        class="form-select"
                        required
                        disabled
                    >
                        <option value="">
                            Choose a service first
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="booking_date" class="form-label">
                        Date
                    </label>

                    <input
                        type="date"
                        name="booking_date"
                        id="booking_date"
                        class="form-control"
                        min="{{ today()->format('Y-m-d') }}"
                        value="{{ old('booking_date') }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="start_time" class="form-label">
                        Available Time
                    </label>

                    <select
                        name="start_time"
                        id="start_time"
                        class="form-select"
                        required
                        disabled
                    >
                        <option value="">
                            Choose staff and date first
                        </option>
                    </select>
                </div>

                <hr>

                <h5 class="mb-3">Your Information</h5>

                <div class="mb-3">
                    <label class="form-label">
                        Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name') }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Phone
                    </label>

                    <input
                        type="text"
                        name="phone"
                        class="form-control"
                        value="{{ old('phone') }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email') }}"
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Notes
                    </label>

                    <textarea
                        name="notes"
                        class="form-control"
                        rows="3"
                    >{{ old('notes') }}</textarea>
                </div>

                <button
                    type="submit"
                    class="btn btn-primary w-100"
                >
                    Book Appointment
                </button>

            </form>

        </div>

    </div>

</div>

<script>
const services = @json(
    $services->map(fn ($service) => [
        'id' => $service->id,
        'staff' => $service->staff->map(fn ($staff) => [
            'id' => $staff->id,
            'name' => $staff->user->name,
        ])->values(),
    ])->values()
);

const serviceSelect = document.getElementById('service_id');
const staffSelect = document.getElementById('staff_profile_id');
const dateInput = document.getElementById('booking_date');
const timeSelect = document.getElementById('start_time');

function updateStaff()
{
    const service = services.find(
        service => service.id == serviceSelect.value
    );

    staffSelect.innerHTML =
        '<option value="">Choose a staff member</option>';

    timeSelect.innerHTML =
        '<option value="">Choose staff and date first</option>';

    timeSelect.disabled = true;

    if (!service) {
        staffSelect.disabled = true;
        return;
    }

    service.staff.forEach(staff => {

        staffSelect.innerHTML += `
            <option value="${staff.id}">
                ${staff.name}
            </option>
        `;

    });

    staffSelect.disabled = false;
}

async function loadSlots()
{
    const staffId = staffSelect.value;
    const serviceId = serviceSelect.value;
    const date = dateInput.value;

    timeSelect.innerHTML =
        '<option value="">Loading...</option>';

    timeSelect.disabled = true;

    if (!staffId || !serviceId || !date) {
        timeSelect.innerHTML =
            '<option value="">Choose staff and date first</option>';
        return;
    }

    const url = new URL(
        "{{ route('public.booking.availability') }}",
        window.location.origin
    );

    url.searchParams.set('staff_profile_id', staffId);
    url.searchParams.set('service_id', serviceId);
    url.searchParams.set('date', date);

    try {

        const response = await fetch(url);

        if (!response.ok) {
            throw new Error('Availability request failed.');
        }

        const data = await response.json();

        timeSelect.innerHTML =
            '<option value="">Choose a time</option>';

        data.slots.forEach(slot => {

            timeSelect.innerHTML += `
                <option value="${slot.start}">
                    ${slot.start} - ${slot.end}
                </option>
            `;

        });

        if (data.slots.length === 0) {

            timeSelect.innerHTML =
                '<option value="">No available times</option>';

        } else {

            timeSelect.disabled = false;

        }

    } catch (error) {

        timeSelect.innerHTML =
            '<option value="">Unable to load availability</option>';

    }
}

serviceSelect.addEventListener('change', updateStaff);
staffSelect.addEventListener('change', loadSlots);
dateInput.addEventListener('change', loadSlots);

updateStaff();
</script>

</body>
</html>