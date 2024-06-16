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
    <a href="#">Help</a>
    <a href="#">About</a>
    <a href="{{ route ('logout') }}">Logout</a>
</div>

    {{-- LABEL --}}
    <div class="marker">USER DASHBOARD</div>

    {{-- ADMIN --}}
    <!-- <div class="text">ADMIN</div> -->
    <!-- <a href="{{route('admin/profile')}}"> -->
    <div class="image"><img src="{{ asset('images/user.png')}}" alt="whise-logo" class="logo"> </div>
    <!-- </a> -->

    <!-- NAME -->
    <div>
        <label>Patient Number: </label>
        {{ $patients->patient_id }}
    </div>

     <!-- NAME -->
    <div>
       {{ $patients->last_name.', '.$patients->first_name.' '.$patients->middle_name }}
    </div>
    <!-- DATE OF BIRTH -->
    <div>
        <label>Date of Birth: </label>
        {{ $patients->date_of_birth }}
    </div>
    <!-- GENDER -->
    <div>
        <label>Gender: </label>
        {{ $patients->gender }}
    </div>
    <!-- DATE OF BIRTH -->
    <div>
        <label>Date of Birth: </label>
        {{ $patients->date_of_birth }}
    </div>
    <!-- ADDRESS -->
    <div>
        <label>Address: </label>
        {{ $patients->address }}
    </div>
    <!-- CONTACT NUMBER -->
    <div>
        <label>Contact Number: </label>
        {{ $patients->contact_number }}
    </div>
    <!-- EMAIL -->
    <div>
        <label>Email: </label>
        {{ $patients->email_address }}
    </div>

    <div>
        <a href = {{ route('appointments.create')}} >Add Appointment</a>
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