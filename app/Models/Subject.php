<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'code', 'description', 'is_active'];

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }
}
