<?php

namespace App\Http\Controllers;

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
        return view('home');
    }

    //admin home
    public function adminHome()
    {
        return view('adminHome');
    }
}
