<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class OperadorSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'operador1@empresa.com'],
            [
                'name' => 'Operador 1',
                'password' => Hash::make('password'),
                'role' => 'operador',
            ]
        );

        //  adicionado mais um operador
        User::firstOrCreate(
            ['email' => 'operador2@empresa.com'],
            [
                'name' => 'Operador 2',
                'password' => Hash::make('password'),
                'role' => 'operador',
            ]
        );
    }
}
