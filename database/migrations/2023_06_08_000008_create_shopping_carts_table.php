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
    public function up():void
    {
        Schema::create('shopping_carts', function (Blueprint $table) {
            $table->unsignedBigInteger('SHOPPING_CART_ID')->primary();
            $table->index('SHOPPING_CART_ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('shopping_carts');
    }
}
