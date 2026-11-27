<?php

namespace App\Livewire\Admin;

use App\Models\Exercise;
use App\Models\FitnessGoal;
use App\Models\FitnessGoalRoutine;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Kelola Tujuan Latihan - Admin PraxisFit')]
#[Layout('layouts.admin')]
class ManageFitnessGoals extends Component
{
    public $goals;

    public bool $isEditing = false;

    public ?int $goalId = null;

    public string $name = '';

    public string $description = '';

    public string $split_type = '';

    // Kelola Rekomendasi Gerakan (FitnessGoalRoutine) untuk tujuan yang dipilih
    public ?int $managingGoalId = null;

    public ?int $routineExerciseId = null;

    public string $routineDay = 'Senin';

    public int $routineSets = 3;

    public string $routineReps = '10-12';

    public string $routineNotes = '';

    public function mount(): void
    {
        $this->loadGoals();
        $firstEx = Exercise::orderBy('name')->first();
        if ($firstEx) {
            $this->routineExerciseId = $firstEx->id;
        }
    }

    public function loadGoals(): void
    {
        $this->goals = FitnessGoal::with(['routines.exercise'])->orderBy('id')->get();
    }

    public function openCreateGoal(): void
    {
        $this->reset(['goalId', 'name', 'description', 'split_type']);
        $this->isEditing = true;
    }

    public function editGoal(int $id): void
    {
        $goal = FitnessGoal::findOrFail($id);
        $this->goalId = $goal->id;
        $this->name = $goal->name;
        $this->description = $goal->description;
        $this->split_type = $goal->split_type;
        $this->isEditing = true;
    }

    public function saveGoal(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'split_type' => 'required|string|max:60',
        ]);

        FitnessGoal::updateOrCreate(
            ['id' => $this->goalId],
            [
                'name' => trim($this->name),
                'description' => trim($this->description),
                'split_type' => trim($this->split_type),
            ]
        );

        session()->flash('success', $this->goalId ? 'Tujuan latihan berhasil diperbarui.' : 'Tujuan latihan baru berhasil ditambahkan.');
        $this->cancelEdit();
        $this->loadGoals();
    }

    public function deleteGoal(int $id): void
    {
        FitnessGoal::where('id', $id)->delete();
        if ($this->managingGoalId === $id) {
            $this->managingGoalId = null;
        }
        $this->loadGoals();
        session()->flash('success', 'Tujuan latihan berhasil dihapus.');
    }

    public function cancelEdit(): void
    {
        $this->isEditing = false;
        $this->reset(['goalId', 'name', 'description', 'split_type']);
    }

    public function openRoutinesModal(int $goalId): void
    {
        $this->managingGoalId = $goalId;
        if (! $this->routineExerciseId) {
            $this->routineExerciseId = Exercise::orderBy('name')->value('id');
        }
    }

    public function closeRoutinesModal(): void
    {
        $this->managingGoalId = null;
    }

    public function addGoalRoutine(): void
    {
        if (! $this->managingGoalId) {
            return;
        }

        $this->validate([
            'routineExerciseId' => 'required|exists:exercises,id',
            'routineDay' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'routineSets' => 'required|integer|min:1|max:20',
            'routineReps' => 'required|string|max:60',
        ]);

        FitnessGoalRoutine::create([
            'fitness_goal_id' => $this->managingGoalId,
            'exercise_id' => $this->routineExerciseId,
            'day_of_week' => $this->routineDay,
            'sets' => $this->routineSets,
            'reps' => trim($this->routineReps),
            'notes' => trim($this->routineNotes) ?: null,
        ]);

        $this->routineNotes = '';
        $this->loadGoals();
        session()->flash('success', 'Rekomendasi gerakan berhasil ditambahkan ke tujuan latihan.');
    }

    public function deleteGoalRoutine(int $routineId): void
    {
        FitnessGoalRoutine::where('id', $routineId)->delete();
        $this->loadGoals();
        session()->flash('success', 'Rekomendasi gerakan dihapus dari tujuan latihan.');
    }

    public function render()
    {
        $managedGoal = $this->managingGoalId
            ? FitnessGoal::with('routines.exercise')->find($this->managingGoalId)
            : null;

        return view('livewire.admin.manage-fitness-goals', [
            'managedGoal' => $managedGoal,
            'allExercises' => Exercise::orderBy('name')->get(['id', 'name', 'target_muscle']),
        ]);
    }
}
