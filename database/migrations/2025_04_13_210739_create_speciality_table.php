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
        Schema::create('speciality', function (Blueprint $table) {
            $table->id();
            $table->enum('name', ['Cardiologie', 'Dermatologie', 'Gynécologie', 'Pédiatrie', 'Psychiatrie', 'Radiologie', 'Médecine générale']);
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speciality');
    }
};
