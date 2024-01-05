<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function PHPUnit\Framework\assertJson;

class TenantTest extends TestCase
{
    /**
     * Test Get All Tenants
     */
    public function test_get_all_tenants(): void
    {
        $tenants = Tenant::factory(10)->create();

        $response = $this->getJson('/api/v1/tenants');

        $response->assertStatus(200)
                ->assertJsonCount(10, 'data');
    }

    public function test_error_get_tenant(): void
    {

        $tenant = "fake_value";

        $response = $this->getJson("/api/v1/tenants/{$tenant}");

        $response->assertStatus(404);
    }

    public function test_get_tenant_by_identify(): void
    {
        $tenant = Tenant::factory()->create();

        $response = $this->getJson("/api/v1/tenant/{$tenant->uuid}");

        $response->assertStatus(200);
    }
}
