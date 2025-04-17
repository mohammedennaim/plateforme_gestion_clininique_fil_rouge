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
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('status', ['active', 'pending', 'not active'])->default('active');
            $table->enum('role', ['admin', 'doctor', 'patient'])->default('patient');
            $table->string('phone')->nullable();
            $table->string('adresse')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        

        // Schema::create('admins', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('user_id')->constrained()->onDelete('cascade');
        //     $table->timestamps();
        // });
    }

    public function down(): void
    {
        // Schema::dropIfExists('admins');
        // Schema::dropIfExists('doctors');
        // Schema::dropIfExists('patients');
        Schema::dropIfExists('users');
    }
};