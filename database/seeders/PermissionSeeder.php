<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dashboard Permissions
        Permission::create(['name' => 'dashboard', 'guard_name' => 'web', 'group_by' => 0]);

        // Role Permissions
        Permission::create(['name' => 'role', 'guard_name' => 'web', 'group_by' => 1]);
        Permission::create(['name' => 'create_role', 'guard_name' => 'web', 'group_by' => 1]);
        Permission::create(['name' => 'edit_role', 'guard_name' => 'web', 'group_by' => 1]);
        Permission::create(['name' => 'delete_role', 'guard_name' => 'web', 'group_by' => 1]);
        Permission::create(['name' => 'view_role', 'guard_name' => 'web', 'group_by' => 1]);

        // User Permissions
        Permission::create(['name' => 'user', 'guard_name' => 'web', 'group_by' => 2]);
        Permission::create(['name' => 'create_user', 'guard_name' => 'web', 'group_by' => 2]);
        Permission::create(['name' => 'edit_user', 'guard_name' => 'web', 'group_by' => 2]);
        Permission::create(['name' => 'delete_user', 'guard_name' => 'web', 'group_by' => 2]);
        Permission::create(['name' => 'view_users', 'guard_name' => 'web', 'group_by' => 2]);
    }
}
