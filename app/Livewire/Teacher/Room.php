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

    protected $rules = [
        'grade' => 'required|numeric|min:1|max:5',
        'quizzes.*.quiz_name' => 'required|string',
        'quizzes.*.quiz_score' => 'required|numeric|min:0',
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
            ->where('user_id', auth()->id())
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
            'quiz_score' => null
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

        // Calculate quiz total
        $this->quizTotal = collect($this->quizzes)->sum('quiz_score');

        // Add quiz total to the quizzes array
        $quizData = [
            'quizzes' => $this->quizzes,
            'quiz_total' => $this->quizTotal
        ];

        $studentGrade = StudentGrade::create([
            'room_section_id' => $this->selectedRoomSectionId,
            'student_id' => $this->selectedStudentId,
            'grade' => $this->grade,
            'status' => $this->grade <= 3.0 ? 'Passed' : 'Failed',
            'quiz_scores' => $quizData
        ]);

        Notification::send([$studentGrade->student, auth()->user()], new StudentGradeNotification($studentGrade));
        $this->reset(['grade', 'selectedStudentId', 'selectedRoomSectionId', 'quizzes', 'quizTotal']);
        toastr()->success('Grade added successfully');
    }

    public function render()
    {
        return view('livewire.teacher.room');
    }
}
