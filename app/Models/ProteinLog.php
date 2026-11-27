<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProteinLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jumlah_protein',
        'kalori',
        'lemak',
        'karbohidrat',
        'berat_gram',
        'sumber_makanan',
        'tanggal',
        'waktu_makan',
        'user_weight',
        'user_height',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_protein' => 'float',
            'kalori' => 'float',
            'lemak' => 'float',
            'karbohidrat' => 'float',
            'berat_gram' => 'float',
            'user_weight' => 'float',
            'user_height' => 'float',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
