<?php

namespace App\Livewire\Admin\Department;

use App\Models\Department;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Edit extends Component
{
    public $department_id;
    public $department;
    public $teachers;
    public $students;
    public $name;
    public $course;
    public $selectedTeachers = [];
    public $selectedStudents = [];
    public $courses = [
        'IT' => 'Bachelor of Science in Information Technology',
        'CS' => 'Bachelor of Science in Computer Science',
        'IS' => 'Bachelor of Science in Information Systems',
        'BA' => 'Bachelor of Arts',
        'BS' => 'Bachelor of Science',
        'BBA' => 'Bachelor of Business Administration',
    ];
    public function mount($department_id)
    {
        $this->department_id = $department_id;
        $this->loadDepartmentData();
        $this->loadTeachersData();
    }

    public function loadDepartmentData()
    {
        $this->department = Department::with(['users', 'students'])->findOrFail($this->department_id);

        $this->name = $this->department->name;
        $this->course = $this->department->course;
        $this->selectedTeachers = $this->department->users ? $this->department->users->pluck('id')->toArray() : [];
        $this->selectedStudents = $this->department->students ? $this->department->students->pluck('id')->toArray() : [];
    }

    public function loadTeachersData()
    {
        $this->teachers = User::role('teacher')->get();
        $this->students = User::role('student')->get();
    }

    public function updateDepartment()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'course' => 'required',
            'selectedTeachers' => 'required|array|min:1',
            'selectedTeachers.*' => 'exists:users,id',
            'selectedStudents' => 'required|array|min:1',
            'selectedStudents.*' => 'exists:users,id',
        ]);

        DB::transaction(function () {
            $this->department->update([
                'name' => $this->name,
                'course' => $this->course,
            ]);

            if ($this->selectedTeachers) {
                $this->department->users()->sync($this->selectedTeachers);
            }

            if ($this->selectedStudents) {
                $this->department->students()->sync($this->selectedStudents);
            }
        });

        toastr()->success('Department updated successfully!');
        return redirect()->route('admin.departments');
    }

    public function render()
    {
        return view('livewire.admin.department.edit', [
            'department' => $this->department,
            'teachers' => $this->teachers,
            'students' => $this->students,
        ]);
    }
}
