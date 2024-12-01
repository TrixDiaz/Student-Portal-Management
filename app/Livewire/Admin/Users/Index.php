<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
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

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
        toastr()->info('User ' . $user->name . ' has been deleted successfully!');
    }

    public function restoreUser($id)
    {
        $user = User::withTrashed()->find($id);
        $user->restore();
        toastr()->info('User ' . $user->name . ' has been restored successfully!');
        return redirect()->back();
    }

    public function forceDeleteUser($id)
    {
        $user = User::withTrashed()->find($id);
        $user->forceDelete();
        toastr()->error('User ' . $user->name . ' has been permanently deleted!');
        return redirect()->back();
    }

    public function render()
    {
        $query = User::query()
            ->where('name', 'like', '%' . $this->search . '%');

        // Filter by archive status
        if ($this->archiveStatus === 'Archived') {
            $query->onlyTrashed();
        } else {
            $query->whereNull('deleted_at');
        }

        // Filter by role
        if ($this->role !== 'All') {
            $query->whereHas('roles', function ($query) {
                $query->where('name', $this->role);
            });
        }

        return view('livewire.admin.users.index', [
            'users' => $query->paginate(10)
        ]);
    }
}
