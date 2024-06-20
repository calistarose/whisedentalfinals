<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with('patient')->get();
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::all();
        return view('appointments.create', compact('patients'));
    }

    public function availableTimes(Request $request)
    {
        $date = $request->query('date');
        $startOfDay = Carbon::parse($date)->startOfDay();
        $endOfDay = Carbon::parse($date)->endOfDay();

        $takenTimes = Appointment::whereBetween('start_datetime', [$startOfDay, $endOfDay])
            ->pluck('start_datetime')
            ->map(function ($datetime) {
                return Carbon::parse($datetime)->format('H:i');
            })
            ->toArray();

        $availableTimes = [];
        for ($hour = 8; $hour <= 16; $hour++) {
            $time = sprintf('%02d:00', $hour);
            if (!in_array($time, $takenTimes)) {
                $availableTimes[] = $time;
            }
        }

        return response()->json($availableTimes);
    }

    public function store(Request $request)
    {
        // Validate the input fields
        $request->validate([
            'type_of_appointment' => 'required',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
        ]);

        // If the user is an admin, allow them to select different patients
        if (Auth::user()->type === 'admin') {
            $request->validate([
                'patient_id' => 'required',
            ]);
            $patientId = $request->input('patient_id');
            $redirectRoute = 'appointments.index';
        } else {
            // For regular users, automatically fill in the patient ID based on the authenticated user
            $patientId = Auth::user()->patients->id ?? null;
            if (!$patientId) {
                return redirect()->back()->withErrors(['error' => 'No associated patient record found for the user.']);
            }
            $redirectRoute = 'home';
        }

        // Check for conflicting appointments
        $start = Carbon::parse($request->start_datetime);
        $end = Carbon::parse($request->end_datetime);
        $conflictingAppointment = Appointment::where(function ($query) use ($start, $end) {
            $query->whereBetween('start_datetime', [$start, $end])
                ->orWhereBetween('end_datetime', [$start, $end]);
        })->exists();

        if ($conflictingAppointment) {
            return redirect()->back()->withErrors(['error' => 'The selected time conflicts with an existing appointment. Please choose a different time.']);
        }

        // Create the appointment
        Appointment::create([
            'type_of_appointment' => $request->type_of_appointment,
            'start_datetime' => $request->start_datetime,
            'end_datetime' => $request->end_datetime,
            'patient_id' => $patientId,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route($redirectRoute)->with('success', 'Appointment created successfully.');
    }

    public function cancel(Request $request, $id)
    {
        $appointment = Appointment::find($id);
        if (!$appointment) {
            return response()->json(['success' => false, 'message' => 'Appointment not found.']);
        }

        if (Carbon::now()->lt($appointment->end_datetime)) {
            $appointment->delete();
            return response()->json(['success' => true, 'message' => 'Appointment cancelled successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'This appointment cannot be cancelled as its end time has already passed.']);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $appointment = Appointment::find($id);
        if (!$appointment) {
            return response()->json(['success' => false, 'message' => 'Appointment not found.'], 404);
        }

        try {
            $appointment->status = $request->status;
            $appointment->save();

            return response()->json(['success' => true, 'message' => 'Appointment status updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while updating the appointment status.'], 500);
        }
    }
    
    
}
