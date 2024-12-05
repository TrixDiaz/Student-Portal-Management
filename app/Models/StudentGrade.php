<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentGrade extends Model
{
    use HasFactory;

    protected $fillable = ['room_section_id', 'student_id', 'grade', 'status'];

    public function roomSection()
    {
        return $this->belongsTo(RoomSection::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
