<?php

namespace App\Services;

use App\Models\Exercise;
use App\Models\MuscleRecoveryLog;
use App\Models\WorkoutProgram;
use App\Models\WorkoutProgramDay;
use App\Models\WorkoutProgramExercise;
use App\Models\WorkoutSession;
use App\Models\WorkoutSessionItem;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class WorkoutProgramGenerator
{
    public function __construct(
        private readonly MuscleRecoveryService $recoveryService
    ) {}

    public const EQUIPMENT_OPTIONS = [
        'Dumbbell',
        'Barbell',
        'Resistance Band',
        'Kettlebell',
        'Cable Machine',
        'Smith Machine',
        'Leg Press Machine',
        'Pull Up Bar',
        'Bench',
        'Gym Machine',
        'Alat Bantu Lainnya',
    ];

    public const TARGET_MUSCLE_OPTIONS = [
        'Full Body' => 'Seluruh Tubuh (Full Body)',
        'Chest' => 'Dada (Chest)',
        'Back' => 'Punggung (Back)',
        'Shoulder' => 'Bahu (Shoulder)',
        'Biceps' => 'Bisep (Biceps)',
        'Triceps' => 'Trisep (Triceps)',
        'Abs' => 'Perut & Core (Abs)',
        'Legs' => 'Kaki (Legs)',
        'Glutes' => 'Bokong & Pinggul (Glutes)',
    ];

    private const MUSCLE_DB_MAP = [
        'Chest' => ['Dada'],
        'Back' => ['Punggung', 'Punggung Atas', 'Punggung Tengah', 'Punggung Bawah', 'Lats', 'Trapezius'],
        'Shoulder' => ['Bahu'],
        'Biceps' => ['Bisep', 'Lengan Bawah'],
        'Triceps' => ['Trisep'],
        'Abs' => ['Perut'],
        'Legs' => ['Paha Depan', 'Paha Belakang', 'Betis', 'Adduktor (Paha Dalam)', 'Abduktor (Paha Luar)'],
        'Glutes' => ['Bokong', 'Pinggul'],
    ];

    private const EXTERNAL_GEAR_KEYWORDS = [
        'pull up', 'pull-up', 'chin up', 'chin-up', 'muscle up', 'muscle-up',
        'hanging', 'inverted row', 'trx', 'ring ', 'rings', 'rope',
        'dumbbell', 'barbell', 'ez-bar', 'ez bar', 'kettlebell', 'cable',
        'machine', 'smith', 'leg press', 'bench', 'box ', 'box jump',
        'medicine ball', 'stability ball', 'swiss ball', 'exercise ball',
        'foam roll', 'bosu', 'plate', 'band', 'banded', 'ab wheel', 'roller', 'sled',
    ];

    /**
     * Generate preview data (non-persisted) for a complete 7-day or 28-day workout program
     * with full muscle recovery validation (48h min / 72h high-volume) and ACSM 2026 rules.
     *
     * @return array{ok: bool, message?: string, available_count?: int, suggestions?: array, program?: array, days?: array}
     */
    public function generatePreview(array $input, ?int $userAge = null, ?int $userId = null): array
    {
        $this->recoveryService->ensureMuscleGroupsSeeded();

        $method = $input['training_method'] ?? WorkoutProgram::METHOD_HYPERTROPHY;
        $equipmentMode = $input['equipment_mode'] ?? 'bodyweight';
        $selectedEquipments = array_values(array_filter((array) ($input['selected_equipments'] ?? [])));
        $level = $input['level'] ?? 'beginner';
        $targetMuscles = array_values(array_filter((array) ($input['target_muscles'] ?? ['Full Body'])));
        if (empty($targetMuscles)) {
            $targetMuscles = ['Full Body'];
        }
        $frequency = max(2, min(6, (int) ($input['frequency_per_week'] ?? 3)));
        $sessionMinutes = (int) ($input['session_duration_minutes'] ?? 45);
        $programDuration = ($input['program_duration'] ?? '1_week') === '1_month' ? '1_month' : '1_week';
        $totalWeeks = $programDuration === '1_month' ? 4 : 1;
        $totalDays = $totalWeeks * 7;
        $fatigueStatus = ($input['fatigue_status'] ?? 'normal') === 'fatigued' ? 'fatigued' : 'normal';

        $startDate = ! empty($input['start_date'])
            ? Carbon::parse($input['start_date'], 'Asia/Jakarta')->startOfDay()
            : Carbon::now('Asia/Jakarta')->startOfDay();
        $endDate = $startDate->copy()->addDays($totalDays - 1);

        $excludedRaw = trim((string) ($input['excluded_keywords'] ?? ''));
        $excludedKeywords = $excludedRaw !== ''
            ? array_values(array_filter(array_map(fn ($v) => strtolower(trim($v)), explode(',', $excludedRaw))))
            : [];
        $excludedIds = array_map('intval', (array) ($input['excluded_exercise_ids'] ?? []));

        $adjustments = [];

        // Beginner high-frequency guidance (Section 4D & 4E)
        if ($level === 'beginner' && $frequency >= 5) {
            $recommendedFreq = $frequency === 6 ? 3 : 4;
            $adjustments[] = [
                'type' => 'frequency_recommendation',
                'title' => 'Rekomendasi Frekuensi Pemula (3–4 Hari/Minggu)',
                'detail' => "Anda memilih {$frequency} hari/minggu pada level Beginner. Untuk adaptasi jaringan dan pemulihan optimal (ACSM 2026), volume per sesi otomatis diturunkan ke level konservatif atau pertimbangkan {$recommendedFreq} hari/minggu.",
            ];
        }

        // 1-3. Filter exercises strictly by Equipment, Target Muscle, Level, Method & Exclusions
        $allExercises = Exercise::query()->orderBy('name')->get();
        $eligible = $this->filterEligibleExercises(
            $allExercises,
            $equipmentMode,
            $selectedEquipments,
            $level,
            $method,
            $excludedKeywords,
            $userAge,
            $excludedIds
        );

        // Filter pool by target muscles (if not Full Body)
        $isFullBody = in_array('Full Body', $targetMuscles, true);
        $targetPool = $isFullBody
            ? $eligible
            : $eligible->filter(fn (Exercise $ex) => $this->exerciseMatchesAnyMuscleKey($ex, $targetMuscles))->values();

        if ($targetPool->count() < 2) {
            $suggestions = [];
            if ($equipmentMode === 'bodyweight') {
                $suggestions[] = 'Aktifkan mode "Dengan Alat" (misalnya Dumbbell atau Resistance Band) untuk memperluas pilihan gerakan.';
            } else {
                $suggestions[] = 'Tambahkan jenis alat lain yang tersedia atau sertakan gerakan bodyweight.';
            }
            if (! $isFullBody) {
                $suggestions[] = 'Pilih target "Seluruh Tubuh (Full Body)" atau tambahkan kelompok otot lain.';
            }
            if (! empty($excludedKeywords) || ! empty($excludedIds)) {
                $suggestions[] = 'Kurangi daftar gerakan yang dihindari.';
            }

            return [
                'ok' => false,
                'available_count' => $targetPool->count(),
                'message' => "Jumlah gerakan yang sesuai di database hanya {$targetPool->count()} gerakan. Minimal dibutuhkan 2 gerakan untuk menyusun program latihan yang aman dan seimbang.",
                'suggestions' => $suggestions,
            ];
        }

        // Determine workout day slots within a 7-day week (1..7)
        $workoutSlots = $this->getWeeklyWorkoutSlots($frequency);
        $exercisesPerDayTarget = $this->getExercisesPerSessionCount($sessionMinutes);

        // Build Week 1 template days (7 slots), then reuse/progress across Weeks 2-4
        $week1Slots = [];
        $workoutCounter = 0;
        for ($d = 1; $d <= 7; $d++) {
            if (! in_array($d, $workoutSlots, true)) {
                $week1Slots[$d] = [
                    'day_type' => WorkoutProgramDay::TYPE_REST,
                    'focus_label' => 'Hari Istirahat & Pemulihan',
                    'muscle_keys' => [],
                    'base_exercises' => [],
                ];

                continue;
            }

            $split = $this->getSplitFocusForWorkoutIndex($workoutCounter, $frequency, $targetMuscles, $isFullBody);
            $picked = $this->selectExercisesForDay(
                $targetPool,
                $eligible,
                $split['muscle_keys'],
                $method,
                $level,
                $equipmentMode,
                $selectedEquipments,
                $exercisesPerDayTarget,
                $workoutCounter
            );

            $week1Slots[$d] = [
                'day_type' => WorkoutProgramDay::TYPE_WORKOUT,
                'focus_label' => $split['label'],
                'muscle_keys' => $split['muscle_keys'],
                'base_exercises' => $picked,
            ];
            $workoutCounter++;
        }

        $isYouth = $userAge !== null && $userAge > 0 && $userAge < 18;
        $safetyNotes = $this->buildSafetyNotes($method, $level, $isYouth);

        // Expand into 7 or 28 calendar days with progressive overload & primary/secondary stimulus mapping
        $days = [];
        for ($dayNum = 1; $dayNum <= $totalDays; $dayNum++) {
            $weekNumber = intdiv($dayNum - 1, 7) + 1;
            $slotInWeek = (($dayNum - 1) % 7) + 1;
            $date = $startDate->copy()->addDays($dayNum - 1);
            $dayName = WorkoutSession::fullIndonesianDay($date);
            $weekPhase = $this->getWeekPhase($weekNumber, $fatigueStatus);
            $template = $week1Slots[$slotInWeek];

            if ($template['day_type'] === WorkoutProgramDay::TYPE_REST) {
                $days[] = [
                    'week_number' => $weekNumber,
                    'day_number' => $dayNum,
                    'day_name' => $dayName,
                    'scheduled_date' => $date->toDateString(),
                    'scheduled_date_label' => WorkoutSession::formatIndonesianDate($date),
                    'day_type' => WorkoutProgramDay::TYPE_REST,
                    'focus_label' => 'Rest Day / Pemulihan Aktif',
                    'week_phase' => $weekPhase,
                    'estimated_duration_minutes' => 0,
                    'notes' => 'Istirahat untuk pemulihan otot (minimal 48 jam jeda antar sesi berat otot yang sama).',
                    'placement_reason' => 'Hari jeda terencana untuk memenuhi siklus pemulihan 48–72 jam kelompok otot besar.',
                    'recovery_status' => 'Hari istirahat',
                    'recovery_summary' => [],
                    'exercises' => [],
                ];

                continue;
            }

            $dayExercises = [];
            foreach ($template['base_exercises'] as $orderIdx => $ex) {
                $prescription = $this->prescribeExercise($ex, $method, $level, $weekNumber, $orderIdx, $isYouth, $frequency, $fatigueStatus);
                $muscleAnalysis = $this->recoveryService->analyzeExercise($ex);

                $dayExercises[] = [
                    'exercise_id' => $ex->id,
                    'name' => $ex->name,
                    'target_muscle' => $ex->target_muscle ?? 'Umum',
                    'primary_group' => $muscleAnalysis['primary_group'],
                    'primary_muscle' => $muscleAnalysis['primary_sub_muscle'],
                    'secondary_muscles' => $muscleAnalysis['secondary_muscles'],
                    'stimulus_level' => $muscleAnalysis['primary_stimulus'],
                    'equipment' => $ex->equipment ?? 'Bodyweight',
                    'difficulty' => $ex->difficulty ?? 'Menengah',
                    'instructions' => $ex->instructions,
                    'image' => $ex->image_1 ?? $ex->icon,
                    'alternative_equipment' => $ex->alternative_equipment,
                    'sort_order' => $orderIdx + 1,
                    'target_sets' => $prescription['sets'],
                    'target_reps' => $prescription['reps'],
                    'is_duration_based' => $prescription['is_duration_based'],
                    'rest_seconds' => $prescription['rest_seconds'],
                    'intensity_note' => $prescription['intensity_note'],
                    'progression_note' => $prescription['progression_note'],
                ];
            }

            $days[] = [
                'week_number' => $weekNumber,
                'day_number' => $dayNum,
                'day_name' => $dayName,
                'scheduled_date' => $date->toDateString(),
                'scheduled_date_label' => WorkoutSession::formatIndonesianDate($date),
                'day_type' => WorkoutProgramDay::TYPE_WORKOUT,
                'focus_label' => $template['focus_label'],
                'week_phase' => $weekPhase,
                'estimated_duration_minutes' => $sessionMinutes,
                'notes' => "Fase {$weekPhase} (Minggu {$weekNumber}): ".$this->getPhaseDescription($weekNumber, $fatigueStatus),
                'placement_reason' => "Sesi {$template['focus_label']} dijadwalkan pada {$dayName} agar setiap otot primer & sekunder memiliki jeda pemulihan optimal.",
                'exercises' => $dayExercises,
            ];
        }

        // Validate against user's recent recovery logs & resolve any recovery conflicts automatically
        $priorLogs = $userId ? $this->recoveryService->getUserRecentRecoveryLogs($userId, $startDate) : [];
        $resolved = $this->validateAndAutoResolveSchedule($days, $method, $priorLogs);
        $days = $resolved['days'];
        $adjustments = array_merge($adjustments, $resolved['adjustments']);

        $totalWorkoutDays = collect($days)->where('day_type', WorkoutProgramDay::TYPE_WORKOUT)->count();
        $totalRestDays = collect($days)->where('day_type', WorkoutProgramDay::TYPE_REST)->count();
        $totalExerciseSlots = collect($days)->sum(fn ($d) => count($d['exercises']));

        $methodLabel = WorkoutProgram::methodLabels()[$method] ?? ucfirst($method);
        $targetLabel = $isFullBody ? 'Full Body' : implode(', ', $targetMuscles);
        $durationLabel = $programDuration === '1_month' ? '1 Bulan (4 Minggu)' : '1 Minggu (7 Hari)';
        $programName = trim((string) ($input['program_name'] ?? '')) !== ''
            ? trim((string) $input['program_name'])
            : "{$methodLabel} — {$targetLabel} ({$durationLabel})";

        return [
            'ok' => true,
            'program' => [
                'name' => $programName,
                'training_method' => $method,
                'method_label' => $methodLabel,
                'equipment_mode' => $equipmentMode,
                'selected_equipments' => $selectedEquipments,
                'equipment_label' => $equipmentMode === 'bodyweight'
                    ? 'Tanpa Alat (Bodyweight)'
                    : 'Dengan Alat: '.(empty($selectedEquipments) ? 'Semua' : implode(', ', $selectedEquipments)),
                'level' => $level,
                'level_label' => WorkoutProgram::levelLabels()[$level] ?? ucfirst($level),
                'target_muscles' => $targetMuscles,
                'target_label' => $targetLabel,
                'frequency_per_week' => $frequency,
                'session_duration_minutes' => $sessionMinutes,
                'program_duration' => $programDuration,
                'duration_label' => $durationLabel,
                'total_weeks' => $totalWeeks,
                'total_days' => $totalDays,
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
                'total_workout_days' => $totalWorkoutDays,
                'total_rest_days' => $totalRestDays,
                'total_exercises' => $totalExerciseSlots,
                'safety_notes' => $safetyNotes,
                'recovery_valid' => $resolved['valid'],
                'adjustments' => $adjustments,
                'recovery_disclaimer' => 'Status pemulihan merupakan hasil perhitungan penjadwalan berdasarkan jeda 48–72 jam dan beban latihan terencana (ACSM 2026), bukan pengukuran biologis langsung atas jaringan otot.',
                'preferences' => [
                    'excluded_keywords' => $excludedRaw,
                    'excluded_exercise_ids' => $excludedIds,
                    'fatigue_status' => $fatigueStatus,
                    'notes' => trim((string) ($input['extra_notes'] ?? '')),
                ],
            ],
            'days' => $days,
        ];
    }

    /**
     * Validate schedule and automatically resolve 48h/72h recovery conflicts
     * by reducing excessive load or converting unsafe consecutive sessions to Rest Day.
     */
    private function validateAndAutoResolveSchedule(array $days, string $method, array $priorLogs): array
    {
        $adjustments = [];
        $validation = $this->recoveryService->validateSchedule($days, $method, $priorLogs);

        if (! $validation['valid']) {
            foreach ($validation['conflicts'] as $conflict) {
                $idx = $conflict['day_index'];
                if (! isset($days[$idx]) || ($days[$idx]['day_type'] ?? '') !== WorkoutProgramDay::TYPE_WORKOUT) {
                    continue;
                }

                // If conflict is 48h violation (< 48h) or heavy recovery violation, convert that day to Rest / Active Recovery
                // to protect muscle recovery and keep the schedule scientifically valid.
                $days[$idx]['day_type'] = WorkoutProgramDay::TYPE_REST;
                $days[$idx]['focus_label'] = 'Rest / Active Recovery (Penyesuaian Pemulihan)';
                $days[$idx]['estimated_duration_minutes'] = 0;
                $days[$idx]['exercises'] = [];
                $days[$idx]['placement_reason'] = "Jadwal digeser menjadi Rest Day otomatis: {$conflict['message']}";
                $days[$idx]['notes'] = "Solusi Otomatis: {$conflict['message']} Sesi dialihkan ke pemulihan agar jeda pemulihan terpenuhi.";

                $adjustments[] = [
                    'type' => 'recovery_conflict_resolved',
                    'title' => "Penyesuaian Otomatis Hari {$days[$idx]['day_number']} ({$days[$idx]['day_name']})",
                    'detail' => "{$conflict['message']} Solusi: Hari {$days[$idx]['day_name']} diubah menjadi Rest / Active Recovery untuk memenuhi jeda pemulihan.",
                ];
            }

            $validation = $this->recoveryService->validateSchedule($days, $method, $priorLogs);
        }

        return [
            'valid' => $validation['valid'],
            'days' => $validation['days'],
            'adjustments' => $adjustments,
        ];
    }

    /**
     * Save a previewed program and sync all workout days into Rutinku & MuscleRecoveryLogs.
     * Backend re-validates recovery rules before persisting so rules cannot be bypassed.
     */
    public function saveProgramToRutinku(int $userId, array $previewData, bool $archivePreviousActive = true): WorkoutProgram
    {
        $meta = $previewData['program'];
        $startDate = Carbon::parse($meta['start_date'], 'Asia/Jakarta')->startOfDay();
        $priorLogs = $this->recoveryService->getUserRecentRecoveryLogs($userId, $startDate);

        // Backend Security Gate: enforce recovery validation prior to DB transaction
        $validation = $this->recoveryService->validateSchedule(
            $previewData['days'],
            $meta['training_method'] ?? 'hypertrophy',
            $priorLogs
        );

        if (! $validation['valid']) {
            $firstConflict = $validation['conflicts'][0]['message'] ?? 'Jadwal melanggar batas pemulihan minimal 48 jam.';
            throw new \InvalidArgumentException($firstConflict);
        }

        $validatedDays = $validation['days'];

        return DB::transaction(function () use ($userId, $meta, $validatedDays, $archivePreviousActive) {
            if ($archivePreviousActive) {
                WorkoutProgram::where('user_id', $userId)
                    ->where('status', WorkoutProgram::STATUS_ACTIVE)
                    ->update(['status' => WorkoutProgram::STATUS_ARCHIVED]);
            }

            $program = WorkoutProgram::create([
                'user_id' => $userId,
                'name' => $meta['name'],
                'training_method' => $meta['training_method'],
                'equipment_mode' => $meta['equipment_mode'],
                'selected_equipments' => $meta['selected_equipments'] ?? [],
                'level' => $meta['level'],
                'target_muscles' => $meta['target_muscles'] ?? ['Full Body'],
                'frequency_per_week' => $meta['frequency_per_week'],
                'session_duration_minutes' => $meta['session_duration_minutes'],
                'program_duration' => $meta['program_duration'],
                'total_weeks' => $meta['total_weeks'],
                'total_days' => $meta['total_days'],
                'start_date' => $meta['start_date'],
                'end_date' => $meta['end_date'],
                'preferences' => $meta['preferences'] ?? [],
                'status' => WorkoutProgram::STATUS_ACTIVE,
                'safety_notes' => $meta['safety_notes'] ?? null,
            ]);

            foreach ($validatedDays as $dayData) {
                $programDay = WorkoutProgramDay::create([
                    'workout_program_id' => $program->id,
                    'week_number' => $dayData['week_number'],
                    'day_number' => $dayData['day_number'],
                    'day_name' => $dayData['day_name'],
                    'scheduled_date' => $dayData['scheduled_date'],
                    'day_type' => $dayData['day_type'],
                    'focus_label' => $dayData['focus_label'],
                    'week_phase' => $dayData['week_phase'],
                    'estimated_duration_minutes' => $dayData['estimated_duration_minutes'],
                    'notes' => $dayData['notes'],
                    'placement_reason' => $dayData['placement_reason'] ?? null,
                    'recovery_status' => $dayData['recovery_status'] ?? null,
                    'recovery_summary' => $dayData['recovery_summary'] ?? [],
                ]);

                if ($dayData['day_type'] !== WorkoutProgramDay::TYPE_WORKOUT || empty($dayData['exercises'])) {
                    continue;
                }

                foreach ($dayData['exercises'] as $idx => $exData) {
                    WorkoutProgramExercise::create([
                        'workout_program_day_id' => $programDay->id,
                        'exercise_id' => $exData['exercise_id'],
                        'primary_muscle' => $exData['primary_muscle'] ?? ($exData['target_muscle'] ?? null),
                        'secondary_muscles' => $exData['secondary_muscles'] ?? [],
                        'stimulus_level' => $exData['stimulus_level'] ?? 'high',
                        'sort_order' => $idx + 1,
                        'target_sets' => $exData['target_sets'],
                        'target_reps' => $exData['target_reps'],
                        'is_duration_based' => (bool) ($exData['is_duration_based'] ?? false),
                        'rest_seconds' => $exData['rest_seconds'] ?? 60,
                        'intensity_note' => $exData['intensity_note'] ?? null,
                        'progression_note' => $exData['progression_note'] ?? null,
                    ]);
                }

                // Connect directly to existing Rutinku / Workout Planner system
                $session = WorkoutSession::create([
                    'user_id' => $userId,
                    'workout_program_id' => $program->id,
                    'workout_program_day_id' => $programDay->id,
                    'name' => "{$dayData['focus_label']} (M{$dayData['week_number']})",
                    'category' => $meta['method_label'] ?? 'Program Terjadwal',
                    'training_method' => $meta['training_method'],
                    'week_number' => $dayData['week_number'],
                    'scheduled_date' => $dayData['scheduled_date'],
                    'scheduled_time' => '07:00',
                    'status' => WorkoutSession::STATUS_UPCOMING,
                    'progress_percent' => 0,
                    'notes' => $dayData['notes'],
                ]);

                foreach ($dayData['exercises'] as $idx => $exData) {
                    WorkoutSessionItem::create([
                        'workout_session_id' => $session->id,
                        'exercise_id' => $exData['exercise_id'],
                        'exercise_name' => $exData['name'],
                        'target_muscle' => $exData['target_muscle'] ?? 'Umum',
                        'target_sets' => $exData['target_sets'],
                        'completed_sets' => 0,
                        'target_reps' => $exData['target_reps'],
                        'rest_seconds' => $exData['rest_seconds'] ?? 60,
                        'intensity_note' => $exData['intensity_note'] ?? null,
                        'is_completed' => false,
                        'notes' => $exData['progression_note'] ?? null,
                        'sort_order' => $idx + 1,
                    ]);
                }

                // Store muscle recovery tracking records for this scheduled session
                foreach ((array) ($dayData['recovery_summary'] ?? []) as $rec) {
                    MuscleRecoveryLog::create([
                        'user_id' => $userId,
                        'workout_program_id' => $program->id,
                        'workout_session_id' => $session->id,
                        'muscle_group' => $this->recoveryService->inferParentGroup((string) $rec['muscle']),
                        'sub_muscle' => $rec['muscle'],
                        'role' => $rec['role'] ?? 'primary',
                        'stimulus_level' => $rec['stimulus'] ?? 'high',
                        'total_sets' => (int) ($rec['total_sets'] ?? 3),
                        'intensity_level' => ($rec['required_hours'] ?? 48) >= 72 ? 'high' : 'moderate',
                        'training_method' => $meta['training_method'],
                        'trained_date' => $dayData['scheduled_date'],
                        'required_recovery_hours' => (int) ($rec['required_hours'] ?? 48),
                        'completion_status' => 'planned',
                    ]);
                }
            }

            return $program;
        });
    }

    /**
     * Find compatible substitute exercises from DB for preview editing.
     */
    public function getSubstituteOptions(
        int $currentExerciseId,
        string $targetMuscle,
        string $equipmentMode,
        array $selectedEquipments,
        string $level,
        string $method,
        array $excludedKeywords = []
    ): Collection {
        $all = Exercise::query()->where('id', '!=', $currentExerciseId)->orderBy('name')->get();
        $eligible = $this->filterEligibleExercises($all, $equipmentMode, $selectedEquipments, $level, $method, $excludedKeywords);

        $sameMuscle = $eligible->filter(fn (Exercise $ex) => strtolower((string) $ex->target_muscle) === strtolower($targetMuscle))->values();
        if ($sameMuscle->isNotEmpty()) {
            return $sameMuscle->take(15);
        }

        return $eligible->take(15);
    }

    private function filterEligibleExercises(
        Collection $exercises,
        string $equipmentMode,
        array $selectedEquipments,
        string $level,
        string $method,
        array $excludedKeywords = [],
        ?int $userAge = null,
        array $excludedIds = []
    ): Collection {
        return $exercises->filter(function (Exercise $ex) use ($equipmentMode, $selectedEquipments, $level, $method, $excludedKeywords, $userAge, $excludedIds) {
            if (! empty($excludedIds) && in_array((int) $ex->id, $excludedIds, true)) {
                return false;
            }

            if (! $this->passesEquipmentRule($ex, $equipmentMode, $selectedEquipments)) {
                return false;
            }

            if (! $this->passesLevelRule($ex, $level, $method, $userAge)) {
                return false;
            }

            if (! empty($excludedKeywords)) {
                $haystack = strtolower($ex->name.' '.($ex->target_muscle ?? '').' '.($ex->equipment ?? ''));
                foreach ($excludedKeywords as $kw) {
                    if ($kw !== '' && str_contains($haystack, $kw)) {
                        return false;
                    }
                }
            }

            return true;
        })->values();
    }

    public function passesEquipmentRule(Exercise $ex, string $equipmentMode, array $selectedEquipments): bool
    {
        $nameLower = strtolower((string) $ex->name);
        $dbEquip = strtolower(trim((string) ($ex->equipment ?? 'Bodyweight')));
        $isPureBodyweight = $this->isPureBodyweightExercise($ex);

        if ($equipmentMode === 'bodyweight') {
            return $isPureBodyweight;
        }

        // With equipment mode: allow pure bodyweight OR exercises matching user's selected equipment
        if ($isPureBodyweight) {
            return true;
        }

        $selectedLower = array_map('strtolower', $selectedEquipments);

        // Pull-up bar check
        $needsPullUpBar = str_contains($nameLower, 'pull up') || str_contains($nameLower, 'pull-up')
            || str_contains($nameLower, 'chin up') || str_contains($nameLower, 'chin-up')
            || str_contains($nameLower, 'muscle up') || str_contains($nameLower, 'hanging');
        if ($needsPullUpBar) {
            return in_array('pull up bar', $selectedLower, true);
        }

        // Bench check
        if (str_contains($nameLower, 'bench')) {
            if (! in_array('bench', $selectedLower, true)) {
                return false;
            }
            if ($dbEquip === 'barbell' && ! in_array('barbell', $selectedLower, true)) {
                return false;
            }
            if ($dbEquip === 'dumbbell' && ! in_array('dumbbell', $selectedLower, true)) {
                return false;
            }

            return true;
        }

        if ($dbEquip === 'dumbbell' || str_contains($nameLower, 'dumbbell')) {
            return in_array('dumbbell', $selectedLower, true);
        }
        if ($dbEquip === 'barbell' || str_contains($nameLower, 'barbell') || str_contains($nameLower, 'ez-bar') || str_contains($nameLower, 'ez bar')) {
            return in_array('barbell', $selectedLower, true);
        }
        if ($dbEquip === 'resistance band' || str_contains($nameLower, 'band')) {
            return in_array('resistance band', $selectedLower, true);
        }
        if ($dbEquip === 'kettlebell' || str_contains($nameLower, 'kettlebell')) {
            return in_array('kettlebell', $selectedLower, true);
        }
        if ($dbEquip === 'cable' || str_contains($nameLower, 'cable')) {
            return in_array('cable machine', $selectedLower, true);
        }
        if (str_contains($nameLower, 'smith')) {
            return in_array('smith machine', $selectedLower, true) || in_array('gym machine', $selectedLower, true);
        }
        if (str_contains($nameLower, 'leg press')) {
            return in_array('leg press machine', $selectedLower, true) || in_array('gym machine', $selectedLower, true);
        }
        if ($dbEquip === 'machine' || str_contains($nameLower, 'machine')) {
            return in_array('gym machine', $selectedLower, true);
        }
        if ($dbEquip === 'alat bantu lainnya') {
            return in_array('alat bantu lainnya', $selectedLower, true);
        }

        return false;
    }

    public function isPureBodyweightExercise(Exercise $ex): bool
    {
        $dbEquip = strtolower(trim((string) ($ex->equipment ?? 'Bodyweight')));
        if (! in_array($dbEquip, ['', 'bodyweight', 'body only', 'body weight', 'none'], true)) {
            return false;
        }

        $nameLower = strtolower((string) $ex->name);
        foreach (self::EXTERNAL_GEAR_KEYWORDS as $kw) {
            if (str_contains($nameLower, $kw)) {
                return false;
            }
        }

        // Floor dips are fine if explicitly floor, otherwise exclude bar dips
        if (preg_match('/\bdips?\b/', $nameLower) && ! str_contains($nameLower, 'floor')) {
            return false;
        }

        return true;
    }

    private function passesLevelRule(Exercise $ex, string $level, string $method, ?int $userAge = null): bool
    {
        $exDiff = strtolower(trim((string) ($ex->difficulty ?? 'menengah')));
        $nameLower = strtolower((string) $ex->name);
        $isYouth = $userAge !== null && $userAge > 0 && $userAge < 18;

        if ($level === 'beginner' || $isYouth) {
            return ! in_array($exDiff, ['lanjut', 'advanced'], true);
        }

        if ($level === 'intermediate') {
            return ! in_array($exDiff, ['lanjut', 'advanced'], true);
        }

        return true;
    }

    private function exerciseMatchesAnyMuscleKey(Exercise $ex, array $muscleKeys): bool
    {
        $dbMuscle = strtolower((string) ($ex->target_muscle ?? ''));
        foreach ($muscleKeys as $key) {
            $mapped = self::MUSCLE_DB_MAP[$key] ?? [$key];
            foreach ($mapped as $indo) {
                if ($dbMuscle === strtolower($indo)) {
                    return true;
                }
            }
        }

        return false;
    }

    private function getWeeklyWorkoutSlots(int $frequency): array
    {
        return match ($frequency) {
            2 => [1, 4],
            3 => [1, 3, 5],
            4 => [1, 2, 4, 5],
            5 => [1, 2, 3, 5, 6],
            6 => [1, 2, 3, 4, 5, 6],
            default => [1, 3, 5],
        };
    }

    private function getExercisesPerSessionCount(int $minutes): int
    {
        return match (true) {
            $minutes <= 20 => 3,
            $minutes <= 30 => 4,
            $minutes <= 45 => 5,
            $minutes <= 60 => 6,
            default => 7,
        };
    }

    private function getSplitFocusForWorkoutIndex(int $idx, int $frequency, array $targetMuscles, bool $isFullBody): array
    {
        if ($isFullBody) {
            if ($frequency <= 3) {
                return [
                    'label' => 'Full Body '.chr(65 + ($idx % 3)),
                    'muscle_keys' => ['Chest', 'Back', 'Shoulder', 'Legs', 'Glutes', 'Abs'],
                ];
            }
            if ($frequency === 4) {
                return $idx % 2 === 0
                    ? ['label' => 'Upper Body', 'muscle_keys' => ['Chest', 'Back', 'Shoulder', 'Biceps', 'Triceps']]
                    : ['label' => 'Lower Body & Core', 'muscle_keys' => ['Legs', 'Glutes', 'Abs']];
            }
            if ($frequency === 5) {
                $splits = [
                    ['label' => 'Push (Dada, Bahu, Trisep)', 'muscle_keys' => ['Chest', 'Shoulder', 'Triceps']],
                    ['label' => 'Pull (Punggung & Bisep)', 'muscle_keys' => ['Back', 'Biceps']],
                    ['label' => 'Legs & Core (Kaki, Bokong, Perut)', 'muscle_keys' => ['Legs', 'Glutes', 'Abs']],
                    ['label' => 'Upper Body & Accessory', 'muscle_keys' => ['Chest', 'Back', 'Shoulder', 'Biceps', 'Triceps']],
                    ['label' => 'Lower Body & Core Accessory', 'muscle_keys' => ['Legs', 'Glutes', 'Abs']],
                ];

                return $splits[$idx % 5];
            }

            // 6 days: Push / Pull / Legs (memberikan jarak ~72 jam antar sesi otot sejenis)
            $variant = intdiv($idx, 3) % 2 === 0 ? 'A' : 'B';
            $ppl = [
                ['label' => "Push {$variant} (Dada, Bahu, Trisep)", 'muscle_keys' => ['Chest', 'Shoulder', 'Triceps']],
                ['label' => "Pull {$variant} (Punggung & Bisep)", 'muscle_keys' => ['Back', 'Biceps']],
                ['label' => "Legs {$variant} & Core (Kaki, Bokong, Perut)", 'muscle_keys' => ['Legs', 'Glutes', 'Abs']],
            ];

            return $ppl[$idx % 3];
        }

        // Custom selected target muscles
        if (count($targetMuscles) === 1) {
            return [
                'label' => 'Fokus '.$targetMuscles[0],
                'muscle_keys' => $targetMuscles,
            ];
        }

        // Rotate subsets across days to protect recovery
        $chunkSize = max(1, (int) ceil(count($targetMuscles) / min($frequency, count($targetMuscles))));
        $start = ($idx * $chunkSize) % count($targetMuscles);
        $slice = array_slice(array_merge($targetMuscles, $targetMuscles), $start, min(3, count($targetMuscles)));
        $slice = array_values(array_unique($slice));

        return [
            'label' => 'Fokus '.implode(' & ', $slice),
            'muscle_keys' => $slice,
        ];
    }

    private function selectExercisesForDay(
        Collection $targetPool,
        Collection $fallbackPool,
        array $dayMuscleKeys,
        string $method,
        string $level,
        string $equipmentMode,
        array $selectedEquipments,
        int $desiredCount,
        int $dayOffset
    ): array {
        $selected = collect();
        $usedIds = [];

        // Score & sort candidates so compounds/main movements and selected equipment come first
        $scored = $targetPool->sortByDesc(function (Exercise $ex) use ($method, $level, $equipmentMode, $selectedEquipments) {
            return $this->scoreExerciseFit($ex, $method, $level, $equipmentMode, $selectedEquipments);
        })->values();

        // Pick at least 1 exercise per muscle key in the day's split first
        foreach ($dayMuscleKeys as $mIdx => $mKey) {
            if ($selected->count() >= $desiredCount) {
                break;
            }
            $candidates = $scored->filter(fn (Exercise $ex) => ! in_array($ex->id, $usedIds, true) && $this->exerciseMatchesAnyMuscleKey($ex, [$mKey]))->values();
            if ($candidates->isNotEmpty()) {
                // Rotate index across days (Day A, Day B, Day C) so workouts have smart variety
                $pickIdx = $dayOffset % min(3, $candidates->count());
                $pick = $candidates->get($pickIdx);
                $selected->push($pick);
                $usedIds[] = $pick->id;
            }
        }

        // Fill remaining slots ONLY from dayMuscleKeys pool so split boundaries (Push/Pull/Legs/Upper/Lower) stay strict
        if ($selected->count() < $desiredCount) {
            $dayPool = $scored->filter(fn (Exercise $ex) => ! in_array($ex->id, $usedIds, true) && $this->exerciseMatchesAnyMuscleKey($ex, $dayMuscleKeys))->values();
            foreach ($dayPool as $ex) {
                if ($selected->count() >= $desiredCount) {
                    break;
                }
                $selected->push($ex);
                $usedIds[] = $ex->id;
            }
        }

        // Order exercises: Main/Compound first, Isolation/Core/Cardio later
        return $selected->sortByDesc(function (Exercise $ex) {
            return $this->isCompoundExercise($ex) ? 1 : 0;
        })->values()->all();
    }

    private function scoreExerciseFit(Exercise $ex, string $method, string $level, string $equipmentMode, array $selectedEquipments): int
    {
        $score = 10;
        $nameLower = strtolower((string) $ex->name);
        $diffLower = strtolower((string) ($ex->difficulty ?? 'menengah'));

        if ($level === 'beginner' && $diffLower === 'pemula') {
            $score += 15;
        } elseif ($level === 'intermediate' && $diffLower === 'menengah') {
            $score += 12;
        } elseif ($level === 'advanced' && $diffLower === 'lanjut') {
            $score += 12;
        }

        if ($equipmentMode === 'with_equipment' && ! $this->isPureBodyweightExercise($ex)) {
            $score += 12;
        }

        if ($this->isCompoundExercise($ex) && in_array($method, [WorkoutProgram::METHOD_STRENGTH, WorkoutProgram::METHOD_HYPERTROPHY], true)) {
            $score += 10;
        }

        if ($method === WorkoutProgram::METHOD_CONDITIONING && (strtolower((string) $ex->category) === 'kardio & daya tahan' || str_contains($nameLower, 'burpee') || str_contains($nameLower, 'mountain'))) {
            $score += 15;
        }

        if (! empty($ex->recommended_methods) && is_array($ex->recommended_methods) && in_array($method, $ex->recommended_methods, true)) {
            $score += 20;
        }

        return $score;
    }

    private function isCompoundExercise(Exercise $ex): bool
    {
        $nameLower = strtolower((string) $ex->name);
        foreach (['squat', 'deadlift', 'bench', 'press', 'row', 'pull', 'lunge', 'push up', 'push-up', 'bridge', 'thruster', 'burpee'] as $kw) {
            if (str_contains($nameLower, $kw)) {
                return true;
            }
        }

        return false;
    }

    private function isDurationBasedExercise(Exercise $ex): bool
    {
        $nameLower = strtolower((string) $ex->name);
        foreach (['plank', 'bridge', 'wall sit', 'hollow', 'hold', 'stretch', 'jogging', 'running', 'bicycling', 'mountain climber', 'skipping', 'jump rope', 'hang'] as $kw) {
            if (str_contains($nameLower, $kw) && ! str_contains($nameLower, 'glute bridge')) {
                return true;
            }
        }

        return false;
    }

    private function prescribeExercise(
        Exercise $ex,
        string $method,
        string $level,
        int $weekNumber,
        int $orderIndex,
        bool $isYouth,
        int $frequency = 3,
        string $fatigueStatus = 'normal'
    ): array {
        $isDuration = $this->isDurationBasedExercise($ex);
        $isPrimary = $orderIndex < 2 && $this->isCompoundExercise($ex);

        // Baseline parameters by Method & Level (ACSM 2026)
        [$baseSets, $minRep, $maxRep, $restSec, $intensity] = match ($method) {
            WorkoutProgram::METHOD_STRENGTH => match ($level) {
                'beginner' => [3, 6, 8, 90, 'Fokus teknik dasar & kontrol penuh (tanpa tes 1RM)'],
                'intermediate' => [$isPrimary ? 4 : 3, 5, 8, 120, 'Beban menantang terkontrol (RPE 7–8)'],
                default => [$isPrimary ? 5 : 3, 3, 6, 150, 'Beban berat ~80%+ 1RM atau progresi leverage lanjut'],
            },
            WorkoutProgram::METHOD_ENDURANCE => match ($level) {
                'beginner' => [2, 12, 15, 45, 'Tempo stabil, hindari kelelahan berlebih'],
                'intermediate' => [3, 15, 20, 35, 'Istirahat singkat, jaga kualitas napas'],
                default => [3, 15, 25, 30, 'Kepadatan tinggi / circuit pace terkontrol'],
            },
            WorkoutProgram::METHOD_CONDITIONING => match ($level) {
                'beginner' => [2, 10, 12, 45, 'Intensitas moderat, dukung kebugaran & pembakaran kalori'],
                'intermediate' => [3, 12, 15, 35, 'Aliran sesi aktif dengan jeda singkat'],
                default => [3, 12, 18, 30, 'Conditioning intensitas tinggi terkontrol'],
            },
            default => match ($level) { // Hypertrophy
                'beginner' => [2, 8, 12, 60, 'Kontrol fase turun 2 detik, sisakan 2–3 rep sebelum gagal'],
                'intermediate' => [3, 8, 12, 75, 'Volume terarah (~10 set/otot/minggu), RIR 1–2'],
                default => [$isPrimary ? 4 : 3, 8, 12, 90, 'Progressive overload terukur, teknik ketat'],
            },
        };

        // Beginner safety cap on 5-6x/week or Youth safety cap
        if ($isYouth || ($level === 'beginner' && $frequency >= 5)) {
            $baseSets = min($baseSets, 2);
            if ($isYouth) {
                $intensity = 'Pendekatan aman usia remaja: fokus teknik & pendampingan yang tepat';
            }
        }

        // On 3-day Full Body (48h gap), cap moderate sets so 48h recovery remains sufficient
        if ($frequency === 3 && $method !== WorkoutProgram::METHOD_STRENGTH) {
            $baseSets = min($baseSets, 3);
        }

        // Duration-based prescription (seconds)
        $baseDurationSec = match ($level) {
            'beginner' => 25,
            'intermediate' => 35,
            default => 45,
        };

        // Progressive overload across Weeks 1-4 (with fatigue evaluation check — Section 9)
        $sets = $baseSets;
        $progressionNote = 'Minggu 1 (Adaptasi): Pelajari teknik dan ritme gerakan.';

        if ($fatigueStatus === 'fatigued' && $weekNumber > 1) {
            $sets = max(2, $baseSets - 1);
            $progressionNote = "Minggu {$weekNumber} (Penyesuaian Kelelahan): Beban/volume diturunkan sementara agar pemulihan terjaga.";
        } elseif ($weekNumber === 2) {
            if ($isDuration) {
                $baseDurationSec += 5;
            } else {
                $minRep += 1;
                $maxRep += 2;
            }
            $progressionNote = 'Minggu 2 (Progression): Tambah 1–2 repetisi atau +5 detik bila teknik Minggu 1 sudah rapi.';
        } elseif ($weekNumber === 3) {
            if ($isPrimary && $level !== 'beginner' && ! $isYouth && $frequency !== 3) {
                $sets = min(5, $baseSets + 1);
            } elseif ($isDuration) {
                $baseDurationSec += 10;
            } else {
                $minRep += 2;
                $maxRep += 2;
            }
            $progressionNote = 'Minggu 3 (Development): Tingkatkan volume secara bertahap hanya jika target sebelumnya tercapai nyaman.';
        } elseif ($weekNumber === 4) {
            if ($sets > 2 && $orderIndex >= 3) {
                $sets -= 1;
            }
            $progressionNote = 'Minggu 4 (Consolidation): Evaluasi progres & jaga kualitas teknik untuk pemulihan optimal.';
        }

        $targetRepsStr = $isDuration
            ? "{$baseDurationSec} detik"
            : "{$minRep}-{$maxRep}";

        return [
            'sets' => $sets,
            'reps' => $targetRepsStr,
            'is_duration_based' => $isDuration,
            'rest_seconds' => $restSec,
            'intensity_note' => $intensity,
            'progression_note' => $progressionNote,
        ];
    }

    private function getWeekPhase(int $week, string $fatigueStatus = 'normal'): string
    {
        if ($fatigueStatus === 'fatigued' && $week > 1) {
            return 'Deload & Pemulihan';
        }

        return match ($week) {
            1 => 'Adaptasi',
            2 => 'Progression',
            3 => 'Development',
            default => 'Consolidation',
        };
    }

    private function getPhaseDescription(int $week, string $fatigueStatus = 'normal'): string
    {
        if ($fatigueStatus === 'fatigued' && $week > 1) {
            return 'Volume diturunkan berdasarkan laporan kelelahan untuk memulihkan performa secara aman.';
        }

        return match ($week) {
            1 => 'Kenali pola gerakan dan pastikan teknik dasar stabil.',
            2 => 'Tingkatkan repetisi atau durasi secara bertahap bila sesi sebelumnya terkendali.',
            3 => 'Lanjutkan progressive overload secara terukur sesuai respons tubuh.',
            default => 'Konsolidasi hasil latihan dan beri ruang pemulihan.',
        };
    }

    private function buildSafetyNotes(string $method, string $level, bool $isYouth): string
    {
        $notes = [
            'Panduan ini merupakan rekomendasi kebugaran umum, bukan pengganti evaluasi dokter atau pelatih profesional.',
            'Hentikan latihan segera jika muncul nyeri tajam, pusing, sesak napas tidak wajar, atau gejala yang mengkhawatirkan.',
            'Lakukan pemanasan dinamis 5 menit sebelum sesi dan pendinginan setelah selesai.',
        ];

        if ($level === 'beginner') {
            $notes[] = 'Level Pemula: Utamakan teknik yang benar; tidak perlu memaksakan latihan hingga gagal otot (failure) atau tes beban maksimal (1RM).';
        }
        if ($method === WorkoutProgram::METHOD_CONDITIONING) {
            $notes[] = 'Catatan: Latihan mendukung kebugaran dan aktivitas fisik, namun pengelolaan berat badan tetap dipengaruhi asupan nutrisi dan gaya hidup.';
        }
        if ($isYouth) {
            $notes[] = 'Perhatian Usia Remaja: Program telah disesuaikan untuk intensitas aman; disarankan berlatih dengan pendampingan orang dewasa/pelatih.';
        }

        return implode(' ', $notes);
    }
}
