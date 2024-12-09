<?php

namespace Database\Seeders;

use App\Models\RoomSection;
use App\Models\RoomSectionStudent;
use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Section::insert([
            [
                'id' => 1,
                'name' => 'Section 1',
                'is_active' => true,
            ],
            [
                'id' => 2,
                'name' => 'Section 2',
                'is_active' => true,
            ],
        ]);

        RoomSection::insert([
            [
                'teacher_id' => 1,
                'room_id' => 1,
                'section_id' => 1,
                'subject_id' => 1,
                'evaluation_id' => 1,
                'department_id' => 1,
                'year_level' => '1st',
                'semester' => '1st',
                'start_date' => '2024-01-01 10:00:00',
                'end_date' => '2024-01-01 12:00:00',
            ],
            [
                'teacher_id' => 2,
                'room_id' => 2,
                'section_id' => 2,
                'subject_id' => 2,
                'evaluation_id' => 1,
                'department_id' => 2,
                'year_level' => '2nd',
                'semester' => '2nd',
                'start_date' => '2024-01-01 10:00:00',
                'end_date' => '2024-01-01 12:00:00',
            ],
        ]);

        RoomSectionStudent::insert([
            [
                'room_section_id' => 1,
                'student_id' => 4,
            ],
            [
                'room_section_id' => 2,
                'student_id' => 4,
            ],
            [
                'room_section_id' => 1,
                'student_id' => 5,
            ],
            [
                'room_section_id' => 2,
                'student_id' => 5,
            ],
            [
                'room_section_id' => 2,
                'student_id' => 6,
            ],
            [
                'room_section_id' => 1,
                'student_id' => 6,
            ],
            [
                'room_section_id' => 2,
                'student_id' => 7,
            ],
            [
                'room_section_id' => 1,
                'student_id' => 7,
            ],
            [
                'room_section_id' => 2,
                'student_id' => 8,
            ],
            [
                'room_section_id' => 1,
                'student_id' => 8,
            ],
        ]);
    }
}
