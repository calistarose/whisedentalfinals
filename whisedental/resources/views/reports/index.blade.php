<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/styles.css')}}">
    <title>Whise Smile Dental Clinic </title>
</head>
<body>
    {{-- HEADER --}}
    @include('partials.adminHeader')

    {{-- SIDE NAVIGATION BAR --}}
    <div id="sidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="{{ route ('admin/home') }}">Dashboard</a>
        <a href="{{ route ('appointments.index')}}">Appointments</a>
        <a href={{ route ('patient') }}>Patient's Record</a>
        <a href=" {{ route('income/home')}}">Reports</a>
        <a href="{{ route ('payments/home')}}">Payments</a>
        <a href="{{ route ('admin/inventory')}}">Inventory</a>
        <a href="#">Help</a>
        <a href="#">About</a>
        <a href="{{ route ('logout') }}">Logout</a>
    </div>

    {{-- LABEL --}}
    <div class="marker">DASHBOARD</div>

    {{-- ADMIN --}}
    <div class="text">ADMIN</div>
    <a href="{{route('admin/profile')}}">
    <div class="image"><img src="{{ asset('images/user.png')}}" alt="whise-logo" class="logo"> </div>
    </a>
    {{-- SECOND ROW OF BUTTONS --}}
    <div class="">
        {{-- REPORTS --}}
        <div class="filled-box">
            <div class="text">
                <a href = '{{ route('get/income')}}'>
                <p class="">Income</p>
                </a>
            </div>
        </div>
        <div class="filled-box">
            <div class="text">
            <a href = ''>
                <p class="">Patient</p>
                </a>
            </div>
        </div>
        <div class="filled-box">
            <div class="text">
            <a href = ''>
                <p class="">Payments</p>
                </a>
            </div>
        </div>
    </div>
    

    {{-- SCRIPTS --}}
    <script>
        // Get current date and time
        var now = new Date();
        year = now.getFullYear();
        const monthNames = [
            "January", "February", "March", "April", "May", "June", 
            "July", "August", "September", "October", "November", "December"
        ];
        month = monthNames[now.getMonth() + 1];
        date = now.getDate();
        const dayNames = [
            "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", 
        ];
        day = dayNames[now.getDay()];
        hours = now.getHours();
        minutes = now.getMinutes();
        seconds = now.getSeconds();
        
        document.getElementById("date").innerHTML = month + " " + date + ", " + year;
        document.getElementById("day_and_time").innerHTML = day + ", " + hours + ":" + minutes + ":" + seconds;

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