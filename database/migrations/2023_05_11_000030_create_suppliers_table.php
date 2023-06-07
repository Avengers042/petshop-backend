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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->unsignedBigInteger('SUPPLIER_ID')->autoIncrement();
            $table->string('CORPORATE_NAME', 100);
            $table->string('TRADE_NAME', 50);
            $table->char('CNPJ', 14)->unique();
            $table->string('EMAIL', 256)->unique();
            $table->string('COMMERCIAL_PHONE', 20);
            $table->unsignedBigInteger('ADDRESS_ID');
            $table->foreign('ADDRESS_ID')->references('ADDRESS_ID')->on('addresses');
            $table->index('SUPPLIER_ID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
