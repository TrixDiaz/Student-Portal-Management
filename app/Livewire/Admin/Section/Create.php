<?php

namespace App\Livewire\Admin\Section;

use Livewire\Component;
use App\Models\Section;

class Create extends Component
{
    public $name;

    public function storeSection()
    {
        Section::create([
            'name' => $this->name,
        ]);

        toastr()->success('Section created successfully');
        return redirect()->route('admin.sections');
    }
    public function render()
    {
        return view('livewire.admin.section.create');
    }
}
