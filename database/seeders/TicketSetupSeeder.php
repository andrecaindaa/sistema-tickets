<?php

namespace Database\Seeders;
use App\Models\TicketEstado;
use App\Models\TicketTipo;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
        {
            TicketTipo::insert([
        ['nome' => 'Pedido de Informação'],
        ['nome' => 'Incidente'],
        ['nome' => 'Reclamação'],
    ]);


        }
}
