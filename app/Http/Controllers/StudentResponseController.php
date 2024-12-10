<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\EvaluationResponse;
use App\Models\Department;
use App\Models\QuestionResponse;
use App\Models\User;
use Illuminate\Http\Request;

class StudentResponseController extends Controller
{
    public function index(Request $request)
    {
        $departments = Department::all();
        $teachers = User::role('teacher')->get();

        $evaluationsQuery = Evaluation::with([
            'evaluationResponses.roomSection.teacher',
            'evaluationResponses.roomSection.department',
            'phases.questions.questionResponses'
        ])->whereHas('evaluationResponses');

        // Apply filters
        if ($request->filled('department')) {
            $evaluationsQuery->whereHas('evaluationResponses.roomSection', function ($query) use ($request) {
                $query->where('department_id', $request->department);
            });
        }

        if ($request->filled('teacher')) {
            $evaluationsQuery->whereHas('evaluationResponses.roomSection', function ($query) use ($request) {
                $query->where('teacher_id', $request->teacher);
            });
        }

        $evaluations = $evaluationsQuery->get();

        // Group responses by teacher
        $evaluations = $evaluations->map(function ($evaluation) {
            $evaluation->teacherResponses = $evaluation->evaluationResponses
                ->groupBy('roomSection.teacher_id')
                ->map(function ($responses) {
                    return [
                        'teacher' => $responses->first()->roomSection->teacher,
                        'department' => $responses->first()->roomSection->department,
                        'total_responses' => $responses->count(),
                        'completed_responses' => $responses->where('is_completed', true)->count()
                    ];
                });
            return $evaluation;
        });

        return view('student-responses.index', compact('evaluations', 'departments', 'teachers'));
    }

    public function show(Request $request, Evaluation $evaluation)
    {
        $teacher_id = $request->teacher_id;
        $teacher = User::findOrFail($teacher_id);

        // Get all responses for this evaluation and teacher
        $responses = EvaluationResponse::where('evaluation_id', $evaluation->id)
            ->whereHas('roomSection', function ($query) use ($teacher_id) {
                $query->where('teacher_id', $teacher_id);
            })
            ->where('is_completed', true)
            ->get();

        // Get all phases with questions and aggregate responses
        $phases = $evaluation->phases()->with(['questions'])->get();

        foreach ($phases as $phase) {
            foreach ($phase->questions as $question) {
                // Aggregate ratings for this question
                $question->aggregatedResponses = QuestionResponse::where('question_id', $question->id)
                    ->whereIn('evaluation_response_id', $responses->pluck('id'))
                    ->selectRaw('rating, COUNT(*) as count')
                    ->groupBy('rating')
                    ->pluck('count', 'rating')
                    ->toArray();
            }
        }

        return view('student-responses.show', compact('evaluation', 'teacher', 'phases', 'responses'));
    }
}
