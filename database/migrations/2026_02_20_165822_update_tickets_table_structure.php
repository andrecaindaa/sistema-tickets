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
    if (!Schema::hasColumn('tickets', 'numero')) {
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('numero')->nullable()->after('id');
        });
    }

    Schema::table('tickets', function (Blueprint $table) {

        if (!Schema::hasColumn('tickets', 'ticket_tipo_id')) {
            $table->foreignId('ticket_tipo_id')->nullable()->constrained();
        }

        if (!Schema::hasColumn('tickets', 'ticket_estado_id')) {
            $table->foreignId('ticket_estado_id')->nullable()->constrained();
        }

        if (!Schema::hasColumn('tickets', 'entidade_id')) {
            $table->foreignId('entidade_id')->nullable()->constrained();
        }

        if (!Schema::hasColumn('tickets', 'contacto_id')) {
            $table->foreignId('contacto_id')->nullable()->constrained();
        }

        if (!Schema::hasColumn('tickets', 'conhecimento')) {
            $table->json('conhecimento')->nullable();
        }
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
