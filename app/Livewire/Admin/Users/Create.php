<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Create extends Component
{
    public $name, $email, $password;

    public function storeUser()
    {
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        toastr()->success('User created successfully');
        return redirect()->route('admin.users');
    }
    public function render()
    {
        return view('livewire.admin.users.create');
    }
}
