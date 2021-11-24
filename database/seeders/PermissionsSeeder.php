<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        Role::create(['name' => User::ROLE_CUSTOMER_SERVICE_AGENT]);
        Role::create(['name' => User::ROLE_SALES_AGENT]);
        Role::create(['name' => User::ROLE_ADMINISTRATOR]);
        Role::create(['name' => User::ROLE_PRODUCTION_MANAGER]);
        Role::create(['name' => User::ROLE_PURCHASING_OFFICER]);
    }
}
