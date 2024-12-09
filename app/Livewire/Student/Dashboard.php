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
    public $semesters = ['1st', '2nd'];
    public $yearLevels = ['1st', '2nd', '3rd', '4th'];
    public $selectedYearLevel = null;
    public $hasCompletedEvaluation = false;
    public $grade = null;
    public $status = null;

    public function mount()
    {
        $this->selectedYear = date('Y');
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
        $studentId = auth()->id();

        $this->subjects = Room::whereHas('roomSections', function ($query) use ($studentId) {
            $query->join('room_section_students', 'room_sections.id', '=', 'room_section_students.room_section_id')
                ->where('room_section_students.student_id', $studentId)
                ->when($this->selectedSemester, function ($q) {
                    $q->where('room_sections.semester', $this->selectedSemester);
                })
                ->when($this->selectedYearLevel, function ($q) {
                    $q->where('room_sections.year_level', $this->selectedYearLevel);
                });
        })
            ->with(['roomSections' => function ($query) use ($studentId) {
                $query->join('room_section_students', 'room_sections.id', '=', 'room_section_students.room_section_id')
                    ->where('room_section_students.student_id', $studentId)
                    ->when($this->selectedSemester, function ($q) {
                        $q->where('room_sections.semester', $this->selectedSemester);
                    })
                    ->when($this->selectedYearLevel, function ($q) {
                        $q->where('room_sections.year_level', $this->selectedYearLevel);
                    })
                    ->with(['subject', 'teacher', 'section', 'room']);
            }])
            ->get();

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
