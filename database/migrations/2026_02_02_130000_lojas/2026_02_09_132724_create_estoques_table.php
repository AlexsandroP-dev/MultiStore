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
        Schema::create('estoques', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('produto_id')->constrained('produtos');
            // Medida: 'unidade', 'm2', 'kg', 'metro', etc
            $table->string('medida')->default('unidade');
            $table->decimal('preco_venda', 12, 2)->default(0.00);
            $table->decimal('preco_custo', 12, 2)->nullable();
            // Quantidade em decimal também para caso a medida requerer, por exemplo m2, kg
            $table->decimal('quantidade', 12,2)->default(0);
            $table->decimal('estoque_minimo', 12,2)->default(1);
            $table->boolean('disponivel')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estoques');
    }
};
