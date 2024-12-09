<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::insert(
            [
                'name' => 'IT Department',
                'courses' => 'Bachelor of Science in Information Technology',
            ],
            [
                'name' => 'Accountancy Department',
                'courses' => 'Bachelor of Science in Accounting Management',
            ],
            [
                'name' => 'Entrepreneurship Department',
                'courses' => 'Bachelor of Science in Entrepreneurship',
            ],
            [
                'name' => 'Education Department',
                'courses' => 'Bachelor of Elementary Education',
            ],
            [
                'name' => 'Business Administration Department',
                'courses' => 'Bachelor of Science in Business Administration',
            ],
        );
    }
}
