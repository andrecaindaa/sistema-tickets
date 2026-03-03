<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketEstado;

class TicketEstadoSeeder extends Seeder
{
    public function run(): void
    {
        $estados = [
            'Aberto',
            'Em Atendimento',
            'Resolvido',
            'Fechado'
        ];

        foreach ($estados as $nome) {
            TicketEstado::firstOrCreate(['nome' => $nome]);
        }
    }
}
