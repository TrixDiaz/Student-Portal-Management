<?php

namespace App\Livewire\Admin\Section;

use App\Models\Department;
use App\Models\RoomSection;
use App\Models\RoomSectionStudent;
use Livewire\Component;
use App\Models\Section;
use App\Models\Room;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Edit extends Component
{
    public $name;
    public $section_id;
    public $section;
    public $roomSection;
    public $room_id;
    public $user_id;
    public $subject_id;
    public $student_ids = [];
    public $start_date;
    public $end_date;
    public $existingSections = [];
    public $semester;
    public $year_level;
    public $departments;
    public $department_id;
    public $users;
    public $students;

    public function mount($section_id)
    {
        $this->section_id = $section_id;
        $this->loadSectionData();
        $this->loadRoomSectionData();
        $this->loadStudentData();
        $this->departments = Department::all();

        // Initialize collections
        $this->users = collect();
        $this->students = collect();

        // Load department-specific users and students
        if ($this->department_id) {
            $this->updatedDepartmentId($this->department_id);
        }
    }

    public function loadSectionData()
    {
        $this->section = Section::findOrFail($this->section_id);
        $this->name = $this->section->name;
    }

    public function loadRoomSectionData()
    {
        $this->roomSection = RoomSection::where('section_id', $this->section_id)->firstOrFail();
        $this->room_id = $this->roomSection->room_id;
        $this->user_id = $this->roomSection->teacher_id;
        $this->subject_id = $this->roomSection->subject_id;
        $this->start_date = $this->roomSection->start_date->format('Y-m-d\TH:i');
        $this->end_date = $this->roomSection->end_date->format('Y-m-d\TH:i');
        $this->semester = $this->roomSection->semester;
        $this->year_level = $this->roomSection->section->year_level;
        $this->department_id = $this->roomSection->section->department_id;
        $this->updatedRoomId();
    }

    public function loadStudentData()
    {
        $this->student_ids = RoomSectionStudent::where('room_section_id', $this->roomSection->id)
            ->pluck('student_id')
            ->toArray();
    }

    public function updatedRoomId()
    {
        if ($this->room_id) {
            $this->existingSections = RoomSection::where('room_id', $this->room_id)
                ->where('section_id', '!=', $this->section_id)
                ->whereHas('section')
                ->with(['section', 'subject', 'teacher'])
                ->orderBy('start_date')
                ->get()
                ->map(function ($roomSection) {
                    return [
                        'name' => $roomSection->selected_name,
                        'start_date' => $roomSection->start_date->format('Y-m-d H:i'),
                        'end_date' => $roomSection->end_date->format('Y-m-d H:i'),
                    ];
                })
                ->toArray();
        } else {
            $this->existingSections = [];
        }
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

    public function updateSection()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'subject_id' => 'required|exists:subjects,id',
            'semester' => 'required|in:1st,2nd',
            'year_level' => 'required|in:1st,2nd,3rd,4th',
            'department_id' => 'required|exists:departments,id',
        ]);

        DB::transaction(function () {
            $this->section->update([
                'name' => $this->name,
                'year_level' => $this->year_level,
                'department_id' => $this->department_id,
            ]);

            $this->roomSection->update([
                'teacher_id' => $this->user_id,
                'room_id' => $this->room_id,
                'subject_id' => $this->subject_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'semester' => $this->semester,
            ]);

            // Delete existing student associations
            RoomSectionStudent::where('room_section_id', $this->roomSection->id)->delete();

            // Create new student associations
            foreach ($this->student_ids as $studentId) {
                RoomSectionStudent::create([
                    'room_section_id' => $this->roomSection->id,
                    'student_id' => $studentId,
                ]);
            }

            return redirect()->route('admin.sections')->with('success', 'Section updated successfully');
        });
    }

    public function render()
    {
        return view('livewire.admin.section.edit', [
            'section' => $this->section,
            'rooms' => Room::all(),
            'subjects' => Subject::all(),
            'departments' => $this->departments,
            'users' => $this->users,
            'students' => $this->students,
        ]);
    }
}
