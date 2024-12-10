<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\RoomSection;
use App\Models\EvaluationResponse;
use App\Models\Question;
use App\Models\Phase;
use App\Models\QuestionResponse;

class Evaluation extends Component
{
    public $roomSection;
    public $questions;
    public $evaluationResponses = [];
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
            ->where('student_id', auth()->id())
            ->where('is_completed', true)
            ->first();

        if ($existingResponse) {
            $this->evaluationResponses = $existingResponse->responses ?? [];
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

        // Create the main evaluation response
        $evaluationResponse = EvaluationResponse::create([
            'evaluation_id' => $this->evaluation->id,
            'room_section_id' => $this->roomSection->id,
            'student_id' => auth()->id(),
            'is_completed' => true,
            'completed_at' => now(),
        ]);

        // Store individual question responses
        foreach ($this->evaluationResponses as $questionId => $rating) {
            QuestionResponse::create([
                'evaluation_response_id' => $evaluationResponse->id,
                'question_id' => $questionId,
                'rating' => $rating,
                'student_id' => auth()->id(),
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Evaluation submitted successfully!');
    }

    public function render()
    {
        return view('livewire.student.evaluation');
    }
}
