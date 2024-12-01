<?php

namespace App\Livewire\Layout;

use App\Models\Building;
use App\Models\Department;
use App\Models\Room;
use App\Models\User;
use Livewire\Component;

class Sidebar extends Component
{
    public $usersCount;
    public $departmentsCount;
    public $buildingsCount;
    public $roomsCount;

    public function mount()
    {
        $this->usersCount = User::count();
        $this->departmentsCount = Department::count();
        $this->buildingsCount = Building::count();
        $this->roomsCount = Room::count();
    }

    public function render()
    {
        return view('livewire.layout.sidebar');
    }
}
