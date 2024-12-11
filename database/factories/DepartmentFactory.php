<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'course' => fake()->randomElement(['IT', 'CS', 'IS', 'BA', 'BS', 'BBA']),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Department $department) {
            // Create and attach a teacher
            $teacher = User::factory()->create();
            $teacher->assignRole('teacher');
            $department->users()->attach($teacher->id);

            // Create and attach a student
            $student = User::factory()->create();
            $student->assignRole('student');
            $department->students()->attach($student->id);
        });
    }
}
