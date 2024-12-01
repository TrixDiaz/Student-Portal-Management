<?php

namespace App\Livewire\Admin\Section;

use Livewire\Component;
use App\Models\Section;

class Edit extends Component
{
    public $name;
    public $section_id;
    public $section;

    public function mount($section_id)
    {
        $this->section_id = $section_id;
        $this->loadSectionData();
    }

    public function loadSectionData()
    {
        $this->section = Section::findOrFail($this->section_id);
        $this->name = $this->section->name;
    }

    public function updateSection()
    {
        $this->section->update([
            'name' => $this->name,
        ]);

        toastr()->success('Section updated successfully');
        return redirect()->route('admin.sections');
    }

    public function render()
    {
        return view('livewire.admin.section.edit', [
            'section' => $this->section,
        ]);
    }
}
