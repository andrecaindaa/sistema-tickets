<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Funcao;

class FuncaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function run(): void
    {
        $funcoes = [
            'Gerente',
            'Técnico',
            'Administrativo',
            'Diretor',
            'Outro'
        ];

        foreach ($funcoes as $nome) {
            //Funcao::create(['nome' => $nome]);
            Funcao::firstOrCreate(['nome' => $nome]);
        }
    }

}
