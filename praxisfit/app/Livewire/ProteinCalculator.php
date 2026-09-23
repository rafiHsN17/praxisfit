<?php

namespace App\Livewire;

use App\Models\ProteinLog;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Carbon\Carbon;

#[Title('Kalkulator Protein - PraxisFit')]
class ProteinCalculator extends Component
{
    // Form Input Properties (Bound via wire:model)
    public string $tanggal = '';
    public string $sumber_makanan = 'Dada Ayam Fillet / Boneless';
    public float $berat = 100;
    public float $targetProtein = 150.0; // Can default to user's saved profile target

    // public array $foodDatabase = [...]; // Di hapus, diganti ambil dari DB di DB!

    public $foodSources = []; // Untuk dropdown

    public function mount()
    {
        $this->tanggal = Carbon::today()->format('Y-m-d');
        
        if (auth()->check() && isset(auth()->user()->protein_target)) {
            $this->targetProtein = (float) auth()->user()->protein_target;
        }

        // Ambil data dari database
        $this->foodSources = \App\Models\ProteinSource::orderBy('name')->get();
        
        // Set default dropdown if available
        if ($this->foodSources->isNotEmpty() && empty($this->sumber_makanan)) {
            $this->sumber_makanan = $this->foodSources->first()->name;
        }
    }

    #[Computed]
    public function calculatedProtein(): float
    {
        if (empty($this->sumber_makanan) || $this->berat <= 0) {
            return 0.0;
        }

        // Cari nilai protein berdasarkan pilihan dropdown
        $source = $this->foodSources->where('name', $this->sumber_makanan)->first();
        if (!$source) return 0.0;

        $proteinPer100g = $source->protein_per_100g;
        return round(($this->berat / 100) * $proteinPer100g, 1);
    }

    /**
     * Fetch all logs for the selected date using Eloquent directly.
     * Zero REST APIs or fetch() calls!
     */
    #[Computed]
    public function dailyLogs()
    {
        return ProteinLog::where('tanggal', $this->tanggal)
            ->when(auth()->check(), fn($q) => $q->where('user_id', auth()->id()))
            ->latest()
            ->get();
    }

    /**
     * Calculate total protein achieved for the selected date.
     */
    #[Computed]
    public function totalAchieved(): float
    {
        return (float) $this->dailyLogs()->sum('jumlah_protein');
    }

    /**
     * Save the protein log directly via Eloquent.
     */
    public function saveLog()
    {
        $this->validate([
            'tanggal' => 'required|date',
            'sumber_makanan' => 'required|string',
            'berat' => 'required|numeric|min:1',
        ], [
            'berat.min' => 'Berat makanan minimal 1 gram.',
        ]);

        ProteinLog::create([
            'user_id' => auth()->id() ?? 1, // Fallback to ID 1 if testing without auth
            'sumber_makanan' => $this->sumber_makanan,
            'jumlah_protein' => $this->calculatedProtein(),
            'tanggal' => $this->tanggal,
        ]);

        session()->flash('success', '✅ Berhasil menambahkan ' . $this->calculatedProtein() . 'g protein ke catatan harian Anda!');
        
        // Reset weight input after logging while keeping selected date and food
        $this->berat = 100;
        
        // Bust computed cache in Livewire 3 so table refreshes automatically
        unset($this->dailyLogs);
        unset($this->totalAchieved);
    }

    /**
     * Delete log directly via Eloquent.
     */
    public function deleteLog(int $id)
    {
        $log = ProteinLog::where('id', $id)
            ->when(auth()->check(), fn($q) => $q->where('user_id', auth()->id()))
            ->first();

        if ($log) {
            $log->delete();
            session()->flash('info', '🗑️ Catatan berhasil dihapus.');
            unset($this->dailyLogs);
            unset($this->totalAchieved);
        }
    }

    public function render()
    {
        return view('livewire.protein-calculator')
            ->layout('components.layouts.app');
    }
}
