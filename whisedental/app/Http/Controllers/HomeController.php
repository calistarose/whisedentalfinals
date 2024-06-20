<?php

namespace App\Http\Controllers;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\Appointment;
use Illuminate\Support\Carbon;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //autheticate user
    public function __construct()
    {
        $this->middleware('auth');
    }
    //user home
    public function index(){
        
        $user = auth()->user();

        $patients = $user->patients;

        $payments = Payment::whereIn('patient_id', $patients->pluck('id'))->get();

        // Initialize total balance
        $total_balance = 0;

        // Calculate total balance for the authenticated user
        foreach ($payments as $payment) {
            $total_balance += $payment->credit - $payment->debit;
            $payment->balance = $total_balance;
        }

        return view('home', compact('patients', 'payments', 'total_balance'));
    }

    //admin home
    public function adminHome()
    {
        $today = Carbon::today();

        // Count appointments for today
        $appointmentsCount = Appointment::whereDate('start_datetime', $today)->count();

        return view('adminHome', compact('appointmentsCount'));
    }
}