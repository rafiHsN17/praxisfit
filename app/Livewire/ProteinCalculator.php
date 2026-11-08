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

    public $editingLogId = null; // Store ID when editing

    public $foodSources = []; // Untuk dropdown

    // User Physical Data Confirmation
    public $user_weight;
    public $user_height;
    public $user_gender = 'M';
    public $is_confirmed = false;

    public function mount()
    {
        $this->tanggal = Carbon::today()->format('Y-m-d');
        
        if (auth()->check()) {
            $user = auth()->user();
            if (isset($user->protein_target)) {
                $this->targetProtein = (float) $user->protein_target;
            }
            if ($user->weight && $user->height && $user->gender) {
                $this->user_weight = $user->weight;
                $this->user_height = $user->height;
                $this->user_gender = $user->gender;
                $this->is_confirmed = true;
            }
        }

        // Ambil data dari database
        $this->foodSources = \App\Models\ProteinSource::orderBy('name')->get();
        
        // Set default dropdown if available
        if ($this->foodSources->isNotEmpty() && empty($this->sumber_makanan)) {
            $this->sumber_makanan = $this->foodSources->first()->name;
        }
    }

    public function confirmPhysicalData()
    {
        $this->validate([
            'user_weight' => 'required|numeric|min:30',
            'user_height' => 'required|numeric|min:100',
            'user_gender' => 'required|in:M,F',
        ], [
            'user_weight.required' => 'Berat badan wajib diisi',
            'user_height.required' => 'Tinggi badan wajib diisi',
            'user_gender.required' => 'Jenis kelamin wajib diisi',
        ]);

        // Perhitungan berat badan ideal & penyesuaian gizi (Standar Gizi Klinik / AKG Kemenkes RI)
        // Pria: 50.0 kg + 0.9 kg per cm di atas 152.4 cm
        // Wanita: 45.5 kg + 0.9 kg per cm di atas 152.4 cm
        $baseWeight = $this->user_gender === 'M' ? 50.0 : 45.5;
        $heightOverBase = max(0, $this->user_height - 152.4);
        $ibw = $baseWeight + (0.9 * $heightOverBase);

        $weightToUse = $this->user_weight;
        // Jika berat aktual > 120% BBI, gunakan berat badan penyesuaian (Adjusted Body Weight)
        if ($this->user_weight > 1.2 * $ibw) {
            $weightToUse = $ibw + 0.4 * ($this->user_weight - $ibw);
        }

        // 1.6g per kg berat badan untuk individu aktif olahraga beban (Rekomendasi Praktisi Gizi & Olahraga Indonesia)
        $this->targetProtein = round($weightToUse * 1.6, 1);
        $this->is_confirmed = true;

        if (auth()->check()) {
            $user = auth()->user();
            $user->weight = $this->user_weight;
            $user->height = $this->user_height;
            $user->gender = $this->user_gender;
            $user->protein_target = $this->targetProtein;
            $user->save();
        }

        session()->flash('success_confirm', 'Target protein harian diperbarui ke ' . $this->targetProtein . 'g berdasarkan data fisik.');
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

        if ($this->editingLogId) {
            $log = ProteinLog::where('id', $this->editingLogId)
                ->when(auth()->check(), fn($q) => $q->where('user_id', auth()->id()))
                ->first();
                
            if ($log) {
                $log->update([
                    'sumber_makanan' => $this->sumber_makanan,
                    'jumlah_protein' => $this->calculatedProtein(),
                    'tanggal' => $this->tanggal,
                    'user_weight' => $this->user_weight,
                    'user_height' => $this->user_height,
                ]);
                session()->flash('success', '✅ Berhasil mengubah catatan protein harian Anda!');
            }
            
            $this->cancelEdit();
        } else {
            ProteinLog::create([
                'user_id' => auth()->id() ?? 1, // Fallback to ID 1 if testing without auth
                'sumber_makanan' => $this->sumber_makanan,
                'jumlah_protein' => $this->calculatedProtein(),
                'tanggal' => $this->tanggal,
                'user_weight' => $this->user_weight,
                'user_height' => $this->user_height,
            ]);

            session()->flash('success', '✅ Berhasil menambahkan ' . $this->calculatedProtein() . 'g protein ke catatan harian Anda!');
            
            // Reset weight input after logging while keeping selected date and food
            $this->berat = 100;
        }
        
        // Bust computed cache in Livewire 3 so table refreshes automatically
        unset($this->dailyLogs);
        unset($this->totalAchieved);
    }

    /**
     * Start editing a log.
     */
    public function editLog(int $id)
    {
        $log = ProteinLog::where('id', $id)
            ->when(auth()->check(), fn($q) => $q->where('user_id', auth()->id()))
            ->first();

        if ($log) {
            $this->editingLogId = $log->id;
            $this->tanggal = $log->tanggal;
            $this->sumber_makanan = $log->sumber_makanan;
            
            // Calculate reverse weight
            $source = $this->foodSources->where('name', $log->sumber_makanan)->first();
            if ($source && $source->protein_per_100g > 0) {
                $this->berat = round(($log->jumlah_protein / $source->protein_per_100g) * 100, 1);
            } else {
                $this->berat = 100;
            }
            
            // Re-verify if needed or just scroll up in UI
        }
    }

    /**
     * Cancel editing.
     */
    public function cancelEdit()
    {
        $this->editingLogId = null;
        $this->berat = 100;
        // Keep date and food source as they were
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
