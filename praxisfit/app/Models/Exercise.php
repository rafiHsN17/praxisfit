<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'target_muscle',
        'equipment',
        'difficulty',
        'instructions',
        'icon',
        'image_1',
        'image_2',
        'image_3',
        'is_custom',
        'alternative_equipment',
    ];

    /**
     * Relasi Eloquent: Sebuah gerakan latihan (Exercise) bisa memiliki banyak jadwal latihan pengguna (WorkoutRoutine).
     */
    public function workoutRoutines(): HasMany
    {
        return $this->hasMany(WorkoutRoutine::class);
    }
}
