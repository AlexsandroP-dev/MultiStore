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
        Schema::create('lojas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nome');
            $table->string('slug')->unique();
            $table->string('cnpj')->nullable()->unique();
            $table->string('contato')->nullable();
            $table->dateTime('expira_em')->nullable();
            $table->string('diretorio_logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lojas');
    }
};
