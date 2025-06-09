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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. MTN Airtime
            $table->string('type'); // e.g. airtime, electricity, data
            $table->string('provider'); // e.g. MTN, ZESCO
            $table->boolean('available')->default(true);
            $table->decimal('commission_rate', 5, 2)->nullable(); // % commission
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
