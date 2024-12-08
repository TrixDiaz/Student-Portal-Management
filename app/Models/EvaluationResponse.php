<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EvaluationResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_section_id',
        'user_id',
        'evaluation_id',
        'is_completed',
        'completed_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function roomSection()
    {
        return $this->belongsTo(RoomSection::class);
    }

    public static function getOrCreateForStudent($roomSectionId, $userId)
    {
        $activeEvaluation = Evaluation::where('is_active', true)->first();

        if (!$activeEvaluation) {
            \Log::error('No active evaluation found');
            return null;
        }

        try {
            return self::firstOrCreate(
                [
                    'room_section_id' => $roomSectionId,
                    'user_id' => $userId,
                    'evaluation_id' => $activeEvaluation->id,
                ]
            );
        } catch (\Exception $e) {
            \Log::error('Error creating evaluation response: ' . $e->getMessage());
            return null;
        }
    }
}
