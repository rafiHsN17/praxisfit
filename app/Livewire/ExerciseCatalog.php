<?php

namespace App\Livewire;

use App\Models\Exercise;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Katalog Gerakan - PraxisFit')]
class ExerciseCatalog extends Component
{
    use WithPagination;

    public string $search = '';

    public string $filterMuscle = '';

    public string $filterEquipment = '';

    public string $filterDifficulty = '';

    public string $filterCategory = '';

    public $selectedExercise = null;

    public const STANDARD_EQUIPMENTS = [
        'Bodyweight',
        'Dumbbell',
        'Barbell',
        'Machine',
        'Cable',
        'Resistance Band',
        'Kettlebell',
        'Alat Bantu Lainnya',
    ];

    public const DIFFICULTY_OPTIONS = [
        'Pemula' => 'Beginner (Pemula)',
        'Menengah' => 'Intermediate (Menengah)',
        'Lanjut' => 'Advanced (Lanjut)',
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterMuscle(): void
    {
        $this->resetPage();
    }

    public function updatingFilterEquipment(): void
    {
        $this->resetPage();
    }

    public function updatingFilterDifficulty(): void
    {
        $this->resetPage();
    }

    public function updatingFilterCategory(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'filterMuscle', 'filterEquipment', 'filterDifficulty', 'filterCategory']);
        $this->selectedExercise = null;
        $this->resetPage();
    }

    public function openExerciseDetail(int $id): void
    {
        $this->selectedExercise = Exercise::find($id);
    }

    public function closeExerciseDetail(): void
    {
        $this->selectedExercise = null;
    }

    public function render()
    {
        $query = Exercise::query()
            ->when(trim($this->search) !== '', function ($q) {
                $term = '%'.trim($this->search).'%';
                $q->where(function ($sub) use ($term) {
                    $sub->where('name', 'like', $term)
                        ->orWhere('target_muscle', 'like', $term)
                        ->orWhere('equipment', 'like', $term)
                        ->orWhere('instructions', 'like', $term);
                });
            })
            ->when($this->filterMuscle !== '', fn ($q) => $q->where('target_muscle', $this->filterMuscle))
            ->when($this->filterEquipment !== '', function ($q) {
                $q->where('equipment', $this->filterEquipment);
            })
            ->when($this->filterDifficulty !== '', function ($q) {
                $aliases = match (strtolower($this->filterDifficulty)) {
                    'pemula', 'beginner' => ['Pemula', 'pemula', 'Beginner', 'beginner'],
                    'menengah', 'intermediate' => ['Menengah', 'menengah', 'Intermediate', 'intermediate'],
                    'lanjut', 'advanced' => ['Lanjut', 'lanjut', 'Advanced', 'advanced'],
                    default => [$this->filterDifficulty],
                };
                $q->whereIn('difficulty', $aliases);
            })
            ->when($this->filterCategory !== '', fn ($q) => $q->where('category', $this->filterCategory));

        $exercises = $query->orderBy('name', 'asc')->paginate(12);

        $muscleTargets = Exercise::select('target_muscle')
            ->whereNotNull('target_muscle')
            ->where('target_muscle', '!=', '')
            ->distinct()
            ->orderBy('target_muscle', 'asc')
            ->pluck('target_muscle');

        $dbEquipments = Exercise::select('equipment')
            ->whereNotNull('equipment')
            ->where('equipment', '!=', '')
            ->distinct()
            ->pluck('equipment')
            ->all();

        $equipments = collect(array_merge(self::STANDARD_EQUIPMENTS, $dbEquipments))
            ->unique()
            ->values();

        $categories = Exercise::select('category')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category', 'asc')
            ->pluck('category');

        $hasActiveFilters = trim($this->search) !== ''
            || $this->filterMuscle !== ''
            || $this->filterEquipment !== ''
            || $this->filterDifficulty !== ''
            || $this->filterCategory !== '';

        return view('livewire.exercise-catalog', [
            'exercises' => $exercises,
            'muscleTargets' => $muscleTargets,
            'equipments' => $equipments,
            'categories' => $categories,
            'hasActiveFilters' => $hasActiveFilters,
        ])->layout('components.layouts.app');
    }
}
