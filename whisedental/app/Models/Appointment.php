<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'type_of_appointment', 
        'start_datetime', 
        'end_datetime', 
        'patient_id'];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            
            $lastappointment = static::orderBy('created_at', 'desc')->first();

            if ($lastappointment) {
                $model->appointment_id = 'A' . str_pad((int) substr($lastappointment->appointment_id, 1) + 1, 5, '0', STR_PAD_LEFT);
            } else {
                $model->appointment_id = 'A00001'; // Initial appointment_id if table is empty
            }
        });
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
