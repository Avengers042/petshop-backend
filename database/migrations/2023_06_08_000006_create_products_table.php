<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->unsignedBigInteger('PRODUCT_ID')->autoIncrement();
            $table->string('NAME', 25);
            $table->text('DESCRIPTION');
            $table->decimal('PRICE', 8, 2);
            $table->unsignedBigInteger('SUPPLIER_ID');
            $table->unsignedBigInteger('IMAGE_ID');
            $table->unsignedBigInteger('CATEGORY_ID');
            $table->foreign('SUPPLIER_ID')->references('SUPPLIER_ID')->on('suppliers');
            $table->foreign('IMAGE_ID')->references('IMAGE_ID')->on('images');
            $table->foreign('CATEGORY_ID')->references('CATEGORY_ID')->on('categories');
            $table->index('PRODUCT_ID');
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
