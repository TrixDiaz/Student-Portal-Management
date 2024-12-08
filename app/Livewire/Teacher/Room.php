<?php

namespace App\Livewire\Teacher;

use App\Models\Subject;
use App\Models\RoomSection;
use App\Models\RoomSectionStudent;
use App\Models\StudentGrade;
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

    protected $rules = [
        'grade' => 'required|numeric|min:1|max:5',
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

    public function saveGrade()
    {
        $this->validate();

        StudentGrade::create([
            'room_section_id' => $this->selectedRoomSectionId,
            'student_id' => $this->selectedStudentId,
            'grade' => $this->grade,
            'status' => $this->grade <= 3.0 ? 'Passed' : 'Failed'
        ]);

        $this->reset(['grade', 'selectedStudentId', 'selectedRoomSectionId']);
        toastr()->success('Grade added successfully');
    }

    public function render()
    {
        return view('livewire.teacher.room');
    }
}
