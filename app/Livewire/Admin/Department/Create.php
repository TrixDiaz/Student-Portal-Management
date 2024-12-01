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
    public $is_active = true;
    public $selectedTeachers = [];
    public $teachers;

    public function mount()
    {
        $this->teachers = User::whereHas('roles', function ($query) {
            $query->where('name', 'teacher');
        })->get();
    }

    public function storeDepartment()
    {
        $department = Department::create([
            'name' => $this->name,
            'is_active' => $this->is_active,
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
