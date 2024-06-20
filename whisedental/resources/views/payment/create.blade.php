<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <title>Create Payment</title>
</head>
<body>
    @include('partials.adminHeader')

    <div id="sidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="{{ route('admin/home') }}">Dashboard</a>
        <a href="{{ route('appointments.index') }}">Appointments</a>
        <a href="#">Patient's Record</a>
        <a href="#">Reports</a>
        <a href="{{ route('payments/home') }}">Payments</a>
        <a href="{{ route('admin/inventory') }}">Inventory</a>
        <a href="#">Help</a>
        <a href="#">About</a>
        <a href="{{ route('logout') }}">Logout</a>
    </div>

    <div class="marker">CREATE PAYMENT</div>
    <div class="text">ADMIN</div>
    <a href="{{ route('admin/profile') }}">
        <div class="image"><img src="{{ asset('images/user.png') }}" alt="admin-avatar" class="logo"></div>
    </a>

    <div class="container">
        <form action="{{ route('payments.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="patientId">Select Patient</label>
                <select name="patient_id" id="patientId" class="form-control">
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->last_name }}, {{ $patient->first_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="appointmentType">Appointment Type:</label>
                <span id="selectedAppointmentType">Select a Patient to see Appointment Type</span>
                <input type="hidden" name="type_of_appointment" id="appointmentTypeHidden" value="">
            </div>
            <div class="form-group">
                <label for="payment_method">Mode of Payment</label>
                <select name="payment_method" id="payment_method" class="form-control" required onchange="checkPaymentMode()">
                    <option value="cash">Cash</option>
                    <option value="gcash">GCash</option>
                    <!-- Add more options as needed -->
                </select>
            </div>
            <div class="form-group">
                <label for="credit">Amount to be Paid</label>
                <input type="number" name="credit" id="credit" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="debit">Amount Paid</label>
                <input type="number" name="debit" id="debit" class="form-control" required>
            </div>
            
            <button type="submit">Create Payment</button>
        </form>

        {{-- Display QR code if payment mode is 'gcash' --}}
        <div id="gcashQRCode" style="display: none;" class="qr-code">
            <h3>Scan to Pay with GCash</h3>
            <img id="gcashQRImage" src="" alt="GCash QR Code">
        </div>
    </div>

    <script>
        function openNav() {
            document.getElementById("sidenav").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("sidenav").style.width = "0";
        }

        function checkPaymentMode() {
            var mode = document.getElementById('payment_method').value;
            if (mode === 'gcash') {
                document.getElementById('gcashQRCode').style.display = 'block';
                var qrCodeSrc = "{{ asset('storage/qrcodes/qr-placeholder.png') }}";
                document.getElementById('gcashQRImage').src = qrCodeSrc;
            } else {
                document.getElementById('gcashQRCode').style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var patientSelect = document.getElementById('patientId');
            var selectedAppointmentType = document.getElementById('selectedAppointmentType');
            var hiddenInput = document.getElementById('appointmentTypeHidden');
            
            // Update on initial page load
            updateAppointmentType();

            // Update when patient selection changes
            patientSelect.addEventListener('change', function() {
                updateAppointmentType();
            });

            function updateAppointmentType() {
                var selectedPatientId = patientSelect.value;
                var appointmentType = @json($latestAppointmentTypes); // Convert PHP array to JSON

                // Fetch appointment type based on selected patient
                var selectedPatientType = appointmentType[selectedPatientId] ?? 'No appointment found';

                selectedAppointmentType.textContent = selectedPatientType;
                hiddenInput.value = selectedPatientType;
            }
        });
    </script>
</body>
</html>
