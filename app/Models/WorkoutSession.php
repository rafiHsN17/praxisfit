<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkoutSession extends Model
{
    use HasFactory;

    public const STATUS_UPCOMING = 'upcoming';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_MISSED = 'missed';

    protected $fillable = [
        'user_id',
        'name',
        'category',
        'scheduled_date',
        'scheduled_time',
        'actual_date',
        'started_at',
        'completed_at',
        'duration_seconds',
        'status',
        'is_off_schedule',
        'progress_percent',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_date' => 'date',
            'actual_date' => 'date',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
            'duration_seconds' => 'integer',
            'is_off_schedule' => 'boolean',
            'progress_percent' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(WorkoutSessionItem::class)->orderBy('sort_order')->orderBy('id');
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_IN_PROGRESS => 'In Progress',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_MISSED => 'Missed',
            default => 'Upcoming',
        };
    }

    public function effectiveStatus(): string
    {
        if ($this->status === self::STATUS_UPCOMING && $this->scheduled_date) {
            $today = Carbon::now('Asia/Jakarta')->toDateString();
            if ($this->scheduled_date->toDateString() < $today) {
                return self::STATUS_MISSED;
            }
        }

        return $this->status;
    }

    public function recalculateProgress(): int
    {
        $items = $this->items()->get();
        if ($items->isEmpty()) {
            $percent = $this->status === self::STATUS_COMPLETED ? 100 : 0;
        } else {
            $completed = $items->where('is_completed', true)->count();
            $percent = (int) round(($completed / $items->count()) * 100);
        }

        $this->update(['progress_percent' => $percent]);

        return $percent;
    }

    public function formattedDuration(): ?string
    {
        if (!$this->duration_seconds || $this->duration_seconds <= 0) {
            return null;
        }

        $hours = intdiv($this->duration_seconds, 3600);
        $minutes = intdiv($this->duration_seconds % 3600, 60);
        $seconds = $this->duration_seconds % 60;

        if ($hours > 0) {
            return sprintf('%02dj %02dm', $hours, $minutes);
        }

        return sprintf('%02dm %02dd', $minutes, $seconds);
    }

    public static function formatIndonesianDate($date): string
    {
        if (!$date) {
            return '-';
        }

        $carbon = $date instanceof Carbon ? $date->copy() : Carbon::parse($date, 'Asia/Jakarta');
        $hari = match ($carbon->dayOfWeekIso) {
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        };
        $bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ][$carbon->month];

        return "{$hari}, {$carbon->day} {$bulan} {$carbon->year}";
    }

    public static function fullIndonesianDay($date): string
    {
        $carbon = $date instanceof Carbon ? $date->copy() : Carbon::parse($date, 'Asia/Jakarta');

        return match ($carbon->dayOfWeekIso) {
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        };
    }

    public static function shortIndonesianDay($date): string
    {
        $carbon = $date instanceof Carbon ? $date->copy() : Carbon::parse($date, 'Asia/Jakarta');

        return match ($carbon->dayOfWeekIso) {
            1 => 'Sen',
            2 => 'Sel',
            3 => 'Rab',
            4 => 'Kam',
            5 => 'Jum',
            6 => 'Sab',
            7 => 'Min',
        };
    }
}
