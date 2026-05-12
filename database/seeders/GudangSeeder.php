<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class GudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gudangs = [
            ['name' => 'Gudang Kayu Agung', 'address' => 'Kayu Agung, Ogan Komering Ilir'],
            ['name' => 'Gudang Karang Agung', 'address' => 'Karang Agung, Musi Banyuasin'],
            ['name' => 'Gudang Ogan Komering Ulu', 'address' => 'Ogan Komering Ulu']
        ];

        foreach ($gudangs as $gudang) {
            Location::create($gudang);
        }
    }
}
