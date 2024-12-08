<?php

namespace App\Livewire\Chart;

use Livewire\Component;
use App\Models\StudentGrade;
use Illuminate\Support\Facades\Auth;

class Grade extends Component
{
    public $grades = [];
    public $averageGrade = 0;
    public $averageFails = 0;

    public function mount()
    {
        // Get authenticated student's grades grouped by semester
        $studentGrades = StudentGrade::with('roomSection')
            ->whereHas('roomSection', function ($query) {
                $query->whereNotNull('semester');
            })
            ->get()
            ->groupBy('roomSection.semester');

        // Format data for the chart
        $firstSemester = $studentGrades->get('1st', collect());
        $secondSemester = $studentGrades->get('2nd', collect());

        $firstSemesterGrade = $firstSemester->pluck('grade')->avg() ?? 0;
        $secondSemesterGrade = $secondSemester->pluck('grade')->avg() ?? 0;

        // Count fails per semester (assuming grade < 3 is a fail)
        $firstSemesterFails = $firstSemester->where('grade', '>', 3)->count();
        $secondSemesterFails = $secondSemester->where('grade', '>', 3)->count();

        $this->grades = [
            [
                'name' => 'Grades',
                'color' => '#1A56DB',
                'data' => [
                    ['x' => '1st Semester', 'y' => round($firstSemesterGrade, 2)],
                    ['x' => '2nd Semester', 'y' => round($secondSemesterGrade, 2)],
                ],
            ],
            [
                'name' => 'Failed Subjects',
                'color' => '#DC2626', // Red color for fails
                'data' => [
                    ['x' => '1st Semester', 'y' => $firstSemesterFails],
                    ['x' => '2nd Semester', 'y' => $secondSemesterFails],
                ],
            ]
        ];

        $this->averageGrade = round(($firstSemesterGrade + $secondSemesterGrade) / 2, 2);
        $this->averageFails = round(($firstSemesterFails + $secondSemesterFails) / 2, 2);
    }

    public function render()
    {
        return view('livewire.chart.grade');
    }
}
