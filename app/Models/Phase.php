<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Phase extends Model
{
    use HasFactory;

    protected $fillable = ['evaluation_id', 'title', 'order'];

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
