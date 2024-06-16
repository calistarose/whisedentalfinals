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
            // $table->string('google2fa_secret')->nullable()->after('password');
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
