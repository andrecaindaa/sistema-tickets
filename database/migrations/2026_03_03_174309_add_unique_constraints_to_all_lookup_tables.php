<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Funções
        Schema::table('funcoes', function (Blueprint $table) {
            $table->unique('nome', 'funcoes_nome_unique');
        });

        // Tipos de ticket
        Schema::table('ticket_tipos', function (Blueprint $table) {
            $table->unique('nome', 'ticket_tipos_nome_unique');
        });

        // Estados de ticket
        Schema::table('ticket_estados', function (Blueprint $table) {
            $table->unique('nome', 'ticket_estados_nome_unique');
        });

        // Entidades (opcional - se fizer sentido)
        Schema::table('entidades', function (Blueprint $table) {
            $table->unique('nome', 'entidades_nome_unique');
        });
    }

    public function down(): void
    {
        Schema::table('funcoes', function (Blueprint $table) {
            $table->dropUnique('funcoes_nome_unique');
        });

        Schema::table('ticket_tipos', function (Blueprint $table) {
            $table->dropUnique('ticket_tipos_nome_unique');
        });

        Schema::table('ticket_estados', function (Blueprint $table) {
            $table->dropUnique('ticket_estados_nome_unique');
        });

        Schema::table('entidades', function (Blueprint $table) {
            $table->dropUnique('entidades_nome_unique');
        });
    }
};
