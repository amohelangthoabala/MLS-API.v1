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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users'); // The agent who made the purchase
            $table->foreignId('voucher_id')->nullable()->constrained('vouchers'); // If linked to a specific voucher
            $table->enum('type', ['purchase', 'allocation', 'sale'])->default('purchase');
            $table->decimal('amount', 10, 2); // How much they paid
            $table->string('payment_method')->nullable(); // e.g., 'mpesa', 'emoney'
            $table->string('reference')->nullable(); // Mobile Money transaction reference
            $table->enum('status', ['pending', 'successful', 'failed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
