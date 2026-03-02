<?php

namespace Tests\Feature;

use App\Models\Inventory;
use App\Models\User;
use App\Models\Variety;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_displays_stock_by_expiry()
    {
        // Arrange
        $variety = Variety::create(['name' => 'Ciherang']);
        $location = Location::create(['name' => 'Gudang A']);
        
        Inventory::create([
            'variety_id' => $variety->id,
            'location_id' => $location->id,
            'batch_code' => 'BATCH-001',
            'expiry_date' => now()->addDays(10)->format('Y-m-d'), // Near expiry
            'status' => 'ready',
            'quantity' => 100,
        ]);

        Inventory::create([
            'variety_id' => $variety->id,
            'location_id' => $location->id,
            'batch_code' => 'BATCH-002',
            'expiry_date' => now()->addDays(60)->format('Y-m-d'), // Safe
            'status' => 'ready',
            'quantity' => 50,
        ]);

        // Act
        $response = $this->get('/dashboard');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Stok Berdasarkan Tanggal Kadaluarsa');
        $response->assertSee('Ciherang');
        $response->assertSee(now()->addDays(10)->format('d M Y'));
        $response->assertSee('100 kg');
        $response->assertSee('Mendekati Kadaluarsa');
        
        $response->assertSee(now()->addDays(60)->format('d M Y'));
        $response->assertSee('50 kg');
        $response->assertSee('Aman');
    }
}
