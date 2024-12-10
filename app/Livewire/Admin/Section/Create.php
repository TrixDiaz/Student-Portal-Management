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
    public $department_id;

    public function mount()
    {
        $this->rooms = Room::all();
        $this->users = collect();
        $this->students = collect();
        $this->department_id = null;
    }

    public function updatedDepartmentId($value)
    {
        if ($value) {
            // Get teachers using the correct relationship and table names
            $this->users = User::role('teacher')
                ->whereExists(function ($query) use ($value) {
                    $query->select(DB::raw(1))
                        ->from('department_teachers')
                        ->whereColumn('department_teachers.teacher_id', 'users.id')
                        ->where('department_teachers.department_id', $value);
                })
                ->get();

            // Get students using the correct relationship and table names
            $this->students = User::role('student')
                ->whereExists(function ($query) use ($value) {
                    $query->select(DB::raw(1))
                        ->from('department_students')
                        ->whereColumn('department_students.student_id', 'users.id')
                        ->where('department_students.department_id', $value);
                })
                ->get();

            // Add debug logging
            \Log::info('Department ID:', ['id' => $value]);
            \Log::info('Teachers found:', ['count' => $this->users->count(), 'teachers' => $this->users->pluck('name')]);
            \Log::info('Students found:', ['count' => $this->students->count(), 'students' => $this->students->pluck('name')]);
        } else {
            $this->users = collect();
            $this->students = collect();
        }

        // Reset selections
        $this->user_id = null;
        $this->student_ids = [];
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
            'department_id' => 'required|exists:departments,id',
        ]);

        DB::transaction(function () {
            // First create the section
            $section = Section::create([
                'name' => $this->name,
            ]);

            // Create room_section record with evaluation_id explicitly set to null
            $roomSection = RoomSection::create([
                'teacher_id' => $this->user_id,
                'room_id' => $this->room_id,
                'section_id' => $section->id,
                'subject_id' => $this->subject_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'semester' => $this->semester,
                'year_level' => $this->year_level,
                'department_id' => $this->department_id,
                'evaluation_id' => null,
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
            'departments' => Department::all(),
            'rooms' => $this->rooms,
            'subjects' => Subject::all(),
            'existingSections' => $this->existingSections,
            'users' => $this->users,
            'students' => $this->students,
        ]);
    }
}
