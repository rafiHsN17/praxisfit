<?php

namespace App\Livewire;

use App\Models\Exercise;
use App\Models\ProteinLog;
use App\Models\WorkoutProgram;
use App\Models\WorkoutRoutine;
use App\Models\WorkoutSession;
use Carbon\Carbon;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Beranda - PraxisFit')]
class Dashboard extends Component
{
    public bool $isGuest = true;

    public string $todayFormatted = '';

    public string $todayDate = '';

    // Nutrition Metrics (User-scoped)
    public float $totalProteinToday = 0;

    public float $targetProtein = 150;

    public float $totalCaloriesToday = 0;

    public float $targetCalories = 2000;

    // Catalog & Routine Metrics
    public int $totalExercises = 0;

    public int $totalRoutines = 0;

    // Workout Session Tracking Metrics (User-scoped, Real DB)
    public $todaySessions = [];

    public int $todaySessionsCount = 0;

    public int $completedSessionsCount = 0;

    public int $unfinishedSessionsCount = 0;

    public int $missedSessionsCount = 0;

    public int $dailyWorkoutProgress = 0;

    public ?array $latestHistorySession = null;

    public ?array $nextScheduledSession = null;

    public ?array $activeProgramSummary = null;

    public array $scheduleNotifications = [];

    public function mount(): void
    {
        $nowJakarta = Carbon::now('Asia/Jakarta');
        $today = $nowJakarta->toDateString();
        $this->todayDate = $today;
        $this->todayFormatted = WorkoutSession::formatIndonesianDate($nowJakarta);

        $this->totalExercises = Exercise::count();

        if (! auth()->check()) {
            $this->isGuest = true;

            return;
        }

        $this->isGuest = false;
        $user = auth()->user();
        $userId = $user->id;

        // 1. Nutrition stats (strictly current user)
        $this->targetProtein = (float) ($user->protein_target ?? 150);
        $this->targetCalories = (float) ($user->calorie_target ?? 2000);

        $todayNutrition = ProteinLog::where('user_id', $userId)
            ->whereDate('tanggal', $today)
            ->selectRaw('COALESCE(SUM(jumlah_protein), 0) as total_protein, COALESCE(SUM(kalori), 0) as total_calories')
            ->first();

        $this->totalProteinToday = (float) ($todayNutrition->total_protein ?? 0);
        $this->totalCaloriesToday = (float) ($todayNutrition->total_calories ?? 0);

        // 2. Weekly Routine Count
        $this->totalRoutines = WorkoutRoutine::where('user_id', $userId)->count();

        // 3. Auto-sync missed sessions strictly for past scheduled dates still left upcoming
        WorkoutSession::where('user_id', $userId)
            ->where('status', WorkoutSession::STATUS_UPCOMING)
            ->whereDate('scheduled_date', '<', $today)
            ->update(['status' => WorkoutSession::STATUS_MISSED]);

        $allSessions = WorkoutSession::with('items')
            ->where('user_id', $userId)
            ->orderBy('scheduled_date', 'asc')
            ->get();

        // Today's scheduled or executed-today sessions
        $todayFiltered = $allSessions->filter(function (WorkoutSession $session) use ($today) {
            $scheduled = $session->scheduled_date?->toDateString() === $today;
            $actual = $session->actual_date?->toDateString() === $today;

            return $scheduled || $actual;
        })->values();

        $this->todaySessions = $todayFiltered->map(function (WorkoutSession $s) {
            return [
                'id' => $s->id,
                'name' => $s->name,
                'category' => $s->category,
                'status' => $s->status,
                'status_label' => $s->statusLabel(),
                'scheduled_date' => $s->scheduled_date?->toDateString(),
                'scheduled_time' => $s->scheduled_time,
                'progress_percent' => $s->progress_percent,
                'is_off_schedule' => $s->is_off_schedule,
                'items_count' => $s->items->count(),
            ];
        })->all();

        $this->todaySessionsCount = count($this->todaySessions);
        $this->completedSessionsCount = $allSessions->where('status', WorkoutSession::STATUS_COMPLETED)->count();
        $this->unfinishedSessionsCount = $allSessions->whereIn('status', [
            WorkoutSession::STATUS_UPCOMING,
            WorkoutSession::STATUS_IN_PROGRESS,
        ])->count();
        $this->missedSessionsCount = $allSessions->where('status', WorkoutSession::STATUS_MISSED)->count();

        // Daily progress bar calculation based strictly on today's sessions
        if ($todayFiltered->isNotEmpty()) {
            $avgProgress = $todayFiltered->avg(function (WorkoutSession $s) {
                if ($s->status === WorkoutSession::STATUS_COMPLETED) {
                    return 100;
                }

                return (int) $s->progress_percent;
            });
            $this->dailyWorkoutProgress = (int) round($avgProgress ?? 0);
        } else {
            $this->dailyWorkoutProgress = 0;
        }

        // Latest completed workout session history
        $latestCompleted = WorkoutSession::where('user_id', $userId)
            ->where('status', WorkoutSession::STATUS_COMPLETED)
            ->orderByDesc('completed_at')
            ->orderByDesc('updated_at')
            ->first();

        if ($latestCompleted) {
            $this->latestHistorySession = [
                'id' => $latestCompleted->id,
                'name' => $latestCompleted->name,
                'scheduled_label' => WorkoutSession::formatIndonesianDate($latestCompleted->scheduled_date),
                'actual_label' => WorkoutSession::formatIndonesianDate($latestCompleted->actual_date ?? $latestCompleted->scheduled_date),
                'duration' => $latestCompleted->formattedDuration(),
                'is_off_schedule' => $latestCompleted->is_off_schedule,
            ];
        }

        // Upcoming next schedule
        $next = $allSessions
            ->filter(fn (WorkoutSession $s) => in_array($s->status, [WorkoutSession::STATUS_UPCOMING, WorkoutSession::STATUS_IN_PROGRESS], true)
                && $s->scheduled_date
                && $s->scheduled_date->toDateString() >= $today)
            ->first();

        if ($next) {
            $this->nextScheduledSession = [
                'name' => $next->name,
                'date_label' => WorkoutSession::formatIndonesianDate($next->scheduled_date),
                'time' => $next->scheduled_time,
                'status_label' => $next->statusLabel(),
            ];
        }

        // Schedule Notifications (strictly from user DB state)
        $notifications = [];

        $todayPending = $todayFiltered->whereIn('status', [
            WorkoutSession::STATUS_UPCOMING,
            WorkoutSession::STATUS_IN_PROGRESS,
        ]);

        foreach ($todayPending as $session) {
            $timeInfo = $session->scheduled_time ? " pukul {$session->scheduled_time} WIB" : '';
            $notifications[] = [
                'level' => 'active',
                'title' => "Jadwal Hari Ini{$timeInfo}",
                'detail' => "{$session->name} ({$session->statusLabel()}) — Progres {$session->progress_percent}%",
            ];
        }

        $missedRecent = $allSessions
            ->where('status', WorkoutSession::STATUS_MISSED)
            ->sortByDesc('scheduled_date')
            ->take(2);

        foreach ($missedRecent as $missed) {
            $notifications[] = [
                'level' => 'warning',
                'title' => 'Jadwal Terlewat',
                'detail' => "{$missed->name} seharusnya dilakukan pada ".WorkoutSession::formatIndonesianDate($missed->scheduled_date).'.',
            ];
        }

        if ($todayFiltered->isNotEmpty() && $todayPending->isEmpty() && $todayFiltered->where('status', WorkoutSession::STATUS_COMPLETED)->isNotEmpty()) {
            $notifications[] = [
                'level' => 'done',
                'title' => 'Target Latihan Hari Ini Selesai',
                'detail' => 'Semua sesi latihan Anda hari ini sudah ditandai selesai.',
            ];
        }

        $this->scheduleNotifications = array_slice($notifications, 0, 3);

        // Ringkasan Program Latihan Aktif (tanpa mengubah layout utama dashboard)
        $activeProgram = WorkoutProgram::where('user_id', $userId)
            ->where('status', WorkoutProgram::STATUS_ACTIVE)
            ->latest()
            ->first();

        if ($activeProgram) {
            $programSessions = $allSessions->where('workout_program_id', $activeProgram->id);
            $progTotal = $programSessions->count();
            $progCompleted = $programSessions->where('status', WorkoutSession::STATUS_COMPLETED)->count();
            $progPending = $programSessions->whereIn('status', [
                WorkoutSession::STATUS_UPCOMING,
                WorkoutSession::STATUS_IN_PROGRESS,
            ])->count();
            $progPercent = $progTotal > 0 ? (int) round(($progCompleted / $progTotal) * 100) : 0;

            $progNext = $programSessions
                ->filter(fn (WorkoutSession $s) => in_array($s->status, [WorkoutSession::STATUS_UPCOMING, WorkoutSession::STATUS_IN_PROGRESS], true)
                    && $s->scheduled_date
                    && $s->scheduled_date->toDateString() >= $today)
                ->first();

            $this->activeProgramSummary = [
                'id' => $activeProgram->id,
                'name' => $activeProgram->name,
                'method_label' => $activeProgram->methodLabel(),
                'current_week' => $activeProgram->currentWeekNumber(),
                'total_weeks' => $activeProgram->total_weeks,
                'progress_percent' => $progPercent,
                'completed_count' => $progCompleted,
                'pending_count' => $progPending,
                'total_count' => $progTotal,
                'next_session_name' => $progNext?->name,
                'next_session_date' => $progNext ? WorkoutSession::formatIndonesianDate($progNext->scheduled_date) : null,
            ];
        }
    }

    public function render()
    {
        return view('livewire.dashboard')
            ->layout('components.layouts.app');
    }
}
