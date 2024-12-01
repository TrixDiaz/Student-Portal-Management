<?php

namespace App\Livewire\Admin\Building;

use Livewire\Component;
use App\Models\Building;

class Edit extends Component
{
    public $name;
    public $building_id;
    public $building;

    public function mount($building_id)
    {
        $this->building_id = $building_id;
        $this->loadBuildingData();
    }

    public function loadBuildingData()
    {
        $this->building = Building::findOrFail($this->building_id);
        $this->name = $this->building->name;
    }

    public function updateBuilding()
    {
        $this->building->update([
            'name' => $this->name,
        ]);

        toastr()->success('Building updated successfully');
        return redirect()->route('admin.buildings');
    }

    public function render()
    {
        return view('livewire.admin.building.edit', [
            'building' => $this->building,
        ]);
    }
}
