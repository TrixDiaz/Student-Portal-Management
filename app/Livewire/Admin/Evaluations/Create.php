<?php

namespace App\Livewire\Admin\Evaluations;

use App\Models\Evaluation;
use Livewire\Component;
use App\Models\Phase;
use App\Models\Question;
use App\Models\EvaluationResponse;
use App\Models\RoomSectionStudent;
use App\Models\Section;
use App\Models\RoomSection;
use App\Notifications\CreateEvaluationNotification;
use Illuminate\Support\Facades\Notification;

class Create extends Component
{
    public $title;
    public $description;
    public $phases = [];
    public $sections = [];
    public $selectedSections = [];

    public function mount()
    {
        // Initialize with one empty phase
        $this->addPhase();

        // Load all active sections
        $this->sections = Section::where('is_active', true)->get();
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

    public function storeEvaluation()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'phases.*.title' => 'required|string|max:255',
            'phases.*.questions.*.question' => 'required|string',
            'selectedSections' => 'required|array|min:1',
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
                    'question_text' => $questionData['question'],
                    'order' => $questionIndex + 1,
                ]);
            }
        }

        RoomSection::whereIn('section_id', $this->selectedSections)
            ->update(['evaluation_id' => $evaluation->id]);

        $roomSections = RoomSection::whereIn('section_id', $this->selectedSections)
            ->with(['students' => function ($query) {
                $query->whereHas('roles', function ($q) {
                    $q->where('name', 'student');
                });
            }])
            ->get();

        foreach ($roomSections as $roomSection) {
            foreach ($roomSection->students as $student) {
                EvaluationResponse::create([
                    'room_section_id' => $roomSection->id,
                    'user_id' => $student->id,
                    'evaluation_id' => $evaluation->id,
                    'is_completed' => false,
                    'completed_at' => null,
                ]);

                Notification::send($student, new CreateEvaluationNotification($evaluation, $roomSection));
            }
        }

        return redirect()->route('admin.evaluations')->with('success', 'Evaluation created successfully!');
    }

    public function render()
    {
        return view('livewire.admin.evaluations.create');
    }
}
