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
    public $existingSections = [];

    public function mount()
    {
        $this->rooms = Room::all();

        // Set default start_date to 7 days from now
        $this->start_date = now()->addDays(7)->format('Y-m-d\TH:i');

        // Set default end_date to 7 days from start_date
        $this->end_date = now()->addDays(14)->format('Y-m-d\TH:i');
    }

    public function updatedRoomId()
    {
        if ($this->room_id) {
            $this->existingSections = RoomSection::where('room_id', $this->room_id)
                ->whereHas('section')
                ->with('section')
                ->orderBy('start_date')
                ->get()
                ->map(function ($roomSection) {
                    return [
                        'name' => $roomSection->section?->name ?? 'Unknown Section',
                        'start_date' => $roomSection->start_date->format('Y-m-d H:i'),
                        'end_date' => $roomSection->end_date->format('Y-m-d H:i'),
                    ];
                })
                ->toArray();
        } else {
            $this->existingSections = [];
        }
    }

    public function storeSection()
    {
        $this->validate([
            'name' => 'required',
            'room_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Check for time conflicts
        $hasConflict = RoomSection::where('room_id', $this->room_id)
            ->where(function ($query) {
                $query->whereBetween('start_date', [$this->start_date, $this->end_date])
                    ->orWhereBetween('end_date', [$this->start_date, $this->end_date])
                    ->orWhere(function ($q) {
                        $q->where('start_date', '<=', $this->start_date)
                            ->where('end_date', '>=', $this->end_date);
                    });
            })
            ->exists();

        if ($hasConflict) {
            $this->addError('start_date', 'There is a time conflict with another section in this room');
            $this->addError('end_date', 'There is a time conflict with another section in this room');
            return;
        }

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
