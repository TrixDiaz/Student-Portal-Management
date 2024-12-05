<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Room;
use App\Models\RoomSection;
use App\Models\RoomSectionStudent;
use App\Models\Section;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        // Create buildings first
        $buildings = Building::factory(3)->create();

        // Create rooms connected to buildings
        $rooms = [];
        foreach ($buildings as $building) {
            $rooms[] = Room::factory(2)->create([
                'building_id' => $building->id
            ]);
        }

        // Create subjects
        $subjects = Subject::factory(5)->create();

        // Get existing teachers
        $teachers = User::role('teacher')->get();

        // Create sections
        $sections = Section::factory(5)->create();

        // Create room sections
        foreach ($rooms as $buildingRooms) {
            foreach ($buildingRooms as $room) {
                RoomSection::factory(2)->create([
                    'room_id' => $room->id,
                    'section_id' => $sections->random()->id,
                    'subject_id' => $subjects->random()->id,
                    'user_id' => $teachers->random()->id,
                    'semester' => fake()->randomElement(['1st', '2nd']),
                    'start_date' => now(),
                    'end_date' => now()->addMonths(6),
                ]);
            }
        }

        // Get existing students
        $students = User::role('student')->get();

        // Assign students to room sections
        $roomSections = RoomSection::all();
        foreach ($roomSections as $roomSection) {
            // Assign 5-8 random students to each room section
            $randomStudents = $students->random(fake()->numberBetween(5, 8));
            foreach ($randomStudents as $student) {
                RoomSectionStudent::create([
                    'room_section_id' => $roomSection->id,
                    'student_id' => $student->id,
                ]);
            }
        }
    }
}
