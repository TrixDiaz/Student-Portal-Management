<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = ['order', 'title', 'description', 'question', 'rating_scale'];

    public function phases()
    {
        return $this->hasMany(Phase::class);
    }
}
