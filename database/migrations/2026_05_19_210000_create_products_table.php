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
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('product_brand_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('product_category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('thumbnail')->nullable();
            $table->json('images')->nullable();
            $table->string('warranty_policy')->nullable();
            $table->string('return_policy')->nullable();
            $table->json('highlights')->nullable();
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->boolean('is_preorder')->default(false);
            $table->timestamps();

            $table->index(['status', 'product_category_id']);
            $table->index(['status', 'product_brand_id']);
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
