<?php

namespace App\Livewire\Admin\Roles;

use App\Models\Role;
use App\Models\Permission;
use Livewire\Component;

class Create extends Component
{
    public $name;
    public $guard_name = 'web';
    public $permissions;
    public $selectedPermissions = [];

    public function mount()
    {
        $this->permissions = Permission::getRecord();
    }

    public function storeRole()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'unique:roles,name', 'lowercase', 'max:255'],
            'guard_name' => ['required', 'string', 'max:255'],
            'selectedPermissions' => ['array'],
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => $validated['guard_name'],
        ]);

        $permissionNames = Permission::whereIn('id', $this->selectedPermissions)
            ->pluck('name')
            ->toArray();

        $role->syncPermissions($permissionNames);

        toastr()->success('Role created successfully');
        return redirect()->route('admin.roles');
    }

    public function render()
    {
        return view('livewire.admin.roles.create');
    }
}
