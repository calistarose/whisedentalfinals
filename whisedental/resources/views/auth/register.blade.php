<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/styles.css')}}">
    <title>Whise Dental Clinic</title>
    <style>
        .error { color: red; }
    </style>
</head>
<body>
    {{-- HEADER FOR REGISTRATION --}}
    @include('partials.registrationHeader')

    <div class="form-container">
        <form method="POST" action="{{ route('register.save') }}" id="multi-step-form">
            @csrf
            @method('post')
            <!-- @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif -->
            {{-- FIRST PAGE --}}
            <div class="form-section active" id="step1">
                <div class="marker">PERSONAL INFORMATION</div>
                {{-- LAST NAME --}}
                <div class=""> <label for="last_name">Last Name</label> </div>
                <div class=""> <input type="text" placeholder="Dela Cruz" name="last_name" value="{{ old('last_name') }}"> </div>
                @if ($errors->has('last_name'))
                    <div class="error">
                        {{ $errors->first('last_name') }}
                    </div>
                @endif
                {{-- FIRST NAME --}}
                <div class=""> <label for="first_name">First Name</label> </div>
                <div class=""> <input type="text" placeholder="Juan" name="first_name" value="{{ old('first_name') }}"> </div>
                @error('first_name')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- MIDDLE NAME --}}
                <div class=""> <label for="middle_name">Middle Name</label> </div>
                <div class=""> <input type="text" placeholder="Carlos" name="middle_name" value="{{ old('middle_name') }}"> </div>
                @error('middle_name')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- SUFFIX --}}
                <div class=""> <label for="suffix">Suffix</label> </div>
                <div class=""> <input type="text" placeholder="Jr" name="suffix" value="{{ old('suffix') }}"> </div>
                @error('suffix')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- DATE OF BIRTH --}}
                <div class=""> <label for="date_of_birth">Date of Birth</label> </div>
                <div class=""> <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"> </div>
                @error('date_of_birth')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- GENDER --}}
                <div class=""> <label for="gender">Gender</label> </div>
                <div class="">
                    <select class="" name="gender">
                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
                @error('gender')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- MARITAL STATUS --}}
                <div class=""> <label for="marital_status">Marital Status</label> </div>
                <div class="">
                    <select class="" name="marital_status">
                    <option value="Single" {{ old('marital_status') == 'Single' ? 'selected' : '' }}>Single</option>
                    <option value="Married" {{ old('marital_status') == 'Married' ? 'selected' : '' }}>Married</option>
                    <option value="Separated" {{ old('marital_status') == 'Separated' ? 'selected' : '' }}>Separated</option>
                    <option value="Widowed" {{ old('marital_status') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                </select>
                    </select>
                </div>
                @error('marital_status')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- HOME ADDRESS --}}
                <div class=""> <label for="home_address">Home Address</label> </div>
                <div class=""> <input type="text" placeholder="#123 Notre Dame, Aurora Blvd., Cubao, QC" name="home_address" value="{{ old('home_address') }}"> </div>
                @error('home_address')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- CONTACT NUMBER --}}
                <div class=""> <label for="contact_number">Contact Number</label> </div>
                <div class=""> <input type="text" placeholder="09123456789" name="contact_number" value="{{ old('contact_number') }}"> </div>
                @error('contact_number')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- EMAIL ADDRESS --}}
                <div class=""> <label for="email_address">Email Address</label> </div>
                <div class=""> <input type="text" placeholder="juandelacruz.7@gmail.com" name="email_address" value="{{ old('email_address') }}"> </div>
                @error('email_address')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- NEXT PAGE --}}
                <div class=""> <button class="" type="button" onclick="nextStep()">Next</button> </div>
                <div class=""> <label for="have_account">Already have an Account? <a href = "{{ route('login')}}">Login</a></label> </div>
            </div>
            
            {{-- SECOND PAGE --}}
            <div class="form-section" id="step2">
                <div class="marker">DENTAL INFORMATION & HISTORY</div>
                {{-- LAST DENTIST VISIT --}}
                <div class=""> <label for="last_dentist_visit">Last Dentist Visit</label> </div>
                <div class=""> <input type="date" name="last_dentist_visit" value="{{ old('last_dentist_visit') }}"> </div>
                @error('last_dentist_visit')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- HAD CAVITIES --}}
                <div class=""> <p class="">Have you ever had cavities?</p></div>
                <div class=""> <input type="radio" name="had_cavities" value="Yes" {{ old('had_cavities') == 'Yes' ? 'checked' : '' }}> Yes </div>
                <div class=""> <input type="radio" name="had_cavities" value="No" {{ old('had_cavities') == 'No' ? 'checked' : '' }}> No </div>
                @error('had_cavities')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- HAVE TOOTH SENSITIVITY --}}
                <div class=""> <p class="">Have you experienced tooth sensitivity?</p></div>
                <div class=""> <input type="radio" name="have_tooth_sensitivity" value="Yes" {{ old('have_tooth_sensitivity') == 'Yes' ? 'checked' : '' }}> Yes </div>
                <div class=""> <input type="radio" name="have_tooth_sensitivity" value="No" {{ old('have_tooth_sensitivity') == 'No' ? 'checked' : '' }}> No </div>
                @error('have_tooth_sensitivity')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- GRIND OR CLENCH TEETH --}}
                <div class=""> <p class="">Do you grind or clench your teeth?</p></div>
                <div class=""> <input type="radio" name="grind_or_clench_teeth" value="Yes" {{ old('grind_or_clench_teeth') == 'Yes' ? 'checked' : '' }}> Yes </div>
                <div class=""> <input type="radio" name="grind_or_clench_teeth" value="No" {{ old('grind_or_clench_teeth') == 'No' ? 'checked' : '' }}> No </div>
                @error('grind_or_clench_teeth')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- HAD ORAL SURGERIES --}}
                <div class=""> <p class="">Have you had any oral surgeries?</p></div>
                <div class=""> <input type="radio" name="had_oral_surgeries" value="Yes" {{ old('had_oral_surgeries') == 'Yes' ? 'checked' : '' }}> Yes </div>
                <div class=""> <input type="radio" name="had_oral_surgeries" value="No" {{ old('had_oral_surgeries') == 'No' ? 'checked' : '' }}> No </div>
                @error('had_oral_surgeries')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- HAD BRACES OR OTHER ORTHODONTIC TREATMENTS --}}
                <div class=""> <p class="">Have you ever had braces or other orthodontic treatments?</p></div>
                <div class=""> <input type="radio" name="had_braces_or_orthodontic_treatments" value="Yes" {{ old('had_braces_or_orthodontic_treatments') == 'Yes' ? 'checked' : '' }}> Yes </div>
                <div class=""> <input type="radio" name="had_braces_or_orthodontic_treatments" value="No" {{ old('had_braces_or_orthodontic_treatments') == 'No' ? 'checked' : '' }}> No </div>
                @error('had_braces_or_orthodontic_treatments')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- HAVE GUM DISEASE --}}
                <div class=""> <p class="">Have you been diagnosed with gum disease (periodontitis)?</p></div>
                <div class=""> <input type="radio" name="have_gum_disease" value="Yes" {{ old('have_gum_disease') == 'Yes' ? 'checked' : '' }}> Yes </div>
                <div class=""> <input type="radio" name="have_gum_disease" value="No" {{ old('have_gum_disease') == 'No' ? 'checked' : '' }}> No </div>
                @error('have_gum_disease')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- DO GUMS BLEED --}}
                <div class=""> <p class="">Do your gums bleed when you brush or floss?</p></div>
                <div class=""> <input type="radio" name="do_gums_bleed" value="Yes" {{ old('do_gums_bleed') == 'Yes' ? 'checked' : '' }}> Yes </div>
                <div class=""> <input type="radio" name="do_gums_bleed" value="No" {{ old('do_gums_bleed') == 'No' ? 'checked' : '' }}> No </div>
                @error('do_gums_bleed')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- GUM RECESSION OR GUM GRAFTING --}}
                <div class=""> <p class="">Have you ever been treated for gum recession or gum grafting?</p></div>
                <div class=""> <input type="radio" name="gum_recession_or_gum_grafting" value="Yes" {{ old('gum_recession_or_gum_grafting') == 'Yes' ? 'checked' : '' }}> Yes </div>
                <div class=""> <input type="radio" name="gum_recession_or_gum_grafting" value="No" {{ old('gum_recession_or_gum_grafting') == 'No' ? 'checked' : '' }}> No </div>
                @error('gum_recession_or_gum_grafting')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- LOST TEETH DUE TO DECAY OR INJURY --}}
                <div class=""> <p class="">Have you lost any teeth due to decay or injury?</p></div>
                <div class=""> <input type="radio" name="lost_teeth_due_to_decay_or_injury" value="Yes" {{ old('lost_teeth_due_to_decay_or_injury') == 'Yes' ? 'checked' : '' }}> Yes </div>
                <div class=""> <input type="radio" name="lost_teeth_due_to_decay_or_injury" value="No"{{ old('lost_teeth_due_to_decay_or_injury') == 'No' ? 'checked' : '' }}> No </div>
                @error('lost_teeth_due_to_decay_or_injury')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- HAVE DENTAL IMPLANTS --}}
                <div class=""> <p class="">Have you received dental implants?</p></div>
                <div class=""> <input type="radio" name="have_dental_implants" value="Yes" {{ old('have_dental_implants') == 'Yes' ? 'checked' : '' }}> Yes </div>
                <div class=""> <input type="radio" name="have_dental_implants" value="No" {{ old('have_dental_implants') == 'No' ? 'checked' : '' }}> No </div>
                @error('have_dental_implants')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- HAVE CROWNS, BRIDGES, OR DENTURES --}}
                <div class=""> <p class="">Do you have any crowns, bridges, or dentures?</p></div>
                <div class=""> <input type="radio" name="have_crowns_bridges_or_dentures" value="Yes" {{ old('have_crowns_bridges_or_dentures') == 'Yes' ? 'checked' : '' }}> Yes </div>
                <div class=""> <input type="radio" name="have_crowns_bridges_or_dentures" value="No" {{ old('have_crowns_bridges_or_dentures') == 'No' ? 'checked' : '' }}> No </div>
                @error('have_crowns_bridges_or_dentures')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- BRUSH TEETH AT LEAST TWICE A DAY --}}
                <div class=""> <p class="">Do you brush your teeth at least twice a day?</p></div>
                <div class=""> <input type="radio" name="brush_teeth_at_least_twice_a_day" value="Yes" {{ old('brush_teeth_at_least_twice_a_day') == 'Yes' ? 'checked' : '' }}> Yes </div>
                <div class=""> <input type="radio" name="brush_teeth_at_least_twice_a_day" value="No" {{ old('brush_teeth_at_least_twice_a_day') == 'No' ? 'checked' : '' }}> No </div>
                @error('brush_teeth_at_least_twice_a_day')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- FLOSS DAILY --}}
                <div class=""> <p class="">Do you floss daily?</p></div>
                <div class=""> <input type="radio" name="floss_daily" value="Yes" {{ old('floss_daily') == 'Yes' ? 'checked' : '' }}> Yes </div>
                <div class=""> <input type="radio" name="floss_daily" value="No" {{ old('floss_daily') == 'No' ? 'checked' : '' }}> No </div>
                @error('floss_daily')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- TAKING MEDICATIONS --}}
                <div class=""> <p class="">Are you taking any medications that may affect your oral health or cause dry mouth?</p></div>
                <div class=""> <input type="radio" name="taking_medications" value="Yes" {{ old('taking_medications') == 'Yes' ? 'checked' : '' }}> Yes </div>
                <div class=""> <input type="radio" name="taking_medications" value="No" {{ old('taking_medications') == 'No' ? 'checked' : '' }}> No </div>
                @error('taking_medications')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- CONSUME SUGARY OR ACIDIC FOODS --}}
                <div class=""> <p class="">Do you consume sugary or acidic foods/beverages frequently?</p></div>
                <div class=""> <input type="radio" name="consume_sugary_or_acidic_foods" value="Yes" {{ old('consume_sugary_or_acidic_foods') == 'Yes' ? 'checked' : '' }}> Yes </div>
                <div class=""> <input type="radio" name="consume_sugary_or_acidic_foods" value="No" {{ old('consume_sugary_or_acidic_foods') == 'No' ? 'checked' : '' }}> No </div>
                @error('consume_sugary_or_acidic_foods')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- IS SMOKING  --}}
                <div class=""> <p class="">Do you smoke or use tobacco products?</p></div>
                <div class=""> <input type="radio" name="is_smoking" value="Yes" {{ old('is_smoking') == 'Yes' ? 'checked' : '' }}> Yes </div>
                <div class=""> <input type="radio" name="is_smoking" value="No" {{ old('is_smoking') == 'No' ? 'checked' : '' }}> No </div>
                @error('is_smoking')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- DRINK COFFEE, TEA, OR RED WINE --}}
                <div class=""> <p class="">Do you regularly drink coffee, tea, or red wine?</p></div>
                <div class=""> <input type="radio" name="drink_coffee_tea_or_red_wine" value="Yes" {{ old('drink_coffee_tea_or_red_wine') == 'Yes' ? 'checked' : '' }}> Yes </div>
                <div class=""> <input type="radio" name="drink_coffee_tea_or_red_wine" value="No" {{ old('drink_coffee_tea_or_red_wine') == 'No' ? 'checked' : '' }}> No </div>
                @error('drink_coffee_tea_or_red_wine')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- MEDICAL CONDIITONS LIKE DIABETES --}}
                <div class=""> <p class="">Do you have any medical conditions that affect your dental health (e.g., diabetes)?</p></div>
                <div class=""> <input type="text" placeholder="Specify if there's any" name="medical_conditions" value="{{ old('medical_conditions') }}"> </div>
                @error('medical_conditions')
                    <span class="error">{{ $message }}</span>
                @enderror
                {{-- ALLERGY --}}
                <div class=""> <p class="">Do you have any allergy?</p></div>
                <div class=""> <input type="text" placeholder="Specify if there's any" name="allergy" value="{{ old('allergy') }}"> </div>
                @error('allergy')
                    <span class="error">{{ $message }}</span>
                @enderror
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
                    <input type="text" placeholder="juandc02" name="username" value="{{ old('username') }}"> 
                </div>
                @error('username')
                        <span class="error">{{ $message }}</span>
                @enderror
                {{-- PASSWORD --}}
                <div>
                    <div><label for="password">Password</label> </div>
                    <input type="text" placeholder="password" name="password"> 
                </div>
                @error('password')
                        <span class="error">{{ $message }}</span>
                @enderror
                {{-- VERIFY PASSWORD --}}
                <div>
                    <div><label for="verify_password">Verify Password</label> </div>
                    <input type="text" placeholder="verify password" name="verify_password"> 
                </div>
                @error('verify_password')
                        <span class="error">{{ $message }}</span>
                @enderror
                {{-- CHECKBOX FOR DATA COLLECTION --}}
                <div class=""> <input type="checkbox" name="agree_data_collection" {{ old('agree_data_collection') ? 'checked' : '' }}>
                I agree to Whise Smile Dental Clinic's collection of personal and dental information</div>
                @error('agree_data_collection')
                        <span class="error">{{ $message }}</span>
                @enderror
                {{-- CHECKBOX FOR USER AGREEMENT AND PRIVACY POLICY --}}
                <div class=""> <input type="checkbox" name="agree_user_policy" {{ old('agree_user_policy') ? 'checked' : '' }}> 
                I have read and agree to Whise Smile Dental Clinic's user agreement and privacy policy</div>
                @error('agree_user_policy')
                        <span class="error">{{ $message }}</span>
                @enderror
                <br>
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