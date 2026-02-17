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
        Schema::create('produtos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('loja_id')->constrained('lojas');
            $table->foreignUuid('categoria_id')->constrained('categorias');
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->string('sku')->nullable();
            $table->string('diretorio_imagem')->nullable();
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
