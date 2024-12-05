<?php

namespace Database\Factories;

use App\Models\RoomSection;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoomSectionStudent>
 */
class RoomSectionStudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'room_section_id' => RoomSection::factory(),
            'student_id' => User::factory(),
        ];
    }
}
