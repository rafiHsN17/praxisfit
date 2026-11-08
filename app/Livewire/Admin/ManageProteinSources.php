<?php

namespace App\Livewire\Admin;

use App\Models\ProteinSource;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.admin')]
#[Title('Kelola Kalkulator Protein')]
class ManageProteinSources extends Component
{
    public $sources;

    public $name = '';
    public $protein_per_100g = '';
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
        $this->editId = null;
        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:protein_sources,name,' . $this->editId,
            'protein_per_100g' => 'required|numeric|min:0',
        ], [
            'name.required' => 'Nama makanan wajib diisi.',
            'name.unique' => 'Nama makanan sudah ada di database.',
            'protein_per_100g.required' => 'Kandungan protein wajib diisi.',
        ]);

        ProteinSource::updateOrCreate(
            ['id' => $this->editId],
            [
                'name' => $this->name,
                'protein_per_100g' => $this->protein_per_100g,
            ]
        );

        $this->closeModal();
        $this->loadSources();

        session()->flash('success', $this->editId ? 'Data sumber protein berhasil diperbarui.' : 'Sumber protein baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $source = ProteinSource::findOrFail($id);
        $this->editId = $source->id;
        $this->name = $source->name;
        $this->protein_per_100g = $source->protein_per_100g;
        $this->isModalOpen = true;
    }

    public function delete($id)
    {
        ProteinSource::findOrFail($id)->delete();
        $this->loadSources();
        session()->flash('success', 'Sumber protein berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.manage-protein-sources');
    }
}
