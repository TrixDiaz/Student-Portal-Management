<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([
            ['id' => 1, 'name' => 'Department 1', 'course' => 'Bachelor of Science in Information Technology'],
            ['id' => 2, 'name' => 'Department 2', 'course' => 'Bachelor of Science in Biology'],
        ]);

        $teacherExists = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('roles.name', 'teacher')
            ->whereIn('users.id', [1, 2])
            ->exists();

        if ($teacherExists) {
            DB::table('department_teachers')->insert([
                ['department_id' => 1, 'teacher_id' => 1],
                ['department_id' => 2, 'teacher_id' => 2],
            ]);
        }

        $studentExists = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('roles.name', 'student')
            ->whereIn('users.id', [1, 2])
            ->exists();

        if ($studentExists) {
            DB::table('department_students')->insert([
                ['department_id' => 1, 'student_id' => 1],
                ['department_id' => 2, 'student_id' => 2],
            ]);
        }

        Department::factory()->count(10)->create();
    }
}
