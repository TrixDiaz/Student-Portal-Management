<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = ['order', 'title', 'description', 'question', 'rating_scale'];

    protected static function boot()
    {
        parent::boot();

        // This will automatically delete related records when an evaluation is deleted
        static::deleting(function ($evaluation) {
            $evaluation->phases()->delete();
            $evaluation->evaluationResponses()->delete();
        });
    }

    public function phases()
    {
        return $this->hasMany(Phase::class);
    }

    public function evaluationResponses()
    {
        return $this->hasMany(EvaluationResponse::class);
    }
}
