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
        return [
            'evaluation_response_id' => EvaluationResponse::factory(),
            'question_id' => Question::factory(),
            'student_id' => User::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
        ];
    }
}
