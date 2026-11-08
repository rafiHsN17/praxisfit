<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FitnessGoalRoutine extends Model
{
    use HasFactory;

    protected $fillable = [
        'fitness_goal_id',
        'exercise_id',
        'day_of_week',
        'sets',
        'reps',
        'notes',
    ];

    public function fitnessGoal()
    {
        return $this->belongsTo(FitnessGoal::class);
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
}
