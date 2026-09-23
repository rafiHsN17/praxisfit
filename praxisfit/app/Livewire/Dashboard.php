<?php

namespace App\Livewire;

use App\Models\ProteinLog;
use Livewire\Component;
use Livewire\Attributes\Title;
use Carbon\Carbon;

#[Title('Home - PraxisFit Command Center')]
class Dashboard extends Component
{
    public float $totalProteinToday = 0;
    public float $targetProtein = 150;
    public int $totalExercises = 0;
    public int $totalRoutines = 0;

    public function mount()
    {
        $today = Carbon::today()->toDateString();
        
        $this->totalExercises = \App\Models\Exercise::count();
        $this->totalRoutines = \App\Models\WorkoutRoutine::count();
        
        if (auth()->check()) {
            $this->targetProtein = (float) (auth()->user()->protein_target ?? 150);
            $this->totalProteinToday = (float) \App\Models\ProteinLog::where('user_id', auth()->id())
                ->where('tanggal', $today)
                ->sum('jumlah_protein');
        } else {
            $this->totalProteinToday = (float) \App\Models\ProteinLog::where('tanggal', $today)->sum('jumlah_protein');
        }
    }

    public function render()
    {
        return view('livewire.dashboard')
            ->layout('components.layouts.app');
    }
}
