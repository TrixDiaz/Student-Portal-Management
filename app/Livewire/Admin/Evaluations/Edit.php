<?php

namespace App\Livewire\Admin\Evaluations;

use Livewire\Component;
use App\Models\Evaluation;
use App\Models\Phase;
use App\Models\Question;

class Edit extends Component
{
    public $evaluationId;
    public $title;
    public $description;
    public $phases = [];

    public function mount($evaluationId)
    {
        $evaluation = Evaluation::with('phases.questions')->findOrFail($evaluationId);
        $this->evaluationId = $evaluation->id;
        $this->title = $evaluation->title;
        $this->description = $evaluation->description;
        $this->phases = $evaluation->phases->map(function ($phase) {
            return [
                'id' => $phase->id,
                'title' => $phase->title,
                'questions' => $phase->questions->map(function ($question) {
                    return [
                        'id' => $question->id,
                        'question_text' => $question->question_text,
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
                ['question_text' => '']
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
            'question_text' => ''
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
            'phases.*.questions.*.question_text' => 'required|string',
        ]);

        $evaluation = Evaluation::findOrFail($this->evaluationId);
        $evaluation->update([
            'title' => $this->title,
            'description' => $this->description,
        ]);

        foreach ($this->phases as $phaseIndex => $phaseData) {
            $phase = Phase::updateOrCreate(
                ['id' => $phaseData['id'] ?? null, 'evaluation_id' => $evaluation->id],
                ['title' => $phaseData['title'], 'order' => $phaseIndex + 1]
            );

            foreach ($phaseData['questions'] as $questionIndex => $questionData) {
                Question::updateOrCreate(
                    ['id' => $questionData['id'] ?? null, 'phase_id' => $phase->id],
                    ['question_text' => $questionData['question_text'], 'order' => $questionIndex + 1]
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
