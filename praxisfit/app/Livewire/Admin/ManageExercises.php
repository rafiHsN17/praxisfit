<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Exercise;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class ManageExercises extends Component
{
    use WithFileUploads;

    public $exercises;

    public $editId = null;
    public $name;
    public $target_muscle;
    public $equipment;
    public $difficulty = 'Pemula';
    public $instructions;
    
    // File uploads
    public $image_1_file;
    public $image_2_file;
    public $image_3_file;

    // Existing previews
    public $image_1_preview;
    public $image_2_preview;
    public $image_3_preview;

    public $isModalOpen = false;

    public function mount()
    {
        $this->loadExercises();
    }

    public function loadExercises()
    {
        // Load all exercises ordered by newest
        $this->exercises = Exercise::orderBy('id', 'desc')->get();
    }

    public function openModal()
    {
        $this->resetForm();
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editId = null;
        $this->name = '';
        $this->target_muscle = '';
        $this->equipment = 'Bodyweight';
        $this->difficulty = 'Pemula';
        $this->instructions = '';
        
        $this->image_1_file = null;
        $this->image_2_file = null;
        $this->image_3_file = null;

        $this->image_1_preview = null;
        $this->image_2_preview = null;
        $this->image_3_preview = null;

        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'target_muscle' => 'required|string|max:100',
            'equipment' => 'nullable|string|max:100',
            'difficulty' => 'required|in:Pemula,Menengah,Lanjut',
            'instructions' => 'required|string',
            'image_1_file' => 'nullable|image|max:2048', // max 2MB
            'image_2_file' => 'nullable|image|max:2048',
            'image_3_file' => 'nullable|image|max:2048',
        ]);

        try {
            $data = [
                'name' => $this->name,
                'target_muscle' => $this->target_muscle,
                'equipment' => $this->equipment ?? 'Bodyweight',
                'difficulty' => $this->difficulty,
                'instructions' => $this->instructions,
                'is_custom' => true,
            ];

            // Handle file uploads
            if ($this->image_1_file) {
                $path = $this->image_1_file->store('exercises', 'public');
                $data['image_1'] = '/storage/' . $path;
                // update icon as fallback to image 1 if not set
                $data['icon'] = $data['image_1'];
            }
            if ($this->image_2_file) {
                $path = $this->image_2_file->store('exercises', 'public');
                $data['image_2'] = '/storage/' . $path;
            }
            if ($this->image_3_file) {
                $path = $this->image_3_file->store('exercises', 'public');
                $data['image_3'] = '/storage/' . $path;
            }

            Exercise::updateOrCreate(
                ['id' => $this->editId],
                $data
            );

            session()->flash('success', $this->editId ? 'Data gerakan berhasil diperbarui.' : 'Gerakan baru berhasil ditambahkan.');
            
            $this->closeModal();
            $this->loadExercises();

        } catch (\Exception $e) {
            Log::error('Error saving custom exercise: ' . $e->getMessage());
            session()->flash('error', 'Gagal menyimpan data gerakan. Silakan coba lagi.');
        }
    }

    public function edit($id)
    {
        $exercise = Exercise::findOrFail($id);
        
        $this->editId = $exercise->id;
        $this->name = $exercise->name;
        $this->target_muscle = $exercise->target_muscle;
        $this->equipment = $exercise->equipment;
        $this->difficulty = $exercise->difficulty;
        $this->instructions = $exercise->instructions;
        
        $this->image_1_preview = $exercise->image_1;
        $this->image_2_preview = $exercise->image_2;
        $this->image_3_preview = $exercise->image_3;
        
        $this->isModalOpen = true;
    }

    public function delete($id)
    {
        $exercise = Exercise::findOrFail($id);
        
        // Optional: Hapus file gambar fisik dari storage jika perlu
        if ($exercise->image_1 && str_starts_with($exercise->image_1, '/storage/exercises/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $exercise->image_1));
        }
        if ($exercise->image_2 && str_starts_with($exercise->image_2, '/storage/exercises/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $exercise->image_2));
        }
        if ($exercise->image_3 && str_starts_with($exercise->image_3, '/storage/exercises/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $exercise->image_3));
        }

        $exercise->delete();
        
        $this->loadExercises();
        session()->flash('success', 'Gerakan berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.manage-exercises');
    }
}
