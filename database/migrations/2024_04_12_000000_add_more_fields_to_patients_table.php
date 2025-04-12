<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->text('medical_history')->nullable()->after('emergency_contact');
            $table->json('allergies')->nullable()->after('medical_history');
            $table->decimal('height', 5, 2)->nullable()->after('allergies');
            $table->decimal('weight', 5, 2)->nullable()->after('height');
            $table->timestamp('last_visit_date')->nullable()->after('weight');
        });
    }

    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn([
                'medical_history',
                'allergies',
                'height',
                'weight',
                'last_visit_date'
            ]);
        });
    }
}; 