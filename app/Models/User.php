<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // <-- 1. PASTIKAN BARIS INI ADA
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /**
     * Relasi Eloquent: Satu User bisa memiliki banyak jadwal latihan mandiri (WorkoutRoutine).
     */
    public function workoutRoutines(): HasMany
    {
        return $this->hasMany(WorkoutRoutine::class);
    }

    public function fitnessGoal()
    {
        return $this->belongsTo(FitnessGoal::class);
    }

    use HasApiTokens, HasFactory, Notifiable; // <-- 2. TAMBAHKAN HasApiTokens DI SINI

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
        'protein_target',
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
            'password' => 'hashed',
        ];
    }
}