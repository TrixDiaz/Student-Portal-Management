<?php

namespace App\Livewire\Chart;

use App\Models\StudentGrade;
use Livewire\Component;

class QuizScore extends Component
{
    public $grades = [];
    public $averageGrade = 0;
    public $averageFails = 0;

    public function mount()
    {
        // Get authenticated student's grades with quiz scores
        $studentGrades = StudentGrade::with('roomSection')
            ->whereHas('roomSection', function ($query) {
                $query->whereNotNull('semester');
            })
            ->get();

        // Collect all quiz scores
        $quizScores = collect();
        foreach ($studentGrades as $grade) {
            if (!empty($grade->quiz_scores['quizzes'])) {
                foreach ($grade->quiz_scores['quizzes'] as $quiz) {
                    $percentage = min(round(($quiz['quiz_score'] / $quiz['quiz_over']) * 100, 2), 100);
                    $quizScores->push([
                        'name' => $quiz['quiz_name'],
                        'percentage' => $percentage,
                        'isHigh' => $percentage >= 75 // Threshold for high scores
                    ]);
                }
            }
        }

        // Calculate averages (capped at 100%)
        $this->averageGrade = min($quizScores->avg('percentage'), 100);
        $this->averageFails = $quizScores->where('isHigh', false)->count();

        // Format data for the chart with two series
        $this->grades = [
            [
                'name' => 'High Scores',
                'color' => '#1A56DB', // Blue
                'data' => $quizScores->where('isHigh', true)
                    ->map(function ($quiz) {
                        return [
                            'x' => $quiz['name'],
                            'y' => min($quiz['percentage'], 100) // Ensure maximum of 100%
                        ];
                    })->values()->all()
            ],
            [
                'name' => 'Low Scores',
                'color' => '#DC2626', // Red
                'data' => $quizScores->where('isHigh', false)
                    ->map(function ($quiz) {
                        return [
                            'x' => $quiz['name'],
                            'y' => min($quiz['percentage'], 100) // Ensure maximum of 100%
                        ];
                    })->values()->all()
            ]
        ];
    }

    public function render()
    {
        return view('livewire.chart.quiz-score');
    }
}
