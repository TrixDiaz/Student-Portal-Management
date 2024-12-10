<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentGrade extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'quiz_scores' => 'array',
        'prelim' => 'float',
        'midterm' => 'float',
        'final' => 'float'
    ];

    // Add a scope for current student's grades
    public function scopeForCurrentStudent($query)
    {
        return $query->where('student_id', auth()->id());
    }

    // Add a scope for specific room section
    public function scopeForRoomSection($query, $roomSectionId)
    {
        return $query->where('room_section_id', $roomSectionId);
    }

    // Then you can use these scopes like:
    // StudentGrade::forCurrentStudent()->forRoomSection($roomSectionId)->first();

    public function roomSection()
    {
        return $this->belongsTo(RoomSection::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
