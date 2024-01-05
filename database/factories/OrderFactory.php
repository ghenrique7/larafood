<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Tenant;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{


    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'identify' => uniqid() . Str::random(10),
            'total' => 80.0,
            'status' => 'open'
        ];
    }
}
