<?php

namespace App\Livewire\Admin\Users;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Edit extends Component
{
    public $email, $name, $password, $user_id, $roles, $selectedRoles;

    public function mount($user_id)
    {
        $this->user_id = $user_id;
        $this->loadUserData();
        $this->loadRolesData();
    }

    public function loadRolesData()
    {
        $this->roles = Role::all();
    }

    public function loadUserData()
    {
        $user = User::findOrFail($this->user_id);

        if ($user) {
            $this->name = $user->name;
            $this->email = $user->email;
            $this->password = $user->password;
        }
    }

    public function updateUser()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $validated = User::findOrFail($this->user_id);

        if ($validated) {
            $validated->update([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);

            if ($this->selectedRoles) {
                $validated->roles()->sync($this->selectedRoles);
            }


            toastr()->success('User updated successfully!');
            return redirect()->route('admin.users');
        }
    }

    public function render()
    {
        return view('livewire.admin.users.edit',);
    }
}
