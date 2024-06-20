<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'debit',
        'credit',
        'balance',
        'patient_id',
        'appointment_id',
        'payment_method',
        'type_of_appointment',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Example of generating a formatted patient_id (e.g., P000000001)
            $lastpayment = static::orderBy('created_at', 'desc')->first();

            if ($lastpayment) {
                $model->payment_id = 'R' . str_pad((int) substr($lastpayment->payment_id, 1) + 1, 5, '0', STR_PAD_LEFT);
            } else {
                $model->payment_id = 'R00001'; // Initial payment_id if table is empty
            }
        });
    }

    /**
     * Define the relationship with Patient model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
