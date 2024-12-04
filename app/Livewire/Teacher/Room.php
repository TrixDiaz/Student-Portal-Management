<?php

namespace App\Livewire\Teacher;

use App\Models\Room as ModelsRoom;
use Livewire\Component;

class Room extends Component
{

    public $subjectId;
    public $subject;

    public function mount($subjectId)
    {
        $subject = ModelsRoom::find($subjectId);
        $this->subjectId = $subject;
    }
    public function render()
    {
        return view('livewire.teacher.room');
    }
}
