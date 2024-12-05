<?php

namespace App\Livewire\Teacher;

use Livewire\Component;
use App\Models\StudentGrade;

class AddGrade extends Component
{
    public $showModal = false;
    public $studentId;
    public $roomSectionId;
    public $grade;

    protected $rules = [
        'grade' => 'required|numeric|min:1|max:5',
    ];

    public function mount($roomSectionId)
    {
        $this->roomSectionId = $roomSectionId;
    }

    public function openModal($studentId)
    {
        $this->studentId = $studentId;
        $this->showModal = true;
    }

    public function saveGrade()
    {
        $this->validate();

        StudentGrade::create([
            'room_section_id' => $this->roomSectionId,
            'student_id' => $this->studentId,
            'grade' => $this->grade,
            'status' => $this->grade <= 3.0 ? 'Passed' : 'Failed'
        ]);

        $this->reset(['grade', 'showModal']);
        $this->dispatch('grade-added');
    }

    public function render()
    {
        return view('livewire.teacher.add-grade');
    }
}
