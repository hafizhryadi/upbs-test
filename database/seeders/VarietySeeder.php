<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Variety;

class VarietySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $varieties = [
            ['name' => 'Inpari 32', 'type' => 'SS', 'description' => 'Varietas unggul baru padi sawah'],
            ['name' => 'Inpari 42', 'type' => 'SS', 'description' => 'Varietas unggul padi sawah irigasi'],
            ['name' => 'Inpari 50', 'type' => 'SS', 'description' => 'Varietas unggul padi sawah'],
            ['name' => 'Padjajaran agritan', 'type' => 'SS', 'description' => 'Varietas unggul toleran kekeringan'],
        ];

        foreach ($varieties as $variety) {
            Variety::create($variety);
        }
    }
}
