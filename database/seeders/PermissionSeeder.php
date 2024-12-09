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

        // Department Permissions
        Permission::create(['name' => 'department', 'guard_name' => 'web', 'group_by' => 3]);
        Permission::create(['name' => 'create_department', 'guard_name' => 'web', 'group_by' => 3]);
        Permission::create(['name' => 'edit_department', 'guard_name' => 'web', 'group_by' => 3]);
        Permission::create(['name' => 'delete_department', 'guard_name' => 'web', 'group_by' => 3]);
        Permission::create(['name' => 'view_departments', 'guard_name' => 'web', 'group_by' => 3]);

        // Building Permissions
        Permission::create(['name' => 'building', 'guard_name' => 'web', 'group_by' => 4]);
        Permission::create(['name' => 'create_building', 'guard_name' => 'web', 'group_by' => 4]);
        Permission::create(['name' => 'edit_building', 'guard_name' => 'web', 'group_by' => 4]);
        Permission::create(['name' => 'delete_building', 'guard_name' => 'web', 'group_by' => 4]);
        Permission::create(['name' => 'view_buildings', 'guard_name' => 'web', 'group_by' => 4]);

        // Room Permissions
        Permission::create(['name' => 'room', 'guard_name' => 'web', 'group_by' => 5]);
        Permission::create(['name' => 'create_room', 'guard_name' => 'web', 'group_by' => 5]);
        Permission::create(['name' => 'edit_room', 'guard_name' => 'web', 'group_by' => 5]);
        Permission::create(['name' => 'delete_room', 'guard_name' => 'web', 'group_by' => 5]);
        Permission::create(['name' => 'view_rooms', 'guard_name' => 'web', 'group_by' => 5]);

        // Subject Permissions
        Permission::create(['name' => 'subject', 'guard_name' => 'web', 'group_by' => 6]);
        Permission::create(['name' => 'create_subject', 'guard_name' => 'web', 'group_by' => 6]);
        Permission::create(['name' => 'edit_subject', 'guard_name' => 'web', 'group_by' => 6]);
        Permission::create(['name' => 'delete_subject', 'guard_name' => 'web', 'group_by' => 6]);
        Permission::create(['name' => 'view_subjects', 'guard_name' => 'web', 'group_by' => 6]);

        // Section Permissions
        Permission::create(['name' => 'section', 'guard_name' => 'web', 'group_by' => 7]);
        Permission::create(['name' => 'create_section', 'guard_name' => 'web', 'group_by' => 7]);
        Permission::create(['name' => 'edit_section', 'guard_name' => 'web', 'group_by' => 7]);
        Permission::create(['name' => 'delete_section', 'guard_name' => 'web', 'group_by' => 7]);
        Permission::create(['name' => 'view_sections', 'guard_name' => 'web', 'group_by' => 7]);

        // Evaluation Permissions
        Permission::create(['name' => 'evaluation', 'guard_name' => 'web', 'group_by' => 8]);
        Permission::create(['name' => 'create_evaluation', 'guard_name' => 'web', 'group_by' => 8]);
        Permission::create(['name' => 'edit_evaluation', 'guard_name' => 'web', 'group_by' => 8]);
        Permission::create(['name' => 'delete_evaluation', 'guard_name' => 'web', 'group_by' => 8]);
        Permission::create(['name' => 'view_evaluations', 'guard_name' => 'web', 'group_by' => 8]);

        // Result Permissions
        Permission::create(['name' => 'response', 'guard_name' => 'web', 'group_by' => 9]);
        Permission::create(['name' => 'create_response', 'guard_name' => 'web', 'group_by' => 9]);
        Permission::create(['name' => 'edit_response', 'guard_name' => 'web', 'group_by' => 9]);
        Permission::create(['name' => 'delete_response', 'guard_name' => 'web', 'group_by' => 9]);
        Permission::create(['name' => 'view_responses', 'guard_name' => 'web', 'group_by' => 9]);

        // Announcement Permissions
        Permission::create(['name' => 'announcement', 'guard_name' => 'web', 'group_by' => 10]);
        Permission::create(['name' => 'create_announcement', 'guard_name' => 'web', 'group_by' => 10]);
        Permission::create(['name' => 'edit_announcement', 'guard_name' => 'web', 'group_by' => 10]);
        Permission::create(['name' => 'delete_announcement', 'guard_name' => 'web', 'group_by' => 10]);
        Permission::create(['name' => 'view_announcements', 'guard_name' => 'web', 'group_by' => 10]);
    }
}
