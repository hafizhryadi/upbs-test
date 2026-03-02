<?php

namespace Tests\Feature;

use Tests\TestCase;

class LandingPageTest extends TestCase
{
    public function test_landing_page_accessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Sistem Manajemen Benih Padi');
        $response->assertSee('Masuk ke Dashboard');
    }

    public function test_dashboard_accessible_at_new_route()
    {
        $response = $this->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Stok Benih');
    }
}
