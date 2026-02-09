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
        Schema::create('pedido_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pedido_id')->constrained('pedidos');
            $table->foreignUuid('estoque_id')->constrained('estoques');

            // Registrando os dados redundantemente nesta tabela evita de ter alterações automáticas futuras
            // se as informações em estoque_id forem alteradas
            $table->string('produto_nome'); // Será o nome do produto da tabela produtos
            $table->string('medida'); // Será a medida da tabela estoques
            $table->decimal('quantidade', 12,2)->default(0);
            $table->decimal('preco_venda', 12,2)->default(0); // Será p preço_venda da tabela estoques
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido_items');
    }
};
