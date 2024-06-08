<?php

namespace App\Http\Controllers;
use App\Models\Patient;

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

        // // Fetch the patient record associated with the authenticated user
        $patients = $user->patients;
        return view('home',compact('patients'));

        //return view('home');
    }

    //admin home
    public function adminHome()
    {
        return view('adminHome');
    }
}
