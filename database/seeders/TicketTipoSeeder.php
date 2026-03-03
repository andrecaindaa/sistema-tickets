<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketTipo;

class TicketTipoSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            'Reserva',
            'Suporte Técnico',
            'Informação'
        ];

        foreach ($tipos as $nome) {
            TicketTipo::firstOrCreate(['nome' => $nome]);
        }
    }
}
