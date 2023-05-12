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
            $table->unsignedBigInteger('PRODUCT_ID');
            $table->unsignedBigInteger('USER_ID');
            $table->foreign('PRODUCT_ID')->references('PRODUCT_ID')->on('products');
            $table->foreign('USER_ID')->references('USER_ID')->on('users');
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
