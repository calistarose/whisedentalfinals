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
     <div class="marker">DASHBOARD</div>

    {{-- ADMIN --}}
    <div class="text">ADMIN</div>
    <a href="{{route('admin/profile')}}">
    <div class="image"><img src="{{ asset('images/user.png')}}" alt="whise-logo" class="logo"> </div>
    </a>
    {{-- SEARCH --}}
    <form action="{{ route('search') }}" method="GET">
            <div class="mb-3">
                <input type="text" name="query" class="form-control" placeholder="Search by ID, name, etc.">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
     

    <!-- INVENTORY TABLE -->
    <button class="create-button" onclick="location.href='{{ route('patient/add') }}'">Add Patient</button>
    <table>
        <thead>
            <tr>
                <th scope="col">Patient No.</th>
                <th scope="col">Name</th>
                <th scope="col">More Details</th>
                <th scope="col">Action</th>
                <!-- <th scope="col">Edit</th> -->
            </tr>
        </thead>
        <tbody>
            @if($patient->count()>0)
            @foreach($patient as $ps)
            <tr>
                <td>
                    {{$ps->patient_id}}
                </td>
                <td>
                    {{$ps->last_name.', '.$ps->first_name.' '.$ps->middle_name}}
                </td>
                <td>
                <a href="{{ route('patient/show', $ps->id)}}" class="text-green-800 pl-2">More Details</a>
                </td>
                <td>
                <a href="{{ route('patient/edit', $ps->id)}}" class="text-green-800 pl-2">Edit</a>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td>product not found</td>
            </tr>
            @endif
        </tbody>
    </table>

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