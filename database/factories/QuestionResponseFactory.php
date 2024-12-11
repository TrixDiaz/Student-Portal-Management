<?php

namespace Database\Factories;

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
        return [
            'evaluation_response_id' => \App\Models\EvaluationResponse::factory(),
            'question_id' => \App\Models\Question::factory(),
            'student_id' => \App\Models\User::factory(),
            'rating' => $this->faker->numberBetween(1, 5), // Assuming rating is 1-5
        ];
    }
}
