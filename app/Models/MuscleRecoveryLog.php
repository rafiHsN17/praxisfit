<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MuscleRecoveryLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'workout_program_id',
        'workout_session_id',
        'muscle_group',
        'sub_muscle',
        'role',
        'stimulus_level',
        'total_sets',
        'intensity_level',
        'training_method',
        'trained_date',
        'required_recovery_hours',
        'completion_status',
    ];

    protected function casts(): array
    {
        return [
            'trained_date' => 'date',
            'total_sets' => 'integer',
            'required_recovery_hours' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(WorkoutProgram::class, 'workout_program_id');
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(WorkoutSession::class, 'workout_session_id');
    }
}
