<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
        FuncaoSeeder::class,
        TicketTipoSeeder::class,
        TicketSetupSeeder::class,
        TicketEstadoSeeder::class,
        TicketPrioridadeSeeder::class,
    ]);
        User::firstOrCreate(
            ['email' => 'delfinacaiombe2023@gmail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('1234567'),
            ]
        );
            }
}
