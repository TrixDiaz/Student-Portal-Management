<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'building_id', 'is_active'];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class);
    }

    public function roomSection()
    {
        return $this->hasOne(RoomSection::class);
    }

    public function students()
    {
        return $this->hasMany(User::class)->where('role', 'student');
    }
}
