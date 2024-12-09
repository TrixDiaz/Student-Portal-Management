<?php

namespace Database\Seeders;

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
    }
}
