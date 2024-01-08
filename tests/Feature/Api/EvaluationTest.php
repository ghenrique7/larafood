<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Client;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EvaluationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_error_create_new_evaluation(): void
    {
        // $order = Order::factory()->create();
        $order = 'fake_value';

        $response = $this->postJson("/api/auth/v1/orders/{$order}/evaluations");

        $response->assertStatus(401);
    }

    public function test_create_new_evaluation(): void
    {
        $client = Client::factory()->create();
        $token = $client->createToken(Str::random(10))->plainTextToken;

        $order = $client->orders()->save(Order::factory()->make());

        $payload = [
            'stars' => 5,
            'comment' => 'Muito bom'
        ];

        $headers = [
            'Authorization' => "Bearer {$token}"
        ];

        $response = $this->postJson("/api/auth/v1/orders/{$order->identify}/evaluations", $payload, $headers);

        $response->assertStatus(201);
    }
}
