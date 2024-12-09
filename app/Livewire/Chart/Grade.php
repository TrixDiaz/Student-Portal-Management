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
    public $selectedSemester;
    public $selectedYear;

    public function updated($property)
    {
        if ($property === 'selectedSemester' || $property === 'selectedYear') {
            $this->loadData();
        }
    }

    private function loadData()
    {
        $studentGrades = StudentGrade::with('roomSection')
            ->whereHas('roomSection', function ($query) {
                $query->whereHas('students', function ($q) {
                    $q->where('users.id', Auth::id());
                });

                if ($this->selectedYear) {
                    $query->whereYear('start_date', $this->selectedYear);
                }
            })
            ->get()
            ->groupBy('roomSection.semester');

        // Initialize variables
        $semesterData = [];
        $failsData = [];
        $totalGrade = 0;
        $totalFails = 0;
        $semesterCount = 0;

        if ($this->selectedSemester) {
            $selectedSemesterGrades = $studentGrades->get($this->selectedSemester, collect());
            $grade = $selectedSemesterGrades->pluck('grade')->avg() ?? 0;
            $fails = $selectedSemesterGrades->where('grade', '>', 3)->count();

            $semesterData[] = ['x' => $this->selectedSemester . ' Semester', 'y' => round($grade, 2)];
            $failsData[] = ['x' => $this->selectedSemester . ' Semester', 'y' => $fails];

            $totalGrade = $grade;
            $totalFails = $fails;
            $semesterCount = 1;
        } else {
            $firstSemester = $studentGrades->get('1st', collect());
            $secondSemester = $studentGrades->get('2nd', collect());

            $firstGrade = $firstSemester->pluck('grade')->avg() ?? 0;
            $secondGrade = $secondSemester->pluck('grade')->avg() ?? 0;

            $firstFails = $firstSemester->where('grade', '>', 3)->count();
            $secondFails = $secondSemester->where('grade', '>', 3)->count();

            $semesterData = [
                ['x' => '1st Semester', 'y' => round($firstGrade, 2)],
                ['x' => '2nd Semester', 'y' => round($secondGrade, 2)]
            ];

            $failsData = [
                ['x' => '1st Semester', 'y' => $firstFails],
                ['x' => '2nd Semester', 'y' => $secondFails]
            ];

            $totalGrade = $firstGrade + $secondGrade;
            $totalFails = $firstFails + $secondFails;
            $semesterCount = 2;
        }

        $this->grades = [
            [
                'name' => 'Grades',
                'color' => '#1A56DB',
                'data' => $semesterData,
            ],
            [
                'name' => 'Failed Subjects',
                'color' => '#DC2626',
                'data' => $failsData,
            ]
        ];

        $this->averageGrade = $semesterCount > 0 ? round($totalGrade / $semesterCount, 2) : 0;
        $this->averageFails = $semesterCount > 0 ? round($totalFails / $semesterCount, 2) : 0;
    }

    public function mount($selectedSemester, $selectedYear)
    {
        $this->selectedSemester = $selectedSemester;
        $this->selectedYear = $selectedYear;
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.chart.grade');
    }
}
