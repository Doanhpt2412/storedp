<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('promotion_code')->nullable()->after('order_status');
            $table->string('promotion_name')->nullable()->after('promotion_code');
            $table->unsignedTinyInteger('discount_percentage')->default(0)->after('promotion_name');
            $table->unsignedBigInteger('discount_amount')->default(0)->after('discount_percentage');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'promotion_code',
                'promotion_name',
                'discount_percentage',
                'discount_amount',
            ]);
        });
    }
};
