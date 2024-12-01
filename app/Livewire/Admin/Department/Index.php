<?php

namespace App\Livewire\Admin\Department;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use App\Models\Department;
use App\Models\Role;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $archiveStatus = 'Active';
    public $role = 'All';
    public $roles;

    public function mount()
    {
        $this->roles = Role::all();
    }

    public function deleteDepartment($id)
    {
        $department = Department::find($id);
        $department->delete();
        toastr()->info('Department ' . $department->name . ' has been deleted successfully!');
    }

    public function restoreDepartment($id)
    {
        $department = Department::withTrashed()->find($id);
        $department->restore();
        toastr()->info('Department ' . $department->name . ' has been restored successfully!');
        return redirect()->back();
    }

    public function forceDeleteDepartment($id)
    {
        $department = Department::withTrashed()->find($id);
        $department->forceDelete();
        toastr()->error('Department ' . $department->name . ' has been permanently deleted!');
        return redirect()->back();
    }


    public function render()
    {
        $query = Department::query()
            ->where('name', 'like', '%' . $this->search . '%');

        // Filter by archive status
        if ($this->archiveStatus === 'Archived') {
            $query->onlyTrashed();
        } else {
            $query->whereNull('deleted_at');
        }

        return view('livewire.admin.department.index', [
            'departments' => $query->paginate(10)
        ]);
    }
}
