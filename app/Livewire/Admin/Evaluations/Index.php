<?php

namespace App\Livewire\Admin\Evaluations;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Evaluation;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function deleteEvaluation($id)
    {
        $evaluation = Evaluation::find($id);
        $evaluation->delete();
        toastr()->info('Evaluation ' . $evaluation->title . ' has been deleted successfully!');
    }

    public function render()
    {
        $query = Evaluation::query()
            ->where('title', 'like', '%' . $this->search . '%');

        return view('livewire.admin.evaluations.index', [
            'evaluations' => $query->paginate(10)
        ]);
    }
}
