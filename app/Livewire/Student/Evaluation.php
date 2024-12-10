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
        $this->evaluation = $roomSection->evaluation;

        if (!$this->evaluation) {
            $this->phases = collect();
            return;
        }

        // Get phases and questions that belong to the current evaluation
        $this->phases = Phase::with(['questions' => function ($query) {
            $query->orderBy('order');
        }])
            ->where('evaluation_id', $this->evaluation->id)  // Only get phases for this evaluation
            ->orderBy('order')
            ->get();

        // Updated to use student_id instead of user_id
        $existingResponse = EvaluationResponse::where('room_section_id', $roomSection->id)
            ->where('student_id', auth()->id())  // Changed from user_id to student_id
            ->where('is_completed', true)
            ->first();

        if ($existingResponse) {
            $this->responses = $existingResponse->responses ?? [];
            return;
        }
    }

    public function submitEvaluation()
    {
        if (!$this->evaluation) {
            return;
        }

        $this->validate([
            'responses.*' => 'required|integer|between:1,5',
        ]);

        EvaluationResponse::create([
            'evaluation_id' => $this->evaluation->id,
            'room_section_id' => $this->roomSection->id,
            'student_id' => auth()->id(),  // Changed from user_id to student_id
            'is_completed' => true,
            'completed_at' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Evaluation submitted successfully!');
    }

    public function render()
    {
        return view('livewire.student.evaluation');
    }
}
