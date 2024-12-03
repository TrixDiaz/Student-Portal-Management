<?php

namespace App\Livewire\Admin\Evaluations;

use App\Models\Evaluation;
use Livewire\Component;
use App\Models\Phase;
use App\Models\Question;

class Create extends Component
{
    public $title;
    public $description;
    public $phases = [];

    public function mount()
    {
        // Initialize with one empty phase
        $this->addPhase();
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

    public function storeEvaluation()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'phases.*.title' => 'required|string|max:255',
            'phases.*.questions.*.question_text' => 'required|string',
        ]);

        $evaluation = Evaluation::create([
            'title' => $this->title,
            'description' => $this->description,
        ]);

        foreach ($this->phases as $phaseIndex => $phaseData) {
            $phase = $evaluation->phases()->create([
                'title' => $phaseData['title'],
                'order' => $phaseIndex + 1,
            ]);

            foreach ($phaseData['questions'] as $questionIndex => $questionData) {
                $phase->questions()->create([
                    'question_text' => $questionData['question_text'],
                    'order' => $questionIndex + 1,
                ]);
            }
        }

        return redirect()->route('admin.evaluations')->with('success', 'Evaluation created successfully!');
    }

    public function render()
    {
        return view('livewire.admin.evaluations.create');
    }
}
