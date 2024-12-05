<?php

namespace App\Livewire\Student;

use App\Models\Room;
use Livewire\Component;

class Dashboard extends Component
{
    public $totalSubjects;
    public $subjects;
    public $selectedSemester = null;
    public $selectedYear;
    public $availableYears;
    public $semesters = ['first', 'second', 'summer'];

    public function mount()
    {
        $this->selectedYear = date('Y');
        $this->availableYears = range(date('Y') - 4, date('Y'));
        $this->updateTotalSubjects();
    }

    public function updatedSelectedSemester()
    {
        $this->updateTotalSubjects();
    }

    public function updatedSelectedYear()
    {
        $this->updateTotalSubjects();
    }

    private function updateTotalSubjects()
    {
        $query = Room::forStudent(
            auth()->user()->id,
            $this->selectedSemester,
            $this->selectedYear
        );

        $this->subjects = $query->with(['roomSections' => function ($query) {
            $query->with('subject')
                ->when($this->selectedSemester, function ($query) {
                    $query->where('semester', $this->selectedSemester);
                })
                ->whereYear('created_at', $this->selectedYear)
                ->whereHas('students', function ($query) {
                    $query->where('users.id', auth()->user()->id);
                });
        }])->get();

        $this->totalSubjects = $this->subjects->sum('subjects_count');
    }

    public function render()
    {
        return view('livewire.student.dashboard');
    }
}
