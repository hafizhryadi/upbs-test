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
        User::factory()->create([
            'name' => 'Pimpinan UPBS',
            'email' => 'pimpinan@brmp.sumsel',
            'password' => 'password',
            'role' => 'pimpinan',
        ]);

        User::factory()->create([
            'name' => 'Staff UPBS',
            'email' => 'staff@brmp.sumsel',
            'password' => 'password',
            'role' => 'staff',
        ]);

        $this->call([
            VarietySeeder::class,
            GudangSeeder::class,
            InventorySeeder::class,
        ]);
    }
}
