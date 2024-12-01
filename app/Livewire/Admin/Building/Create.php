<?php

namespace App\Livewire\Admin\Building;

use Livewire\Component;
use App\Models\Building;

class Create extends Component
{
    public $name;

    public function storeBuilding()
    {
        Building::create([
            'name' => $this->name,
        ]);

        toastr()->success('Building created successfully');
        return redirect()->route('admin.buildings');
    }
    public function render()
    {
        return view('livewire.admin.building.create');
    }
}
