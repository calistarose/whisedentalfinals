<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Inventory;

class MaintenanceController extends Controller
{
    //
    public function index(){
    
        // $inventory = Inventory::all();
        // return view('maintenance.maintenanceHome', compact('inventory'));
        return view("maintenance.maintenanceHome");
    }
}
