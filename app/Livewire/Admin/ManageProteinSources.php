<?php

namespace App\Livewire\Admin;

use App\Models\ProteinSource;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Title('Kelola Sumber Nutrisi - Admin PraxisFit')]
class ManageProteinSources extends Component
{
    public $sources;

    public $name = '';

    public $protein_per_100g = '';

    public $calories_per_100g = '';

    public $fat_per_100g = '';

    public $carbs_per_100g = '';

    public $editId = null;

    public $isModalOpen = false;

    public function mount()
    {
        $this->loadSources();
    }

    public function loadSources()
    {
        $this->sources = ProteinSource::orderBy('name')->get();
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
        $this->name = '';
        $this->protein_per_100g = '';
        $this->calories_per_100g = '';
        $this->fat_per_100g = '';
        $this->carbs_per_100g = '';
        $this->editId = null;
        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:protein_sources,name,'.$this->editId,
            'protein_per_100g' => 'required|numeric|min:0|max:100',
            'calories_per_100g' => 'nullable|numeric|min:0|max:1000',
            'fat_per_100g' => 'nullable|numeric|min:0|max:100',
            'carbs_per_100g' => 'nullable|numeric|min:0|max:100',
        ], [
            'name.required' => 'Nama makanan wajib diisi.',
            'name.unique' => 'Nama makanan sudah ada di database.',
            'protein_per_100g.required' => 'Kandungan protein wajib diisi.',
        ]);

        $wasEdit = (bool) $this->editId;

        ProteinSource::updateOrCreate(
            ['id' => $this->editId],
            [
                'name' => trim($this->name),
                'protein_per_100g' => (float) $this->protein_per_100g,
                'calories_per_100g' => $this->calories_per_100g !== '' ? (float) $this->calories_per_100g : 0,
                'fat_per_100g' => $this->fat_per_100g !== '' ? (float) $this->fat_per_100g : 0,
                'carbs_per_100g' => $this->carbs_per_100g !== '' ? (float) $this->carbs_per_100g : 0,
            ]
        );

        $this->closeModal();
        $this->loadSources();

        session()->flash('success', $wasEdit ? 'Data sumber nutrisi berhasil diperbarui.' : 'Sumber nutrisi baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $source = ProteinSource::findOrFail($id);
        $this->editId = $source->id;
        $this->name = $source->name;
        $this->protein_per_100g = $source->protein_per_100g;
        $this->calories_per_100g = $source->calories_per_100g;
        $this->fat_per_100g = $source->fat_per_100g;
        $this->carbs_per_100g = $source->carbs_per_100g;
        $this->isModalOpen = true;
    }

    public function delete($id)
    {
        ProteinSource::findOrFail($id)->delete();
        $this->loadSources();
        session()->flash('success', 'Sumber nutrisi berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.manage-protein-sources');
    }
}
