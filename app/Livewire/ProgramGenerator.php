<?php

namespace App\Livewire;

use App\Models\Exercise;
use App\Models\WorkoutProgram;
use App\Models\WorkoutProgramDay;
use App\Services\MuscleRecoveryService;
use App\Services\WorkoutProgramGenerator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Buat Program Latihan - PraxisFit')]
class ProgramGenerator extends Component
{
    // Form Inputs (Section 4)
    public string $programName = '';

    public string $trainingMethod = WorkoutProgram::METHOD_HYPERTROPHY;

    public string $equipmentMode = 'bodyweight';

    public array $selectedEquipments = [];

    public string $level = 'beginner';

    public array $targetMuscles = ['Full Body'];

    public int $frequencyPerWeek = 3;

    public int $sessionDurationMinutes = 45;

    public string $programDuration = '1_month';

    public string $startDate = '';

    public string $excludedKeywords = '';

    public string $avoidSearch = '';

    public array $excludedExerciseIds = [];

    public string $fatigueStatus = 'normal';

    public string $extraNotes = '';

    // Preview & Editor State
    public ?array $previewData = null;

    public ?array $generationError = null;

    public int $selectedDayIndex = 0;

    public int $selectedWeekFilter = 1;

    // Ganti Gerakan Modal
    public ?int $replaceDayIndex = null;

    public ?int $replaceExerciseIndex = null;

    public array $substituteOptions = [];

    // Active Program Conflict Confirmation
    public bool $showActiveConflictModal = false;

    public ?string $existingActiveProgramName = null;

    public function mount(): void
    {
        if (Exercise::count() === 0) {
            Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\ExerciseSeeder', '--force' => true]);
        }

        $this->startDate = Carbon::now('Asia/Jakarta')->toDateString();
    }

    public function updatedEquipmentMode(string $value): void
    {
        if ($value === 'bodyweight') {
            $this->selectedEquipments = [];
        }
    }

    public function toggleEquipment(string $equipment): void
    {
        if (in_array($equipment, $this->selectedEquipments, true)) {
            $this->selectedEquipments = array_values(array_diff($this->selectedEquipments, [$equipment]));
        } else {
            $this->selectedEquipments[] = $equipment;
        }
    }

    public function toggleTargetMuscle(string $muscleKey): void
    {
        if ($muscleKey === 'Full Body') {
            $this->targetMuscles = ['Full Body'];

            return;
        }

        $current = array_values(array_diff($this->targetMuscles, ['Full Body']));
        if (in_array($muscleKey, $current, true)) {
            $current = array_values(array_diff($current, [$muscleKey]));
        } else {
            $current[] = $muscleKey;
        }

        $this->targetMuscles = empty($current) ? ['Full Body'] : $current;
    }

    public function toggleExcludedExercise(int $exerciseId): void
    {
        if (in_array($exerciseId, $this->excludedExerciseIds, true)) {
            $this->excludedExerciseIds = array_values(array_diff($this->excludedExerciseIds, [$exerciseId]));
        } else {
            $this->excludedExerciseIds[] = $exerciseId;
        }
    }

    public function generateProgram(WorkoutProgramGenerator $generator): void
    {
        $this->generationError = null;

        $rules = [
            'trainingMethod' => 'required|in:hypertrophy,strength,endurance,conditioning',
            'equipmentMode' => 'required|in:bodyweight,with_equipment',
            'level' => 'required|in:beginner,intermediate,advanced',
            'targetMuscles' => 'required|array|min:1',
            'frequencyPerWeek' => 'required|integer|min:2|max:6',
            'sessionDurationMinutes' => 'required|in:20,30,45,60,90',
            'programDuration' => 'required|in:1_week,1_month',
            'startDate' => 'required|date',
        ];

        if ($this->equipmentMode === 'with_equipment') {
            $rules['selectedEquipments'] = 'required|array|min:1';
        }

        $this->validate($rules, [
            'selectedEquipments.required' => 'Pilih minimal satu peralatan yang tersedia atau ganti ke mode Tanpa Alat.',
            'targetMuscles.required' => 'Pilih minimal satu target kelompok otot.',
            'startDate.required' => 'Tanggal mulai program wajib diisi.',
        ]);

        $userAge = Auth::check() ? Auth::user()->age : null;

        $result = $generator->generatePreview([
            'program_name' => $this->programName,
            'training_method' => $this->trainingMethod,
            'equipment_mode' => $this->equipmentMode,
            'selected_equipments' => $this->selectedEquipments,
            'level' => $this->level,
            'target_muscles' => $this->targetMuscles,
            'frequency_per_week' => $this->frequencyPerWeek,
            'session_duration_minutes' => $this->sessionDurationMinutes,
            'program_duration' => $this->programDuration,
            'start_date' => $this->startDate,
            'excluded_keywords' => $this->excludedKeywords,
            'excluded_exercise_ids' => $this->excludedExerciseIds,
            'fatigue_status' => $this->fatigueStatus,
            'extra_notes' => $this->extraNotes,
        ], $userAge, Auth::id());

        if (! $result['ok']) {
            $this->previewData = null;
            $this->generationError = $result;

            return;
        }

        $this->previewData = $result;
        $this->selectedWeekFilter = 1;
        $this->selectedDayIndex = 0;

        // Focus first workout day if Day 1 is rest
        foreach ($result['days'] as $idx => $day) {
            if ($day['day_type'] === WorkoutProgramDay::TYPE_WORKOUT) {
                $this->selectedDayIndex = $idx;
                break;
            }
        }
    }

    public function selectWeekFilter(int $week): void
    {
        $this->selectedWeekFilter = max(1, min(4, $week));
        if ($this->previewData && ! empty($this->previewData['days'])) {
            foreach ($this->previewData['days'] as $idx => $day) {
                if ((int) $day['week_number'] === $this->selectedWeekFilter) {
                    $this->selectedDayIndex = $idx;
                    break;
                }
            }
        }
    }

    public function selectPreviewDay(int $dayIndex): void
    {
        if ($this->previewData && isset($this->previewData['days'][$dayIndex])) {
            $this->selectedDayIndex = $dayIndex;
            $this->selectedWeekFilter = (int) $this->previewData['days'][$dayIndex]['week_number'];
        }
    }

    public function openSubstituteModal(int $dayIndex, int $exerciseIndex, WorkoutProgramGenerator $generator): void
    {
        if (! $this->previewData || ! isset($this->previewData['days'][$dayIndex]['exercises'][$exerciseIndex])) {
            return;
        }

        $current = $this->previewData['days'][$dayIndex]['exercises'][$exerciseIndex];
        $excluded = trim($this->excludedKeywords) !== ''
            ? array_values(array_filter(array_map(fn ($v) => strtolower(trim($v)), explode(',', $this->excludedKeywords))))
            : [];

        $options = $generator->getSubstituteOptions(
            (int) $current['exercise_id'],
            (string) ($current['target_muscle'] ?? ''),
            $this->equipmentMode,
            $this->selectedEquipments,
            $this->level,
            $this->trainingMethod,
            $excluded
        );

        $this->replaceDayIndex = $dayIndex;
        $this->replaceExerciseIndex = $exerciseIndex;
        $this->substituteOptions = $options->map(fn (Exercise $ex) => [
            'id' => $ex->id,
            'name' => $ex->name,
            'target_muscle' => $ex->target_muscle ?? 'Umum',
            'equipment' => $ex->equipment ?? 'Bodyweight',
            'difficulty' => $ex->difficulty ?? 'Menengah',
            'image' => $ex->image_1 ?? $ex->icon,
            'instructions' => $ex->instructions,
        ])->all();
    }

    public function closeSubstituteModal(): void
    {
        $this->replaceDayIndex = null;
        $this->replaceExerciseIndex = null;
        $this->substituteOptions = [];
    }

    public function applySubstitute(int $newExerciseId, MuscleRecoveryService $recoveryService): void
    {
        if (
            $this->previewData === null
            || $this->replaceDayIndex === null
            || $this->replaceExerciseIndex === null
            || ! isset($this->previewData['days'][$this->replaceDayIndex]['exercises'][$this->replaceExerciseIndex])
        ) {
            $this->closeSubstituteModal();

            return;
        }

        $newEx = Exercise::find($newExerciseId);
        if (! $newEx) {
            $this->closeSubstituteModal();

            return;
        }

        $analysis = $recoveryService->analyzeExercise($newEx);
        $existing = $this->previewData['days'][$this->replaceDayIndex]['exercises'][$this->replaceExerciseIndex];
        $this->previewData['days'][$this->replaceDayIndex]['exercises'][$this->replaceExerciseIndex] = array_merge($existing, [
            'exercise_id' => $newEx->id,
            'name' => $newEx->name,
            'target_muscle' => $newEx->target_muscle ?? $existing['target_muscle'],
            'primary_group' => $analysis['primary_group'],
            'primary_muscle' => $analysis['primary_sub_muscle'],
            'secondary_muscles' => $analysis['secondary_muscles'],
            'stimulus_level' => $analysis['primary_stimulus'],
            'equipment' => $newEx->equipment ?? 'Bodyweight',
            'difficulty' => $newEx->difficulty ?? 'Menengah',
            'instructions' => $newEx->instructions,
            'image' => $newEx->image_1 ?? $newEx->icon,
            'alternative_equipment' => $newEx->alternative_equipment,
        ]);

        // Re-validate recovery status across the whole program after substitution
        $startDate = Carbon::parse($this->previewData['program']['start_date'], 'Asia/Jakarta')->startOfDay();
        $priorLogs = Auth::check() ? $recoveryService->getUserRecentRecoveryLogs(Auth::id(), $startDate) : [];
        $recheck = $recoveryService->validateSchedule(
            $this->previewData['days'],
            $this->previewData['program']['training_method'] ?? 'hypertrophy',
            $priorLogs
        );
        $this->previewData['days'] = $recheck['days'];
        $this->previewData['program']['recovery_valid'] = $recheck['valid'];

        $this->closeSubstituteModal();
    }

    public function editProgramSettings(): void
    {
        $this->previewData = null;
        $this->generationError = null;
    }

    public function cancelPreview(): void
    {
        $this->previewData = null;
        $this->generationError = null;
        $this->selectedDayIndex = 0;
        $this->selectedWeekFilter = 1;
    }

    public function attemptSaveProgram(WorkoutProgramGenerator $generator)
    {
        if (! Auth::check()) {
            session()->flash('error', 'Silakan masuk ke akun terlebih dahulu untuk menyimpan program ke Rutinku.');

            return redirect()->route('login');
        }

        if (! $this->previewData) {
            return null;
        }

        $existingActive = WorkoutProgram::where('user_id', Auth::id())
            ->where('status', WorkoutProgram::STATUS_ACTIVE)
            ->first();

        if ($existingActive) {
            $this->existingActiveProgramName = $existingActive->name;
            $this->showActiveConflictModal = true;

            return null;
        }

        return $this->persistProgram($generator);
    }

    public function cancelActiveConflictModal(): void
    {
        $this->showActiveConflictModal = false;
        $this->existingActiveProgramName = null;
    }

    public function confirmSaveProgram(WorkoutProgramGenerator $generator)
    {
        if (! Auth::check() || ! $this->previewData) {
            $this->cancelActiveConflictModal();

            return null;
        }

        $this->showActiveConflictModal = false;

        return $this->persistProgram($generator);
    }

    private function persistProgram(WorkoutProgramGenerator $generator)
    {
        try {
            $program = $generator->saveProgramToRutinku(Auth::id(), $this->previewData, true);
        } catch (\InvalidArgumentException $e) {
            session()->flash('error', 'Konflik pemulihan otot terdeteksi: '.$e->getMessage());

            return null;
        }

        session()->flash('success', "Program \"{$program->name}\" berhasil disimpan dan dijadwalkan ke Rutinku!");

        return redirect()->route('workout.planner');
    }

    public function render()
    {
        $avoidSearchResults = collect();
        if (trim($this->avoidSearch) !== '') {
            $term = '%'.trim($this->avoidSearch).'%';
            $avoidSearchResults = Exercise::query()
                ->where(function ($q) use ($term) {
                    $q->where('name', 'like', $term)
                        ->orWhere('target_muscle', 'like', $term);
                })
                ->orderBy('name')
                ->limit(12)
                ->get(['id', 'name', 'target_muscle', 'equipment', 'image_1', 'icon']);
        }

        $excludedExercisesList = ! empty($this->excludedExerciseIds)
            ? Exercise::whereIn('id', $this->excludedExerciseIds)->orderBy('name')->get(['id', 'name', 'target_muscle'])
            : collect();

        return view('livewire.program-generator', [
            'methodLabels' => WorkoutProgram::methodLabels(),
            'levelLabels' => WorkoutProgram::levelLabels(),
            'equipmentOptions' => WorkoutProgramGenerator::EQUIPMENT_OPTIONS,
            'targetMuscleOptions' => WorkoutProgramGenerator::TARGET_MUSCLE_OPTIONS,
            'avoidSearchResults' => $avoidSearchResults,
            'excludedExercisesList' => $excludedExercisesList,
        ])->layout('components.layouts.app');
    }
}
