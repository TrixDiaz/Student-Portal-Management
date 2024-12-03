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
}
