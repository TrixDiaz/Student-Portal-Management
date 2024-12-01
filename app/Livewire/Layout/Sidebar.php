<?php

namespace App\Livewire\Layout;

use App\Models\Department;
use App\Models\User;
use Livewire\Component;

class Sidebar extends Component
{
    public $usersCount;
    public $departmentsCount;
    public function mount()
    {
        $this->usersCount = User::count();
        $this->departmentsCount = Department::count();
    }

    public function render()
    {
        return view('livewire.layout.sidebar');
    }
}
