<?php

namespace App\Http\Controllers;

use App\Models\RoomSection;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('teacher')) {
            $roomSections = RoomSection::where('teacher_id', auth()->id())
                ->with(['section', 'subject', 'room', 'teacher', 'students'])
                ->paginate(6); // Show 6 items per page

            $totalStudents = $roomSections->sum(function ($roomSection) {
                return $roomSection->students->count();
            });

            return view('dashboard', compact('roomSections', 'totalStudents'));
        }

        return view('dashboard');
    }
}
