<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'date_of_birth',
        'gender',
        'marital_status',
        'home_address',
        'contact_number',
        'email_address',
        'last_dentist_visit',
        'had_cavities',
        'have_tooth_sensitivity',
        'grind_or_clench_teeth',
        'had_oral_surgeries',
        'had_braces_or_orthodontic_treatments',
        'have_gum_disease',
        'do_gums_bleed',
        'gum_recession_or_gum_grafting',
        'lost_teeth_due_to_decay_or_injury',
        'have_dental_implants',
        'have_crowns_bridges_or_dentures',
        'brush_teeth_at_least_twice_a_day',
        'floss_daily',
        'taking_medications',
        'consume_sugary_or_acidic_foods',
        'is_smoking',
        'drink_coffee_tea_or_red_wine',
        'medical_conditions',
        'allergy' ,
        'username' ,
        'password'
];
}
