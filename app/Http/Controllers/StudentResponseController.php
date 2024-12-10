<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\EvaluationResponse;
use Illuminate\Http\Request;

class StudentResponseController extends Controller
{
    public function index(Request $request)
    {
        $evaluations = Evaluation::with([
            'evaluationResponses.user',
            'evaluationResponses.roomSection',
            'phases.questions'
        ])
            ->whereHas('evaluationResponses')
            ->get();

        return view('student-responses.index', compact('evaluations'));
    }

    public function show(EvaluationResponse $evaluationResponse)
    {
        $responsesByPhase = $evaluationResponse->getResponsesByPhase();

        return view('student-responses.show', compact('evaluationResponse', 'responsesByPhase'));
    }
}
