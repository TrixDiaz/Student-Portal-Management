<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evaluation>
 */
class EvaluationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'order' => fake()->numberBetween(1, 100),
            'rating_scale' => '1-Poor, 2-Fair, 3-Good, 4-Very Good, 5-Excellent',
            'is_active' => true,
        ];
    }
}
