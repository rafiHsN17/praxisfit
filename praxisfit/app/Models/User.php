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

    use HasApiTokens, HasFactory, Notifiable; // <-- 2. TAMBAHKAN HasApiTokens DI SINI

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'facebook_id',
        'otp_code',
        'otp_expires_at',
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