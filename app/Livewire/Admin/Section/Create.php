<?php

namespace App\Livewire\Admin\Section;

use App\Models\Room;
use App\Models\RoomSection;
use Livewire\Component;
use App\Models\Section;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\RoomSectionStudent;
use App\Models\Subject;
use App\Models\Evaluation;
use App\Models\Department;

class Create extends Component
{
    public $name;
    public $user_id;
    public $room_id;
    public $student_ids = [];
    public $subject_id;
    public $start_date;
    public $end_date;
    public $rooms;
    public $existingSections = [];
    public $users;
    public $students;
    public $semester;
    public $year_level;
    public $evaluation_id;
    public $department_id;

    public function mount()
    {
        $this->rooms = Room::all();
        $this->users = User::role('teacher')->get();
        $this->students = User::role('student')->get();

        // Set default start_date to 7 days from now
        $this->start_date = now()->addDays(7)->format('Y-m-d\TH:i');

        // Set default end_date to 7 days from start_date
        $this->end_date = now()->addDays(14)->format('Y-m-d\TH:i');

        $this->evaluation_id = null;
        $this->department_id = null;
    }

    public function updatedRoomId()
    {
        if ($this->room_id) {
            $this->existingSections = RoomSection::where('room_id', $this->room_id)
                ->whereHas('section')
                ->with('section')
                ->orderBy('start_date')
                ->get()
                ->map(function ($roomSection) {
                    return [
                        'name' => $roomSection->section?->name ?? 'Unknown Section',
                        'start_date' => $roomSection->start_date->format('Y-m-d H:i'),
                        'end_date' => $roomSection->end_date->format('Y-m-d H:i'),
                    ];
                })
                ->toArray();
        } else {
            $this->existingSections = [];
        }
    }

    public function storeSection()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'semester' => 'required|in:1st,2nd',
            'year_level' => 'required|in:1st,2nd,3rd,4th',
            'evaluation_id' => 'nullable|exists:evaluations,id',
            'department_id' => 'required|exists:departments,id',
        ]);

        DB::transaction(function () {
            // First create the section
            $section = Section::create([
                'name' => $this->name,
            ]);

            // Create room_section record with evaluation_id set to null
            $roomSection = RoomSection::create([
                'teacher_id' => $this->user_id,
                'room_id' => $this->room_id,
                'section_id' => $section->id,
                'subject_id' => $this->subject_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'evaluation_id' => $this->evaluation_id,
                'semester' => $this->semester,
                'year_level' => $this->year_level,
                'department_id' => $this->department_id,
            ]);

            // Create room_section_student records for each selected student
            foreach ($this->student_ids as $studentId) {
                RoomSectionStudent::create([
                    'room_section_id' => $roomSection->id,
                    'student_id' => $studentId,
                ]);
            }

            return redirect()->route('admin.sections')->with('success', 'Section created successfully.');
        });
    }
    public function render()
    {
        return view('livewire.admin.section.create', [
            'users' => User::role('teacher')->get(),
            'students' => User::role('student')->get(),
            'rooms' => Room::all(),
            'subjects' => Subject::all(),
            'existingSections' => $this->existingSections,
            'evaluations' => Evaluation::all(),
            'departments' => Department::all(),
        ]);
    }
}
