<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'brand',
        'supplier',
        'quantity',
        'date_expired',  
        'date_restocked' 
    ];

    protected static function boot()
        {
            parent::boot();
    
            static::creating(function ($model) {
                // Example of generating a formatted patient_id (e.g., P000000001)
                $lastinventory = static::orderBy('created_at', 'desc')->first();
    
                if ($lastinventory) {
                    $model->inventory_id = 'I' . str_pad((int) substr($lastinventory->inventory_id, 1) + 1, 9, '0', STR_PAD_LEFT);
                } else {
                    $model->inventory_id = 'I00001'; // Initial inventory_id if table is empty
                }
            });
        }
}
