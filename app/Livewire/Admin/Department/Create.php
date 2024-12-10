<?php

namespace App\Livewire\Admin\Department;

use App\Models\Department;
use App\Models\DepartmentStudents;
use App\Models\DepartmentUser;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Create extends Component
{
    public $name;
    public $course;
    public $selectedTeachers = [];
    public $selectedStudents = [];

    public function storeDepartment()
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
            $department = Department::create([
                'name' => $this->name,
                'course' => $this->course,
            ]);

            // Create department teacher records
            foreach ($this->selectedTeachers as $teacherId) {
                DepartmentUser::create([
                    'department_id' => $department->id,
                    'teacher_id' => $teacherId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Create department student records
            foreach ($this->selectedStudents as $studentId) {
                DepartmentStudents::create([
                    'department_id' => $department->id,
                    'student_id' => $studentId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return redirect()->route('admin.departments')->with('success', 'Department created successfully.');
        });
    }

    public function render()
    {
        return view('livewire.admin.department.create', [
            'teachers' => User::role('teacher')->get(),
            'students' => User::role('student')->get(),
            'courses' => [
                'BSIT' => 'Bachelor of Science in Information Technology',
                // Add other courses as needed
            ],
        ]);
    }
}
