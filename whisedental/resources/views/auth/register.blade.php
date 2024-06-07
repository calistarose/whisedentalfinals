<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/styles.css')}}">
    <title>Whise Dental Clinic</title>
</head>
<body>
    {{-- HEADER FOR REGISTRATION --}}
    @include('partials.registrationHeader')

    <div class="form-container">
        <form method="POST" action="{{ route('register.save') }}" id="multi-step-form">
            @csrf
            @method('post')
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {{-- FIRST PAGE --}}
            <div class="form-section active" id="step1">
                <div class="marker">PERSONAL INFORMATION</div>
                {{-- LAST NAME --}}
                <div class=""> <label for="last_name">Last Name</label> </div>
                <div class=""> <input type="text" placeholder="Dela Cruz" name="last_name"> </div>
                {{-- FIRST NAME --}}
                <div class=""> <label for="first_name">First Name</label> </div>
                <div class=""> <input type="text" placeholder="Juan" name="first_name"> </div>
                {{-- MIDDLE NAME --}}
                <div class=""> <label for="middle_name">Middle Name</label> </div>
                <div class=""> <input type="text" placeholder="Carlos" name="middle_name"> </div>
                {{-- DATE OF BIRTH --}}
                <div class=""> <label for="date_of_birth">Date of Birth</label> </div>
                <div class=""> <input type="date" name="date_of_birth"> </div>
                {{-- GENDER --}}
                <div class=""> <label for="gender">Gender</label> </div>
                <div class="">
                    <select class="" name="gender">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                {{-- MARITAL STATUS --}}
                <div class=""> <label for="marital_status">Marital Status</label> </div>
                <div class="">
                    <select class="" name="marital_status">
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Separated">Separated</option>
                        <option value="Widowed">Widowed</option>
                    </select>
                </div>
                {{-- HOME ADDRESS --}}
                <div class=""> <label for="home_address">Home Address</label> </div>
                <div class=""> <input type="text" placeholder="#123 Notre Dame, Aurora Blvd., Cubao, QC" name="home_address"> </div>
                {{-- CONTACT NUMBER --}}
                <div class=""> <label for="contact_number">Contact Number</label> </div>
                <div class=""> <input type="text" placeholder="09123456789" name="contact_number"> </div>
                {{-- EMAIL ADDRESS --}}
                <div class=""> <label for="email_address">Email Address</label> </div>
                <div class=""> <input type="text" placeholder="juandelacruz.7@gmail.com" name="email_address"> </div>
                {{-- NEXT PAGE --}}
                <div class=""> <button class="" type="button" onclick="nextStep()">Next</button> </div>
                <div class=""> <label for="have_account">Already have an Account? <a href = "{{ route('login')}}">Login</a></label> </div>
            </div>
            
            {{-- SECOND PAGE --}}
            <div class="form-section" id="step2">
                <div class="marker">DENTAL INFORMATION & HISTORY</div>
                {{-- LAST DENTIST VISIT --}}
                <div class=""> <label for="last_dentist_visit">Last Dentist Visit</label> </div>
                <div class=""> <input type="date" name="last_dentist_visit"> </div>
                {{-- HAD CAVITIES --}}
                <div class=""> <p class="">Have you ever had cavities?</p></div>
                <div class=""> <input type="radio" name="had_cavities" value="Yes"> Yes </div>
                <div class=""> <input type="radio" name="had_cavities" value="No"> No </div>
                {{-- HAVE TOOTH SENSITIVITY --}}
                <div class=""> <p class="">Have you experienced tooth sensitivity?</p></div>
                <div class=""> <input type="radio" name="have_tooth_sensitivity" value="Yes"> Yes </div>
                <div class=""> <input type="radio" name="have_tooth_sensitivity" value="No"> No </div>
                {{-- GRIND OR CLENCH TEETH --}}
                <div class=""> <p class="">Do you grind or clench your teeth?</p></div>
                <div class=""> <input type="radio" name="grind_or_clench_teeth" value="Yes"> Yes </div>
                <div class=""> <input type="radio" name="grind_or_clench_teeth" value="No"> No </div>
                {{-- HAD ORAL SURGERIES --}}
                <div class=""> <p class="">Have you had any oral surgeries?</p></div>
                <div class=""> <input type="radio" name="had_oral_surgeries" value="Yes"> Yes </div>
                <div class=""> <input type="radio" name="had_oral_surgeries" value="No"> No </div>
                {{-- HAD BRACES OR OTHER ORTHODONTIC TREATMENTS --}}
                <div class=""> <p class="">Have you ever had braces or other orthodontic treatments?</p></div>
                <div class=""> <input type="radio" name="had_braces_or_orthodontic_treatments" value="Yes"> Yes </div>
                <div class=""> <input type="radio" name="had_braces_or_orthodontic_treatments" value="No"> No </div>
                {{-- HAVE GUM DISEASE --}}
                <div class=""> <p class="">Have you been diagnosed with gum disease (periodontitis)?</p></div>
                <div class=""> <input type="radio" name="have_gum_disease" value="Yes"> Yes </div>
                <div class=""> <input type="radio" name="have_gum_disease" value="No"> No </div>
                {{-- DO GUMS BLEED --}}
                <div class=""> <p class="">Do your gums bleed when you brush or floss?</p></div>
                <div class=""> <input type="radio" name="do_gums_bleed" value="Yes"> Yes </div>
                <div class=""> <input type="radio" name="do_gums_bleed" value="No"> No </div>
                {{-- GUM RECESSION OR GUM GRAFTING --}}
                <div class=""> <p class="">Have you ever been treated for gum recession or gum grafting?</p></div>
                <div class=""> <input type="radio" name="gum_recession_or_gum_grafting" value="Yes"> Yes </div>
                <div class=""> <input type="radio" name="gum_recession_or_gum_grafting" value="No"> No </div>
                {{-- LOST TEETH DUE TO DECAY OR INJURY --}}
                <div class=""> <p class="">Have you lost any teeth due to decay or injury?</p></div>
                <div class=""> <input type="radio" name="lost_teeth_due_to_decay_or_injury" value="Yes"> Yes </div>
                <div class=""> <input type="radio" name="lost_teeth_due_to_decay_or_injury" value="No"> No </div>
                {{-- HAVE DENTAL IMPLANTS --}}
                <div class=""> <p class="">Have you received dental implants?</p></div>
                <div class=""> <input type="radio" name="have_dental_implants" value="Yes"> Yes </div>
                <div class=""> <input type="radio" name="have_dental_implants" value="No"> No </div>
                {{-- HAVE CROWNS, BRIDGES, OR DENTURES --}}
                <div class=""> <p class="">Do you have any crowns, bridges, or dentures?</p></div>
                <div class=""> <input type="radio" name="have_crowns_bridges_or_dentures" value="Yes"> Yes </div>
                <div class=""> <input type="radio" name="have_crowns_bridges_or_dentures" value="No"> No </div>
                {{-- BRUSH TEETH AT LEAST TWICE A DAY --}}
                <div class=""> <p class="">Do you brush your teeth at least twice a day?</p></div>
                <div class=""> <input type="radio" name="brush_teeth_at_least_twice_a_day" value="Yes"> Yes </div>
                <div class=""> <input type="radio" name="brush_teeth_at_least_twice_a_day" value="No"> No </div>
                {{-- FLOSS DAILY --}}
                <div class=""> <p class="">Do you floss daily?</p></div>
                <div class=""> <input type="radio" name="floss_daily" value="Yes"> Yes </div>
                <div class=""> <input type="radio" name="floss_daily" value="No"> No </div>
                {{-- TAKING MEDICATIONS --}}
                <div class=""> <p class="">Are you taking any medications that may affect your oral health or cause dry mouth?</p></div>
                <div class=""> <input type="radio" name="taking_medications" value="Yes"> Yes </div>
                <div class=""> <input type="radio" name="taking_medications" value="No"> No </div>
                {{-- CONSUME SUGARY OR ACIDIC FOODS --}}
                <div class=""> <p class="">Do you consume sugary or acidic foods/beverages frequently?</p></div>
                <div class=""> <input type="radio" name="consume_sugary_or_acidic_foods" value="Yes"> Yes </div>
                <div class=""> <input type="radio" name="consume_sugary_or_acidic_foods" value="No"> No </div>
                {{-- IS SMOKING  --}}
                <div class=""> <p class="">Do you smoke or use tobacco products?</p></div>
                <div class=""> <input type="radio" name="is_smoking" value="Yes"> Yes </div>
                <div class=""> <input type="radio" name="is_smoking" value="No"> No </div>
                {{-- DRINK COFFEE, TEA, OR RED WINE --}}
                <div class=""> <p class="">Do you regularly drink coffee, tea, or red wine?</p></div>
                <div class=""> <input type="radio" name="drink_coffee_tea_or_red_wine" value="Yes"> Yes </div>
                <div class=""> <input type="radio" name="drink_coffee_tea_or_red_wine" value="No"> No </div>
                {{-- MEDICAL CONDIITONS LIKE DIABETES --}}
                <div class=""> <p class="">Do you have any medical conditions that affect your dental health (e.g., diabetes)?</p></div>
                <div class=""> <input type="text" placeholder="Specify if there's any" name="medical_conditions"> </div>
                {{-- ALLERGY --}}
                <div class=""> <p class="">Do you have any allergy?</p></div>
                <div class=""> <input type="text" placeholder="Specify if there's any" name="allergy"> </div>
                {{-- PREVIOUS PAGE --}}
                <button type="button" onclick="prevStep()">Previous</button>
                {{-- NEXT PAGE --}}
                <div class=""> <button class="" type="button" onclick="nextStep()">Next</button> </div>
                <div class=""> <label for="have_account">Already have an Account? <a href = "{{ route('login')}}">Login</a></label> </div>
            </div>

            {{-- THIRD PAGE --}}
            <div class="form-section" id="step3">
                <div class="marker">CREATE ACCOUNT</div>
                {{-- USERNAME --}}
                <div>
                    <div><label for="username">Username</label> </div>
                    <input type="text" placeholder="juandc02" name="username"> 
                    @error('username')
                    <span class="text-red-600">{{$message}}</span>
                    @enderror
                </div>
                {{-- PASSWORD --}}
                <div>
                    <div><label for="password">Password</label> </div>
                    <input type="text" placeholder="password" name="password"> 
                    @error('password')
                    <span class="text-red-600">{{$message}}</span>
                    @enderror
                </div>
                {{-- VERIFY PASSWORD --}}
                <div>
                    <div><label for="verify_password">Verify Password</label> </div>
                    <input type="text" placeholder="verify password" name="verify_password"> 
                    @error('password_confirmation')
                    <span class="text-red-600">{{$message}}</span>
                    @enderror
                </div>
                {{-- CHECKBOX FOR DATA COLLECTION --}}
                <div class=""> <input type="checkbox" name="agree_data_collection"> I agree to Whise Smile Dental Clinic's collection of personal and dental information</div>
                {{-- CHECKBOX FOR USER AGREEMENT AND PRIVACY POLICY --}}
                <div class=""> <input type="checkbox" name="agree_user_policy"> I have read and agree to Whise Smile Dental Clinic's user agreement and privacy policy</div>
                {{-- PREVIOUS PAGE --}}
                <button type="button" onclick="prevStep()">Previous</button>
                {{-- SUBMIT BUTTON --}}
                <div class=""> <button type="submit" class="">REGISTER</button> </div>
                <div class=""> <label for="have_account">Already have an Account? <a href = "{{route('login')}}">Login</a></label> </div>
            </div>
        </form>
    </div>

    <script>
        let currentStep = 1;

        function showStep(step) {
            const steps = document.querySelectorAll('.form-section');
            steps.forEach((section, index) => {
                section.classList.toggle('active', index === step - 1);
            });
        }

        function nextStep() {
            currentStep++;
            showStep(currentStep);
        }

        function prevStep() {
            currentStep--;
            showStep(currentStep);
        }

        document.addEventListener('DOMContentLoaded', () => {
            showStep(currentStep);
        });
    </script>
</body>
</html>
