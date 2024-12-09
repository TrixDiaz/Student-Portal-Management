<?php

namespace Database\Factories;

use App\Models\Evaluation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Phase>
 */
class PhaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'evaluation_id' => Evaluation::factory(),
            'name' => fake()->words(2, true),
            'title' => fake()->words(2, true),
            'description' => fake()->sentence(),
            'order' => fake()->numberBetween(1, 100),
        ];
    }
}
