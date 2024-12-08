<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evaluation;
use App\Models\Phase;
use App\Models\Question;

class EvaluationSeeder extends Seeder
{
    public function run(): void
    {
        // Create main evaluation
        $evaluation = Evaluation::create([
            'order' => 1,
            'title' => 'Teacher Performance Evaluation',
            'description' => 'Evaluate your teacher\'s performance for this semester',
            'rating_scale' => '1-Poor, 2-Fair, 3-Good, 4-Very Good, 5-Excellent',
            'is_active' => true,
        ]);

        // Create phases with questions
        $phases = [
            [
                'name' => 'Teaching Competency',
                'description' => 'Evaluate the teacher\'s ability to deliver lessons effectively',
                'questions' => [
                    'Demonstrates mastery of the subject matter',
                    'Explains the lessons clearly and effectively',
                    'Uses appropriate teaching methods and strategies',
                    'Provides relevant examples and applications',
                ],
            ],
            [
                'name' => 'Class Management',
                'description' => 'Assess how well the teacher manages the classroom',
                'questions' => [
                    'Maintains classroom discipline effectively',
                    'Creates a conducive learning environment',
                    'Manages time efficiently',
                    'Handles student concerns appropriately',
                ],
            ],
            [
                'name' => 'Professional Characteristics',
                'description' => 'Evaluate the teacher\'s professional behavior',
                'questions' => [
                    'Comes to class on time and regularly',
                    'Shows enthusiasm in teaching',
                    'Treats students with respect and fairness',
                    'Demonstrates professional behavior and appearance',
                ],
            ],
        ];

        foreach ($phases as $index => $phaseData) {
            $phase = Phase::create([
                'evaluation_id' => $evaluation->id,
                'name' => $phaseData['name'],
                'description' => $phaseData['description'],
                'order' => $index + 1,
            ]);

            foreach ($phaseData['questions'] as $questionIndex => $questionText) {
                Question::create([
                    'phase_id' => $phase->id,
                    'question' => $questionText,
                    'order' => $questionIndex + 1,
                ]);
            }
        }
    }
}
