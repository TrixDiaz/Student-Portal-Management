<?php

namespace App\Livewire\Layout;

use App\Models\User;
use Livewire\Component;

class Sidebar extends Component
{
    public $usersCount;

    public function mount()
    {
        $this->usersCount = User::count();
    }

    public function render()
    {
        return view('livewire.layout.sidebar');
    }
}
