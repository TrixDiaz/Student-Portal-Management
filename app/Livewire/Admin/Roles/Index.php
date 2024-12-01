<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function archiveUser($id)
    {
        $role = Role::find($id);
        toastr()->info('Role ' . $role->name . ' has been archived successfully!');
        Role::find($id)->delete();
        redirect()->back();
    }

    public function render()
    {
        return view('livewire.admin.roles.index', [
            'roles' => Role::where('name', 'like', '%' . $this->search . '%')->paginate(10),
        ]);
    }
}
