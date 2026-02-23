<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketEstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \App\Models\TicketEstado::insert([
        ['nome' => 'Aberto'],
        ['nome' => 'Em Atendimento'],
        ['nome' => 'Resolvido'],
        ['nome' => 'Fechado'],
    ]);
}
}
