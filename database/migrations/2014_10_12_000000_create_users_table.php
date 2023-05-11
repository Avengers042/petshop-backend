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
            $table->char('USER_CPF', 11)->primary();
            $table->string('FIRST_NAME', 25);
            $table->string('LAST_NAME', 25);
            $table->string('EMAIL', 100)->unique();
            $table->integer('AGE');
            $table->string('PASSWORD', 25);
            $table->foreign('ADDRESS_ID')->references('ADDRESS_ID')->on('addresses');
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
