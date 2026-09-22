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
        'video_male',
        'video_female',
        'is_custom',
        'youtube_url',
        'alternative_equipment',
    ];

    /**
     * Relasi Eloquent: Sebuah gerakan latihan (Exercise) bisa memiliki banyak jadwal latihan pengguna (WorkoutRoutine).
     */
    public function workoutRoutines(): HasMany
    {
        return $this->hasMany(WorkoutRoutine::class);
    }

    /**
     * Accessor untuk mendapatkan URL Embed YouTube yang valid
     */
    public function getEmbedUrlAttribute()
    {
        if (!$this->youtube_url) {
            return null;
        }

        // Regex robust untuk ekstrak ID Video YouTube dari berbagai format URL
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $this->youtube_url, $match);
        
        $videoId = $match[1] ?? null;

        if ($videoId) {
            return "https://www.youtube.com/embed/{$videoId}";
        }

        return null;
    }
}
