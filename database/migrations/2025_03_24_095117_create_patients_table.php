<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name_assurance')->nullable();
            $table->string('assurance_number')->nullable();
            $table->string('blood_type')->nullable();
            $table->string('emergency_contact')->nullable();
            // $table->text('medical_history')->nullable()->after('emergency_contact');
            // $table->json('allergies')->nullable()->after('medical_history');
            // $table->decimal('height', 5, 2)->nullable()->after('allergies');
            // $table->decimal('weight', 5, 2)->nullable()->after('height');
            // $table->timestamp('last_visit_date')->nullable()->after('weight');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('patients');
    }
};
