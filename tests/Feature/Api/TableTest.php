<?php

namespace Tests\Feature\Api;

use App\Models\Table;
use Tests\TestCase;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TableTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_error_get_tables_by_tenant(): void
    {
        $response = $this->getJson('/api/v1/tables');

        $response->assertStatus(422);
    }

    public function test_get_all_tables_by_tenant(): void
    {
        $tenant = Tenant::factory()->create();

        $response = $this->getJson("/api/v1/tables?token_company={$tenant->uuid}");

        $response->assertStatus(200);
    }

    public function test_error_get_table_by_tenant(): void
    {
        $table = "fake_value";
        $tenant = Tenant::factory()->create();

        $response = $this->getJson("/api/v1/tables/{$table}?token_company={$tenant->uuid}");

        $response->assertStatus(404);
    }

    public function test_get_table_by_tenant(): void
    {
        $table = Table::factory()->create();
        $tenant = Tenant::factory()->create();

        $response = $this->getJson("/api/v1/table/{$table->uuid}?token_company={$tenant->uuid}");

        $response->assertStatus(200);
    }
}
