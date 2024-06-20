<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReceiptEmail;

class PaymentController extends Controller
{
    public function index()
    {
        // Fetch payments with patient and appointment information
        $payments = Payment::with(['patient', 'patient.appointment'])->get();

        return view('payment.index', compact('payments'));
    }
    public function create()
    {
        // Fetch all patients
        $patients = Patient::all();

        // Initialize an array to store latest appointment types
        $latestAppointmentTypes = [];

        // Loop through each patient to fetch their latest appointment type
        foreach ($patients as $patient) {
            // Fetch the latest appointment type for the current patient
            $latestAppointmentType = Appointment::where('patient_id', $patient->id)
                                                ->latest()
                                                ->value('type_of_appointment');

            // Store the latest appointment type in the array
            $latestAppointmentTypes[$patient->id] = $latestAppointmentType;
        }

        return view('payment.create', [
            'patients' => $patients,
            'latestAppointmentTypes' => $latestAppointmentTypes,
        ]);
    }

    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'payment_method' => 'required|string',
            'debit' => 'required|numeric',
            'credit' => 'required|numeric',
            'type_of_appointment'=>'required'
        ]);

        // Calculate balance
        $debit = $request->input('debit');
        $credit = $request->input('credit');
        $balance = $credit - $debit;

        // Create new payment record
        $payment = Payment::create([
            'patient_id' => $request->input('patient_id'),
            'payment_method' => $request->input('payment_method'),
            'type_of_appointment'=>$request->input('type_of_appointment'),
            'debit' => $debit,
            'credit' => $credit,
            'balance' => $balance,
        ]);

        // Send payment receipt email
        try {
            Mail::to($payment->patient->email_address)->send(new ReceiptEmail($payment));
        } catch (\Exception $e) {
            \Log::error('Failed to send receipt email: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to send receipt email.');
        }

        // Redirect back with success message
        return redirect()->route('payments/home')->with('success', 'Payment created successfully.');
    }
}
