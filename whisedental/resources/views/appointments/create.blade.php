<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Appointment</title>
    <style>
        .hidden { display: none; }
    </style>
    
    <!-- Link to your CSS file -->
    <link rel="stylesheet" href="{{ asset('css/styles.css')}}">
</head>
<body>
    {{-- HEADER --}}
    @include('partials.adminHeader')

    {{-- SIDE NAVIGATION BAR --}}
    <div id="sidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="{{ route ('admin/home')}}">Dashboard</a>
        <a href="{{ route ('appointments.index')}}">Appointments</a>
        <a href="#">Patient's Record</a>
        <a href="#">Reports</a>
        <a href="{{ route ('admin/maintenance')}}">Maintenance</a>
        <a href="{{ route ('admin/inventory')}}">Inventory</a>
        <a href="#">Help</a>
        <a href="#">About</a>
        <a href="{{ route ('logout') }}">Logout</a>
    </div>

    <h1>Schedule Appointment</h1>

    {{-- Displaying validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Appointment creation form --}}
    <form action="{{ route('appointments.store') }}" method="POST" onsubmit="formatDatetimeInputs(event)">
        @csrf
        <div class="dropdown-container">
            <label for="appointment-type">Type of appointment:</label>
            <select id="appointment-type" name="type_of_appointment" required>
                <option value="">Select an appointment type</option>
                <option value="general">General Consultation</option>
                <option value="cleaning">Teeth Cleaning</option>
                <option value="whitening">Teeth Whitening</option>
                <option value="checkup">Routine Checkup</option>
            </select>
        </div>

        <div>
            <label for="appointment-date">Appointment Date:</label>
            <input type="date" id="appointment-date" name="appointment_date" required>
        </div>

        <div>
            <label for="start-time">Start Time:</label>
            <select id="start-time" name="start_time" required>
                <option value="">Select preferred time</option>
                <!-- Time slots will be populated by JavaScript -->
            </select>
        </div>

        <input type="hidden" id="start_datetime" name="start_datetime">
        <input type="hidden" id="end_datetime" name="end_datetime">

        {{-- Admin-only patient selection --}}
        @if (auth()->user()->type == 'admin')
            <div>
                <label for="patient_id">Patient:</label>
                <select id="patient_id" name="patient_id">
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->last_name }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <button type="submit">Schedule Appointment</button>
    </form>

    {{-- Back button --}}
    <a href="{{ auth()->user()->type === 'admin' ? route('appointments.index') : route('home') }}">Back</a>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const appointmentDateInput = document.getElementById('appointment-date');
            const startTimeSelect = document.getElementById('start-time');
            const startDateTimeInput = document.getElementById('start_datetime');
            const endDateTimeInput = document.getElementById('end_datetime');

            // Event listener for appointment date change
            appointmentDateInput.addEventListener('change', async function() {
                const date = this.value;
                if (date) {
                    const response = await fetch(`/appointments/available-times?date=${date}`);
                    const availableTimes = await response.json();
                    startTimeSelect.innerHTML = ''; // Clear existing options
                    // Add the "Select preferred time" option first
                    const defaultOption = document.createElement('option');
                    defaultOption.value = '';
                    defaultOption.textContent = 'Select preferred time';
                    startTimeSelect.appendChild(defaultOption);
                    // Add available times
                    availableTimes.forEach(time => {
                        const option = document.createElement('option');
                        option.value = time; // Assuming time is like '08:00'
                        option.textContent = convertTo12HourFormat(time);
                        startTimeSelect.appendChild(option);
                    });
                }
            });

            // Event listener for start time selection
            startTimeSelect.addEventListener('change', function() {
                const date = appointmentDateInput.value;
                const time = this.value;
                if (time) {
                    const startDateTime = new Date(`${date}T${time}:00`);
                    const endDateTime = new Date(startDateTime.getTime() + 60 * 60 * 1000);
                    startDateTimeInput.value = formatDateTime(startDateTime);
                    endDateTimeInput.value = formatDateTime(endDateTime);
                } else {
                    startDateTimeInput.value = '';
                    endDateTimeInput.value = '';
                }
            });

            // Function to format datetime to YYYY-MM-DD HH:mm:ss
            function formatDateTime(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                const hours = String(date.getHours()).padStart(2, '0');
                const minutes = String(date.getMinutes()).padStart(2, '0');
                const seconds = String(date.getSeconds()).padStart(2, '0');
                return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
            }

            // Function to convert 24-hour time to 12-hour AM/PM format
            function convertTo12HourFormat(time) {
                const [hour, minute] = time.split(':');
                const h = parseInt(hour);
                const ampm = h >= 12 ? 'PM' : 'AM';
                const adjustedHour = h % 12 || 12;
                return `${adjustedHour}:${minute} ${ampm}`;
            }
        });

        // Function to validate datetime inputs before submission
        function formatDatetimeInputs(event) {
            const startDateTimeInput = document.getElementById('start_datetime');
            const endDateTimeInput = document.getElementById('end_datetime');

            // Ensure the datetime fields are populated before submission
            if (!startDateTimeInput.value.trim() || !endDateTimeInput.value.trim()) {
                event.preventDefault();
                alert('Please select a valid date and time for the appointment.');
            }
        }

        // Script for opening and closing the side navigation bar
        function openNav() {
            document.getElementById("sidenav").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("sidenav").style.width = "0";
        }
    </script>
</body>
</html>
