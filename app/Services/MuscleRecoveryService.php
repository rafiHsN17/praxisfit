<?php

namespace App\Services;

use App\Models\Exercise;
use App\Models\MuscleGroup;
use App\Models\MuscleRecoveryLog;
use App\Models\WorkoutSession;
use Carbon\Carbon;

class MuscleRecoveryService
{
    public const HIERARCHY = [
        'Back' => [
            'Latissimus Dorsi',
            'Trapezius',
            'Rhomboids',
            'Lower Back / Erector Spinae',
        ],
        'Legs' => [
            'Quadriceps',
            'Hamstrings',
            'Glutes',
            'Calves',
        ],
        'Chest' => [
            'Upper Chest',
            'Middle Chest',
            'Lower Chest',
        ],
        'Shoulders' => [
            'Front Deltoid',
            'Side Deltoid',
            'Rear Deltoid',
        ],
        'Arms' => [
            'Biceps',
            'Triceps',
            'Forearms',
        ],
        'Core' => [
            'Rectus Abdominis',
            'Obliques',
            'Core Stabilizers',
        ],
    ];

    public const LARGE_MUSCLE_GROUPS = ['Back', 'Legs', 'Chest', 'Shoulders'];

    public function ensureMuscleGroupsSeeded(): void
    {
        if (MuscleGroup::count() > 0) {
            return;
        }

        foreach (self::HIERARCHY as $parent => $subs) {
            $isLarge = in_array($parent, self::LARGE_MUSCLE_GROUPS, true);
            foreach ($subs as $subName) {
                $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '_', trim($subName, '/ ')));
                MuscleGroup::firstOrCreate(
                    ['slug' => trim($slug, '_')],
                    [
                        'name' => $subName,
                        'parent_group' => $parent,
                        'is_large_muscle' => $isLarge,
                        'min_recovery_hours' => 48,
                        'high_volume_recovery_hours' => 72,
                    ]
                );
            }
        }
    }

    /**
     * Classify an exercise into primary group, sub-muscle, secondary muscles, and stimulus levels.
     *
     * @return array{
     *   primary_group: string,
     *   primary_sub_muscle: string,
     *   primary_stimulus: string,
     *   secondary_muscles: array<int, array{group: string, sub_muscle: string, role: string, stimulus: string}>
     * }
     */
    public function analyzeExercise(Exercise $ex): array
    {
        $nameLower = strtolower((string) $ex->name);
        $dbMuscle = strtolower(trim((string) ($ex->target_muscle ?? '')));

        // 1. Determine Primary Group & Specific Sub-Muscle
        $primaryGroup = 'Core';
        $primarySub = 'Core Stabilizers';

        if (str_contains($nameLower, 'romanian deadlift') || str_contains($nameLower, 'stiff-legged') || str_contains($nameLower, 'leg curl') || str_contains($dbMuscle, 'paha belakang')) {
            $primaryGroup = 'Legs';
            $primarySub = 'Hamstrings';
        } elseif (str_contains($nameLower, 'glute bridge') || str_contains($nameLower, 'hip thrust') || str_contains($dbMuscle, 'bokong') || str_contains($dbMuscle, 'pinggul')) {
            $primaryGroup = 'Legs';
            $primarySub = 'Glutes';
        } elseif (str_contains($nameLower, 'calf') || str_contains($dbMuscle, 'betis')) {
            $primaryGroup = 'Legs';
            $primarySub = 'Calves';
        } elseif (str_contains($nameLower, 'squat') || str_contains($nameLower, 'lunge') || str_contains($nameLower, 'leg press') || str_contains($nameLower, 'leg extension') || str_contains($dbMuscle, 'paha depan') || str_contains($dbMuscle, 'adduktor') || str_contains($dbMuscle, 'abduktor')) {
            $primaryGroup = 'Legs';
            $primarySub = 'Quadriceps';
        } elseif (str_contains($nameLower, 'deadlift') || str_contains($nameLower, 'superman') || str_contains($nameLower, 'back extension') || str_contains($dbMuscle, 'punggung bawah')) {
            $primaryGroup = 'Back';
            $primarySub = 'Lower Back / Erector Spinae';
        } elseif (str_contains($nameLower, 'shrug') || str_contains($dbMuscle, 'trapezius')) {
            $primaryGroup = 'Back';
            $primarySub = 'Trapezius';
        } elseif (str_contains($nameLower, 'row') || str_contains($dbMuscle, 'punggung tengah') || str_contains($dbMuscle, 'punggung atas')) {
            $primaryGroup = 'Back';
            $primarySub = 'Rhomboids';
        } elseif (str_contains($nameLower, 'pull-up') || str_contains($nameLower, 'pull up') || str_contains($nameLower, 'chin-up') || str_contains($nameLower, 'chin up') || str_contains($nameLower, 'pulldown') || str_contains($dbMuscle, 'lats') || str_contains($dbMuscle, 'punggung')) {
            $primaryGroup = 'Back';
            $primarySub = 'Latissimus Dorsi';
        } elseif (str_contains($nameLower, 'incline') && (str_contains($nameLower, 'press') || str_contains($nameLower, 'fly') || str_contains($nameLower, 'push') || str_contains($dbMuscle, 'dada'))) {
            $primaryGroup = 'Chest';
            $primarySub = 'Upper Chest';
        } elseif (str_contains($nameLower, 'decline') && (str_contains($nameLower, 'press') || str_contains($nameLower, 'fly') || str_contains($nameLower, 'push') || str_contains($dbMuscle, 'dada'))) {
            $primaryGroup = 'Chest';
            $primarySub = 'Lower Chest';
        } elseif (str_contains($dbMuscle, 'dada') || str_contains($nameLower, 'bench press') || str_contains($nameLower, 'push up') || str_contains($nameLower, 'push-up')) {
            $primaryGroup = 'Chest';
            $primarySub = 'Middle Chest';
        } elseif (str_contains($nameLower, 'lateral raise') || str_contains($nameLower, 'upright row')) {
            $primaryGroup = 'Shoulders';
            $primarySub = 'Side Deltoid';
        } elseif (str_contains($nameLower, 'reverse fly') || str_contains($nameLower, 'rear delt') || str_contains($nameLower, 'face pull')) {
            $primaryGroup = 'Shoulders';
            $primarySub = 'Rear Deltoid';
        } elseif (str_contains($dbMuscle, 'bahu') || str_contains($nameLower, 'shoulder press') || str_contains($nameLower, 'pike push') || str_contains($nameLower, 'overhead press')) {
            $primaryGroup = 'Shoulders';
            $primarySub = 'Front Deltoid';
        } elseif (str_contains($dbMuscle, 'trisep') || str_contains($nameLower, 'tricep') || str_contains($nameLower, 'skull crusher') || str_contains($nameLower, 'dip')) {
            $primaryGroup = 'Arms';
            $primarySub = 'Triceps';
        } elseif (str_contains($dbMuscle, 'bisep') || str_contains($nameLower, 'bicep') || str_contains($nameLower, 'curl')) {
            $primaryGroup = 'Arms';
            $primarySub = 'Biceps';
        } elseif (str_contains($dbMuscle, 'lengan bawah') || str_contains($nameLower, 'wrist') || str_contains($nameLower, 'forearm')) {
            $primaryGroup = 'Arms';
            $primarySub = 'Forearms';
        } elseif (str_contains($nameLower, 'russian twist') || str_contains($nameLower, 'side plank') || str_contains($nameLower, 'side bridge') || str_contains($nameLower, 'oblique') || str_contains($nameLower, 'bicycle')) {
            $primaryGroup = 'Core';
            $primarySub = 'Obliques';
        } elseif (str_contains($nameLower, 'plank') || str_contains($nameLower, 'hollow') || str_contains($nameLower, 'dead bug')) {
            $primaryGroup = 'Core';
            $primarySub = 'Core Stabilizers';
        } elseif (str_contains($dbMuscle, 'perut') || str_contains($nameLower, 'crunch') || str_contains($nameLower, 'sit-up') || str_contains($nameLower, 'sit up')) {
            $primaryGroup = 'Core';
            $primarySub = 'Rectus Abdominis';
        } elseif (str_contains($dbMuscle, 'kardio') || str_contains($nameLower, 'burpee') || str_contains($nameLower, 'mountain') || str_contains($nameLower, 'jumping')) {
            $primaryGroup = 'Legs';
            $primarySub = 'Quadriceps';
        }

        // 2. Compound Secondary Muscles & Stimulus Levels
        $secondaries = [];

        if (str_contains($nameLower, 'bench') || str_contains($nameLower, 'push up') || str_contains($nameLower, 'push-up') || str_contains($nameLower, 'chest press') || (str_contains($nameLower, 'dip') && ! str_contains($nameLower, 'tricep'))) {
            $secondaries[] = ['group' => 'Arms', 'sub_muscle' => 'Triceps', 'role' => 'secondary', 'stimulus' => 'high'];
            $secondaries[] = ['group' => 'Shoulders', 'sub_muscle' => 'Front Deltoid', 'role' => 'secondary', 'stimulus' => 'high'];
            $secondaries[] = ['group' => 'Core', 'sub_muscle' => 'Core Stabilizers', 'role' => 'secondary', 'stimulus' => 'low'];
        } elseif (str_contains($nameLower, 'shoulder press') || str_contains($nameLower, 'pike push') || str_contains($nameLower, 'overhead press') || str_contains($nameLower, 'arnold')) {
            $secondaries[] = ['group' => 'Arms', 'sub_muscle' => 'Triceps', 'role' => 'secondary', 'stimulus' => 'high'];
            $secondaries[] = ['group' => 'Shoulders', 'sub_muscle' => 'Side Deltoid', 'role' => 'secondary', 'stimulus' => 'moderate'];
            $secondaries[] = ['group' => 'Core', 'sub_muscle' => 'Core Stabilizers', 'role' => 'secondary', 'stimulus' => 'low'];
        } elseif (str_contains($nameLower, 'pull-up') || str_contains($nameLower, 'pull up') || str_contains($nameLower, 'chin') || str_contains($nameLower, 'row') || str_contains($nameLower, 'pulldown')) {
            $secondaries[] = ['group' => 'Arms', 'sub_muscle' => 'Biceps', 'role' => 'secondary', 'stimulus' => 'high'];
            $secondaries[] = ['group' => 'Shoulders', 'sub_muscle' => 'Rear Deltoid', 'role' => 'secondary', 'stimulus' => 'moderate'];
            $secondaries[] = ['group' => 'Arms', 'sub_muscle' => 'Forearms', 'role' => 'secondary', 'stimulus' => 'moderate'];
        } elseif (str_contains($nameLower, 'romanian deadlift')) {
            $secondaries[] = ['group' => 'Legs', 'sub_muscle' => 'Glutes', 'role' => 'secondary', 'stimulus' => 'high'];
            $secondaries[] = ['group' => 'Back', 'sub_muscle' => 'Lower Back / Erector Spinae', 'role' => 'secondary', 'stimulus' => 'moderate'];
            $secondaries[] = ['group' => 'Arms', 'sub_muscle' => 'Forearms', 'role' => 'secondary', 'stimulus' => 'moderate'];
        } elseif (str_contains($nameLower, 'deadlift')) {
            $secondaries[] = ['group' => 'Legs', 'sub_muscle' => 'Glutes', 'role' => 'secondary', 'stimulus' => 'high'];
            $secondaries[] = ['group' => 'Back', 'sub_muscle' => 'Lower Back / Erector Spinae', 'role' => 'secondary', 'stimulus' => 'high'];
            $secondaries[] = ['group' => 'Arms', 'sub_muscle' => 'Forearms', 'role' => 'secondary', 'stimulus' => 'moderate'];
        } elseif (str_contains($nameLower, 'squat') || str_contains($nameLower, 'lunge') || str_contains($nameLower, 'leg press')) {
            $secondaries[] = ['group' => 'Legs', 'sub_muscle' => 'Glutes', 'role' => 'secondary', 'stimulus' => 'high'];
            $secondaries[] = ['group' => 'Legs', 'sub_muscle' => 'Hamstrings', 'role' => 'secondary', 'stimulus' => 'moderate'];
            $secondaries[] = ['group' => 'Core', 'sub_muscle' => 'Core Stabilizers', 'role' => 'secondary', 'stimulus' => 'low'];
        } elseif (str_contains($nameLower, 'glute bridge') || str_contains($nameLower, 'hip thrust')) {
            $secondaries[] = ['group' => 'Legs', 'sub_muscle' => 'Hamstrings', 'role' => 'secondary', 'stimulus' => 'moderate'];
            $secondaries[] = ['group' => 'Core', 'sub_muscle' => 'Core Stabilizers', 'role' => 'secondary', 'stimulus' => 'low'];
        } elseif (str_contains($nameLower, 'burpee')) {
            $secondaries[] = ['group' => 'Chest', 'sub_muscle' => 'Middle Chest', 'role' => 'secondary', 'stimulus' => 'moderate'];
            $secondaries[] = ['group' => 'Arms', 'sub_muscle' => 'Triceps', 'role' => 'secondary', 'stimulus' => 'moderate'];
            $secondaries[] = ['group' => 'Core', 'sub_muscle' => 'Core Stabilizers', 'role' => 'secondary', 'stimulus' => 'moderate'];
        }

        // Determine primary stimulus intensity
        $isCompound = ! empty($secondaries);
        $primaryStimulus = $isCompound || in_array($primaryGroup, self::LARGE_MUSCLE_GROUPS, true) ? 'high' : 'moderate';
        if ($primarySub === 'Core Stabilizers' || str_contains($nameLower, 'stretch')) {
            $primaryStimulus = 'low';
        }

        return [
            'primary_group' => $primaryGroup,
            'primary_sub_muscle' => $primarySub,
            'primary_stimulus' => $primaryStimulus,
            'secondary_muscles' => $secondaries,
        ];
    }

    /**
     * Evaluate whether scheduling a muscle group/sub-muscle on $plannedDate violates 48h/72h rules
     * given a map of prior stimuli keyed by sub_muscle/group.
     *
     * @param  array<string, array{trained_date: string, stimulus: string, total_sets: int, intensity: string, source_label: string}>  $historyMap
     * @return array{valid: bool, status: string, hours_elapsed: ?int, required_hours: int, reason: string, last_trained_label: ?string}
     */
    public function evaluateMuscleRecovery(
        string $muscleKey,
        string $plannedDate,
        array $historyMap,
        bool $isIncomingHeavy = true
    ): array {
        if (! isset($historyMap[$muscleKey])) {
            return [
                'valid' => true,
                'status' => 'Recovery cukup',
                'hours_elapsed' => null,
                'required_hours' => 48,
                'reason' => 'Belum ada beban latihan berat terbaru pada kelompok otot ini.',
                'last_trained_label' => null,
            ];
        }

        $prev = $historyMap[$muscleKey];
        $prevDate = Carbon::parse($prev['trained_date'], 'Asia/Jakarta')->startOfDay();
        $nextDate = Carbon::parse($plannedDate, 'Asia/Jakarta')->startOfDay();

        $daysDiff = (int) $prevDate->diffInDays($nextDate, false);
        $hoursElapsed = $daysDiff * 24;
        $lastLabel = WorkoutSession::formatIndonesianDate($prevDate);

        // Determine if 72h is required (high volume >= 7 sets OR high intensity heavy session >= 5 sets)
        $isPrevHighDemand = ($prev['total_sets'] >= 7) || ($prev['intensity'] === 'high' && $prev['total_sets'] >= 5);
        $requiredHours = ($isPrevHighDemand && $isIncomingHeavy) ? 72 : 48;

        // Rule: Same large muscle or significant stimulus on consecutive days (< 48h) is strictly REJECTED
        if ($hoursElapsed < 48) {
            return [
                'valid' => false,
                'status' => 'Jadwal bertabrakan',
                'hours_elapsed' => max(0, $hoursElapsed),
                'required_hours' => $requiredHours,
                'reason' => "{$muscleKey} terakhir mendapat {$prev['source_label']} pada {$lastLabel} (jeda baru {$hoursElapsed} jam, minimal 48 jam / 2 hari kalender).",
                'last_trained_label' => $lastLabel,
            ];
        }

        // Rule: High volume/intensity sessions prioritize 72h recovery before next heavy stimulus
        if ($hoursElapsed < $requiredHours) {
            return [
                'valid' => false,
                'status' => 'Perlu pemulihan tambahan',
                'hours_elapsed' => $hoursElapsed,
                'required_hours' => 72,
                'reason' => "{$muscleKey} mendapat stimulus volume/intensitas tinggi pada {$lastLabel}. Jeda {$hoursElapsed} jam belum memenuhi target pemulihan optimal 72 jam.",
                'last_trained_label' => $lastLabel,
            ];
        }

        return [
            'valid' => true,
            'status' => 'Recovery cukup',
            'hours_elapsed' => $hoursElapsed,
            'required_hours' => $requiredHours,
            'reason' => "Jeda {$hoursElapsed} jam sejak {$lastLabel} memenuhi syarat pemulihan ({$requiredHours} jam).",
            'last_trained_label' => $lastLabel,
        ];
    }

    /**
     * Validate a full multi-day schedule array (either generated or edited) in the backend.
     *
     * @param  array<int, array<string, mixed>>  $days
     * @param  array<int, array<string, mixed>>  $priorLogs
     * @return array{valid: bool, conflicts: array<int, array<string, mixed>>, days: array<int, array<string, mixed>>}
     */
    public function validateSchedule(array $days, string $method = 'hypertrophy', array $priorLogs = []): array
    {
        $history = [];

        // Seed history from user's prior active/completed muscle recovery logs before start date
        foreach ($priorLogs as $log) {
            $key = $log['sub_muscle'] ?: $log['muscle_group'];
            $groupKey = $this->functionalGroupKey($log['muscle_group'], $key);
            $entry = [
                'trained_date' => $log['trained_date'],
                'stimulus' => $log['stimulus_level'] ?? 'high',
                'total_sets' => (int) ($log['total_sets'] ?? 3),
                'intensity' => $log['intensity_level'] ?? 'moderate',
                'source_label' => ($log['role'] ?? 'primary') === 'secondary' ? 'stimulus sekunder' : 'latihan utama',
            ];
            if (($entry['stimulus'] === 'high' || ($log['role'] ?? 'primary') === 'primary')) {
                $history[$key] = $entry;
                $history[$groupKey] = $entry;
            }
        }

        $conflicts = [];

        foreach ($days as $idx => &$day) {
            if (($day['day_type'] ?? 'workout') !== 'workout' || empty($day['exercises'])) {
                $day['recovery_status'] = 'Hari istirahat';
                $day['recovery_summary'] = [];

                continue;
            }

            $dateStr = $day['scheduled_date'];
            $dayMuscleLoad = [];

            foreach ($day['exercises'] as $ex) {
                $sets = (int) ($ex['target_sets'] ?? 3);
                $primaryGroup = $ex['primary_group'] ?? $this->inferParentGroup((string) ($ex['primary_muscle'] ?? $ex['target_muscle'] ?? 'Core'));
                $primarySub = $ex['primary_muscle'] ?? ($ex['target_muscle'] ?? $primaryGroup);
                $stimulus = $ex['stimulus_level'] ?? 'high';
                $intensity = $this->inferIntensity($method, $sets);

                // Accumulate specific primary sub-muscle, plus functional chest/upper-back recovery key
                $this->accumulateLoad($dayMuscleLoad, $primarySub, 'primary', $stimulus, $sets, $intensity, 'latihan utama');
                $functionalKey = $this->functionalGroupKey($primaryGroup, $primarySub);
                if ($functionalKey !== $primarySub) {
                    $this->accumulateLoad($dayMuscleLoad, $functionalKey, 'primary', $stimulus, $sets, $intensity, 'latihan utama');
                }

                // Accumulate secondary muscles with significant stimulus
                foreach ((array) ($ex['secondary_muscles'] ?? []) as $sec) {
                    $secStim = $sec['stimulus'] ?? 'low';
                    if ($secStim === 'low') {
                        continue;
                    }
                    $secGroup = $sec['group'] ?? $this->inferParentGroup((string) ($sec['sub_muscle'] ?? ''));
                    $secSub = $sec['sub_muscle'] ?? $secGroup;
                    $secSets = $secStim === 'high' ? $sets : (int) ceil($sets * 0.5);
                    $this->accumulateLoad($dayMuscleLoad, $secSub, 'secondary', $secStim, $secSets, $intensity, "stimulus sekunder ({$primaryGroup})");
                    $secFuncKey = $this->functionalGroupKey($secGroup, $secSub);
                    if ($secFuncKey !== $secSub && $secStim === 'high') {
                        $this->accumulateLoad($dayMuscleLoad, $secFuncKey, 'secondary', $secStim, $secSets, $intensity, "stimulus sekunder ({$primaryGroup})");
                    }
                }
            }

            $dayRecoverySummary = [];
            $dayHasConflict = false;
            $dayNeedsExtraRest = false;

            foreach ($dayMuscleLoad as $mKey => $load) {
                // Only enforce strict 48h/72h on significant stimulus (primary or high secondary)
                $isIncomingHeavy = ($load['role'] === 'primary' || $load['stimulus'] === 'high');
                $eval = $this->evaluateMuscleRecovery($mKey, $dateStr, $history, $isIncomingHeavy);

                if (! $eval['valid'] && $isIncomingHeavy) {
                    if ($eval['status'] === 'Jadwal bertabrakan') {
                        $dayHasConflict = true;
                    } else {
                        $dayNeedsExtraRest = true;
                    }
                    $conflicts[] = [
                        'day_index' => $idx,
                        'day_number' => $day['day_number'] ?? ($idx + 1),
                        'day_name' => $day['day_name'] ?? '',
                        'scheduled_date' => $dateStr,
                        'muscle' => $mKey,
                        'status' => $eval['status'],
                        'hours_elapsed' => $eval['hours_elapsed'],
                        'required_hours' => $eval['required_hours'],
                        'message' => $eval['reason'],
                    ];
                }

                if ($load['role'] === 'primary' || $load['stimulus'] === 'high') {
                    $dayRecoverySummary[$mKey] = [
                        'muscle' => $mKey,
                        'role' => $load['role'],
                        'stimulus' => $load['stimulus'],
                        'total_sets' => $load['total_sets'],
                        'last_trained' => $eval['last_trained_label'] ?? 'Sesi Awal Program',
                        'next_scheduled' => WorkoutSession::formatIndonesianDate($dateStr),
                        'hours_elapsed' => $eval['hours_elapsed'],
                        'required_hours' => $eval['required_hours'],
                        'status' => $eval['status'],
                        'note' => $eval['reason'],
                    ];
                }
            }

            $day['recovery_status'] = $dayHasConflict
                ? 'Jadwal bertabrakan'
                : ($dayNeedsExtraRest ? 'Perlu pemulihan tambahan' : 'Recovery cukup');
            $day['recovery_summary'] = array_values($dayRecoverySummary);

            // Commit day's muscle load into rolling history for subsequent days
            foreach ($dayMuscleLoad as $mKey => $load) {
                if ($load['role'] === 'primary' || $load['stimulus'] === 'high') {
                    $history[$mKey] = [
                        'trained_date' => $dateStr,
                        'stimulus' => $load['stimulus'],
                        'total_sets' => $load['total_sets'],
                        'intensity' => $load['intensity'],
                        'source_label' => $load['source_label'],
                    ];
                }
            }
        }
        unset($day);

        return [
            'valid' => empty($conflicts),
            'conflicts' => $conflicts,
            'days' => $days,
        ];
    }

    /**
     * Load recent muscle recovery logs for an authenticated user around start date.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getUserRecentRecoveryLogs(int $userId, Carbon $beforeDate): array
    {
        $windowStart = $beforeDate->copy()->subDays(4)->toDateString();

        return MuscleRecoveryLog::where('user_id', $userId)
            ->whereDate('trained_date', '>=', $windowStart)
            ->whereDate('trained_date', '<', $beforeDate->toDateString())
            ->orderBy('trained_date')
            ->get()
            ->map(fn (MuscleRecoveryLog $log) => [
                'muscle_group' => $log->muscle_group,
                'sub_muscle' => $log->sub_muscle,
                'role' => $log->role,
                'stimulus_level' => $log->stimulus_level,
                'total_sets' => $log->total_sets,
                'intensity_level' => $log->intensity_level,
                'trained_date' => $log->trained_date->toDateString(),
            ])
            ->all();
    }

    public function inferParentGroup(string $muscleName): string
    {
        $m = strtolower($muscleName);
        if (str_contains($m, 'dada') || str_contains($m, 'chest') || str_contains($m, 'pector')) {
            return 'Chest';
        }
        if (str_contains($m, 'punggung') || str_contains($m, 'lat') || str_contains($m, 'trapez') || str_contains($m, 'rhomboid') || str_contains($m, 'back')) {
            return 'Back';
        }
        if (str_contains($m, 'bahu') || str_contains($m, 'delt') || str_contains($m, 'shoulder')) {
            return 'Shoulders';
        }
        if (str_contains($m, 'bisep') || str_contains($m, 'trisep') || str_contains($m, 'lengan') || str_contains($m, 'bicep') || str_contains($m, 'tricep') || str_contains($m, 'forearm')) {
            return 'Arms';
        }
        if (str_contains($m, 'paha') || str_contains($m, 'bokong') || str_contains($m, 'betis') || str_contains($m, 'pinggul') || str_contains($m, 'quad') || str_contains($m, 'hamstring') || str_contains($m, 'glute') || str_contains($m, 'calf') || str_contains($m, 'kaki') || str_contains($m, 'kardio')) {
            return 'Legs';
        }

        return 'Core';
    }

    private function functionalGroupKey(string $parentGroup, string $subMuscle): string
    {
        return match ($parentGroup) {
            'Chest' => 'Chest',
            'Back' => $subMuscle === 'Lower Back / Erector Spinae' ? 'Lower Back / Erector Spinae' : 'Upper Back',
            'Legs' => $subMuscle,
            default => $subMuscle, // Front/Side/Rear Deltoid, Biceps/Triceps/Forearms, Core sub-muscles stay distinct
        };
    }

    private function inferIntensity(string $method, int $sets): string
    {
        if ($method === 'strength' || $sets >= 5) {
            return 'high';
        }
        if ($method === 'hypertrophy' && $sets >= 4) {
            return 'high';
        }
        if ($method === 'endurance') {
            return 'moderate';
        }

        return 'moderate';
    }

    private function accumulateLoad(array &$map, string $key, string $role, string $stimulus, int $sets, string $intensity, string $sourceLabel): void
    {
        if (! isset($map[$key])) {
            $map[$key] = [
                'role' => $role,
                'stimulus' => $stimulus,
                'total_sets' => $sets,
                'intensity' => $intensity,
                'source_label' => $sourceLabel,
            ];

            return;
        }

        $map[$key]['total_sets'] += $sets;
        if ($role === 'primary') {
            $map[$key]['role'] = 'primary';
            $map[$key]['source_label'] = $sourceLabel;
        }
        if ($stimulus === 'high') {
            $map[$key]['stimulus'] = 'high';
        }
        if ($intensity === 'high') {
            $map[$key]['intensity'] = 'high';
        }
    }
}
