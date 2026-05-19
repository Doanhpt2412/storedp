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
            $table->string('sku')->unique();
            $table->string('storage')->nullable();
            $table->string('color_name')->nullable();
            $table->string('color_code', 20)->nullable();
            $table->decimal('price_original', 15, 2)->default(0);
            $table->decimal('price_sale', 15, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->timestamps();

            $table->index(['product_id', 'storage']);
            $table->index(['product_id', 'color_name']);
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
