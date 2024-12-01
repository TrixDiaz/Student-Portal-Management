<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DepartmentUser extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function department(): BelongsToMany
    {
        return $this->belongsToMany(Department::class);
    }

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
