<?php

namespace App\Livewire\Student;

use App\Models\Room;
use Livewire\Component;
use App\Models\EvaluationResponse;
use App\Models\StudentGrade;
use App\Models\RoomSection;

class Dashboard extends Component
{
    public $totalSubjects;
    public $subjects;
    public $selectedSemester = null;
    public $selectedYear;
    public $availableYears;
    public $semesters = ['1st', '2nd'];
    public $yearLevels = ['1st', '2nd', '3rd', '4th'];
    public $selectedYearLevel = null;
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
        $query = RoomSection::with(['subject', 'user', 'section', 'room'])
            ->whereHas('student', function ($query) {
                $query->where('student_id', auth()->id());
            })
            ->when($this->selectedSemester, function ($query) {
                $query->where('semester', $this->selectedSemester);
            })
            ->when($this->selectedYearLevel, function ($query) {
                $query->where('year_level', $this->selectedYearLevel);
            })
            ->whereYear('created_at', $this->selectedYear);

        $this->subjects = Room::whereHas('roomSections.students', function ($query) {
            $query->where('student_id', auth()->id());
        })->with(['roomSections' => function ($query) {
            $query->with(['subject', 'teacher', 'section', 'room'])
                ->whereHas('students', function ($q) {
                    $q->where('student_id', auth()->id());
                })
                ->when($this->selectedSemester, function ($q) {
                    $q->where('semester', $this->selectedSemester);
                })
                ->when($this->selectedYearLevel, function ($q) {
                    $q->where('year_level', $this->selectedYearLevel);
                })
                ->whereYear('created_at', $this->selectedYear);
        }])->get();

        $this->totalSubjects = $this->subjects->flatMap->roomSections->count();
    }

    public function checkEvaluation($roomSectionId)
    {
        $evaluationResponse = EvaluationResponse::where('room_section_id', $roomSectionId)
            ->where('student_id', auth()->id())
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
