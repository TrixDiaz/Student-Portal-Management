<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomSectionStudent extends Model
{
    use HasFactory;

    protected $fillable = ['room_section_id', 'student_id'];

    public function roomSection()
    {
        return $this->belongsTo(RoomSection::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class);
    }
}
