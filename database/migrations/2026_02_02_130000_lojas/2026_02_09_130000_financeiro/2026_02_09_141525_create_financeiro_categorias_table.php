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
        Schema::create('financeiro_categorias', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('loja_id')->constrained('lojas');
            $table->string('nome'); //Nome da categoria, ex: vendas, marketing, manutenção, reposição de estoque, investimento, etc.
            $table->string('tipo'); //Entrada ou saída
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financeiro_categorias');
    }
};
