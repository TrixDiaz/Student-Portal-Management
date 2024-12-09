<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentGrade extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'quiz_scores' => 'array'
    ];

    public function roomSection()
    {
        return $this->belongsTo(RoomSection::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
