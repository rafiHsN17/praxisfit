<?php

namespace App\Livewire;

use App\Models\WorkoutRoutine;
use App\Models\Exercise;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Jadwal Latihan - PraxisFit')]
class MyWorkoutPlanner extends Component
{
    // Properti Form CRUD
    public ?int $routine_id = null;
    public ?int $exercise_id = null;
    public string $day_of_week = 'Senin';
    public int $sets = 3;
    public string $reps = '12-15';
    public string $notes = '';

    public function mount()
    {
        // [AUTO-SEED FAILSAFE]: Jika katalog gerakan kosong, otomatis lakukan seeding terlebih dahulu
        if (Exercise::count() === 0) {
            Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\ExerciseSeeder', '--force' => true]);
        }

        if (!$this->exercise_id) {
            $defaultExercise = Exercise::first();
            if ($defaultExercise) {
                $this->exercise_id = $defaultExercise->id;
            }
        }
    }

    public function edit(int $id)
    {
        $routine = WorkoutRoutine::find($id);
        if ($routine) {
            $this->routine_id = $routine->id;
            $this->exercise_id = $routine->exercise_id;
            $this->day_of_week = $routine->day_of_week;
            $this->sets = $routine->sets;
            $this->reps = $routine->reps;
            $this->notes = $routine->notes ?? '';
            
            $this->dispatch('open-modal-form');
        }
    }

    public function save()
    {
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

        $userId = auth()->id();
        if (!$userId) {
            $athlete = User::firstOrCreate(
                ['email' => 'athlete@praxisfit.id'],
                ['name' => 'PraxisFit Athlete', 'password' => bcrypt('password')]
            );
            $userId = $athlete->id;
        }

        WorkoutRoutine::updateOrCreate(
            ['id' => $this->routine_id],
            [
                'user_id' => $userId,
                'exercise_id' => $this->exercise_id,
                'day_of_week' => $this->day_of_week,
                'sets' => $this->sets,
                'reps' => $this->reps,
                'notes' => $this->notes,
            ]
        );

        session()->flash('message', $this->routine_id ? 'Jadwal latihan berhasil diperbarui!' : 'Jadwal berhasil ditambahkan!');

        $this->resetForm();
        $this->dispatch('close-modal-form');
    }

    public function delete(int $id)
    {
        WorkoutRoutine::where('id', $id)->delete();
        session()->flash('message', 'Jadwal latihan berhasil dihapus!');
    }

    public function resetForm()
    {
        $this->reset(['routine_id', 'sets', 'notes']);
        $this->day_of_week = 'Senin';
        $this->reps = '12-15';
        $defaultExercise = Exercise::first();
        if ($defaultExercise) {
            $this->exercise_id = $defaultExercise->id;
        }
    }

    public function render()
    {
        $userId = auth()->id() ?? User::where('email', 'athlete@praxisfit.id')->first()?->id ?? 1;

        $routines = WorkoutRoutine::with('exercise')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        $exercises = Exercise::orderBy('name', 'asc')->get();

        return view('livewire.my-workout-planner', [
            'routines' => $routines,
            'exercises' => $exercises,
        ])->layout('components.layouts.app');
    }
}
