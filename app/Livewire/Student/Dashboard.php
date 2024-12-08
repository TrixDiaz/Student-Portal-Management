<?php

namespace App\Livewire\Student;

use App\Models\Room;
use Livewire\Component;
use App\Models\EvaluationResponse;
use App\Models\StudentGrade;

class Dashboard extends Component
{
    public $totalSubjects;
    public $subjects;
    public $selectedSemester = null;
    public $selectedYear;
    public $availableYears;
    public $semesters = ['first', 'second', 'summer'];
    public $hasCompletedEvaluation = false;
    public $grade = null;
    public $status = null;

    public function mount()
    {
        $this->selectedYear = date('Y');
        $this->availableYears = range(date('Y') - 4, date('Y'));
        $this->updateTotalSubjects();
    }

    public function updatedSelectedSemester()
    {
        $this->updateTotalSubjects();
    }

    public function updatedSelectedYear()
    {
        $this->updateTotalSubjects();
    }

    private function updateTotalSubjects()
    {
        $query = Room::forStudent(
            auth()->user()->id,
            $this->selectedSemester,
            $this->selectedYear
        );

        $this->subjects = $query->with(['roomSections' => function ($query) {
            $query->with(['subject', 'user', 'studentGrades' => function ($query) {
                $query->where('student_id', auth()->id());
            }])
                ->when($this->selectedSemester, function ($query) {
                    $query->where('semester', $this->selectedSemester);
                })
                ->whereYear('created_at', $this->selectedYear)
                ->whereHas('students', function ($query) {
                    $query->where('users.id', auth()->user()->id);
                });
        }])->get();

        $this->totalSubjects = $this->subjects->sum('subjects_count');
    }

    public function checkEvaluation($roomSectionId)
    {
        $evaluationResponse = EvaluationResponse::where('room_section_id', $roomSectionId)
            ->where('user_id', auth()->id())
            ->first();

        $this->hasCompletedEvaluation = $evaluationResponse?->is_completed ?? false;

        if ($this->hasCompletedEvaluation) {
            $grade = StudentGrade::where('room_section_id', $roomSectionId)
                ->where('student_id', auth()->id())
                ->first();

            $this->grade = $grade?->grade;
            $this->status = $grade?->status;
        } else {
            $this->grade = null;
            $this->status = null;
        }
    }

    public function redirectToEvaluation($roomSectionId)
    {
        return redirect()->route('student.evaluation', ['roomSection' => $roomSectionId]);
    }

    public function render()
    {
        return view('livewire.student.dashboard');
    }
}
