<?php

namespace App\Livewire\Admin\Department;

use App\Models\Department;
use App\Models\User;
use App\Notifications\CreateDepartment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class Create extends Component
{
    public $name;
    public $course;
    public $is_active = true;
    public $selectedTeachers = [];
    public $courses = [
        'IT' => 'Bachelor of Science in Information Technology',
        'CS' => 'Bachelor of Science in Computer Science',
        'IS' => 'Bachelor of Science in Information Systems',
        'BA' => 'Bachelor of Arts',
        'BS' => 'Bachelor of Science',
        'BBA' => 'Bachelor of Business Administration',
    ];
    public $teachers;

    public function mount()
    {
        $this->teachers = User::whereHas('roles', function ($query) {
            $query->where('name', 'teacher');
        })->get();
    }

    public function storeDepartment()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
        ]);

        $department = Department::create([
            'name' => $this->name,
            'course' => $this->course,
        ]);

        if ($this->selectedTeachers) {
            $department->users()->sync($this->selectedTeachers);
        }

        Notification::send(Auth::user(), new CreateDepartment($department));
        toastr()->success('Department created successfully');
        return redirect()->route('admin.departments');
    }
    public function render()
    {
        return view('livewire.admin.department.create');
    }
}
