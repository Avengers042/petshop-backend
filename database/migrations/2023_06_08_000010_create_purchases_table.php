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
        Schema::create('purchases', function (Blueprint $table) {
            $table->unsignedBigInteger('PURCHASE_ID')->autoIncrement();
            $table->unsignedBigInteger('SHOPPING_CART_ID');
            $table->unsignedBigInteger('USER_ID');
            $table->unsignedBigInteger('PRODUCT_ID');
            $table->foreign('SHOPPING_CART_ID')->references('SHOPPING_CART_ID')->on('shopping_carts');
            $table->foreign('PRODUCT_ID')->references('PRODUCT_ID')->on('products');
            $table->foreign('USER_ID')->references('USER_ID')->on('users');
            $table->index('PURCHASE_ID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
