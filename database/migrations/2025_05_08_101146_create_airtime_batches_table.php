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
        Schema::create('airtime_batches', function (Blueprint $table) {
            $table->id();
            $table->string('mno'); // e.g., VCL, ETL
            $table->unsignedInteger('denomination');
            $table->unsignedInteger('count');
            $table->decimal('purchase_price', 8, 2);
            $table->enum('status', ['available', 'assigned', 'sold'])->default('available');
            $table->foreignId('agent_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airtime_batches');
    }
};
