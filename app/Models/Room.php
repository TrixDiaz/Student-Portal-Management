<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'building_id', 'is_active'];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class);
    }

    public function roomSections()
    {
        return $this->hasMany(RoomSection::class);
    }

    public function scopeForStudent($query, $studentId, $semester = null, $year = null)
    {
        $year = $year ?? date('Y');

        return $query->whereHas('roomSections', function ($query) use ($studentId, $semester, $year) {
            $query->whereHas('students', function ($query) use ($studentId) {
                $query->where('users.id', $studentId);
            })
                ->when($year, function ($query) use ($year) {
                    $query->whereYear('created_at', $year);
                })
                ->when($semester, function ($query) use ($semester) {
                    $query->where('semester', $semester);
                });
        })
            ->withCount(['roomSections as subjects_count' => function ($query) use ($studentId, $semester, $year) {
                $query->whereHas('students', function ($query) use ($studentId) {
                    $query->where('users.id', $studentId);
                })
                    ->when($year, function ($query) use ($year) {
                        $query->whereYear('created_at', $year);
                    })
                    ->when($semester, function ($query) use ($semester) {
                        $query->where('semester', $semester);
                    });
            }]);
    }
}
