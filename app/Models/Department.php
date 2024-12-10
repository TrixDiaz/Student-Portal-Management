<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'department_teachers', 'department_id', 'teacher_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'department_students', 'department_id', 'student_id');
    }

    public function roomSections()
    {
        return $this->hasMany(RoomSection::class);
    }

    public function departmentStudents()
    {
        return $this->hasMany(DepartmentStudents::class);
    }
}
