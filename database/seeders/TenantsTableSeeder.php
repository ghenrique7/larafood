<?php

namespace Database\Seeders;

use Database\Factories\TenantFactory;
use Illuminate\Database\Seeder;

class TenantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TenantFactory::new()->count(10)->create();
    }
}
