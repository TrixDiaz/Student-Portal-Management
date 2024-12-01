<?php

namespace App\Livewire\Admin\Rooms;

use Livewire\Component;
use App\Models\Room;

class Create extends Component
{
    public $name;

    public function storeRoom()
    {
        Room::create([
            'name' => $this->name,
        ]);

        toastr()->success('Room created successfully');
        return redirect()->route('admin.rooms');
    }
    public function render()
    {
        return view('livewire.admin.rooms.create');
    }
}
