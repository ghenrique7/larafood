<?php

namespace Tests\Feature\Api;

use App\Models\Product;
use Tests\TestCase;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_error_get_products_by_tenant(): void
    {
        $response = $this->getJson('/api/v1/products');

        $response->assertStatus(422);
    }

    public function test_get_all_products_by_tenant(): void
    {
        $tenant = Tenant::factory()->create();

        $response = $this->getJson("/api/v1/products?token_company={$tenant->uuid}");

        $response->assertStatus(200);
    }

    public function test_error_get_product_by_tenant(): void
    {
        $product = "fake_value";
        $tenant = Tenant::factory()->create();

        $response = $this->getJson("/api/v1/products/{$product}?token_company={$tenant->uuid}");

        $response->assertStatus(404);
    }

    public function test_get_product_by_tenant(): void
    {
        $product = Product::factory()->create();
        $tenant = Tenant::factory()->create();

        $response = $this->getJson("/api/v1/product/{$product->uuid}?token_company={$tenant->uuid}");

        $response->assertStatus(200);
    }
}
