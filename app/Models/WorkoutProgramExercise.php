<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkoutProgramExercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'workout_program_day_id',
        'exercise_id',
        'primary_muscle',
        'secondary_muscles',
        'stimulus_level',
        'sort_order',
        'target_sets',
        'target_reps',
        'is_duration_based',
        'rest_seconds',
        'intensity_note',
        'progression_note',
    ];

    protected function casts(): array
    {
        return [
            'secondary_muscles' => 'array',
            'sort_order' => 'integer',
            'target_sets' => 'integer',
            'is_duration_based' => 'boolean',
            'rest_seconds' => 'integer',
        ];
    }

    public function day(): BelongsTo
    {
        return $this->belongsTo(WorkoutProgramDay::class, 'workout_program_day_id');
    }

    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }
}
