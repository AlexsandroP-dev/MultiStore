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
        Schema::create('financeiro_movimentacoes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('loja_id')->constrained('lojas');
            $table->foreignUuid('categoria_id')->constrained('financeiro_categorias');
            // Relacionamento opcional pois se a entrada vier de um produto então será vinculada aqui
            // nem todas as entradas serão de produtos
            $table->foreignUuid('pedido_id')->nullable()->constrained('pedidos');

            $table->string('descricao'); //Exemplo: #pedido->id, "Pagamento de Aluguel mês/ano

            $table->date('data_vencimento');
            $table->date('data_pagamento')->nullable(); //Caso for nulo então é uma conta a pagar ou dinheiro a receber
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financeiro_movimentacaos');
    }
};
