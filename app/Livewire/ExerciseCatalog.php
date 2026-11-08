<?php

namespace App\Livewire;

use App\Models\Exercise;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Katalog Gerakan - PraxisFit')]
class ExerciseCatalog extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterMuscle = '';
    public $selectedExercise = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterMuscle()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->filterMuscle = '';
        $this->selectedExercise = null;
        $this->resetPage();
    }

    public function openExerciseDetail($id)
    {
        $this->selectedExercise = Exercise::find($id);
    }

    public function closeExerciseDetail()
    {
        $this->selectedExercise = null;
    }

    public function render()
    {
        $exercises = Exercise::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('instructions', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterMuscle !== '', function ($query) {
                $query->where('target_muscle', $this->filterMuscle);
            })
            ->orderBy('name', 'asc')
            ->paginate(12);

        $muscleTargets = Exercise::select('target_muscle')
            ->whereNotNull('target_muscle')
            ->distinct()
            ->orderBy('target_muscle', 'asc')
            ->pluck('target_muscle');

        return view('livewire.exercise-catalog', [
            'exercises' => $exercises,
            'muscleTargets' => $muscleTargets,
        ])->layout('components.layouts.app');
    }
}
