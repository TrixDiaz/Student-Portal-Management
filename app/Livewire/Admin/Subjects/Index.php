<?php

namespace App\Livewire\Admin\Subjects;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Subject;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $archiveStatus = 'Active';

    public function deleteSubject($id)
    {
        $subject = Subject::find($id);
        $subject->delete();
        toastr()->info('Subject ' . $subject->name . ' has been deleted successfully!');
    }

    public function restoreSubject($id)
    {
        $subject = Subject::withTrashed()->find($id);
        $subject->restore();
        toastr()->info('Subject ' . $subject->name . ' has been restored successfully!');
        return redirect()->back();
    }

    public function forceDeleteSubject($id)
    {
        $subject = Subject::withTrashed()->find($id);
        $subject->forceDelete();
        toastr()->error('Subject ' . $subject->name . ' has been permanently deleted!');
        return redirect()->back();
    }

    public function render()
    {
        $query = Subject::query()
            ->where('name', 'like', '%' . $this->search . '%');



        return view('livewire.admin.subjects.index', [
            'subjects' => $query->paginate(10)
        ]);
    }
}
