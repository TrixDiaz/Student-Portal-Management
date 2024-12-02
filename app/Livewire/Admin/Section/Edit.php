<?php

namespace App\Livewire\Admin\Section;

use App\Models\RoomSection;
use App\Models\RoomSectionStudent;
use Livewire\Component;
use App\Models\Section;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Edit extends Component
{
    public $name;
    public $section_id;
    public $section;
    public $roomSection;
    public $room_id;
    public $user_id;
    public $student_ids = [];
    public $start_date;
    public $end_date;
    public $existingSections = [];

    public function mount($section_id)
    {
        $this->section_id = $section_id;
        $this->loadSectionData();
        $this->loadRoomSectionData();
        $this->loadStudentData();
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
        $this->user_id = $this->roomSection->user_id;
        $this->start_date = $this->roomSection->start_date->format('Y-m-d\TH:i');
        $this->end_date = $this->roomSection->end_date->format('Y-m-d\TH:i');

        $this->updatedRoomId();
    }

    public function loadStudentData()
    {
        $this->student_ids = RoomSectionStudent::where('room_section_id', $this->roomSection->id)
            ->pluck('student_id')
            ->toArray();
    }

    public function updatedRoomId()
    {
        if ($this->room_id) {
            $this->existingSections = RoomSection::where('room_id', $this->room_id)
                ->where('section_id', '!=', $this->section_id) // Exclude current section
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

    public function updateSection()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        DB::transaction(function () {
            $this->section->update([
                'name' => $this->name,
            ]);

            $this->roomSection->update([
                'user_id' => $this->user_id,
                'room_id' => $this->room_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
            ]);

            // Delete existing student associations
            RoomSectionStudent::where('room_section_id', $this->roomSection->id)->delete();

            // Create new student associations
            foreach ($this->student_ids as $studentId) {
                RoomSectionStudent::create([
                    'room_section_id' => $this->roomSection->id,
                    'student_id' => $studentId,
                ]);
            }

            session()->flash('message', 'Section updated successfully');
            return redirect()->route('admin.sections');
        });
    }

    public function render()
    {
        return view('livewire.admin.section.edit', [
            'section' => $this->section,
            'rooms' => Room::all(),
            'users' => User::role('teacher')->get(),
            'students' => User::role('student')->get(),
        ]);
    }
}
