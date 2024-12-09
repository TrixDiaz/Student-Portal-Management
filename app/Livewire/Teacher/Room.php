<?php

namespace App\Livewire\Teacher;

use App\Models\Subject;
use App\Models\RoomSection;
use App\Models\RoomSectionStudent;
use App\Models\StudentGrade;
use App\Notifications\StudentGradeNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class Room extends Component
{
    public $subjectId;
    public $subject;
    public $roomSections;
    public $studentId;
    public $showModal = false;
    public $grade;
    public $selectedStudentId;
    public $selectedRoomSectionId;
    public $quizzes = [];
    public $quizTotal = 0;
    public $prelim_grade;
    public $midterm_grade;
    public $final_grade;

    protected $rules = [
        'grade' => 'nullable|numeric|min:max:5',
        'prelim_grade' => 'nullable|numeric|min:0|max:5',
        'midterm_grade' => 'nullable|numeric|min:0|max:5',
        'final_grade' => 'nullable|numeric|min:0|max:5',
        'quizzes.*.quiz_name' => 'nullable|string',
        'quizzes.*.quiz_score' => 'nullable|numeric|min:0',
        'quizzes.*.quiz_over' => 'nullable|numeric|min:1',
    ];

    public function removeStudent($studentId)
    {
        $roomSectionStudent = RoomSectionStudent::where('student_id', $studentId)
            ->whereIn('room_section_id', $this->roomSections->pluck('id'))
            ->firstOrFail();

        $roomSectionStudent->delete();

        // Refresh the room sections data
        $this->mount($this->subjectId);
        $this->dispatch('student-removed');
        toastr()->success('Student removed successfully');
    }

    public function mount($subjectId)
    {
        $this->subject = Subject::findOrFail($subjectId);
        $this->subjectId = $subjectId;

        $this->roomSections = RoomSection::where('subject_id', $this->subjectId)
            ->where('teacher_id', auth()->id())
            ->with([
                'students',
                'section',
                'subject',
                'room.building',
                'room',
                'user',
                'students.grades'
            ])
            ->get();
    }

    public function addQuiz()
    {
        $this->quizzes[] = [
            'quiz_name' => '',
            'quiz_score' => null,
            'quiz_over' => null
        ];
    }

    public function removeQuiz($index)
    {
        unset($this->quizzes[$index]);
        $this->quizzes = array_values($this->quizzes);
    }

    public function saveGrade()
    {
        $this->validate();

        // Calculate quiz totals only if quizzes exist
        $quizScores = null;
        if (!empty($this->quizzes)) {
            $quizTotal = collect($this->quizzes)->sum('quiz_score');
            $quizOverTotal = collect($this->quizzes)->sum('quiz_over');

            $quizScores = [
                'quizzes' => collect($this->quizzes)->map(function ($quiz) {
                    $percentage = $quiz['quiz_over'] > 0 ? ($quiz['quiz_score'] / $quiz['quiz_over']) * 100 : 0;
                    return [
                        'quiz_name' => $quiz['quiz_name'],
                        'quiz_score' => $quiz['quiz_score'],
                        'quiz_over' => $quiz['quiz_over'],
                        'status' => $percentage >= 75 ? 'Passed' : 'Failed',
                        'percentage' => round($percentage, 2)
                    ];
                })->toArray(),
                'quiz_total' => $quizTotal,
                'quiz_over_total' => $quizOverTotal,
                'total_percentage' => $quizOverTotal > 0 ? round(($quizTotal / $quizOverTotal) * 100, 2) : 0
            ];
        }

        $status = null;
        if ($this->grade !== null) {
            $status = $this->grade <= 3.0 ? 'Passed' : 'Failed';
        }

        $studentGrade = StudentGrade::create([
            'room_section_id' => $this->selectedRoomSectionId,
            'student_id' => $this->selectedStudentId,
            'grade' => $this->grade,
            'prelim_grade' => $this->prelim_grade,
            'midterm_grade' => $this->midterm_grade,
            'final_grade' => $this->final_grade,
            'status' => $status,
            'quiz_scores' => $quizScores
        ]);

        Notification::send([$studentGrade->student, auth()->user()], new StudentGradeNotification($studentGrade));
        $this->reset(['grade', 'prelim_grade', 'midterm_grade', 'final_grade', 'selectedStudentId', 'selectedRoomSectionId', 'quizzes']);
        toastr()->success('Grade added successfully');
    }

    public function render()
    {
        return view('livewire.teacher.room');
    }
}
