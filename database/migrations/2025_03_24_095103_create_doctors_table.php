<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('speciality');
            $table->text('qualification')->nullable();
            $table->string('experience')->nullable();
            $table->boolean('is_available')->default(true);
            $table->string('emergency_contact')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('doctors');
    }
};
