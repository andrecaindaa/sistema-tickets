<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            FuncaoSeeder::class,
            TicketTipoSeeder::class,
            TicketSetupSeeder::class,
            TicketEstadoSeeder::class,
            TicketPrioridadeSeeder::class,
            OperadorSeeder::class,
            AdminUserSeeder::class,
        ]);

        // Admin principal
        User::firstOrCreate(
            ['email' => 'delfinacaiombe2023@gmail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('1234567'),
                'role' => 'operador', // ALTERADO para 'operador'
            ]
        );
    }
}
