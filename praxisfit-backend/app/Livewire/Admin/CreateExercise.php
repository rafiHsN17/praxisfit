<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Exercise;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class CreateExercise extends Component
{
    public function mount()
    {
        if (auth()->user()->name !== 'admin-praxisfit-1') {
            abort(403, 'Unauthorized action.');
        }
    }

    public $name;
    public $target_muscle;
    public $equipment;
    public $difficulty = 'Pemula';
    public $instructions;
    public $youtube_url;

    protected $rules = [
        'name' => 'required|string|max:255',
        'target_muscle' => 'required|string|max:100',
        'equipment' => 'nullable|string|max:100',
        'difficulty' => 'required|in:Pemula,Menengah,Lanjut',
        'instructions' => 'required|string',
        'youtube_url' => 'nullable|url',
    ];

    public function save()
    {
        $this->validate();

        try {
            Exercise::create([
                'name' => $this->name,
                'target_muscle' => $this->target_muscle,
                'equipment' => $this->equipment ?? 'Bodyweight',
                'difficulty' => $this->difficulty,
                'instructions' => $this->instructions,
                'youtube_url' => $this->youtube_url,
                'is_custom' => true,
            ]);

            session()->flash('message', 'Gerakan baru berhasil ditambahkan!');
            $this->reset(['name', 'target_muscle', 'equipment', 'difficulty', 'instructions', 'youtube_url']);
        } catch (\Exception $e) {
            Log::error('Error saving custom exercise: ' . $e->getMessage());
            session()->flash('error', 'Gagal menambahkan gerakan baru. Silakan coba lagi.');
        }
    }

    public function render()
    {
        return view('livewire.admin.create-exercise');
    }
}
