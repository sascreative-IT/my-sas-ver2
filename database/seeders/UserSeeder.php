<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'test'
        ])->assignRole(User::ROLE_CUSTOMER_SERVICE_AGENT);

        User::factory()->create([
            'email' => 'test2@example.com',
            'password' => 'test2'
        ])->assignRole(User::ROLE_SALES_AGENT);
    }
}
