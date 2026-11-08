<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\FitnessGoal;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Kelola Tujuan Latihan - Admin PraxisFit')]
#[Layout('components.layouts.admin')]
class ManageFitnessGoals extends Component
{
    public $goals;
    public $isEditing = false;
    
    public $goalId;
    public $name;
    public $description;
    public $split_type;

    public function mount()
    {
        $this->loadGoals();
    }

    public function loadGoals()
    {
        $this->goals = FitnessGoal::all();
    }

    public function editGoal($id)
    {
        $goal = FitnessGoal::findOrFail($id);
        $this->goalId = $goal->id;
        $this->name = $goal->name;
        $this->description = $goal->description;
        $this->split_type = $goal->split_type;
        $this->isEditing = true;
    }

    public function saveGoal()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'split_type' => 'required|string|max:50',
        ]);

        $goal = FitnessGoal::find($this->goalId);
        if ($goal) {
            $goal->update([
                'name' => $this->name,
                'description' => $this->description,
                'split_type' => $this->split_type,
            ]);
            session()->flash('success', 'Tujuan latihan berhasil diperbarui.');
        }

        $this->isEditing = false;
        $this->loadGoals();
    }

    public function cancelEdit()
    {
        $this->isEditing = false;
        $this->reset(['goalId', 'name', 'description', 'split_type']);
    }

    public function render()
    {
        return view('livewire.admin.manage-fitness-goals');
    }
}
