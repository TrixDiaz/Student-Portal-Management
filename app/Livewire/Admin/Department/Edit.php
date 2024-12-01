<?php

namespace App\Livewire\Admin\Department;

use App\Models\Department;
use App\Models\User;
use Livewire\Component;

class Edit extends Component
{
    public $department_id;
    public $department;
    public $teachers;
    public $name;
    public $selectedTeachers;
    public function mount($department_id)
    {
        $this->department_id = $department_id;
        $this->loadDepartmentData();
        $this->loadTeachersData();
    }

    public function loadDepartmentData()
    {
        $this->department = Department::findOrFail($this->department_id);

        $this->name = $this->department->name;
        $this->selectedTeachers = $this->department->users->pluck('id');
    }

    public function loadTeachersData()
    {
        $this->teachers = User::whereHas('roles', function ($query) {
            $query->where('name', 'teacher');
        })->get();
    }

    public function updateDepartment()
    {
        $this->department->update([
            'name' => $this->name,
        ]);

        if ($this->selectedTeachers) {
            $this->department->users()->sync($this->selectedTeachers);
        }

        toastr()->success('Department updated successfully!');
        return redirect()->route('admin.departments');
    }

    public function render()
    {
        return view('livewire.admin.department.edit', [
            'department' => $this->department,
            'teachers' => $this->teachers,
        ]);
    }
}
