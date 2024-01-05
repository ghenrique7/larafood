<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
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
}
