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
        Schema::create('pedido_status_historicos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pedido_id')->constrained('pedidos');
            // Quem alterou? sistema ou algum colaborador
            $table->foreignUuid('lojista_id')->nullable()->constrained('lojistas');

            $table->string('status_anterior')->nullable();
            $table->string('status_novo')->nullable();
            $table->text('comentario')->nullable(); // Pagamento aprovado via pix/transferencia, objeto enviado via uber, etc
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido_status_historicos');
    }
};
