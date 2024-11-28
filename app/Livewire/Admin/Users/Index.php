<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $archiveStatus = 'Active';
    public $role = 'All';

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
        toastr()->info('User ' . $user->name . ' has been deleted successfully!');
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
            $query->where('role', $this->role);
        }

        return view('livewire.admin.users.index', [
            'users' => $query->paginate(10)
        ]);
    }
}
