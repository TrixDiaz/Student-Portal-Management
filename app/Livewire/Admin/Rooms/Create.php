<?php

namespace App\Livewire\Admin\Rooms;

use App\Models\Building;
use Livewire\Component;
use App\Models\Room;

class Create extends Component
{
    public $name;
    public $building_id;
    public $buildings;
    public function mount()
    {
        $this->buildings = Building::all();
    }

    public function storeRoom()
    {
        Room::create([
            'name' => $this->name,
            'building_id' => $this->building_id,
        ]);

        toastr()->success('Room created successfully');
        return redirect()->route('admin.rooms');
    }
    public function render()
    {
        return view('livewire.admin.rooms.create');
    }
}
