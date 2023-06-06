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
        Schema::create('stocks', function (Blueprint $table) {
            $table->unsignedBigInteger('PRODUCT_ID');
            $table->integer('AMOUNT');
            $table->primary('PRODUCT_ID');
            $table->foreign('PRODUCT_ID')->references('PRODUCT_ID')->on('products');
            $table->index('PRODUCT_ID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};