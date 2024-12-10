<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EvaluationResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'room_section_id',
        'evaluation_id',
        'is_completed',
        'completed_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function roomSection()
    {
        return $this->belongsTo(RoomSection::class, 'room_section_id');
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function getResponsesByPhase()
    {
        return $this->evaluation->phases()
            ->with(['questions.responses' => function ($query) {
                $query->where('evaluation_response_id', $this->id);
            }])
            ->orderBy('order')
            ->get();
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
                    'student_id' => $userId,
                    'evaluation_id' => $activeEvaluation->id,
                ]
            );
        } catch (\Exception $e) {
            \Log::error('Error creating evaluation response: ' . $e->getMessage());
            return null;
        }
    }
}
