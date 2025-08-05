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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('provider');            // Vodacom, Econet, LEC
            $table->string('name');                // M10, 1GB, M200 Bill
            $table->decimal('amount', 10, 2);      // e.g., 10.00
            $table->decimal('agent_commission_rate', 5, 2)->default(6.00);   // %
            $table->decimal('platform_commission_rate', 5, 2)->default(4.00); // %
            $table->enum('source', ['local', 'api'])->default('api');
            $table->boolean('available')->default(true);
            $table->json('meta')->nullable();      // API codes, tags, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
