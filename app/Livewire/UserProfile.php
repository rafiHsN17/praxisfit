<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\FitnessGoal;
use App\Models\WorkoutRoutine;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;

#[Title('Profil & Tujuan Latihan - PraxisFit')]
class UserProfile extends Component
{
    public $weight;
    public $height;
    public $gender;
    public $fitness_goal_id;

    public function mount()
    {
        $user = Auth::user();
        $this->weight = $user->weight;
        $this->height = $user->height;
        $this->gender = $user->gender;
        $this->fitness_goal_id = $user->fitness_goal_id;
    }

    public function saveProfile()
    {
        $this->validate([
            'weight' => 'nullable|numeric|min:30|max:200',
            'height' => 'nullable|numeric|min:100|max:250',
            'gender' => 'nullable|in:M,F',
            'fitness_goal_id' => 'nullable|exists:fitness_goals,id',
        ]);

        $user = Auth::user();
        
        // Cek jika tujuan latihan berubah, maka jadwalkan ulang rutinitasnya
        $goalChanged = $user->fitness_goal_id != $this->fitness_goal_id;

        $user->update([
            'weight' => $this->weight,
            'height' => $this->height,
            'gender' => $this->gender,
            'fitness_goal_id' => $this->fitness_goal_id,
        ]);

        if ($goalChanged && $this->fitness_goal_id) {
            $this->applyRoutineFromGoal($this->fitness_goal_id, $user->id);
            session()->flash('success', 'Profil dan Jadwal Latihan baru berhasil diterapkan!');
        } else {
            session()->flash('success', 'Profil berhasil diperbarui!');
        }
    }

    private function applyRoutineFromGoal($goalId, $userId)
    {
        // Hapus rutinitas lama
        WorkoutRoutine::where('user_id', $userId)->delete();

        // Ambil rutinitas rekomendasi
        $goal = FitnessGoal::with('routines')->find($goalId);
        
        if ($goal) {
            foreach ($goal->routines as $routine) {
                WorkoutRoutine::create([
                    'user_id' => $userId,
                    'exercise_id' => $routine->exercise_id,
                    'day_of_week' => $routine->day_of_week,
                    'sets' => $routine->sets,
                    'reps' => $routine->reps,
                    'notes' => $routine->notes,
                ]);
            }
        }
    }

    public function render()
    {
        return view('livewire.user-profile', [
            'fitnessGoals' => FitnessGoal::all()
        ])->layout('components.layouts.app');
    }
}
