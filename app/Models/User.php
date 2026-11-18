<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Relasi Eloquent: Satu User bisa memiliki banyak jadwal latihan mandiri (WorkoutRoutine).
     */
    public function workoutRoutines(): HasMany
    {
        return $this->hasMany(WorkoutRoutine::class);
    }

    public function workoutSessions(): HasMany
    {
        return $this->hasMany(WorkoutSession::class);
    }

    public function proteinLogs(): HasMany
    {
        return $this->hasMany(ProteinLog::class);
    }

    public function supportMessages(): HasMany
    {
        return $this->hasMany(SupportMessage::class);
    }

    public function fitnessGoal(): BelongsTo
    {
        return $this->belongsTo(FitnessGoal::class);
    }

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'google_id',
        'facebook_id',
        'otp_code',
        'otp_expires_at',
        'email_verified_at',
        'weight',
        'height',
        'gender',
        'age',
        'activity_level',
        'protein_target',
        'calorie_target',
        'fat_target',
        'carb_target',
        'fitness_goal_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'password' => 'hashed',
            'weight' => 'float',
            'height' => 'float',
            'age' => 'integer',
            'protein_target' => 'float',
            'calorie_target' => 'float',
            'fat_target' => 'float',
            'carb_target' => 'float',
        ];
    }
}