<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuestionResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluation_response_id',
        'question_id',
        'rating',
        'student_id'
    ];

    public function evaluationResponse()
    {
        return $this->belongsTo(EvaluationResponse::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
