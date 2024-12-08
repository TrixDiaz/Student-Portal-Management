<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\RoomSection;
use App\Models\EvaluationResponse;
use App\Models\Question;
use App\Models\Phase;

class Evaluation extends Component
{
    public $roomSection;
    public $questions;
    public $responses = [];
    public $phases;
    public $evaluation;
    public $evaluation_id;


    public function mount(RoomSection $roomSection)
    {
        $this->roomSection = $roomSection;
        // Get the evaluation associated with the room section
        $this->evaluation = $roomSection->evaluation;

        // Get questions grouped by phases
        $this->phases = Phase::with(['questions' => function ($query) {
            $query->orderBy('order');
        }])->get();

        // Check if evaluation was already completed
        $existingResponse = EvaluationResponse::where('room_section_id', $roomSection->id)
            ->where('user_id', auth()->id())
            ->where('is_completed', true)
            ->first();

        if ($existingResponse) {
            return redirect()->route('student.dashboard')->with('error', 'You have already completed this evaluation.');
        }
    }

    public function submitEvaluation()
    {
        $this->validate([
            'responses.*' => 'required|integer|between:1,5',
        ]);

        EvaluationResponse::create([
            'evaluation_id' => $this->evaluation->id,
            'room_section_id' => $this->roomSection->id,
            'user_id' => auth()->id(),
            'is_completed' => true,
            'completed_at' => now(),
        ]);

        return redirect()->route('student.dashboard')->with('success', 'Evaluation submitted successfully!');
    }

    public function render()
    {
        return view('livewire.student.evaluation');
    }
}
