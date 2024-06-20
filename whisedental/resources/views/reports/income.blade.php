<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/styles.css')}}">
    <title>Whise Smile Dental Clinic - Income Summary</title>
</head>
<body>
    {{-- HEADER --}}
    @include('partials.adminHeader')

    {{-- SIDE NAVIGATION BAR --}}
    <div id="sidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="{{ route ('admin/home')}}">Dashboard</a>
        <a href="#">Appointments</a>
        <a href="#">Patient's Record</a>
        <a href="#">Reports</a>
        <a href="{{ route ('payments/home')}}">Payments</a>
        <a href="{{ route ('admin/inventory')}}">Inventory</a>
        <a href="#">Help</a>
        <a href="#">About</a>
        <a href="{{ route ('logout') }}">Logout</a>
    </div>

    {{-- LABEL --}}
    <div class="marker">INCOME SUMMARY</div>

    {{-- Buttons for income summary --}}
    <div class="income-buttons">
        <form id="income-form" action="{{ route('get/income') }}" method="POST">
            @csrf
            <button type="submit" class="income-button" name="type" value="today">Today's Income</button>
            <button type="submit" class="income-button" name="type" value="week">Week's Income</button>
            <button type="submit" class="income-button" name="type" value="month">Month's Income</button>
        </form>
    </div>

    

    {{-- INCOME DISPLAY --}}
    <div id="income-display" class="income-display">
        <!-- Income data will be displayed here -->
        @if(isset($income))
            ${{ number_format($income, 2) }}
        @else
            $0.00
        @endif
    </div>

    {{-- SCRIPTS --}}
    <script>
        // Opening the navbar
        function openNav() {
            document.getElementById("sidenav").style.width = "250px";
        }

        // Closing the navbar
        function closeNav() {
            document.getElementById("sidenav").style.width = "0";
        }
    </script>
</body>
</html>
