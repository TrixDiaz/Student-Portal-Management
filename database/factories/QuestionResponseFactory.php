<?php

namespace Database\Factories;

use App\Models\EvaluationResponse;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuestionResponse>
 */
class QuestionResponseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Create and attach a student
        $student = User::factory()->create();
        $student->assignRole('student');

        return [
            'evaluation_response_id' => 1,
            'question_id' => Question::factory(),
            'student_id' => $student->id,
            'rating' => fake()->numberBetween(1, 5),
        ];
    }
}
