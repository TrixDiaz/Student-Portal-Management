<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin role and give it all permissions
        $permissions = Permission::all();
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->syncPermissions($permissions);

        // Create user role with basic permissions
        $userRole = Role::create(['name' => 'user']);
    }
}
