<?php

namespace App\Livewire\Admin\Rooms;

use Livewire\Component;
use App\Models\Room;

class Edit extends Component
{
    public $name;
    public $room_id;
    public $room;

    public function mount($room_id)
    {
        $this->room_id = $room_id;
        $this->loadRoomData();
    }

    public function loadRoomData()
    {
        $this->room = Room::findOrFail($this->room_id);
        $this->name = $this->room->name;
    }

    public function updateRoom()
    {
        $this->room->update([
            'name' => $this->name,
        ]);

        toastr()->success('Room updated successfully');
        return redirect()->route('admin.rooms');
    }

    public function render()
    {
        return view('livewire.admin.rooms.edit', [
            'room' => $this->room,
        ]);
    }
}
