<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkoutProgram extends Model
{
    use HasFactory;

    public const STATUS_ACTIVE = 'active';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_ARCHIVED = 'archived';

    public const METHOD_HYPERTROPHY = 'hypertrophy';

    public const METHOD_STRENGTH = 'strength';

    public const METHOD_ENDURANCE = 'endurance';

    public const METHOD_CONDITIONING = 'conditioning';

    protected $fillable = [
        'user_id',
        'name',
        'training_method',
        'equipment_mode',
        'selected_equipments',
        'level',
        'target_muscles',
        'frequency_per_week',
        'session_duration_minutes',
        'program_duration',
        'total_weeks',
        'total_days',
        'start_date',
        'end_date',
        'preferences',
        'status',
        'safety_notes',
    ];

    protected function casts(): array
    {
        return [
            'selected_equipments' => 'array',
            'target_muscles' => 'array',
            'preferences' => 'array',
            'frequency_per_week' => 'integer',
            'session_duration_minutes' => 'integer',
            'total_weeks' => 'integer',
            'total_days' => 'integer',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function days(): HasMany
    {
        return $this->hasMany(WorkoutProgramDay::class)->orderBy('day_number');
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(WorkoutSession::class, 'workout_program_id')->orderBy('scheduled_date');
    }

    public static function methodLabels(): array
    {
        return [
            self::METHOD_HYPERTROPHY => 'Hypertrophy (Pembentukan Massa Otot)',
            self::METHOD_STRENGTH => 'Strength Training (Kekuatan)',
            self::METHOD_ENDURANCE => 'Endurance (Daya Tahan Otot)',
            self::METHOD_CONDITIONING => 'Fat Loss / Conditioning',
        ];
    }

    public static function levelLabels(): array
    {
        return [
            'beginner' => 'Beginner (Pemula)',
            'intermediate' => 'Intermediate (Menengah)',
            'advanced' => 'Advanced (Lanjut)',
        ];
    }

    public function methodLabel(): string
    {
        return self::methodLabels()[$this->training_method] ?? ucfirst($this->training_method);
    }

    public function levelLabel(): string
    {
        return self::levelLabels()[$this->level] ?? ucfirst($this->level);
    }

    public function equipmentModeLabel(): string
    {
        if ($this->equipment_mode === 'bodyweight') {
            return 'Tanpa Alat (Bodyweight)';
        }

        $items = $this->selected_equipments ?? [];
        if (empty($items)) {
            return 'Dengan Alat';
        }

        return 'Dengan Alat: '.implode(', ', $items);
    }

    public function currentWeekNumber(): int
    {
        if (! $this->start_date) {
            return 1;
        }

        $today = Carbon::now('Asia/Jakarta')->startOfDay();
        $start = $this->start_date->copy()->startOfDay();

        if ($today->lt($start)) {
            return 1;
        }

        $diffDays = (int) $start->diffInDays($today);
        $week = intdiv($diffDays, 7) + 1;

        return max(1, min($this->total_weeks, $week));
    }
}
