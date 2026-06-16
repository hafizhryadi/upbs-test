<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventory;
use Carbon\Carbon;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inventories = [
            [
                'variety_id' => 1,
                'location_id' => 1,
                'batch_code' => 'BATCH-A001',
                'expiry_date' => Carbon::now()->addMonths(6)->format('Y-m-d'),
                'quantity' => 500
            ],
            [
                'variety_id' => 2,
                'location_id' => 2,
                'batch_code' => 'BATCH-B002',
                'expiry_date' => Carbon::now()->addMonths(2)->format('Y-m-d'),
                'quantity' => 250
            ],
            [
                'variety_id' => 3,
                'location_id' => 3,
                'batch_code' => 'BATCH-C003',
                'expiry_date' => Carbon::now()->subDays(10)->format('Y-m-d'),
                'quantity' => 100
            ],
        ];

        foreach ($inventories as $inventory) {
            Inventory::create($inventory);
        }
    }
}
