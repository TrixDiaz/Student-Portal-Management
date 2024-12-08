<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Section;
use App\Models\Subject;
use App\Models\User;
use App\Models\Evaluation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoomSection>
 */
class RoomSectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'room_id' => Room::factory(),
            'section_id' => Section::factory(),
            'subject_id' => Subject::factory(),
            'user_id' => User::factory(),
            'semester' => fake()->randomElement(['first', 'second', 'summer']),
            'start_date' => fake()->dateTimeBetween('now', '+1 month'),
            'end_date' => fake()->dateTimeBetween('+2 months', '+6 months'),
            'evaluation_id' => Evaluation::factory(),
        ];
    }
}
