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
            $table->char('SUPPLIER_CNPJ', 14)->primary();
            $table->string('RAZAO_SOCIAL', 30);
            $table->string('NOME_FANTASIA', 30);
            $table->string('EMAIL', 256);
            $table->foreign('ADDRESS_ID')->references('ADDRESS_ID')->on('addresses');
            $table->integer('COMMERCIAL_PHONE');
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
