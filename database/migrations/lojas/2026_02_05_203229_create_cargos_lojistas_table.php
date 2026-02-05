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
        Schema::create('cargos_lojistas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('cargo_id')->references('id')->on('cargos');
            $table->foreignUuid('lojista_id')->references('id')->on('lojistas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargos_lojistas');
    }
};
