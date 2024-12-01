<?php

namespace App\Livewire\Admin\Users;

use App\Models\Role;
use App\Models\User;
use App\Notifications\CreateUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class Create extends Component
{
    public $name, $email, $password, $selectedRoles = [];
    public $roles;

    public function mount()
    {
        $this->roles = Role::all();
    }
    public function storeUser()
    {
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        if ($this->selectedRoles) {
            $user->roles()->sync($this->selectedRoles);
        }

        Notification::send(Auth::user(), new CreateUser($user));
        toastr()->success('User created successfully');
        return redirect()->route('admin.users');
    }
    public function render()
    {
        return view('livewire.admin.users.create');
    }
}
