<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            // $table->id();
            // $table->string('name');
            // $table->string('email')->unique();
            // $table->timestamp('email_verified_at')->nullable();
            // $table->string('password');
            // $table->rememberToken();
            // $table->timestamps();

            $table->id();
            $table->string('last_name');
            $table->string('first_name');
            $table->string('contact_number');
            $table->string('email_address')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->boolean('type')->default(false); //add type boolean Users: 0->User, 1->admin
            $table->timestamps();
        });

        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('marital_status');
            $table->string('home_address');
            $table->string('contact_number');
            $table->string('email_address')->unique();
            $table->date('last_dentist_visit');
            $table->string('had_cavities');
            $table->string('have_tooth_sensitivity');
            $table->string('grind_or_clench_teeth');
            $table->string('had_oral_surgeries');
            $table->string('had_braces_or_orthodontic_treatments');
            $table->string('have_gum_disease');
            $table->string('do_gums_bleed');
            $table->string('gum_recession_or_gum_grafting');
            $table->string('lost_teeth_due_to_decay_or_injury');
            $table->string('have_dental_implants');
            $table->string('have_crowns_bridges_or_dentures');
            $table->string('brush_teeth_at_least_twice_a_day');
            $table->string('floss_daily');
            $table->string('taking_medications');
            $table->string('consume_sugary_or_acidic_foods');
            $table->string('is_smoking');
            $table->string('drink_coffee_tea_or_red_wine');
            $table->text('medical_conditions')->nullable();
            $table->text('allergy')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
