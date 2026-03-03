<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketTipo;

class TicketSetupSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            'Pedido de Informação',
            'Incidente',
            'Reclamação'
        ];

        foreach ($tipos as $nome) {
            TicketTipo::firstOrCreate(['nome' => $nome]);
    }
}
