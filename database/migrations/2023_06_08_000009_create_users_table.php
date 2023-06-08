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
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedBigInteger('USER_ID')->autoIncrement();
            $table->string('FIRST_NAME', 25);
            $table->string('LAST_NAME', 25);
            $table->char('CPF', 11)->unique();
            $table->string('EMAIL', 100)->unique();
            $table->date('BIRTHDAY');
            $table->string('PASSWORD', 100);
            $table->unsignedBigInteger('ADDRESS_ID');
            $table->unsignedBigInteger('SHOPPING_CART_ID');
            $table->foreign('ADDRESS_ID')->references('ADDRESS_ID')->on('addresses');
            $table->foreign('SHOPPING_CART_ID')->references('SHOPPING_CART_ID')->on('shopping_carts');
            $table->index('USER_ID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
