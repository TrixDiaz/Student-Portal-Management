<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Edit extends Component
{
    public $email, $name, $password, $user_id;

    public function mount($user_id)
    {
        $this->user_id = $user_id;
        $this->loadUserData();
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


            toastr()->success('User updated successfully!');
            return redirect()->back();
        }
    }

    public function render()
    {
        return view('livewire.admin.users.edit',);
    }
}
