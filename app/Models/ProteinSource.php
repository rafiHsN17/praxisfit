<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProteinSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'protein_per_100g',
        'calories_per_100g',
        'fat_per_100g',
        'carbs_per_100g',
    ];

    protected function casts(): array
    {
        return [
            'protein_per_100g' => 'float',
            'calories_per_100g' => 'float',
            'fat_per_100g' => 'float',
            'carbs_per_100g' => 'float',
        ];
    }
}
