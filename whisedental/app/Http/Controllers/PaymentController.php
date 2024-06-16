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
        // Fetch all patients
        $patients = Patient::all();

        // Fetch payments with patient information
        $payments = Payment::with('patient')->get();

        // Fetch appointments with patient information
        $appointments = Appointment::with('patient')->get();

        return view('payment.index', compact('patients', 'payments', 'appointments'));
    }

    public function create()
    {
        $patients = Patient::all();
        return view('payment.create', compact('patients'));
    }

    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_type' => 'required|string',
            'payment_method' => 'required|string',
            'debit' => 'required|numeric',
            'credit' => 'required|numeric',
        ]);

        // Calculate balance
        $debit = $request->input('debit');
        $credit = $request->input('credit');
        $balance = $credit - $debit;

        // Create new payment record
        $payment = Payment::create([
            'patient_id' => $request->input('patient_id'),
            'appointment_type' => $request->input('appointment_type'),
            'payment_method' => $request->input('payment_method'),
            'debit' => $debit,
            'credit' => $credit,
            'balance' => $balance,
        ]);

        // Send payment receipt email
        try {
            Mail::to($payment->patient->email)->send(new ReceiptEmail($payment));
        } catch (\Exception $e) {
            \Log::error('Failed to send receipt email: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to send receipt email.');
        }

        // Redirect back with success message
        return redirect()->route('payments/index')->with('success', 'Payment created successfully.');
    }
}
