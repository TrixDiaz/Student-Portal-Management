<?php

namespace App\Livewire\Admin\Roles;

use App\Models\Role;
use App\Models\Permission;
use Livewire\Component;

class Edit extends Component
{
    public $role_id;
    public $name;
    public $guard_name;
    public $permissions;
    public $selectedPermissions = [];

    public function mount($role_id)
    {
        $this->role_id = $role_id;
        $this->loadRoleData();
        $this->permissions = Permission::getRecord();

        // Load existing permissions using IDs
        $role = Role::find($role_id);
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
    }

    public function loadRoleData()
    {
        $role = Role::find($this->role_id);
        $this->name = $role->name;
        $this->guard_name = $role->guard_name;
    }

    public function updateRole()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'unique:roles,name,' . $this->role_id, 'lowercase', 'max:255'],
        ]);

        $role = Role::find($this->role_id);
        $role->update($validated);

        // Get Permission models instead of just IDs
        $permissions = Permission::whereIn('id', $this->selectedPermissions)->get();

        // Sync the permissions using the Permission models
        $role->syncPermissions($permissions);

        toastr()->info('Role updated successfully');
        return redirect()->route('admin.roles');
    }

    public function render()
    {
        return view('livewire.admin.roles.edit');
    }
}
