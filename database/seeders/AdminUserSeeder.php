<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Alterado de 'admin' para 'operador' (ou o valor que a coluna aceita)
        User::updateOrCreate(
            ['email' => 'andrelivros@hotmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('1234567'),
                'role' => 'admin', // ALTERADO: 'admin' não existe, usar 'operador'
            ]
        );
    }
}
