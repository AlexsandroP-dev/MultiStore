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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users'); // Cliente que comprou
            $table->foreignUuid('loja_id')->constrained('lojas');
            $table->decimal('total', 12, 2);
            // Status: 'pendente', 'pago', 'em_producao', 'concluido', 'entregue', 'cancelado', 'cancelado e retornado'
            $table->string('status')->default('pendente');

            $table->string('metodo_entrega')->nullable(); // 'Retirada', 'Transportadora', 'Uber', etc
            $table->decimal('valor_frete', 10, 2)->default(0);
            
            $table->text('observacao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
