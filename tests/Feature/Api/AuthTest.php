<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Client;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_error_create_new_client(): void
    {
        $payload = [
            'email' => 'gcoelho730@gmail.com',
            'name' => 'Gabriel Coelho',
        ];

        $response = $this->postJson('/api/auth/register',  $payload);

        $response->assertStatus(422);
        // ->assertExactJson([
        //     'message' => 'The password field is required.',
        //     'errors' => [
        //         'password' => [
        //             trans('validation.required', 'password')
        //         ]
        //     ]
        // ]);
    }

    public function test_create_new_client(): void
    {
        $payload = [
            'email' => 'gcoelho730@gmail.com',
            'name' => 'Gabriel Coelho',
            'password' => '123456'
        ];

        $response = $this->postJson('/api/auth/register',  $payload);

        $response->assertStatus(201)
            ->assertExactJson([
                'data' => [
                    'name' => $payload['name'],
                    'email' => $payload['email']
                ]
            ]);
    }

    public function test_get_error_not_authenticated(): void
    {
        $response = $this->getJson('/api/auth/me');

        $response->assertStatus(401);
    }

    public function test_get_error_wrong_token_user(): void
    {
        $client = Client::factory()->create();
        $token = "invalid_token";

        $response = $this->getJson('/api/auth/me', [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(401);
    }

    public function test_get_authenticated_user(): void
    {
        $client = Client::factory()->create();
        $token = $client->createToken(Str::random(10))->plainTextToken;

        $response = $this->getJson('/api/auth/me', [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(200)
            ->assertExactJson([
                'data' => [
                    'name' => $client->name,
                    'email' => $client->email
                ]
            ]);
    }

    public function test_logout_user(): void
    {
        $client = Client::factory()->create();
        $token = $client->createToken(Str::random(10))->plainTextToken;

        $response = $this->postJson('/api/auth/logout', [], [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(204);
    }
}
