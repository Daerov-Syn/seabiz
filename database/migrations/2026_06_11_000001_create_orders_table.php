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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->index('user_id');
            $table->string('order_number')->unique();
            $table->string('store_name')->nullable();
            $table->string('store_city')->nullable();
            $table->string('status')->default('belum_dibayar');
            $table->string('payment_method')->nullable();
            $table->string('voucher_code')->nullable();
            $table->integer('discount_amount')->default(0);
            $table->integer('shipping_fee')->default(0);
            $table->integer('subtotal')->default(0);
            $table->integer('total')->default(0);
            $table->string('shipping_name');
            $table->string('shipping_phone');
            $table->text('shipping_address');
            $table->string('shipping_city');
            $table->string('shipping_district')->nullable();
            $table->text('shipping_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
