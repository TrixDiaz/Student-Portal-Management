<?php

namespace App\Livewire\Student;

use App\Models\Room;
use Livewire\Component;
use App\Models\EvaluationResponse;
use App\Models\StudentGrade;
use App\Models\RoomSection;
use App\Http\Controllers\DashboardController;

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
    public $rooms;
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
                    ->with([
                        'subject',
                        'teacher',
                        'section',
                        'room',
                        'studentGrades' => function ($q) use ($studentId) {
                            $q->where('student_id', $studentId);
                        }
                    ]);
            }])
            ->get();

        $this->totalSubjects = $this->subjects->flatMap->roomSections->count();
    }

    public function checkEvaluation($roomSectionId)
    {
        $studentId = auth()->id();

        // First check evaluation response
        $evaluationResponse = EvaluationResponse::where('room_section_id', $roomSectionId)
            ->where('student_id', $studentId)
            ->first();

        $this->hasCompletedEvaluation = $evaluationResponse?->is_completed ?? false;

        // Always check for grade regardless of evaluation status
        $grade = StudentGrade::where('room_section_id', $roomSectionId)
            ->where('student_id', $studentId)
            ->first();

        // Set grade and status even if evaluation is not completed
        $this->grade = $grade?->grade;
        $this->status = $grade?->status;

        // Add logging to debug
        logger('Check Evaluation:', [
            'roomSectionId' => $roomSectionId,
            'studentId' => $studentId,
            'hasCompletedEvaluation' => $this->hasCompletedEvaluation,
            'grade' => $this->grade,
            'status' => $this->status
        ]);
    }

    public function redirectToEvaluation($roomSectionId)
    {
        // Check if user has student role
        if (!auth()->user()->hasRole('student')) {
            return;
        }

        return redirect()->route('student.evaluation', ['roomSection' => $roomSectionId]);
    }

    public function render()
    {
        return view('livewire.student.dashboard');
    }

    public function checkEvaluationStatus($roomSectionId)
    {
        // Get the grade for the current student and room section
        $grade = StudentGrade::where('student_id', auth()->id())
            ->where('room_section_id', $roomSectionId)
            ->first();

        // Check if evaluation is completed
        $evaluationResponse = EvaluationResponse::where('room_section_id', $roomSectionId)
            ->where('student_id', auth()->id())
            ->where('is_completed', true)
            ->first();

        return [
            'grade' => $grade,
            'evaluationResponse' => $evaluationResponse
        ];
    }
}
