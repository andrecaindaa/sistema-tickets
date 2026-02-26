<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TicketPrioridade;

class TicketPrioridadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function run(): void
    {
        TicketPrioridade::firstOrCreate(['nome' => 'Baixa'], ['ordem' => 1]);
        TicketPrioridade::firstOrCreate(['nome' => 'Média'], ['ordem' => 2]);
        TicketPrioridade::firstOrCreate(['nome' => 'Alta'], ['ordem' => 3]);
        TicketPrioridade::firstOrCreate(['nome' => 'Urgente'], ['ordem' => 4]);
    }
}
