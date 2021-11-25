<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

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
            'email' => 'admin@example.com',
            'password' => 'admin'
        ])->assignRole(User::ROLE_ADMINISTRATOR);

        User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'test'
        ])->assignRole(User::ROLE_CUSTOMER_SERVICE_AGENT);

        User::factory()->create([
            'email' => 'test2@example.com',
            'password' => 'test2'
        ])->assignRole(User::ROLE_SALES_AGENT);

        User::factory()->create([
            'email' => 'pm@example.com',
            'password' => 'pm'
        ])->assignRole(User::ROLE_PRODUCTION_MANAGER);

        User::factory()->create([
            'email' => 'po@example.com',
            'password' => 'po'
        ])->assignRole(User::ROLE_PURCHASING_OFFICER);
    }
}
