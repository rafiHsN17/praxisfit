<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WorkoutProgramDay extends Model
{
    use HasFactory;

    public const TYPE_WORKOUT = 'workout';

    public const TYPE_REST = 'rest';

    protected $fillable = [
        'workout_program_id',
        'week_number',
        'day_number',
        'day_name',
        'scheduled_date',
        'day_type',
        'focus_label',
        'week_phase',
        'estimated_duration_minutes',
        'notes',
        'placement_reason',
        'recovery_status',
        'recovery_summary',
    ];

    protected function casts(): array
    {
        return [
            'week_number' => 'integer',
            'day_number' => 'integer',
            'scheduled_date' => 'date',
            'estimated_duration_minutes' => 'integer',
            'recovery_summary' => 'array',
        ];
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(WorkoutProgram::class, 'workout_program_id');
    }

    public function exercises(): HasMany
    {
        return $this->hasMany(WorkoutProgramExercise::class, 'workout_program_day_id')->orderBy('sort_order');
    }

    public function workoutSession(): HasOne
    {
        return $this->hasOne(WorkoutSession::class, 'workout_program_day_id');
    }
}
