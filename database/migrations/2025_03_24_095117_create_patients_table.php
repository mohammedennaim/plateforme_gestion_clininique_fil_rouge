<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('assurance')->nullable();
            $table->string('adresse')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('patients');
    }
};
