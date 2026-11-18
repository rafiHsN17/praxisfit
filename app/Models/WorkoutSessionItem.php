<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkoutSessionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'workout_session_id',
        'exercise_id',
        'exercise_name',
        'target_muscle',
        'target_sets',
        'completed_sets',
        'target_reps',
        'weight_kg',
        'is_completed',
        'notes',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'target_sets' => 'integer',
            'completed_sets' => 'integer',
            'weight_kg' => 'float',
            'is_completed' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(WorkoutSession::class, 'workout_session_id');
    }

    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }
}

