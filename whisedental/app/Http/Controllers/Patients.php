<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Validator;
use App\Models\Payment;

class Patients extends Controller
{
    //
    public function index()
    {
        //
        $patient = Patient::orderBy('created_at','ASC')->get();

        return view('patient/index', compact('patient'));

    }

    public function show(string $id)
    {
        $patient = Patient::findOrFail($id);

        $payment = Payment::where('patient_id', $patient->id)->get();

        // Initialize total balance
        $total_balance = 0;

        // Calculate total balance for the authenticated user
        foreach ($payment as $pay) {
            $total_balance += $pay->credit - $pay->debit;
            $pay->balance = $total_balance;
        }

        return view('patient/show', compact('patient', 'payment', 'total_balance'));
    }

    public function edit(string $id)
    {
        //
        $patient = Patient::findOrFail($id);

        return view('patient/edit', compact('patient'));
    }

    public function update(Request $request, string $id)
    {
        //
        $Patient = Patient::findOrFail($id);

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
            ]

            );
        if ($validator->fails()) {
            return redirect()->route('patient/edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $Patient->update($request->all());

        return redirect()->route('patient')->with('success','product updated successfully');
    }

    public function search(Request $request){
        $query = $request->input('query');

        // Search logic
        $patient = Patient::where('patient_id', 'like', "%$query%")
                            ->orWhere('first_name', 'like', "%$query%")
                            ->orWhere('middle_name', 'like', "%$query%")
                            ->orWhere('last_name', 'like', "%$query%")
                            ->get();

        return view('patient.index', compact('patient'));
    }

    public function addPatient()
    {
        return view('auth/register');
    }

}

