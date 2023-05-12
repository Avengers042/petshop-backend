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
        Schema::create('addresses', function (Blueprint $table) {
            $table->unsignedBigInteger('ADDRESS_ID')->autoIncrement();
            $table->integer('NUMBER');
            $table->char('CEP', 8);
            $table->string('UF', 25);
            $table->string('DISTRICT', 25);
            $table->string('PUBLIC_PLACE', 100);
            $table->string('COMPLEMENT', 25)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
