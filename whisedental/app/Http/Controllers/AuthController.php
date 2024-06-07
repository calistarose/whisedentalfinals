<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //logout
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
 
    //redirect to register
    public function register()
    {
        return view('auth/register');
    }

    //patient info and required
    public function registerSave(Request $request){
        Validator::make($request->all(), [
            'last_name' => 'required',
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'date_of_birth' => 'required|date',
            'gender' => 'required',
            'marital_status' => 'required',
            'home_address' => 'required',
            'contact_number' => 'required',
            'email_address' => 'required|email',
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
            'medical_conditions' => 'nullable',
            'allergy' => 'nullable',
            'username' => 'required',
            'password' => 'required|confirmed',
        ])->validate();

        //patient table info
        Patient::create([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
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
            'is_smoking' =>$request->is_smoking,
            'drink_coffee_tea_or_red_wine' => $request->drink_coffee_tea_or_red_wine,
            'medical_conditions' => $request->medical_conditions,
            'allergy' => $request->allergy,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);

        //user table info
        User::create([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'contact_number' => $request->contact_number,
            'email_address' => $request->email_address,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'type' => "0"
        ]);

        return redirect()->route('login');
    }

    public function login(){
        return view('auth/login');
    }

    //validate if user is in database
    public function loginAction(Request $request)
    {
        Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ])->validate();
 
        if (!Auth::attempt($request->only('username', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'username' => trans('auth.failed')
            ]);
        }

        //level of access
        $request->session()->regenerate();
 
        if (auth()->user()->type == 'admin') {
            return redirect()->route('admin/home');
        } else {
            return redirect()->route('home');
        }
         
    }

    //logout
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
 
        $request->session()->invalidate();
 
        return redirect('/login');
    }

}
