<?php

namespace App\Livewire\Admin\Building;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Building;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $archiveStatus = 'Active';

    public function deleteBuilding($id)
    {
        $building = Building::find($id);
        $building->delete();
        toastr()->info('Building ' . $building->name . ' has been deleted successfully!');
    }

    public function restoreBuilding($id)
    {
        $building = Building::withTrashed()->find($id);
        $building->restore();
        toastr()->info('Building ' . $building->name . ' has been restored successfully!');
        return redirect()->back();
    }

    public function forceDeleteBuilding($id)
    {
        $building = Building::withTrashed()->find($id);
        $building->forceDelete();
        toastr()->error('Building ' . $building->name . ' has been permanently deleted!');
        return redirect()->back();
    }

    public function render()
    {
        $query = Building::query()
            ->where('name', 'like', '%' . $this->search . '%');

        // Filter by archive status
        if ($this->archiveStatus === 'Archived') {
            $query->onlyTrashed();
        } else {
            $query->whereNull('deleted_at');
        }

        return view('livewire.admin.building.index', [
            'buildings' => $query->paginate(10)
        ]);
    }
}
