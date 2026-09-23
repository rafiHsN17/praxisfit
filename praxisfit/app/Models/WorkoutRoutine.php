<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkoutRoutine extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'exercise_id',
        'day_of_week',
        'sets',
        'reps',
        'notes',
    ];

    /**
     * Relasi Eloquent: Jadwal latihan milik satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi Eloquent: Jadwal latihan merujuk pada satu Exercise spesifik.
     * Sangat penting untuk Eager Loading: with('exercise')
     */
    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }
}
