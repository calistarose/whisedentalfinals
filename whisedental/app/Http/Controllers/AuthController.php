<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCode;
use PragmaRX\Google2FA\Google2FA;

class AuthController extends Controller
{
    // Constructor
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Register view
    public function register()
    {
        return view('auth/register');
    }

    // Save registration
    public function registerSave(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'last_name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z ]+$/'],
                'first_name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z ]+$/'],
                'middle_name' => ['nullable', 'string', 'max:255', 'regex:/^[A-Za-z ]+$/'],
                'suffix' => ['nullable', 'string', 'max:255', 'regex:/^[A-Za-z ]+$/'],
                'date_of_birth' => 'required|date',
                'gender' => 'required|string',
                'marital_status' => 'required|string|max:255',
                'home_address' => 'required|string|max:255',
                'contact_number' => ['required', 'string', 'max:11', 'regex:/^\d{11}$/'],
                'email_address' => 'required|email|max:255|unique:users,email_address|',
                'last_dentist_visit' => 'required|date',
                'had_cavities' => 'required',
                'have_tooth_sensitivity' => 'required',
                'grind_or_clench_teeth' => 'required',
                'had_oral_surgeries' => 'required',
                'had_braces_or_orthodontic_treatments' => 'required',
                'have_gum_disease' => 'required',
                'do_gums_bleed' => 'required',
                'gum_recession_or_gum_grafting' => 'required',
                'lost_teeth_due_to_decay_or_injury' => 'required',
                'have_dental_implants' => 'required',
                'have_crowns_bridges_or_dentures' => 'required',
                'brush_teeth_at_least_twice_a_day' => 'required',
                'floss_daily' => 'required',
                'taking_medications' => 'required',
                'consume_sugary_or_acidic_foods' => 'required',
                'is_smoking' => 'required',
                'drink_coffee_tea_or_red_wine' => 'required',
                'medical_conditions' => 'nullable|max:255',
                'allergy' => 'nullable|max:255',
                'username' => 'required|unique:users,username|alpha_dash|min:5|max:20',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'max:20',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[~!@#\$%\^&\*\(\)_\-+={}[\]|\\:;\'<>?,.\/])[A-Za-z\d@$!%*?&~!@#\$%\^&\*\(\)_\-+={}[\]|\\:;\'<>?,.\/]{8,20}$/',
                ],
                'verify_password' => 'required|same:password',
                'agree_data_collection' => 'accepted',
                'agree_user_policy' => 'accepted',
            ],
            [
                'last_name.required' => 'Last name is required.',
                'last_name.string' => 'Last name must be a string.',
                'last_name.max' => 'Last name should not exceed :max characters.',
                'last_name.regex' => 'Last name should only contain letters.',

                'first_name.required' => 'First name is required.',
                'first_name.string' => 'First name must be a string.',
                'first_name.max' => 'First name should not exceed :max characters.',
                'first_name.regex' => 'First name should only contain letters.',

                'middle_name.string' => 'Middle name must be a string.',
                'middle_name.max' => 'Middle name should not exceed :max characters.',
                'middle_name.regex' => 'Middle name should only contain letters.',

                'suffix.string' => 'Suffix must be a string.',
                'suffix.max' => 'Suffix should not exceed :max characters.',
                'suffix.regex' => 'Suffix should only contain letters.',

                'date_of_birth.required' => 'Date of birth is required.',

                'gender.required' => 'Gender is required.',

                'marital_status.required' => 'Marital status is required.',

                'home_address.required' => 'Home address is required.',

                'contact_number.required' => 'Contact number is required.',
                'contact_number.string' => 'Contact number must be a string.',
                'contact_number.max' => 'Contact number should not exceed :max characters.',
                'contact_number.regex' => 'Contact number should contain 11 digits.',

                'email_address.required' => 'Email address is required.',
                'email_address.email' => 'Please enter a valid email address.',
                'email_address.max' => 'Email address should not exceed :max characters.',
                'email_address.unique' => 'Email address is already in use.',

                'last_dentist_visit.required' => 'Last dentist visit is required.',

                'had_cavities.required' => 'This field is required.',
                'have_tooth_sensitivity.required' => 'This field is required.',
                'grind_or_clench_teeth.required' => 'This field is required.',
                'had_oral_surgeries.required' => 'This field is required.',
                'had_braces_or_orthodontic_treatments.required' => 'This field is required.',
                'have_gum_disease.required' => 'This field is required.',
                'do_gums_bleed.required' => 'This field is required.',
                'gum_recession_or_gum_grafting.required' => 'This field is required.',
                'lost_teeth_due_to_decay_or_injury.required' => 'This field is required.',
                'have_dental_implants.required' => 'This field is required.',
                'have_crowns_bridges_or_dentures.required' => 'This field is required.',
                'brush_teeth_at_least_twice_a_day.required' => 'This field is required.',
                'floss_daily.required' => 'This field is required.',
                'taking_medications.required' => 'This field is required.',
                'consume_sugary_or_acidic_foods.required' => 'This field is required.',
                'is_smoking.required' => 'This field is required.',
                'drink_coffee_tea_or_red_wine' => 'This field is required.',

                'medical_conditions.max' => 'Medical conditions should not exceed :max characters.',
                'allergy.max' => 'Allergies should not exceed :max characters.',

                'username.required' => 'Username is required.',
                'username.unique' => 'Username is already taken.',
                'username.alpha_dash' => 'Username should only contain letters, numbers, and underscores.',
                'username.min' => 'Username must be at least 5 characters long.',
                'username.max' => 'Username may not be greater than 20 characters.',

                'password.required' => 'Password is required.',
                'password.string' => 'Password must be a string.',
                'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character, and must be at least 8 characters long.',
                'password.min' => 'Password must be at least 8 characters long.',
                'password.max' => 'Password may not be greater than 20 characters.',

                'verify_password.required' => 'Please confirm your password.',
                'verify_password.same' => 'Passwords do not match.',

                'agree_data_collection.accepted' => 'You must agree to data collection.',
                'agree_user_policy.accepted' => 'You must agree to the user policy.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->route('register')
                ->withErrors($validator)
                ->withInput();
        }

        // Create user
        $user = User::create([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'contact_number' => $request->contact_number,
            'email_address' => $request->email_address,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'type' => "0" // Update this to "admin" for admin users
        ]);

        // Create patient
        Patient::create([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'suffix' => $request->suffix,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'marital_status' => $request->marital_status,
            'home_address' => $request->home_address,
            'contact_number' => $request->contact_number,
            'email_address' => $request->email_address,
            'last_dentist_visit' => $request->last_dentist_visit,
            'had_cavities' => $request->had_cavities,
            'have_tooth_sensitivity' => $request->have_tooth_sensitivity,
            'grind_or_clench_teeth' => $request->grind_or_clench_teeth,
            'had_oral_surgeries' => $request->had_oral_surgeries,
            'had_braces_or_orthodontic_treatments' => $request->had_braces_or_orthodontic_treatments,
            'have_gum_disease' => $request->have_gum_disease,
            'do_gums_bleed' => $request->do_gums_bleed,
            'gum_recession_or_gum_grafting' => $request->gum_recession_or_gum_grafting,
            'lost_teeth_due_to_decay_or_injury' => $request->lost_teeth_due_to_decay_or_injury,
            'have_dental_implants' => $request->have_dental_implants,
            'have_crowns_bridges_or_dentures' => $request->have_crowns_bridges_or_dentures,
            'brush_teeth_at_least_twice_a_day' => $request->brush_teeth_at_least_twice_a_day,
            'floss_daily' => $request->floss_daily,
            'taking_medications' => $request->taking_medications,
            'consume_sugary_or_acidic_foods' => $request->consume_sugary_or_acidic_foods,
            'is_smoking' => $request->is_smoking,
            'drink_coffee_tea_or_red_wine' => $request->drink_coffee_tea_or_red_wine,
            'medical_conditions' => $request->medical_conditions,
            'allergy' => $request->allergy,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'user_id' => $user->id
        ]);

        return redirect()->route('login');
    }

    // Login view
    public function login()
    {
        return view('auth/login');
    }

    // Generate OTP
    // public static function generateOTP($length = 6)
    // {
    //     $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //     $otp = '';

    //     for ($i = 0; $i < $length; $i++) {
    //         $otp .= $chars[rand(0, strlen($chars) - 1)];
    //     }

    //     return $otp;
    // }

    // Handle login action
    public function loginAction(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required',
                'password' => 'required',
            ],
            [
                'username.required' => 'Username is required.',
                'password.required' => 'Password is required.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput();
        }

        if (!Auth::attempt($request->only('username', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'username' => trans('auth.failed')
            ]);
        }

        $request->session()->regenerate();

        if (auth()->user()->type == 'admin') {
            return redirect()->route('admin/home');
        } else {
            return redirect()->route('home');
        }

        // $user = Auth::user();

        // $google2fa = app(Google2FA::class);
        // $otpSecret = $google2fa->generateSecretKey();
        // $user->google2fa_secret = $otpSecret;
        // $user->save();

        // $otp = self::generateOTP();
        // $email = $user->email_address;
        // Mail::to($email)->send(new TwoFactorCode($otp));

        // return redirect()->route('enter_otp')->with('userType', $user->type);
    }

    // OTP view
    // public function enter_otp()
    // {
    //     return view('auth/enter_otp');
    // }

    // Verify 2FA
    // public function verify2FA(Request $request)
    // {
    //     $request->validate([
    //         'otp' => ['required', 'string', 'alpha_num'],
    //     ]);

    //     $google2fa = app(Google2FA::class);
    //     $isValid = $google2fa->verifyKey(Auth::user()->google2fa_secret, $request->otp);

    //     if (!$isValid) {
    //         return redirect()->back()->with('error', 'Invalid OTP. Please try again.');
    //     }

    //      Auth::login($user);

    //     if ($user->type === 'admin') {
    //         return redirect()->route('admin/home');
    //     } else {
    //         return redirect()->route('home');
    //     }
    // }

        // if (auth()->user()->type == 'admin') {
        //     return redirect()->route('dashboard');
        // } else {
        //     return redirect()->route('home');
        // }

        // return redirect()->route('home');

    


    // Logout
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        return redirect('/login');
    }
}