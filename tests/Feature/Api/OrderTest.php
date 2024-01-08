<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Client;
use App\Models\Tenant;
use App\Models\Product;
use App\Models\Table;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_validation_create_new_order(): void
    {
        $payload = [];

        $response = $this->postJson('/api/v1/orders', $payload);

        $response->assertStatus(422);
    }

    /**
     * A basic feature test example.
     */
    public function test_create_new_order(): void
    {
        $tenant = Tenant::factory()->create();

        $payload = [
            'token_company' => $tenant->uuid,
            'products' => []
        ];

        $products = Product::factory(10)->create();

        foreach($products as $product) {
            array_push($payload['products'], [
                'identify' => $product->uuid,
                'qty' => 2
            ]);
        }

        $response = $this->postJson('/api/v1/orders', $payload);

        $response->assertStatus(201);
    }

        /**
     * A basic feature test example.
     */
    public function test_total_order(): void
    {
        $tenant = Tenant::factory()->create();

        $payload = [
            'token_company' => $tenant->uuid,
            'products' => []
        ];

        $products = Product::factory(2)->create();

        foreach($products as $product) {
            array_push($payload['products'], [
                'identify' => $product->uuid,
                'qty' => 1
            ]);
        }

        $response = $this->postJson('/api/v1/orders', $payload);

        $response->assertStatus(201)
                 ->assertJsonPath('data.total', 25.8);
    }

    public function test_order_not_found(): void
    {
        $order = "fake_value";

        $response = $this->getJson("api/v1/orders/{$order}");

        $response->assertStatus(404);
    }

    public function test_order_found(): void
    {
        $order = Order::factory()->create();

        $response = $this->getJson("api/v1/orders/{$order->identify}");

        $response->assertStatus(200);
    }

    public function test_create_new_order_authenticated(): void
    {
        $client = Client::factory()->create();
        $token = $client->createToken(Str::random(10))->plainTextToken;
        $tenant = Tenant::factory()->create();

        $payload = [
            'token_company' => $tenant->uuid,
            'products' => []
        ];

        $products = Product::factory(2)->create();

        foreach($products as $product) {
            array_push($payload['products'], [
                'identify' => $product->uuid,
                'qty' => 1
            ]);
        }

        $response = $this->postJson('/api/auth/v1/orders', $payload, [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(201);
    }

    public function test_create_new_order_with_table(): void
    {
        $table = Table::factory()->create();
        $tenant = Tenant::factory()->create();

        $payload = [
            'token_company' => $tenant->uuid,
            'products' => [],
            'table' => $table->uuid
        ];

        $products = Product::factory(2)->create();

        foreach($products as $product) {
            array_push($payload['products'], [
                'identify' => $product->uuid,
                'qty' => 1
            ]);
        }

        $response = $this->postJson('/api/v1/orders', $payload);

        $response->assertStatus(201);
    }

    public function test_get_my_orders_authenticated(): void
    {
        $client = Client::factory()->create();
        $token = $client->createToken(Str::random(10))->plainTextToken;

        Order::factory(2)->create(['client_id' => $client->id]);

        $response = $this->getJson('/api/auth/v1/my-orders', [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(200)
                ->assertJsonCount(2, 'data');
    }
}
