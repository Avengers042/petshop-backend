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
            $table->integer('PRODUCT_ID')->primary()->autoIncrement();
            $table->string('NAME', 25);
            $table->string('DESCRIPTION', 200);
            $table->foreign('SUPPLIER_CNPJ')->references('SUPPLIER_CNPJ')->on('suppliers');
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