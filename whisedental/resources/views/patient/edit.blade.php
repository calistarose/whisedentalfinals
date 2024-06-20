<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/styles.css')}}">
    <title>Whise Smile Dental Clinic - Edit Patient</title>
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
        <a href="{{ route ('admin/maintenance')}}">Maintenance</a>
        <a href="{{ route ('admin/inventory')}}">Inventory</a>
        <a href="#">Help</a>
        <a href="#">About</a>
        <a href="{{ route ('logout') }}">Logout</a>
    </div>

    {{-- LABEL --}}
    <div class="marker">EDIT PATIENT RECORD</div>

    {{-- ADMIN --}}
    <div class="text">ADMIN</div>
    <a href="{{ route('admin/profile') }}">
        <div class="image"><img src="{{ asset('images/user.png')}}" alt="whise-logo" class="logo"> </div>
    </a>

    <!-- EDIT PATIENT RECORD FORM -->
    <form action="{{ route('patient/update', $patient->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Last Name -->
        <div>
            <label>Last Name</label>
            <input id="last_name" name="last_name" type="text" value="{{ $patient->last_name }}">
        </div>

        <!-- First Name -->
        <div>
            <label>First Name</label>
            <input id="first_name" name="first_name" type="text" value="{{ $patient->first_name }}">
        </div>

        <!-- Middle Name -->
        <div>
            <label>Middle Name</label>
            <input id="middle_name" name="middle_name" type="text" value="{{ $patient->middle_name }}">
        </div>

        <!-- Suffix -->
        <div>
            <label>Suffix</label>
            <input id="suffix" name="suffix" type="text" value="{{ $patient->suffix }}">
        </div>

        <!-- Date of Birth -->
        <div>
            <label>Date of Birth</label>
            <input id="date_of_birth" name="date_of_birth" type="date" value="{{ $patient->date_of_birth }}">
        </div>

        <!-- Gender -->
        <div>
            <label>Gender</label><br>
            <input type="radio" id="gender_male" name="gender" value="Male" {{ $patient->gender === 'Male' ? 'checked' : '' }}>
            <label for="gender_male">Male</label><br>
            <input type="radio" id="gender_female" name="gender" value="Female" {{ $patient->gender === 'Female' ? 'checked' : '' }}>
            <label for="gender_female">Female</label><br>
            <input type="radio" id="gender_other" name="gender" value="Other" {{ $patient->gender === 'Other' ? 'checked' : '' }}>
            <label for="gender_other">Other</label>
        </div>

        <!-- Marital Status -->
        <div>
            <label>Marital Status</label>
            <select id="marital_status" name="marital_status">
                <option value="Single" {{ $patient->marital_status === 'Single' ? 'selected' : '' }}>Single</option>
                <option value="Married" {{ $patient->marital_status === 'Married' ? 'selected' : '' }}>Married</option>
                <option value="Divorced" {{ $patient->marital_status === 'Divorced' ? 'selected' : '' }}>Divorced</option>
                <option value="Widowed" {{ $patient->marital_status === 'Widowed' ? 'selected' : '' }}>Widowed</option>
            </select>
        </div>

        <!-- Home Address -->
        <div>
            <label>Home Address</label>
            <textarea id="home_address" name="home_address">{{ $patient->home_address }}</textarea>
        </div>

        <!-- Contact Number -->
        <div>
            <label>Contact Number</label>
            <input id="contact_number" name="contact_number" type="text" value="{{ $patient->contact_number }}">
        </div>

        <!-- Email Address -->
        <div>
            <label>Email Address</label>
            <input id="email_address" name="email_address" type="email" value="{{ $patient->email_address }}">
        </div>

        <!-- Last Dentist Visit -->
        <div>
            <label>Last Dentist Visit</label>
            <input id="last_dentist_visit" name="last_dentist_visit" type="date" value="{{ $patient->last_dentist_visit }}">
        </div>

        <!-- Dental History Section -->
        <div>
            <h3>Dental History</h3>

            <div>
                <label>Had Cavities?</label><br>
                <input type="radio" id="had_cavities_yes" name="had_cavities" value="Yes" {{ $patient->had_cavities === 'Yes' ? 'checked' : '' }}>
                <label for="had_cavities_yes">Yes</label><br>
                <input type="radio" id="had_cavities_no" name="had_cavities" value="No" {{ $patient->had_cavities === 'No' ? 'checked' : '' }}>
                <label for="had_cavities_no">No</label>
            </div>

            <div>
                <label>Have Tooth Sensitivity?</label><br>
                <input type="radio" id="have_tooth_sensitivity_yes" name="have_tooth_sensitivity" value="Yes" {{ $patient->have_tooth_sensitivity === 'Yes' ? 'checked' : '' }}>
                <label for="have_tooth_sensitivity_yes">Yes</label><br>
                <input type="radio" id="have_tooth_sensitivity_no" name="have_tooth_sensitivity" value="No" {{ $patient->have_tooth_sensitivity === 'No' ? 'checked' : '' }}>
                <label for="have_tooth_sensitivity_no">No</label>
            </div>

            <div>
                <label>Grind or Clench Teeth?</label><br>
                <input type="radio" id="grind_or_clench_teeth_yes" name="grind_or_clench_teeth" value="Yes" {{ $patient->grind_or_clench_teeth === 'Yes' ? 'checked' : '' }}>
                <label for="grind_or_clench_teeth_yes">Yes</label><br>
                <input type="radio" id="grind_or_clench_teeth_no" name="grind_or_clench_teeth" value="No" {{ $patient->grind_or_clench_teeth === 'No' ? 'checked' : '' }}>
                <label for="grind_or_clench_teeth_no">No</label>
            </div>

            <div>
                <label>Had Oral Surgeries?</label><br>
                <input type="radio" id="had_oral_surgeries_yes" name="had_oral_surgeries" value="Yes" {{ $patient->had_oral_surgeries === 'Yes' ? 'checked' : '' }}>
                <label for="had_oral_surgeries_yes">Yes</label><br>
                <input type="radio" id="had_oral_surgeries_no" name="had_oral_surgeries" value="No" {{ $patient->had_oral_surgeries === 'No' ? 'checked' : '' }}>
                <label for="had_oral_surgeries_no">No</label>
            </div>

            <div>
                <label>Had Braces or Orthodontic Treatments?</label><br>
                <input type="radio" id="had_braces_or_orthodontic_treatments_yes" name="had_braces_or_orthodontic_treatments" value="Yes" {{ $patient->had_braces_or_orthodontic_treatments === 'Yes' ? 'checked' : '' }}>
                <label for="had_braces_or_orthodontic_treatments_yes">Yes</label><br>
                <input type="radio" id="had_braces_or_orthodontic_treatments_no" name="had_braces_or_orthodontic_treatments" value="No" {{ $patient->had_braces_or_orthodontic_treatments === 'No' ? 'checked' : '' }}>
                <label for="had_braces_or_orthodontic_treatments_no">No</label>
            </div>

            <div>
                <label>Have Gum Disease?</label><br>
                <input type="radio" id="have_gum_disease_yes" name="have_gum_disease" value="Yes" {{ $patient->have_gum_disease === 'Yes' ? 'checked' : '' }}>
                <label for="have_gum_disease_yes">Yes</label><br>
                <input type="radio" id="have_gum_disease_no" name="have_gum_disease" value="No" {{ $patient->have_gum_disease === 'No' ? 'checked' : '' }}>
                <label for="have_gum_disease_no">No</label>
            </div>

            <div>
                <label>Do Gums Bleed?</label><br>
                <input type="radio" id="do_gums_bleed_yes" name="do_gums_bleed" value="Yes" {{ $patient->do_gums_bleed === 'Yes' ? 'checked' : '' }}>
                <label for="do_gums_bleed_yes">Yes</label><br>
                <input type="radio" id="do_gums_bleed_no" name="do_gums_bleed" value="No" {{ $patient->do_gums_bleed === 'No' ? 'checked' : '' }}>
                <label for="do_gums_bleed_no">No</label>
            </div>

            <div>
                <label>Gum Recession or Gum Grafting?</label><br>
                <input type="radio" id="gum_recession_or_gum_grafting_yes" name="gum_recession_or_gum_grafting" value="Yes" {{ $patient->gum_recession_or_gum_grafting === 'Yes' ? 'checked' : '' }}>
                <label for="gum_recession_or_gum_grafting_yes">Yes</label><br>
                <input type="radio" id="gum_recession_or_gum_grafting_no" name="gum_recession_or_gum_grafting" value="No" {{ $patient->gum_recession_or_gum_grafting === 'No' ? 'checked' : '' }}>
                <label for="gum_recession_or_gum_grafting_no">No</label>
            </div>

            <div>
                <label>Lost Teeth Due to Decay or Injury?</label><br>
                <input type="radio" id="lost_teeth_due_to_decay_or_injury_yes" name="lost_teeth_due_to_decay_or_injury" value="Yes" {{ $patient->lost_teeth_due_to_decay_or_injury === 'Yes' ? 'checked' : '' }}>
                <label for="lost_teeth_due_to_decay_or_injury_yes">Yes</label><br>
                <input type="radio" id="lost_teeth_due_to_decay_or_injury_no" name="lost_teeth_due_to_decay_or_injury" value="No" {{ $patient->lost_teeth_due_to_decay_or_injury === 'No' ? 'checked' : '' }}>
                <label for="lost_teeth_due_to_decay_or_injury_no">No</label>
            </div>

            <div>
                <label>Have Dental Implants?</label><br>
                <input type="radio" id="have_dental_implants_yes" name="have_dental_implants" value="Yes" {{ $patient->have_dental_implants === 'Yes' ? 'checked' : '' }}>
                <label for="have_dental_implants_yes">Yes</label><br>
                <input type="radio" id="have_dental_implants_no" name="have_dental_implants" value="No" {{ $patient->have_dental_implants === 'No' ? 'checked' : '' }}>
                <label for="have_dental_implants_no">No</label>
            </div>

            <div>
                <label>Have Crowns, Bridges, or Dentures?</label><br>
                <input type="radio" id="have_crowns_bridges_or_dentures_yes" name="have_crowns_bridges_or_dentures" value="Yes" {{ $patient->have_crowns_bridges_or_dentures === 'Yes' ? 'checked' : '' }}>
                <label for="have_crowns_bridges_or_dentures_yes">Yes</label><br>
                <input type="radio" id="have_crowns_bridges_or_dentures_no" name="have_crowns_bridges_or_dentures" value="No" {{ $patient->have_crowns_bridges_or_dentures === 'No' ? 'checked' : '' }}>
                <label for="have_crowns_bridges_or_dentures_no">No</label>
            </div>

            <div>
                <label>Brush Teeth at Least Twice a Day?</label><br>
                <input type="radio" id="brush_teeth_at_least_twice_a_day_yes" name="brush_teeth_at_least_twice_a_day" value="Yes" {{ $patient->brush_teeth_at_least_twice_a_day === 'Yes' ? 'checked' : '' }}>
                <label for="brush_teeth_at_least_twice_a_day_yes">Yes</label><br>
                <input type="radio" id="brush_teeth_at_least_twice_a_day_no" name="brush_teeth_at_least_twice_a_day" value="No" {{ $patient->brush_teeth_at_least_twice_a_day === 'No' ? 'checked' : '' }}>
                <label for="brush_teeth_at_least_twice_a_day_no">No</label>
            </div>

            <div>
                <label>Floss Daily?</label><br>
                <input type="radio" id="floss_daily_yes" name="floss_daily" value="Yes" {{ $patient->floss_daily === 'Yes' ? 'checked' : '' }}>
                <label for="floss_daily_yes">Yes</label><br>
                <input type="radio" id="floss_daily_no" name="floss_daily" value="No" {{ $patient->floss_daily === 'No' ? 'checked' : '' }}>
                <label for="floss_daily_no">No</label>
            </div>

            <div>
                <label>Taking Medications?</label><br>
                <input type="radio" id="taking_medications_yes" name="taking_medications" value="Yes" {{ $patient->taking_medications === 'Yes' ? 'checked' : '' }}>
                <label for="taking_medications_yes">Yes</label><br>
                <input type="radio" id="taking_medications_no" name="taking_medications" value="No" {{ $patient->taking_medications === 'No' ? 'checked' : '' }}>
                <label for="taking_medications_no">No</label>
            </div>

            <div>
                <label>Consume Sugary or Acidic Foods?</label><br>
                <input type="radio" id="consume_sugary_or_acidic_foods_yes" name="consume_sugary_or_acidic_foods" value="Yes" {{ $patient->consume_sugary_or_acidic_foods === 'Yes' ? 'checked' : '' }}>
                <label for="consume_sugary_or_acidic_foods_yes">Yes</label><br>
                <input type="radio" id="consume_sugary_or_acidic_foods_no" name="consume_sugary_or_acidic_foods" value="No" {{ $patient->consume_sugary_or_acidic_foods === 'No' ? 'checked' : '' }}>
                <label for="consume_sugary_or_acidic_foods_no">No</label>
            </div>

            <div>
                <label>Is Smoking?</label><br>
                <input type="radio" id="is_smoking_yes" name="is_smoking" value="Yes" {{ $patient->is_smoking === 'Yes' ? 'checked' : '' }}>
                <label for="is_smoking_yes">Yes</label><br>
                <input type="radio" id="is_smoking_no" name="is_smoking" value="No" {{ $patient->is_smoking === 'No' ? 'checked' : '' }}>
                <label for="is_smoking_no">No</label>
            </div>

            <div>
                <label>Drink Coffee, Tea, or Red Wine?</label><br>
                <input type="radio" id="drink_coffee_tea_or_red_wine_yes" name="drink_coffee_tea_or_red_wine" value="Yes" {{ $patient->drink_coffee_tea_or_red_wine === 'Yes' ? 'checked' : '' }}>
                <label for="drink_coffee_tea_or_red_wine_yes">Yes</label><br>
                <input type="radio" id="drink_coffee_tea_or_red_wine_no" name="drink_coffee_tea_or_red_wine" value="No" {{ $patient->drink_coffee_tea_or_red_wine === 'No' ? 'checked' : '' }}>
                <label for="drink_coffee_tea_or_red_wine_no">No</label>
            </div>

            <div>
                <label>Medical Conditions</label>
                <textarea id="medical_conditions" name="medical_conditions">{{ $patient->medical_conditions }}</textarea>
            </div>
                        <!-- Allergy -->
                        <div>
                <label>Allergy</label>
                <textarea id="allergy" name="allergy">{{ $patient->allergy }}</textarea>
            </div>

            <!-- Username (Not editable) -->
            <div>
                <label>Username</label>
                <input id="username" name="username" type="text" value="{{ $patient->username }}" readonly>
            </div>

            <!-- User ID (Not editable) -->
            <div>
                <label>User ID</label>
                <input id="user_id" name="user_id" type="text" value="{{ $patient->user_id }}" readonly>
            </div>

            <!-- Submit Button -->
            <button type="submit">Update Patient Record</button>
        </form>

    {{-- SCRIPTS --}}
    <script>
        // Get current date and time
        var now = new Date();
        year = now.getFullYear();
        const monthNames = [
            "January", "February", "March", "April", "May", "June", 
            "July", "August", "September", "October", "November", "December"
        ];
        month = monthNames[now.getMonth()];
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

