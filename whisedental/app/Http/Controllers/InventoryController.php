<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $inventory = Inventory::orderBy('created_at','ASC')->get();

        return view('inventory.index', compact('inventory'));
        //return view('inventory.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('inventory.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make(
            $request->all(),
            [
                'product_name' => 'required',
                'brand' => 'required',
                'supplier' => 'required',
                'quantity' => 'required',
                'date_expired' => 'required',  
                'date_restocked' => 'required',
            ],
            [
                'product_name.required' => 'Product name is required.',
                'brand.required' => 'Brand is required.',
                'supplier.required' => 'Supplier is required.',
                'quantity.required' => 'Quantity is required.',
                'date_expired.required' => 'Date expired is required.',
                'date_restocked.required' => 'Date restocked is required.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->route('admin/inventory/create')
                ->withErrors($validator)
                ->withInput();
        }
 
        Inventory::create($request->all());
        return redirect()->route('admin/inventory')->with('success', 'Product added successfully');
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $inventory = Inventory::findOrFail($id);

        return view('inventory.edit', compact('inventory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $inventory = Inventory::findOrFail($id);

        $validator = Validator::make(
            $request->all(),
            [
                'product_name' => 'required',
                'brand' => 'required',
                'supplier' => 'required',
                'quantity' => 'required',
                'date_expired' => 'required',  
                'date_restocked' => 'required',
            ],
            [
                'product_name.required' => 'Product name is required.',
                'brand.required' => 'Brand is required.',
                'supplier.required' => 'Supplier is required.',
                'quantity.required' => 'Quantity is required.',
                'date_expired.required' => 'Date expired is required.',
                'date_restocked.required' => 'Date restocked is required.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->route('admin/inventory/edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $inventory->update($request->all());

        return redirect()->route('admin/inventory')->with('success','product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     //
    // }
}
