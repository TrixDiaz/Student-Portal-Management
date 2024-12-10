<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DepartmentStudents extends Model
{
    use HasFactory;

    protected $fillable = ['department_id', 'student_id'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class);
    }
}
