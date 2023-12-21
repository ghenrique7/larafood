<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = Tenant::first();

        $tenant->users()->create([
            'name' => 'Gabriel Coelho',
            'email' => 'gcoelho730@gmail.com',
            'password' => bcrypt('123456')
        ]);
    }
}
