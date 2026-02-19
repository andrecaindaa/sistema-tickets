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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inbox_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_id') // cliente
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('operador_id') // operador atribuído
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('assunto');
            $table->text('descricao');

            $table->enum('estado', [
                'aberto',
                'em_atendimento',
                'resolvido',
                'fechado'
            ])->default('aberto');

            $table->enum('prioridade', [
                'baixa',
                'media',
                'alta'
            ])->default('media');

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
