<?php

namespace App\Livewire\Admin\Section;

use App\Models\Room;
use App\Models\RoomSection;
use Livewire\Component;
use App\Models\Section;

class Create extends Component
{
    public $name;
    public $room_id;
    public $start_date;
    public $end_date;
    public $rooms;

    public function mount()
    {
        $this->rooms = Room::all();
    }

    public function storeSection()
    {
        $section = Section::create([
            'name' => $this->name,
        ]);

        RoomSection::create([
            'room_id' => $this->room_id,
            'section_id' => $section->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);

        toastr()->success('Section created successfully');
        return redirect()->route('admin.sections');
    }
    public function render()
    {
        return view('livewire.admin.section.create');
    }
}
