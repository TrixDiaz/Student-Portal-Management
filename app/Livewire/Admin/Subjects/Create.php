<?php

namespace App\Livewire\Admin\Subjects;

use App\Models\Subject;
use Livewire\Component;

class Create extends Component
{
    public $name, $code, $description;

    public function storeSubject()
    {
        Subject::create([
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
        ]);

        toastr()->success('Subject created successfully');
        return redirect()->route('admin.subjects');
    }
    public function render()
    {
        return view('livewire.admin.subjects.create');
    }
}
