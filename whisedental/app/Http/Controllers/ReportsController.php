<?php

namespace App\Http\Controllers;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Request;
use App\Models\Payment;

class ReportsController extends Controller
{
    //
    public function index(){
        return view("reports/index");
    }

    public function downloadReport($type)
    {
        // Determine the date range based on the report type
        
        $startDate = Carbon::now();
        $endDate = Carbon::now();

        switch ($type) {
            case 'day':
                $startDate = Carbon::today();
                $endDate = Carbon::today();
                $filename = 'report-day-' . $startDate->format('Ymd') . '.pdf';
                break;

            case 'week':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                $filename = 'report-week-' . $startDate->format('Ymd') . '-' . $endDate->format('Ymd') . '.pdf';
                break;

            case 'month':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                $filename = 'report-month-' . $startDate->format('Ym') . '.pdf';
                break;

            default:
                abort(404, 'Invalid report type');
        }

        // Load the view with the necessary data for the report
        $pdf = PDF::loadView('pdf.report', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            // Include any other data required for the report
        ]);

        // Return the PDF for download with the generated filename
        return $pdf->download($filename);
    }

    public function getIncome(Request $request)
    {
        $type = $request->input('type');
        $paym = Payment::with(['patient', 'patient.appointment'])->get();

        switch ($type) {
            case 'today':
                $date = Carbon::today();
                $income = Payment::whereDate('created_at', $date)->sum('debit');
                break;
            
            case 'week':
                $startOfWeek = Carbon::now()->startOfWeek();
                $income = Payment::whereBetween('created_at', [$startOfWeek, Carbon::now()])->sum('debit');
                break;

            case 'month':
                $startOfMonth = Carbon::now()->startOfMonth();
                $income = Payment::whereBetween('created_at', [$startOfMonth, Carbon::now()])->sum('debit');
                break;

            default:
                $income = 0;
                break;
        }

        return view('reports/income', compact('income', 'paym'));
    }

    
    // public function showIncomeView()
    // {
    //     return view('reports/income');
    // }
}
