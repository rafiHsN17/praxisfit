<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FitnessGoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'split_type',
    ];

    public function routines()
    {
        return $this->hasMany(FitnessGoalRoutine::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
