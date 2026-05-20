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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->nullable(); // Có thể NULL nếu sản phẩm gốc bị xóa
            $table->string('product_name');
            $table->string('product_image')->nullable();
            $table->string('sku')->nullable();
            $table->string('variant_info')->nullable();
            $table->unsignedBigInteger('price');
            $table->unsignedInteger('quantity');
            $table->unsignedBigInteger('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
