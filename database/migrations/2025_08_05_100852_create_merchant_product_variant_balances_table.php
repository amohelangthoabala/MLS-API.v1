<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('merchant_product_variant_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')
                ->constrained('merchants')
                ->cascadeOnDelete();
            $table->foreignId('product_variant_id')
                ->constrained('product_variants')
                ->cascadeOnDelete();
            $table->decimal('balance', 10, 2)->default(0); // Current stock
            $table->timestamps();

            // Shortened name to avoid index name length issues
            $table->unique(['merchant_id', 'product_variant_id'], 'mpvb_merchant_variant_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('merchant_product_variant_balances');
    }
};