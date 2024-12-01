<?php

namespace App\Livewire\Admin\Section;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Section;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $archiveStatus = 'Active';

    public function deleteSection($id)
    {
        $section = Section::find($id);
        $section->delete();
        toastr()->info('Section ' . $section->name . ' has been deleted successfully!');
    }

    public function restoreSection($id)
    {
        $section = Section::withTrashed()->find($id);
        $section->restore();
        toastr()->info('Section ' . $section->name . ' has been restored successfully!');
        return redirect()->back();
    }

    public function forceDeleteSection($id)
    {
        $section = Section::withTrashed()->find($id);
        $section->forceDelete();
        toastr()->error('Section ' . $section->name . ' has been permanently deleted!');
        return redirect()->back();
    }

    public function render()
    {
        $query = Section::query()
            ->where('name', 'like', '%' . $this->search . '%');

        // Filter by archive status
        if ($this->archiveStatus === 'Archived') {
            $query->onlyTrashed();
        } else {
            $query->whereNull('deleted_at');
        }

        return view('livewire.admin.section.index', [
            'sections' => $query->paginate(10)
        ]);
    }
}
