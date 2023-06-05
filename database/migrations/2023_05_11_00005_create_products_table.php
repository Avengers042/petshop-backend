<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->unsignedBigInteger('PRODUCT_ID')->autoIncrement();
            $table->string('NAME', 25);
            $table->text('DESCRIPTION');
            $table->unsignedBigInteger('SUPPLIER_ID');
            $table->foreign('SUPPLIER_ID')->references('SUPPLIER_ID')->on('suppliers');
            $table->index('PRODUCT_ID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('products');
    }
};