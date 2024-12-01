<?php

namespace App\Livewire\Admin\Section;

use App\Models\RoomSection;
use Livewire\Component;
use App\Models\Section;
use App\Models\Room;

class Edit extends Component
{
    public $name;
    public $section_id;
    public $section;
    public $roomSection;
    public $room_id;
    public $start_date;
    public $end_date;

    public function mount($section_id)
    {
        $this->section_id = $section_id;
        $this->loadSectionData();
        $this->loadRoomSectionData();
    }

    public function loadSectionData()
    {
        $this->section = Section::findOrFail($this->section_id);
        $this->name = $this->section->name;
    }

    public function loadRoomSectionData()
    {
        $this->roomSection = RoomSection::where('section_id', $this->section_id)->firstOrFail();
        $this->room_id = $this->roomSection->room_id;
        $this->start_date = $this->roomSection->start_date->format('Y-m-d\TH:i');
        $this->end_date = $this->roomSection->end_date->format('Y-m-d\TH:i');
    }

    public function updateSection()
    {
        $this->section->update([
            'name' => $this->name,
        ]);

        $this->roomSection->update([
            'room_id' => $this->room_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);

        toastr()->success('Section updated successfully');
        return redirect()->route('admin.sections');
    }

    public function render()
    {
        return view('livewire.admin.section.edit', [
            'section' => $this->section,
            'rooms' => Room::all(),
        ]);
    }
}
