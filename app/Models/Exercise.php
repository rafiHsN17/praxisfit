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
        'secondary_muscles',
        'recommended_methods',
        'category',
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

    protected function casts(): array
    {
        return [
            'secondary_muscles' => 'array',
            'recommended_methods' => 'array',
        ];
    }

    /**
     * Relasi Eloquent: Sebuah gerakan latihan (Exercise) bisa memiliki banyak jadwal latihan pengguna (WorkoutRoutine).
     */
    public function workoutRoutines(): HasMany
    {
        return $this->hasMany(WorkoutRoutine::class);
    }

    public function workoutSessionItems(): HasMany
    {
        return $this->hasMany(WorkoutSessionItem::class);
    }

    public function programExercises(): HasMany
    {
        return $this->hasMany(WorkoutProgramExercise::class);
    }

    /**
     * Klasifikasi rule-based kecocokan gerakan terhadap metode latihan.
     *
     * @return array<int, array{key: string, label: string}>
     */
    public function suitableMethods(): array
    {
        $methodLabelMap = [
            'hypertrophy' => 'Suitable for Hypertrophy',
            'strength' => 'Suitable for Strength',
            'endurance' => 'Suitable for Endurance',
            'conditioning' => 'Suitable for Fat Loss / Conditioning',
        ];

        if (! empty($this->recommended_methods) && is_array($this->recommended_methods)) {
            return collect($this->recommended_methods)
                ->filter(fn ($key) => isset($methodLabelMap[$key]))
                ->map(fn ($key) => ['key' => $key, 'label' => $methodLabelMap[$key]])
                ->values()
                ->all();
        }

        $nameLower = strtolower((string) $this->name);
        $catLower = strtolower((string) ($this->category ?? ''));
        $muscleLower = strtolower((string) ($this->target_muscle ?? ''));
        $diffLower = strtolower((string) ($this->difficulty ?? 'menengah'));

        $isMobility = str_contains($catLower, 'mobilitas') || str_contains($nameLower, 'stretch') || str_contains($nameLower, 'foam') || str_contains($nameLower, 'yoga');
        $isCardio = str_contains($catLower, 'kardio') || $muscleLower === 'kardio' || str_contains($nameLower, 'burpee') || str_contains($nameLower, 'running') || str_contains($nameLower, 'jogging') || str_contains($nameLower, 'bicycling') || str_contains($nameLower, 'mountain climber') || str_contains($nameLower, 'jumping');
        $isExplosive = str_contains($nameLower, 'jump') || str_contains($nameLower, 'plyo') || str_contains($nameLower, 'explosive') || str_contains($nameLower, 'clap') || str_contains($nameLower, 'clean') || str_contains($nameLower, 'snatch') || str_contains($nameLower, 'push press') || str_contains($nameLower, 'swing') || str_contains($nameLower, 'sprint') || str_contains($nameLower, 'burpee');
        $isIsometric = str_contains($nameLower, 'plank') || str_contains($nameLower, 'bridge') || str_contains($nameLower, 'hold') || str_contains($nameLower, 'wall sit');
        $isCompound = str_contains($nameLower, 'squat') || str_contains($nameLower, 'deadlift') || str_contains($nameLower, 'bench') || str_contains($nameLower, 'press') || str_contains($nameLower, 'row') || str_contains($nameLower, 'pull') || str_contains($nameLower, 'lunge') || str_contains($nameLower, 'push up') || str_contains($nameLower, 'push-up') || str_contains($nameLower, 'dip') || str_contains($nameLower, 'thruster');

        $badges = [];

        if (! $isMobility && ! $isCardio) {
            $badges[] = ['key' => 'hypertrophy', 'label' => 'Suitable for Hypertrophy'];
        }

        if ($isCompound || (! $isMobility && ! $isCardio && $diffLower !== 'pemula')) {
            $badges[] = ['key' => 'strength', 'label' => 'Suitable for Strength'];
        }

        if ($isCardio || $isIsometric || ! $isExplosive) {
            $badges[] = ['key' => 'endurance', 'label' => 'Suitable for Endurance'];
        }

        if ($isCardio || $isCompound || $isExplosive) {
            $badges[] = ['key' => 'conditioning', 'label' => 'Suitable for Fat Loss / Conditioning'];
        }

        return collect($badges)->unique('key')->values()->all();
    }

    /**
     * Cari alternatif gerakan pengganti berdasarkan otot target yang sama.
     */
    public function findAlternatives(int $limit = 4)
    {
        return static::query()
            ->where('id', '!=', $this->id)
            ->where('target_muscle', $this->target_muscle)
            ->orderByRaw("CASE WHEN equipment = 'Bodyweight' THEN 0 WHEN equipment = ? THEN 1 ELSE 2 END", [$this->equipment ?? 'Bodyweight'])
            ->orderBy('name')
            ->limit($limit)
            ->get();
    }
}
