<!-- resources/views/payment/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <title>Payment System</title>
</head>
<body>
    @include('partials.adminHeader')

    <div id="sidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="{{ route('admin/home') }}">Dashboard</a>
        <a href="#">Appointments</a>
        <a href="#">Patient's Record</a>
        <a href="#">Reports</a>
        <a href="#">Maintenance</a>
        <a href="{{ route('admin/inventory') }}">Inventory</a>
        <a href="#">Help</a>
        <a href="#">About</a>
        <a href="{{ route('logout') }}">Logout</a>
    </div>

    <div class="marker">DASHBOARD</div>
    <div class="text">ADMIN</div>
    <a href="{{ route('admin/profile') }}">
        <div class="image"><img src="{{ asset('images/user.png') }}" alt="admin-avatar" class="logo"></div>
    </a>

    <div class="container">
        <button class="create-button" onclick="location.href='{{ route('payments.create') }}'">Create Payment</button>
        <table>
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Patient Name</th>
                    <th scope="col">Appointment Type</th>
                    <th scope="col">Mode of Payment</th>
                    <th scope="col">Total Amount to be Paid</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $payment->patient->last_name }}</td>
                        <td>
                            @if ($payment->patient->appointments)
                                {{ $payment->patient->appointments->type_of_appointment }}
                            @else
                                No Appointment
                            @endif
                        </td>
                        <td>{{ $payment->payment_method}}</td>
                        <td>{{ $payment->balance }}</td>
                       
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No payments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        function openNav() {
            document.getElementById("sidenav").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("sidenav").style.width = "0";
        }
    </script>
</body>
</html>
