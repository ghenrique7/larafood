<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Tenant;
use Database\Factories\TenantFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantTest extends TestCase
{
    /**
     * Test Get All Tenants
     */
    public function test_get_all_tenants(): void {
        Tenant::factory(10)->create();

        $response = $this->getJson('/api/v1/tenants');

        $response->assertStatus(200);
    }
}
