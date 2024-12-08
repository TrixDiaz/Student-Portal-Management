<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['phase_id', 'question', 'order'];

    public function phase()
    {
        return $this->belongsTo(Phase::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}
