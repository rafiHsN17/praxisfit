<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MuscleGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'parent_group',
        'is_large_muscle',
        'min_recovery_hours',
        'high_volume_recovery_hours',
    ];

    protected function casts(): array
    {
        return [
            'is_large_muscle' => 'boolean',
            'min_recovery_hours' => 'integer',
            'high_volume_recovery_hours' => 'integer',
        ];
    }
}
