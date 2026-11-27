<?php

namespace App\Livewire\Admin;

use App\Models\Exercise;
use App\Models\WorkoutProgram;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('Kelola Gerakan - Admin PraxisFit')]
class ManageExercises extends Component
{
    use WithFileUploads, WithPagination;

    protected string $paginationTheme = 'tailwind';

    public string $search = '';

    public string $filterEquipment = '';

    public $editId = null;

    public $name;

    public $target_muscle;

    public $equipment = 'Bodyweight';

    public $category = 'Kekuatan & Hipertrofi';

    public $difficulty = 'Pemula';

    public $instructions;

    public $alternative_equipment = '';

    public array $recommended_methods = [];

    public $image_1_file;

    public $image_2_file;

    public $image_3_file;

    public $image_1_preview;

    public $image_2_preview;

    public $image_3_preview;

    public $isModalOpen = false;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterEquipment(): void
    {
        $this->resetPage();
    }

    public function toggleRecommendedMethod(string $methodKey): void
    {
        if (in_array($methodKey, $this->recommended_methods, true)) {
            $this->recommended_methods = array_values(array_diff($this->recommended_methods, [$methodKey]));
        } else {
            $this->recommended_methods[] = $methodKey;
        }
    }

    public function openModal(): void
    {
        $this->resetForm();
        $this->isModalOpen = true;
    }

    public function closeModal(): void
    {
        $this->isModalOpen = false;
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->editId = null;
        $this->name = '';
        $this->target_muscle = '';
        $this->equipment = 'Bodyweight';
        $this->category = 'Kekuatan & Hipertrofi';
        $this->difficulty = 'Pemula';
        $this->instructions = '';
        $this->alternative_equipment = '';
        $this->recommended_methods = [];

        $this->image_1_file = null;
        $this->image_2_file = null;
        $this->image_3_file = null;

        $this->image_1_preview = null;
        $this->image_2_preview = null;
        $this->image_3_preview = null;

        $this->resetErrorBag();
    }

    public function save(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'target_muscle' => 'required|string|max:100',
            'equipment' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:100',
            'difficulty' => 'required|in:Pemula,Menengah,Lanjut',
            'instructions' => 'required|string',
            'alternative_equipment' => 'nullable|string|max:500',
            'recommended_methods' => 'nullable|array',
            'image_1_file' => 'nullable|image|max:2048',
            'image_2_file' => 'nullable|image|max:2048',
            'image_3_file' => 'nullable|image|max:2048',
        ]);

        try {
            $data = [
                'name' => $this->name,
                'target_muscle' => $this->target_muscle,
                'equipment' => trim((string) $this->equipment) !== '' ? trim((string) $this->equipment) : 'Bodyweight',
                'category' => trim((string) $this->category) !== '' ? trim((string) $this->category) : 'Kekuatan & Hipertrofi',
                'difficulty' => $this->difficulty,
                'instructions' => $this->instructions,
                'alternative_equipment' => trim((string) $this->alternative_equipment) !== '' ? trim((string) $this->alternative_equipment) : null,
                'recommended_methods' => ! empty($this->recommended_methods) ? array_values($this->recommended_methods) : null,
                'is_custom' => true,
            ];

            if ($this->image_1_file) {
                $path = $this->image_1_file->store('exercises', 'public');
                $data['image_1'] = '/storage/'.$path;
                $data['icon'] = $data['image_1'];
            }
            if ($this->image_2_file) {
                $path = $this->image_2_file->store('exercises', 'public');
                $data['image_2'] = '/storage/'.$path;
            }
            if ($this->image_3_file) {
                $path = $this->image_3_file->store('exercises', 'public');
                $data['image_3'] = '/storage/'.$path;
            }

            Exercise::updateOrCreate(
                ['id' => $this->editId],
                $data
            );

            session()->flash('success', $this->editId ? 'Data gerakan dan rekomendasi berhasil diperbarui.' : 'Gerakan baru berhasil ditambahkan.');
            $this->closeModal();
        } catch (\Exception $e) {
            Log::error('Error saving custom exercise: '.$e->getMessage());
            session()->flash('error', 'Gagal menyimpan data gerakan. Silakan coba lagi.');
        }
    }

    public function edit(int $id): void
    {
        $exercise = Exercise::findOrFail($id);

        $this->editId = $exercise->id;
        $this->name = $exercise->name;
        $this->target_muscle = $exercise->target_muscle;
        $this->equipment = $exercise->equipment ?: 'Bodyweight';
        $this->category = $exercise->category ?: 'Kekuatan & Hipertrofi';
        $this->difficulty = $exercise->difficulty ?: 'Pemula';
        $this->instructions = $exercise->instructions;
        $this->alternative_equipment = $exercise->alternative_equipment ?? '';
        $this->recommended_methods = ! empty($exercise->recommended_methods) && is_array($exercise->recommended_methods)
            ? $exercise->recommended_methods
            : collect($exercise->suitableMethods())->pluck('key')->all();

        $this->image_1_preview = $exercise->image_1;
        $this->image_2_preview = $exercise->image_2;
        $this->image_3_preview = $exercise->image_3;

        $this->isModalOpen = true;
    }

    public function delete(int $id): void
    {
        $exercise = Exercise::findOrFail($id);

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
        session()->flash('success', 'Gerakan berhasil dihapus.');
    }

    public function render()
    {
        $exercises = Exercise::query()
            ->when(trim($this->search) !== '', function ($q) {
                $term = '%'.trim($this->search).'%';
                $q->where(function ($sub) use ($term) {
                    $sub->where('name', 'like', $term)
                        ->orWhere('target_muscle', 'like', $term)
                        ->orWhere('equipment', 'like', $term);
                });
            })
            ->when($this->filterEquipment !== '', fn ($q) => $q->where('equipment', $this->filterEquipment))
            ->orderBy('id', 'desc')
            ->paginate(20);

        $equipments = Exercise::select('equipment')
            ->whereNotNull('equipment')
            ->where('equipment', '!=', '')
            ->distinct()
            ->orderBy('equipment')
            ->pluck('equipment');

        return view('livewire.admin.manage-exercises', [
            'exercises' => $exercises,
            'equipments' => $equipments,
            'methodOptions' => WorkoutProgram::methodLabels(),
        ]);
    }
}
