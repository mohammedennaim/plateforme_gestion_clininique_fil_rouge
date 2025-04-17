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
        Schema::table('payments', function (Blueprint $table) {
            // Renommer payment_id en transaction_id pour être plus explicite
            $table->renameColumn('payment_id', 'transaction_id');
            
            // Ajouter la relation vers appointments
            $table->foreignId('appointment_id')->nullable()->constrained()->onDelete('set null')->after('user_id');
            
            // Ajouter le type de paiement pour distinguer Stripe d'autres méthodes de paiement
            $table->string('payment_method')->default('stripe')->after('status');
            
            // Rendre user_id nullable car parfois un paiement peut être fait sans compte utilisateur
            $table->foreignId('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->renameColumn('transaction_id', 'payment_id');
            $table->dropForeign(['appointment_id']);
            $table->dropColumn(['appointment_id', 'payment_method']);
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};
