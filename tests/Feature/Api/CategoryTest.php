<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Tenant;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_error_get_categories_by_tenant(): void
    {
        $response = $this->getJson('/api/v1/categories');

        $response->assertStatus(422);
    }

    public function test_get_all_categories_by_tenant(): void
    {
        $tenant = Tenant::factory()->create();

        $response = $this->getJson("/api/v1/categories?token_company={$tenant->uuid}");

        $response->assertStatus(200);
    }

    public function test_error_get_category_by_tenant(): void
    {
        $category = "fake_value";
        $tenant = Tenant::factory()->create();

        $response = $this->getJson("/api/v1/categories/{$category}?token_company={$tenant->uuid}");

        $response->assertStatus(404);
    }

    public function test_get_category_by_tenant(): void
    {
        $category = Category::factory()->create();
        $tenant = Tenant::factory()->create();

        $response = $this->getJson("/api/v1/categories/{$category->identify}?token_company={$tenant->uuid}");

        $response->assertStatus(200);
    }
}
