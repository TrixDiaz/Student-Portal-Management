<?php

namespace App\Livewire\Admin\Evaluations;

use Livewire\Component;
use App\Models\Evaluation;
use App\Models\Phase;
use App\Models\Question;
use App\Models\Section;
use App\Models\RoomSection;
use App\Models\EvaluationResponse;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CreateEvaluationNotification;

class Edit extends Component
{
    public $evaluationId;
    public $title;
    public $description;
    public $phases = [];
    public $sections = [];
    public $selectedSections = [];

    public function mount($evaluationId)
    {
        $evaluation = Evaluation::with(['phases.questions', 'roomSections'])->findOrFail($evaluationId);
        $this->evaluationId = $evaluation->id;
        $this->title = $evaluation->title;
        $this->description = $evaluation->description;

        $this->sections = Section::where('is_active', true)->get();

        $this->selectedSections = $evaluation->roomSections->pluck('section_id')->toArray();

        $this->phases = $evaluation->phases->map(function ($phase) {
            return [
                'id' => $phase->id,
                'title' => $phase->title,
                'questions' => $phase->questions->map(function ($question) {
                    return [
                        'id' => $question->id,
                        'question' => $question->question,
                    ];
                })->toArray(),
            ];
        })->toArray();
    }

    public function addPhase()
    {
        $this->phases[] = [
            'title' => '',
            'questions' => [
                ['question' => '']
            ]
        ];
    }

    public function removePhase($phaseIndex)
    {
        unset($this->phases[$phaseIndex]);
        $this->phases = array_values($this->phases);
    }

    public function addQuestion($phaseIndex)
    {
        $this->phases[$phaseIndex]['questions'][] = [
            'question' => ''
        ];
    }

    public function removeQuestion($phaseIndex, $questionIndex)
    {
        unset($this->phases[$phaseIndex]['questions'][$questionIndex]);
        $this->phases[$phaseIndex]['questions'] = array_values($this->phases[$phaseIndex]['questions']);
    }

    public function updateEvaluation()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'phases.*.title' => 'required|string|max:255',
            'phases.*.questions.*.question' => 'required|string',
            'selectedSections' => 'required|array|min:1',
        ]);

        $evaluation = Evaluation::findOrFail($this->evaluationId);

        // Get existing section IDs before update
        $existingSectionIds = $evaluation->roomSections->pluck('section_id')->toArray();

        $evaluation->update([
            'title' => $this->title,
            'description' => $this->description,
        ]);

        // Update all room sections with the evaluation ID
        RoomSection::whereIn('section_id', $this->selectedSections)
            ->update(['evaluation_id' => $this->evaluationId]);

        // Get all room sections with their students
        $roomSections = RoomSection::whereIn('section_id', $this->selectedSections)
            ->with(['students' => function ($query) {
                $query->whereHas('roles', function ($q) {
                    $q->where('name', 'student');
                });
            }])
            ->get();

        // Create evaluation responses for all students in selected sections
        foreach ($roomSections as $roomSection) {
            foreach ($roomSection->students as $student) {
                EvaluationResponse::updateOrCreate(
                    [
                        'room_section_id' => $roomSection->id,
                        'student_id' => $student->id,
                        'evaluation_id' => $this->evaluationId,
                    ],
                    [
                        'is_completed' => false,
                        'completed_at' => null,
                    ]
                );

                // Only send notification for newly added sections
                if (in_array($roomSection->section_id, array_diff($this->selectedSections, $existingSectionIds))) {
                    Notification::send($student, new CreateEvaluationNotification($evaluation, $roomSection));
                }
            }
        }

        foreach ($this->phases as $phaseIndex => $phaseData) {
            $phase = Phase::updateOrCreate(
                ['id' => $phaseData['id'] ?? null, 'evaluation_id' => $evaluation->id],
                ['title' => $phaseData['title'], 'order' => $phaseIndex + 1]
            );

            foreach ($phaseData['questions'] as $questionIndex => $questionData) {
                Question::updateOrCreate(
                    ['id' => $questionData['id'] ?? null, 'phase_id' => $phase->id],
                    ['question' => $questionData['question'], 'order' => $questionIndex + 1]
                );
            }
        }

        return redirect()->route('admin.evaluations')->with('success', 'Evaluation updated successfully!');
    }

    public function render()
    {
        return view('livewire.admin.evaluations.edit');
    }
}
