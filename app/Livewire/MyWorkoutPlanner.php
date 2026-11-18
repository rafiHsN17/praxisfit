<?php

namespace App\Livewire;

use App\Models\Exercise;
use App\Models\WorkoutRoutine;
use App\Models\WorkoutSession;
use App\Models\WorkoutSessionItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Workout Planner & Riwayat - PraxisFit')]
class MyWorkoutPlanner extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'tailwind';

    // Tab utama: 'plan' | 'history' | 'routines'
    public string $activeTab = 'plan';

    // Filter daftar sesi (Plan List)
    public string $statusFilter = 'all'; // 'all' | 'unfinished' | 'finished'
    public string $search = '';
    public ?string $selectedDate = null;

    // Kalender Bulan & Tampilan Strip Mingguan
    public int $calendarYear;
    public int $calendarMonth;
    public bool $showWeekStrip = false;

    // Filter Riwayat
    public string $historyRange = '30d'; // 'today' | '7d' | '30d' | 'all'
    public ?int $historyDetailSessionId = null;

    // Modal Buat / Edit Sesi Jadwal
    public bool $showSessionModal = false;
    public ?int $editingSessionId = null;
    public string $sessionName = '';
    public string $sessionCategory = 'Latihan Beban';
    public string $sessionDate = '';
    public string $sessionTime = '07:00';
    public string $sessionNotes = '';
    public array $sessionExercises = [];
    public ?int $addExerciseId = null;
    public int $addExerciseSets = 3;
    public string $addExerciseReps = '10-12';
    public string $pickerSearch = '';

    // Modal Peringatan Ketidaksesuaian Tanggal
    public ?int $mismatchSessionId = null;
    public string $mismatchScheduledFormatted = '';
    public string $mismatchTodayFormatted = '';
    public bool $mismatchIsFuture = false;

    // Modal Pelaksanaan Latihan Aktif (1 Layar Full Gerakan + Timer + Rest)
    public ?int $activeSessionId = null;
    public int $activeExerciseIndex = 0;
    public int $restDurationSeconds = 45;
    public ?int $quickAddExerciseId = null;
    public int $quickAddSets = 3;
    public string $quickAddReps = '10-12';

    // CRUD Rutinitas Mingguan (WorkoutRoutine Legacy / Template)
    public bool $showRoutineModal = false;
    public ?int $routine_id = null;
    public ?int $exercise_id = null;
    public string $day_of_week = 'Senin';
    public int $sets = 3;
    public string $reps = '12-15';
    public string $notes = '';

    public function mount(): void
    {
        if (Exercise::count() === 0) {
            Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\ExerciseSeeder', '--force' => true]);
        }

        $now = Carbon::now('Asia/Jakarta');
        $this->calendarYear = $now->year;
        $this->calendarMonth = $now->month;
        $this->sessionDate = $now->toDateString();

        $defaultExercise = Exercise::orderBy('name')->first();
        if ($defaultExercise) {
            $this->exercise_id = $defaultExercise->id;
            $this->addExerciseId = $defaultExercise->id;
            $this->quickAddExerciseId = $defaultExercise->id;
        }
    }

    public function setActiveTab(string $tab): void
    {
        if (in_array($tab, ['plan', 'history', 'routines'], true)) {
            $this->activeTab = $tab;
            $this->resetPage();
        }
    }

    public function setStatusFilter(string $filter): void
    {
        if (in_array($filter, ['all', 'unfinished', 'finished'], true)) {
            $this->statusFilter = $filter;
            $this->resetPage();
        }
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    // === NAVIGASI KALENDER AKTUAL (ASIA/JAKARTA) ===

    public function previousMonth(): void
    {
        $date = Carbon::createFromDate($this->calendarYear, $this->calendarMonth, 1, 'Asia/Jakarta')->subMonth();
        $this->calendarYear = $date->year;
        $this->calendarMonth = $date->month;
    }

    public function nextMonth(): void
    {
        $date = Carbon::createFromDate($this->calendarYear, $this->calendarMonth, 1, 'Asia/Jakarta')->addMonth();
        $this->calendarYear = $date->year;
        $this->calendarMonth = $date->month;
    }

    public function goToToday(): void
    {
        $today = Carbon::now('Asia/Jakarta');
        $this->calendarYear = $today->year;
        $this->calendarMonth = $today->month;
        $this->selectedDate = $today->toDateString();
        $this->activeTab = 'plan';
        $this->resetPage();
    }

    public function selectCalendarDate(string $dateString): void
    {
        if ($this->selectedDate === $dateString) {
            $this->selectedDate = null;
        } else {
            $this->selectedDate = $dateString;
            $parsed = Carbon::parse($dateString, 'Asia/Jakarta');
            $this->calendarYear = $parsed->year;
            $this->calendarMonth = $parsed->month;
        }
        $this->activeTab = 'plan';
        $this->resetPage();
    }

    public function clearDateFilter(): void
    {
        $this->selectedDate = null;
        $this->resetPage();
    }

    // === CREATE / EDIT / DELETE WORKOUT SESSION ===

    public function openCreateSessionModal(?string $date = null): void
    {
        if (!Auth::check()) {
            session()->flash('error', 'Silakan masuk terlebih dahulu untuk membuat jadwal latihan.');
            return;
        }

        $this->resetSessionModal();
        $this->sessionDate = $date ?: ($this->selectedDate ?: Carbon::now('Asia/Jakarta')->toDateString());
        $this->showSessionModal = true;
    }

    public function editSession(int $sessionId): void
    {
        if (!Auth::check()) {
            return;
        }

        $session = WorkoutSession::with('items.exercise')->where('user_id', Auth::id())->find($sessionId);
        if (!$session) {
            return;
        }

        $this->resetValidation();
        $this->editingSessionId = $session->id;
        $this->sessionName = $session->name;
        $this->sessionCategory = $session->category ?? 'Latihan Beban';
        $this->sessionDate = $session->scheduled_date?->toDateString() ?? Carbon::now('Asia/Jakarta')->toDateString();
        $this->sessionTime = $session->scheduled_time ?? '07:00';
        $this->sessionNotes = $session->notes ?? '';
        $this->sessionExercises = $session->items->map(fn ($item) => [
            'exercise_id' => $item->exercise_id,
            'name' => $item->exercise_name,
            'target_muscle' => $item->target_muscle ?? 'Umum',
            'equipment' => $item->exercise?->equipment ?? 'Bodyweight',
            'difficulty' => $item->exercise?->difficulty ?? 'Menengah',
            'image' => $item->exercise?->image_1 ?? $item->exercise?->icon ?? null,
            'target_sets' => $item->target_sets,
            'target_reps' => $item->target_reps,
        ])->toArray();

        $this->showSessionModal = true;
    }

    public function closeSessionModal(): void
    {
        $this->showSessionModal = false;
        $this->resetSessionModal();
    }

    private function resetSessionModal(): void
    {
        $this->resetValidation();
        $this->editingSessionId = null;
        $this->sessionName = '';
        $this->sessionCategory = 'Latihan Beban';
        $this->sessionDate = $this->selectedDate ?: Carbon::now('Asia/Jakarta')->toDateString();
        $this->sessionTime = '07:00';
        $this->sessionNotes = '';
        $this->sessionExercises = [];
        $this->pickerSearch = '';
        $this->addExerciseSets = 3;
        $this->addExerciseReps = '10-12';
    }

    public function addExerciseToDraft(): void
    {
        if (!$this->addExerciseId) {
            return;
        }

        $exercise = Exercise::find($this->addExerciseId);
        if (!$exercise) {
            return;
        }

        $this->sessionExercises[] = [
            'exercise_id' => $exercise->id,
            'name' => $exercise->name,
            'target_muscle' => $exercise->target_muscle ?? 'Umum',
            'equipment' => $exercise->equipment ?? 'Bodyweight',
            'difficulty' => $exercise->difficulty ?? 'Menengah',
            'image' => $exercise->image_1 ?? $exercise->icon ?? null,
            'target_sets' => max(1, min(30, $this->addExerciseSets)),
            'target_reps' => trim($this->addExerciseReps) !== '' ? trim($this->addExerciseReps) : '10-12',
        ];
    }

    public function removeDraftExercise(int $index): void
    {
        unset($this->sessionExercises[$index]);
        $this->sessionExercises = array_values($this->sessionExercises);
    }

    public function saveSession(): void
    {
        if (!Auth::check()) {
            session()->flash('error', 'Silakan masuk terlebih dahulu untuk menyimpan jadwal.');
            return;
        }

        $this->validate([
            'sessionName' => 'required|string|max:120',
            'sessionCategory' => 'required|string|max:60',
            'sessionDate' => 'required|date',
            'sessionTime' => 'nullable|string|max:20',
            'sessionNotes' => 'nullable|string|max:500',
        ], [
            'sessionName.required' => 'Nama sesi latihan wajib diisi.',
            'sessionDate.required' => 'Tanggal jadwal wajib dipilih.',
        ]);

        $session = $this->editingSessionId
            ? WorkoutSession::where('user_id', Auth::id())->find($this->editingSessionId)
            : new WorkoutSession();

        if ($this->editingSessionId && !$session) {
            return;
        }

        $session->user_id = Auth::id();
        $session->name = trim($this->sessionName);
        $session->category = $this->sessionCategory;
        $session->scheduled_date = $this->sessionDate;
        $session->scheduled_time = $this->sessionTime ?: null;
        $session->notes = trim($this->sessionNotes) !== '' ? trim($this->sessionNotes) : null;

        if (!$this->editingSessionId) {
            $session->status = WorkoutSession::STATUS_UPCOMING;
            $session->progress_percent = 0;
        }

        $session->save();

        // Sinkronisasi daftar gerakan sesi bila belum selesai/diedit
        $session->items()->delete();
        foreach ($this->sessionExercises as $idx => $item) {
            WorkoutSessionItem::create([
                'workout_session_id' => $session->id,
                'exercise_id' => $item['exercise_id'] ?? null,
                'exercise_name' => $item['name'],
                'target_muscle' => $item['target_muscle'] ?? 'Umum',
                'target_sets' => (int) ($item['target_sets'] ?? 3),
                'completed_sets' => 0,
                'target_reps' => $item['target_reps'] ?? '10-12',
                'is_completed' => false,
                'sort_order' => $idx + 1,
            ]);
        }

        $parsedDate = Carbon::parse($this->sessionDate, 'Asia/Jakarta');
        $this->calendarYear = $parsedDate->year;
        $this->calendarMonth = $parsedDate->month;

        session()->flash('success', $this->editingSessionId ? 'Jadwal sesi latihan berhasil diperbarui.' : 'Jadwal sesi latihan berhasil dibuat.');
        $this->closeSessionModal();
    }

    public function deleteSession(int $sessionId): void
    {
        if (!Auth::check()) {
            return;
        }

        WorkoutSession::where('user_id', Auth::id())->where('id', $sessionId)->delete();
        if ($this->activeSessionId === $sessionId) {
            $this->activeSessionId = null;
        }
        session()->flash('success', 'Jadwal latihan berhasil dihapus.');
    }

    public function forceFinishSession(int $sessionId, ?int $elapsedSeconds = null): void
    {
        if (!Auth::check()) {
            return;
        }

        $session = WorkoutSession::with('items')->where('user_id', Auth::id())->find($sessionId);
        if (!$session) {
            return;
        }

        $now = Carbon::now('Asia/Jakarta');
        $startedAt = $session->started_at ?? $now->copy()->subMinutes(20);
        $durationSeconds = ($elapsedSeconds !== null && $elapsedSeconds > 0)
            ? $elapsedSeconds
            : max(60, (int) $startedAt->diffInSeconds($now));

        foreach ($session->items as $item) {
            $item->update([
                'is_completed' => true,
                'completed_sets' => max($item->completed_sets, $item->target_sets),
            ]);
        }

        $session->update([
            'status' => WorkoutSession::STATUS_COMPLETED,
            'actual_date' => $session->actual_date ?? $now->toDateString(),
            'started_at' => $startedAt,
            'completed_at' => $now,
            'duration_seconds' => $durationSeconds,
            'is_off_schedule' => $session->scheduled_date?->toDateString() !== $now->toDateString(),
            'progress_percent' => 100,
        ]);

        if ($this->activeSessionId === $sessionId) {
            $this->activeSessionId = null;
            $this->activeExerciseIndex = 0;
        }

        session()->flash('success', "Sesi \"{$session->name}\" selesai dan tersimpan ke Riwayat Latihan.");
    }

    // === PERINGATAN KETIDAKSESUAIAN TANGGAL & MULAI LATIHAN ===

    public function attemptStartSession(int $sessionId): void
    {
        if (!Auth::check()) {
            session()->flash('error', 'Silakan masuk untuk memulai sesi latihan.');
            return;
        }

        $session = WorkoutSession::with('items')->where('user_id', Auth::id())->find($sessionId);
        if (!$session) {
            return;
        }

        if ($session->status === WorkoutSession::STATUS_IN_PROGRESS) {
            $this->openActiveSession($session->id);
            return;
        }

        $today = Carbon::now('Asia/Jakarta')->startOfDay();
        $scheduled = $session->scheduled_date ? $session->scheduled_date->copy()->startOfDay() : $today->copy();

        if ($scheduled->toDateString() !== $today->toDateString()) {
            $this->mismatchSessionId = $session->id;
            $this->mismatchScheduledFormatted = WorkoutSession::formatIndonesianDate($scheduled);
            $this->mismatchTodayFormatted = WorkoutSession::formatIndonesianDate($today);
            $this->mismatchIsFuture = $scheduled->gt($today);
            return;
        }

        $this->executeStartSession($session, false);
    }

    public function cancelMismatchStart(): void
    {
        $this->mismatchSessionId = null;
        $this->mismatchScheduledFormatted = '';
        $this->mismatchTodayFormatted = '';
        $this->mismatchIsFuture = false;
    }

    public function confirmMismatchStart(): void
    {
        if (!Auth::check() || !$this->mismatchSessionId) {
            $this->cancelMismatchStart();
            return;
        }

        $session = WorkoutSession::with('items')->where('user_id', Auth::id())->find($this->mismatchSessionId);
        $this->cancelMismatchStart();

        if ($session) {
            $this->executeStartSession($session, true);
        }
    }

    private function executeStartSession(WorkoutSession $session, bool $isOffSchedule): void
    {
        $now = Carbon::now('Asia/Jakarta');

        $session->update([
            'status' => WorkoutSession::STATUS_IN_PROGRESS,
            'actual_date' => $now->toDateString(),
            'started_at' => $session->started_at ?? $now,
            'is_off_schedule' => $isOffSchedule,
        ]);

        $this->activeSessionId = $session->id;
        $firstIncompleteIndex = $session->items->values()->search(fn ($item) => !$item->is_completed);
        $this->activeExerciseIndex = $firstIncompleteIndex !== false ? (int) $firstIncompleteIndex : 0;

        session()->flash('success', "Sesi \"{$session->name}\" dimulai. Semangat berlatih!");
    }

    public function openActiveSession(int $sessionId): void
    {
        if (!Auth::check()) {
            return;
        }

        $session = WorkoutSession::with('items')->where('user_id', Auth::id())->find($sessionId);
        if ($session) {
            $this->activeSessionId = $session->id;
            $firstIncompleteIndex = $session->items->values()->search(fn ($item) => !$item->is_completed);
            $this->activeExerciseIndex = $firstIncompleteIndex !== false ? (int) $firstIncompleteIndex : 0;
        }
    }

    public function closeActiveSession(): void
    {
        $this->activeSessionId = null;
    }

    public function goToExerciseStep(int $index): void
    {
        $this->activeExerciseIndex = max(0, $index);
    }

    public function completeItemAndAdvance(int $itemId, int $nextIndex): void
    {
        if (!Auth::check()) {
            return;
        }

        $item = WorkoutSessionItem::with('session')->find($itemId);
        if ($item && $item->session && $item->session->user_id === Auth::id()) {
            $item->update([
                'is_completed' => true,
                'completed_sets' => max($item->completed_sets, $item->target_sets),
            ]);
            $item->session->recalculateProgress();
        }

        $this->activeExerciseIndex = max(0, $nextIndex);
    }

    public function incrementItemSet(int $itemId): void
    {
        if (!Auth::check()) {
            return;
        }

        $item = WorkoutSessionItem::with('session')->find($itemId);
        if (!$item || !$item->session || $item->session->user_id !== Auth::id()) {
            return;
        }

        $nextSets = min(50, $item->completed_sets + 1);
        $isDone = $nextSets >= $item->target_sets;
        $item->update([
            'completed_sets' => $nextSets,
            'is_completed' => $isDone ? true : $item->is_completed,
        ]);
        $item->session->recalculateProgress();
    }

    public function decrementItemSet(int $itemId): void
    {
        if (!Auth::check()) {
            return;
        }

        $item = WorkoutSessionItem::with('session')->find($itemId);
        if (!$item || !$item->session || $item->session->user_id !== Auth::id()) {
            return;
        }

        $nextSets = max(0, $item->completed_sets - 1);
        $item->update([
            'completed_sets' => $nextSets,
        ]);
    }

    public function toggleItemCompleted(int $itemId): void
    {
        if (!Auth::check()) {
            return;
        }

        $item = WorkoutSessionItem::with('session')->find($itemId);
        if (!$item || !$item->session || $item->session->user_id !== Auth::id()) {
            return;
        }

        $nextState = !$item->is_completed;
        $item->update([
            'is_completed' => $nextState,
            'completed_sets' => $nextState ? max($item->completed_sets, $item->target_sets) : $item->completed_sets,
        ]);

        $item->session->recalculateProgress();
    }

    public function updateItemTracking(int $itemId, int $completedSets, ?float $weightKg = null): void
    {
        if (!Auth::check()) {
            return;
        }

        $item = WorkoutSessionItem::with('session')->find($itemId);
        if (!$item || !$item->session || $item->session->user_id !== Auth::id()) {
            return;
        }

        $item->update([
            'completed_sets' => max(0, min(50, $completedSets)),
            'weight_kg' => $weightKg !== null ? max(0, min(1000, $weightKg)) : $item->weight_kg,
        ]);
    }

    public function addItemToActiveSession(): void
    {
        if (!Auth::check() || !$this->activeSessionId || !$this->quickAddExerciseId) {
            return;
        }

        $session = WorkoutSession::where('user_id', Auth::id())->find($this->activeSessionId);
        $exercise = Exercise::find($this->quickAddExerciseId);
        if (!$session || !$exercise) {
            return;
        }

        $nextOrder = ((int) $session->items()->max('sort_order')) + 1;
        WorkoutSessionItem::create([
            'workout_session_id' => $session->id,
            'exercise_id' => $exercise->id,
            'exercise_name' => $exercise->name,
            'target_muscle' => $exercise->target_muscle ?? 'Umum',
            'target_sets' => max(1, $this->quickAddSets),
            'completed_sets' => 0,
            'target_reps' => trim($this->quickAddReps) ?: '10-12',
            'is_completed' => false,
            'sort_order' => $nextOrder,
        ]);

        $session->recalculateProgress();
    }

    public function finishActiveSession(?int $elapsedSeconds = null): void
    {
        if (!Auth::check() || !$this->activeSessionId) {
            return;
        }

        $this->forceFinishSession($this->activeSessionId, $elapsedSeconds);
    }

    // === GENERATE SESI MINGGU INI DARI RUTINITAS MINGGUAN ===

    public function generateFromWeeklyRoutines(): void
    {
        if (!Auth::check()) {
            session()->flash('error', 'Silakan masuk terlebih dahulu.');
            return;
        }

        $routines = WorkoutRoutine::with('exercise')
            ->where('user_id', Auth::id())
            ->get()
            ->groupBy('day_of_week');

        if ($routines->isEmpty()) {
            session()->flash('error', 'Rutinitas mingguan masih kosong. Tambahkan gerakan di tab Rutinitas Mingguan terlebih dahulu.');
            return;
        }

        $dayOffsets = [
            'Senin' => 0,
            'Selasa' => 1,
            'Rabu' => 2,
            'Kamis' => 3,
            'Jumat' => 4,
            'Sabtu' => 5,
            'Minggu' => 6,
        ];

        $weekStart = Carbon::now('Asia/Jakarta')->startOfWeek(Carbon::MONDAY);
        $created = 0;

        foreach ($dayOffsets as $dayName => $offset) {
            if (!isset($routines[$dayName]) || $routines[$dayName]->isEmpty()) {
                continue;
            }

            $targetDate = $weekStart->copy()->addDays($offset)->toDateString();
            $title = "Latihan Rutin {$dayName}";

            $exists = WorkoutSession::where('user_id', Auth::id())
                ->whereDate('scheduled_date', $targetDate)
                ->where('name', $title)
                ->exists();

            if ($exists) {
                continue;
            }

            $session = WorkoutSession::create([
                'user_id' => Auth::id(),
                'name' => $title,
                'category' => 'Latihan Rutin',
                'scheduled_date' => $targetDate,
                'scheduled_time' => '07:00',
                'status' => WorkoutSession::STATUS_UPCOMING,
                'progress_percent' => 0,
                'notes' => "Dibuat otomatis dari template Rutinitas {$dayName}.",
            ]);

            foreach ($routines[$dayName] as $idx => $routine) {
                WorkoutSessionItem::create([
                    'workout_session_id' => $session->id,
                    'exercise_id' => $routine->exercise_id,
                    'exercise_name' => $routine->exercise?->name ?? 'Gerakan',
                    'target_muscle' => $routine->exercise?->target_muscle ?? 'Umum',
                    'target_sets' => $routine->sets,
                    'completed_sets' => 0,
                    'target_reps' => $routine->reps,
                    'notes' => $routine->notes,
                    'sort_order' => $idx + 1,
                ]);
            }

            $created++;
        }

        $this->activeTab = 'plan';
        session()->flash('success', $created > 0 ? "{$created} jadwal sesi latihan berhasil ditambahkan ke kalender minggu ini." : 'Seluruh jadwal minggu ini sudah tersedia di kalender.');
    }

    // === HISTORY DETAIL ===

    public function openHistoryDetail(int $sessionId): void
    {
        if (!Auth::check()) {
            return;
        }
        $session = WorkoutSession::where('user_id', Auth::id())->find($sessionId);
        if ($session) {
            $this->historyDetailSessionId = $session->id;
        }
    }

    public function closeHistoryDetail(): void
    {
        $this->historyDetailSessionId = null;
    }

    // === RUTINITAS MINGGUAN (WORKOUT ROUTINES TEMPLATE CRUD) ===

    public function openRoutineModal(?int $id = null, string $day = 'Senin'): void
    {
        if (!Auth::check()) {
            session()->flash('error', 'Silakan masuk terlebih dahulu untuk mengatur rutinitas.');
            return;
        }

        if ($id) {
            $routine = WorkoutRoutine::where('user_id', Auth::id())->find($id);
            if ($routine) {
                $this->routine_id = $routine->id;
                $this->exercise_id = $routine->exercise_id;
                $this->day_of_week = $routine->day_of_week;
                $this->sets = $routine->sets;
                $this->reps = $routine->reps;
                $this->notes = $routine->notes ?? '';
                $this->showRoutineModal = true;
                return;
            }
        }

        $this->resetRoutineForm($day);
        $this->showRoutineModal = true;
    }

    public function edit(int $id): void
    {
        $this->openRoutineModal($id);
    }

    public function save(): void
    {
        if (!Auth::check()) {
            session()->flash('error', 'Silakan masuk terlebih dahulu.');
            return;
        }

        $this->validate([
            'exercise_id' => 'required|exists:exercises,id',
            'day_of_week' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'sets' => 'required|integer|min:1|max:50',
            'reps' => 'required|string|max:100',
            'notes' => 'nullable|string|max:500',
        ], [
            'exercise_id.required' => 'Silakan pilih gerakan workout dari katalog.',
            'sets.min' => 'Jumlah set minimal adalah 1 sesi.',
        ]);

        if ($this->routine_id) {
            $routine = WorkoutRoutine::where('user_id', Auth::id())->find($this->routine_id);
            if (!$routine) {
                return;
            }
            $routine->update([
                'exercise_id' => $this->exercise_id,
                'day_of_week' => $this->day_of_week,
                'sets' => $this->sets,
                'reps' => $this->reps,
                'notes' => $this->notes,
            ]);
            session()->flash('success', 'Rutinitas latihan berhasil diperbarui!');
        } else {
            WorkoutRoutine::create([
                'user_id' => Auth::id(),
                'exercise_id' => $this->exercise_id,
                'day_of_week' => $this->day_of_week,
                'sets' => $this->sets,
                'reps' => $this->reps,
                'notes' => $this->notes,
            ]);
            session()->flash('success', 'Gerakan berhasil ditambahkan ke rutinitas mingguan!');
        }

        $this->showRoutineModal = false;
        $this->resetRoutineForm($this->day_of_week);
    }

    public function delete(int $id): void
    {
        if (!Auth::check()) {
            return;
        }

        WorkoutRoutine::where('user_id', Auth::id())->where('id', $id)->delete();
        session()->flash('success', 'Rutinitas latihan berhasil dihapus!');
    }

    public function resetForm(string $day = 'Senin'): void
    {
        $this->resetRoutineForm($day);
    }

    public function closeRoutineModal(): void
    {
        $this->showRoutineModal = false;
        $this->resetRoutineForm();
    }

    private function resetRoutineForm(string $day = 'Senin'): void
    {
        $this->reset(['routine_id', 'sets', 'notes']);
        $this->day_of_week = $day;
        $this->sets = 3;
        $this->reps = '12-15';
        $defaultExercise = Exercise::orderBy('name')->first();
        if ($defaultExercise) {
            $this->exercise_id = $defaultExercise->id;
        }
        $this->resetValidation();
    }

    // === RENDER ===

    public function render()
    {
        $userId = Auth::id();
        $today = Carbon::now('Asia/Jakarta');
        $todayStr = $today->toDateString();

        // Data kalender aktual bulan terpilih
        $monthStart = Carbon::createFromDate($this->calendarYear, $this->calendarMonth, 1, 'Asia/Jakarta')->startOfDay();
        $monthEnd = $monthStart->copy()->endOfMonth();
        $gridStart = $monthStart->copy()->startOfWeek(Carbon::MONDAY);
        $gridEnd = $monthEnd->copy()->endOfWeek(Carbon::SUNDAY);

        $bulanIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ][$this->calendarMonth];

        $exercises = Exercise::orderBy('name', 'asc')->get([
            'id',
            'name',
            'target_muscle',
            'category',
            'difficulty',
            'equipment',
            'instructions',
            'image_1',
            'image_2',
            'image_3',
            'icon',
        ]);

        if (!$userId) {
            $emptySessions = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 6);

            return view('livewire.my-workout-planner', [
                'isAuthenticated' => false,
                'sessions' => $emptySessions,
                'upcomingSessions' => collect(),
                'historySessions' => collect(),
                'routines' => collect(),
                'exercises' => $exercises,
                'calendarDays' => $this->buildCalendarGrid($gridStart, $gridEnd, $this->calendarMonth, $todayStr, collect()),
                'weekDays' => $this->buildWeekStrip($today, $todayStr, collect()),
                'monthLabel' => "{$bulanIndo} {$this->calendarYear}",
                'todayStr' => $todayStr,
                'todayLabel' => WorkoutSession::formatIndonesianDate($today),
                'activeSession' => null,
                'historyDetailSession' => null,
                'stats' => ['total' => 0, 'completed' => 0, 'unfinished' => 0],
            ])->layout('components.layouts.app');
        }

        // Semua sesi milik user untuk indikator kalender & statistik
        $monthSessions = WorkoutSession::where('user_id', $userId)
            ->whereBetween('scheduled_date', [$gridStart->toDateString(), $gridEnd->toDateString()])
            ->get()
            ->groupBy(fn ($s) => $s->scheduled_date?->toDateString());

        // Plan List query
        $planQuery = WorkoutSession::with('items')
            ->where('user_id', $userId);

        if ($this->selectedDate) {
            $planQuery->whereDate('scheduled_date', $this->selectedDate);
        }

        if ($this->statusFilter === 'unfinished') {
            $planQuery->where('status', '!=', WorkoutSession::STATUS_COMPLETED);
        } elseif ($this->statusFilter === 'finished') {
            $planQuery->where('status', WorkoutSession::STATUS_COMPLETED);
        }

        if (trim($this->search) !== '') {
            $term = '%' . trim($this->search) . '%';
            $planQuery->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                  ->orWhere('category', 'like', $term)
                  ->orWhere('notes', 'like', $term);
            });
        }

        $sessions = $planQuery
            ->orderByRaw("CASE WHEN status = 'in_progress' THEN 0 WHEN scheduled_date >= ? THEN 1 ELSE 2 END", [$todayStr])
            ->orderBy('scheduled_date', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(6);

        // Upcoming next plans (Right column)
        $upcomingSessions = WorkoutSession::withCount('items')
            ->where('user_id', $userId)
            ->where('status', '!=', WorkoutSession::STATUS_COMPLETED)
            ->whereDate('scheduled_date', '>=', $todayStr)
            ->orderBy('scheduled_date', 'asc')
            ->take(5)
            ->get();

        // History query
        $historyQuery = WorkoutSession::with('items')
            ->where('user_id', $userId)
            ->where(function ($q) use ($todayStr) {
                $q->whereIn('status', [WorkoutSession::STATUS_COMPLETED, WorkoutSession::STATUS_MISSED])
                  ->orWhereNotNull('actual_date')
                  ->orWhereDate('scheduled_date', '<', $todayStr);
            });

        if ($this->historyRange === 'today') {
            $historyQuery->where(function ($q) use ($todayStr) {
                $q->whereDate('actual_date', $todayStr)
                  ->orWhereDate('scheduled_date', $todayStr);
            });
        } elseif ($this->historyRange === '7d') {
            $start7 = $today->copy()->subDays(6)->toDateString();
            $historyQuery->where(function ($q) use ($start7) {
                $q->whereDate('actual_date', '>=', $start7)
                  ->orWhereDate('scheduled_date', '>=', $start7);
            });
        } elseif ($this->historyRange === '30d') {
            $start30 = $today->copy()->subDays(29)->toDateString();
            $historyQuery->where(function ($q) use ($start30) {
                $q->whereDate('actual_date', '>=', $start30)
                  ->orWhereDate('scheduled_date', '>=', $start30);
            });
        }

        $historySessions = $historyQuery
            ->orderByDesc('actual_date')
            ->orderByDesc('scheduled_date')
            ->orderByDesc('id')
            ->get();

        $routines = WorkoutRoutine::with('exercise')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        $activeSession = $this->activeSessionId
            ? WorkoutSession::with('items.exercise')->where('user_id', $userId)->find($this->activeSessionId)
            : null;

        $historyDetailSession = $this->historyDetailSessionId
            ? WorkoutSession::with('items')->where('user_id', $userId)->find($this->historyDetailSessionId)
            : null;

        $allUserSessionsCount = WorkoutSession::where('user_id', $userId)->count();
        $completedUserSessionsCount = WorkoutSession::where('user_id', $userId)->where('status', WorkoutSession::STATUS_COMPLETED)->count();

        return view('livewire.my-workout-planner', [
            'isAuthenticated' => true,
            'sessions' => $sessions,
            'upcomingSessions' => $upcomingSessions,
            'historySessions' => $historySessions,
            'routines' => $routines,
            'exercises' => $exercises,
            'calendarDays' => $this->buildCalendarGrid($gridStart, $gridEnd, $this->calendarMonth, $todayStr, $monthSessions),
            'weekDays' => $this->buildWeekStrip($today, $todayStr, $monthSessions),
            'monthLabel' => "{$bulanIndo} {$this->calendarYear}",
            'todayStr' => $todayStr,
            'todayLabel' => WorkoutSession::formatIndonesianDate($today),
            'activeSession' => $activeSession,
            'historyDetailSession' => $historyDetailSession,
            'stats' => [
                'total' => $allUserSessionsCount,
                'completed' => $completedUserSessionsCount,
                'unfinished' => max(0, $allUserSessionsCount - $completedUserSessionsCount),
            ],
        ])->layout('components.layouts.app');
    }

    private function buildCalendarGrid(Carbon $start, Carbon $end, int $activeMonth, string $todayStr, $sessionsByDate): array
    {
        $days = [];
        $cursor = $start->copy();

        while ($cursor->lte($end)) {
            $dateStr = $cursor->toDateString();
            $daySessions = $sessionsByDate->get($dateStr, collect());
            $days[] = [
                'date' => $dateStr,
                'day' => $cursor->day,
                'isCurrentMonth' => $cursor->month === $activeMonth,
                'isToday' => $dateStr === $todayStr,
                'hasSessions' => $daySessions->isNotEmpty(),
                'hasActiveOrUpcoming' => $daySessions->contains(fn ($s) => $s->status !== WorkoutSession::STATUS_COMPLETED),
                'count' => $daySessions->count(),
            ];
            $cursor->addDay();
        }

        return $days;
    }

    private function buildWeekStrip(Carbon $today, string $todayStr, $sessionsByDate): array
    {
        $weekStart = $today->copy()->startOfWeek(Carbon::MONDAY);
        $days = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $weekStart->copy()->addDays($i);
            $dateStr = $date->toDateString();
            $days[] = [
                'date' => $dateStr,
                'short' => WorkoutSession::shortIndonesianDay($date),
                'day' => $date->day,
                'isToday' => $dateStr === $todayStr,
                'count' => $sessionsByDate->get($dateStr, collect())->count(),
            ];
        }

        return $days;
    }
}
