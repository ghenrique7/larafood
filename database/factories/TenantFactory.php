<?php

namespace Database\Factories;

use App\Models\Plan;
use App\Models\Tenant;
use Faker\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Models\Tenant>
 */
class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'plan_id' => Plan::factory(),
            'cnpj' => uniqid() . date('YmdHis'),
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail()
        ];
    }
}
