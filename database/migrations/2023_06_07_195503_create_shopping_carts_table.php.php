<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppingCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SHOPPING_CARTS', function (Blueprint $table) {
            $table->unsignedBigInteger('SHOPPING_CART_ID')->primary();
            $table->unsignedBigInteger('PRODUCT_ID');
            $table->integer('AMOUNT');

            $table->foreign('PRODUCT_ID')->references('PRODUCT_ID')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SHOPPING_CARTS');
    }
}
