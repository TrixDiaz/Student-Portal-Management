<?php

namespace App\Livewire\Admin\Rooms;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Room;
use App\Models\RoomSection;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $archiveStatus = 'Active';
    public $roomSections;

    public function mount()
    {
        $this->roomSections = RoomSection::all();
    }

    public function deleteRoom($id)
    {
        $room = Room::find($id);
        $room->delete();
        toastr()->info('Room ' . $room->name . ' has been deleted successfully!');
    }

    public function restoreRoom($id)
    {
        $room = Room::withTrashed()->find($id);
        $room->restore();
        toastr()->info('Room ' . $room->name . ' has been restored successfully!');
        return redirect()->back();
    }

    public function forceDeleteRoom($id)
    {
        $room = Room::withTrashed()->find($id);
        $room->forceDelete();
        toastr()->error('Room ' . $room->name . ' has been permanently deleted!');
        return redirect()->back();
    }

    public function render()
    {
        $query = Room::query()
            ->where('name', 'like', '%' . $this->search . '%');

        // Filter by archive status
        if ($this->archiveStatus === 'Archived') {
            $query->onlyTrashed();
        } else {
            $query->whereNull('deleted_at');
        }

        return view('livewire.admin.rooms.index', [
            'rooms' => $query->paginate(10)
        ]);
    }
}
