<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomSection extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function grades()
    {
        return $this->hasMany(StudentGrade::class);
    }

    public function evaluationResponses()
    {
        return $this->hasMany(EvaluationResponse::class);
    }

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function studentGrades()
    {
        return $this->hasMany(StudentGrade::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'room_section_students', 'room_section_id', 'student_id');
    }

    /**
     * Get the formatted name for the room section
     */
    public function getSelectedNameAttribute()
    {
        $teacherName = $this->teacher ? $this->teacher->name : 'No Teacher';
        return "{$this->section->name} - {$this->subject->name} - {$teacherName} ({$this->section->year_level} Year, {$this->semester} Semester)";
    }
}
