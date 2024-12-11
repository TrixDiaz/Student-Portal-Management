<?php

namespace App\Livewire\Admin\Users;

use App\Models\Role;
use App\Models\User;
use App\Notifications\CreateUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\CreateUserEmail;

class Create extends Component
{
    public $name, $email, $password, $selectedRoles = [];
    public $roles;
    public $date_of_birth, $phone_number, $address, $city, $state, $zip_code;

    public function mount()
    {
        $this->roles = Role::all();
    }
    public function storeUser()
    {
        $this->password = $this->date_of_birth;

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'date_of_birth' => $this->date_of_birth,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
        ]);

        if ($this->selectedRoles) {
            $user->roles()->sync($this->selectedRoles);
        }

        Notification::send($user, new CreateUser($user, $this->password));
        Mail::to($user->email)->send(new CreateUserEmail($user, $this->password));
        toastr()->success('User created successfully');
        return redirect()->route('admin.users');
    }
    public function render()
    {
        return view('livewire.admin.users.create');
    }
}
