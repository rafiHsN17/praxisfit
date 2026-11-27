<?php

namespace App\Livewire;

use App\Models\ProteinLog;
use App\Models\ProteinSource;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Kalkulator Nutrisi - PraxisFit')]
class ProteinCalculator extends Component
{
    // Form Log Konsumsi Aktual
    public string $tanggal = '';

    public string $waktu_makan = 'Makan Siang';

    public string $sumber_makanan = 'Dada Ayam Fillet / Boneless';

    public float $berat = 100;

    public bool $isCustomFood = false;

    public string $custom_food_name = '';

    public float $custom_protein = 0;

    public float $custom_kalori = 0;

    public float $custom_lemak = 0;

    public float $custom_karbo = 0;

    // Target Harian (Estimasi Kalkulator)
    public float $targetProtein = 150.0;

    public float $targetCalories = 2100.0;

    public float $targetFat = 58.0;

    public float $targetCarbs = 244.0;

    public ?float $bmrValue = null;

    public ?float $tdeeValue = null;

    // Data Biometrik Kalkulator Mifflin-St Jeor
    public $user_weight;

    public $user_height;

    public $user_age = 24;

    public string $user_gender = 'M';

    public string $activity_level = 'moderate';

    public string $fitness_goal = 'maintenance';

    public bool $is_confirmed = false;

    public bool $showCalculatorModal = false;

    // State Edit, Grafik & Filter Riwayat
    public $editingLogId = null;

    public string $chartNutrient = 'protein'; // protein | kalori | lemak | karbohidrat

    public int $chartRange = 7; // 7 | 30

    public string $chartType = 'line'; // line | bar

    public string $historyRange = '30'; // today | 7 | 30 | all | custom

    public string $historyFromDate = '';

    public string $historyToDate = '';

    public $foodSources = [];

    public const ACTIVITY_FACTORS = [
        'sedentary' => ['label' => 'Sedentari (Kerja meja, minim olahraga)', 'factor' => 1.2],
        'light' => ['label' => 'Aktivitas Ringan (Olahraga 1–3 hari/minggu)', 'factor' => 1.375],
        'moderate' => ['label' => 'Aktivitas Sedang (Olahraga 3–5 hari/minggu)', 'factor' => 1.55],
        'active' => ['label' => 'Aktif (Latihan intensif 6–7 hari/minggu)', 'factor' => 1.725],
        'very_active' => ['label' => 'Sangat Aktif (Atlet / Pekerjaan fisik berat)', 'factor' => 1.9],
    ];

    public const GOAL_LABELS = [
        'cutting' => 'Cutting (Defisit Kalori / Turun Lemak)',
        'maintenance' => 'Maintenance (Jaga Berat & Performa)',
        'bulking' => 'Bulking (Surplus Terukur / Tambah Massa Otot)',
    ];

    public function mount(): void
    {
        $now = Carbon::now('Asia/Jakarta');
        $today = $now->toDateString();

        $this->tanggal = $today;
        $this->historyToDate = $today;
        $this->historyFromDate = $now->copy()->subDays(29)->toDateString();

        $this->foodSources = ProteinSource::orderBy('name')->get();
        if ($this->foodSources->isNotEmpty() && ! $this->foodSources->where('name', $this->sumber_makanan)->first()) {
            $this->sumber_makanan = $this->foodSources->first()->name;
        }

        if (auth()->check()) {
            $user = auth()->user();
            $this->user_weight = $user->weight;
            $this->user_height = $user->height;
            $this->user_gender = $user->gender ?? 'M';
            $this->user_age = $user->age ?? 24;
            $this->activity_level = $user->activity_level ?? 'moderate';

            if ($user->fitnessGoal) {
                $goalName = strtolower($user->fitnessGoal->name ?? '');
                if (str_contains($goalName, 'kurus') || str_contains($goalName, 'turun') || str_contains($goalName, 'cut') || str_contains($goalName, 'fat')) {
                    $this->fitness_goal = 'cutting';
                } elseif (str_contains($goalName, 'otot') || str_contains($goalName, 'naik') || str_contains($goalName, 'bulk')) {
                    $this->fitness_goal = 'bulking';
                }
            }

            if ($user->protein_target) {
                $this->targetProtein = (float) $user->protein_target;
            }
            if ($user->calorie_target) {
                $this->targetCalories = (float) $user->calorie_target;
            }
            if ($user->fat_target) {
                $this->targetFat = (float) $user->fat_target;
            }
            if ($user->carb_target) {
                $this->targetCarbs = (float) $user->carb_target;
            }

            if ($user->weight && $user->height && $user->gender) {
                $this->is_confirmed = true;
                $this->computeBmrAndTdeeOnly();
            }
        }
    }

    private function computeBmrAndTdeeOnly(): void
    {
        if (! $this->user_weight || ! $this->user_height || ! $this->user_age) {
            return;
        }
        $genderOffset = $this->user_gender === 'M' ? 5 : -161;
        $this->bmrValue = round((10 * (float) $this->user_weight) + (6.25 * (float) $this->user_height) - (5 * (int) $this->user_age) + $genderOffset, 0);
        $factor = self::ACTIVITY_FACTORS[$this->activity_level]['factor'] ?? 1.55;
        $this->tdeeValue = round($this->bmrValue * $factor, 0);
    }

    public function confirmPhysicalData(): void
    {
        $this->validate([
            'user_weight' => 'required|numeric|min:30|max:250',
            'user_height' => 'required|numeric|min:100|max:250',
            'user_age' => 'required|integer|min:13|max:100',
            'user_gender' => 'required|in:M,F',
            'activity_level' => 'required|in:'.implode(',', array_keys(self::ACTIVITY_FACTORS)),
            'fitness_goal' => 'required|in:cutting,maintenance,bulking',
        ], [
            'user_weight.required' => 'Berat badan wajib diisi.',
            'user_height.required' => 'Tinggi badan wajib diisi.',
            'user_age.required' => 'Usia wajib diisi.',
            'user_gender.required' => 'Jenis kelamin wajib dipilih.',
        ]);

        // 1. Mifflin-St Jeor BMR & TDEE
        $genderOffset = $this->user_gender === 'M' ? 5 : -161;
        $bmr = (10 * (float) $this->user_weight) + (6.25 * (float) $this->user_height) - (5 * (int) $this->user_age) + $genderOffset;
        $factor = self::ACTIVITY_FACTORS[$this->activity_level]['factor'] ?? 1.55;
        $tdee = $bmr * $factor;

        $this->bmrValue = round($bmr, 0);
        $this->tdeeValue = round($tdee, 0);

        // 2. Penyesuaian Kalori sesuai Tujuan
        $calFloor = $this->user_gender === 'M' ? 1400 : 1200;
        $targetCalories = match ($this->fitness_goal) {
            'cutting' => max($calFloor, $tdee - 450),
            'bulking' => $tdee + 300,
            default => $tdee,
        };

        // 3. Kebutuhan Protein (Adjusted Body Weight AKG Kemenkes RI untuk menghindari target berlebih)
        $baseWeight = $this->user_gender === 'M' ? 50.0 : 45.5;
        $heightOverBase = max(0, (float) $this->user_height - 152.4);
        $ibw = $baseWeight + (0.9 * $heightOverBase);
        $weightToUse = (float) $this->user_weight;
        if ($weightToUse > 1.2 * $ibw) {
            $weightToUse = $ibw + 0.4 * ($weightToUse - $ibw);
        }

        $proteinPerKg = match ($this->fitness_goal) {
            'cutting' => 1.8,
            'bulking' => 1.8,
            default => 1.6,
        };

        $targetProtein = round($weightToUse * $proteinPerKg, 1);

        // 4. Kebutuhan Lemak (25% total kalori target / 9 kkal per gram)
        $fatCalories = $targetCalories * 0.25;
        $targetFat = round($fatCalories / 9, 1);

        // 5. Kebutuhan Karbohidrat (Sisa kalori setelah Protein [4 kkal/g] & Lemak [9 kkal/g], min 50g)
        $proteinCalories = $targetProtein * 4;
        $remainingCarbCalories = max(200, $targetCalories - $proteinCalories - ($targetFat * 9));
        $targetCarbs = round($remainingCarbCalories / 4, 1);

        $this->targetCalories = round($targetCalories, 0);
        $this->targetProtein = $targetProtein;
        $this->targetFat = $targetFat;
        $this->targetCarbs = $targetCarbs;
        $this->is_confirmed = true;
        $this->showCalculatorModal = false;

        if (auth()->check()) {
            $user = auth()->user();
            $user->update([
                'weight' => $this->user_weight,
                'height' => $this->user_height,
                'gender' => $this->user_gender,
                'age' => $this->user_age,
                'activity_level' => $this->activity_level,
                'protein_target' => $this->targetProtein,
                'calorie_target' => $this->targetCalories,
                'fat_target' => $this->targetFat,
                'carb_target' => $this->targetCarbs,
            ]);
        }

        session()->flash(
            'success_confirm',
            auth()->check()
                ? "Target nutrisi harian disimpan: {$this->targetCalories} kkal | Protein {$this->targetProtein}g | Lemak {$this->targetFat}g | Karbohidrat {$this->targetCarbs}g."
                : "Simulasi target dihitung: {$this->targetCalories} kkal | Protein {$this->targetProtein}g. Masuk ke akun untuk menyimpan target Anda."
        );
    }

    #[Computed]
    public function calculatedMacros(): array
    {
        if ($this->isCustomFood) {
            return [
                'protein' => round(max(0, (float) $this->custom_protein), 1),
                'kalori' => round(max(0, (float) $this->custom_kalori), 1),
                'lemak' => round(max(0, (float) $this->custom_lemak), 1),
                'karbohidrat' => round(max(0, (float) $this->custom_karbo), 1),
            ];
        }

        if (empty($this->sumber_makanan) || $this->berat <= 0) {
            return ['protein' => 0.0, 'kalori' => 0.0, 'lemak' => 0.0, 'karbohidrat' => 0.0];
        }

        $source = $this->foodSources->where('name', $this->sumber_makanan)->first();
        if (! $source) {
            return ['protein' => 0.0, 'kalori' => 0.0, 'lemak' => 0.0, 'karbohidrat' => 0.0];
        }

        $ratio = ((float) $this->berat) / 100;

        return [
            'protein' => round($ratio * (float) $source->protein_per_100g, 1),
            'kalori' => round($ratio * (float) $source->calories_per_100g, 1),
            'lemak' => round($ratio * (float) $source->fat_per_100g, 1),
            'karbohidrat' => round($ratio * (float) $source->carbs_per_100g, 1),
        ];
    }

    #[Computed]
    public function calculatedProtein(): float
    {
        return (float) ($this->calculatedMacros()['protein'] ?? 0.0);
    }

    #[Computed]
    public function dailyLogs()
    {
        if (! auth()->check()) {
            return collect();
        }

        return ProteinLog::where('user_id', auth()->id())
            ->whereDate('tanggal', $this->tanggal)
            ->latest()
            ->get();
    }

    #[Computed]
    public function todayTotals(): array
    {
        $logs = $this->dailyLogs();

        return [
            'protein' => round((float) $logs->sum('jumlah_protein'), 1),
            'kalori' => round((float) $logs->sum('kalori'), 1),
            'lemak' => round((float) $logs->sum('lemak'), 1),
            'karbohidrat' => round((float) $logs->sum('karbohidrat'), 1),
        ];
    }

    #[Computed]
    public function totalAchieved(): float
    {
        return (float) ($this->todayTotals()['protein'] ?? 0.0);
    }

    #[Computed]
    public function nutrientSummary(): array
    {
        $emptyStat = [
            'total' => 0.0,
            'avg' => 0.0,
            'max' => 0.0,
            'active_days' => 0,
            'today' => 0.0,
            'target' => 0.0,
        ];

        $result = [
            'protein' => array_merge($emptyStat, ['target' => $this->targetProtein, 'unit' => 'g', 'label' => 'Protein']),
            'kalori' => array_merge($emptyStat, ['target' => $this->targetCalories, 'unit' => 'kkal', 'label' => 'Kalori']),
            'lemak' => array_merge($emptyStat, ['target' => $this->targetFat, 'unit' => 'g', 'label' => 'Lemak']),
            'karbohidrat' => array_merge($emptyStat, ['target' => $this->targetCarbs, 'unit' => 'g', 'label' => 'Karbohidrat']),
        ];

        $todayTotals = $this->todayTotals();
        foreach (['protein', 'kalori', 'lemak', 'karbohidrat'] as $key) {
            $result[$key]['today'] = $todayTotals[$key];
        }

        if (! auth()->check()) {
            return $result;
        }

        $now = Carbon::now('Asia/Jakarta');
        $startDate = $now->copy()->subDays($this->chartRange - 1)->toDateString();
        $endDate = $now->toDateString();

        $dailyRows = ProteinLog::where('user_id', auth()->id())
            ->whereDate('tanggal', '>=', $startDate)
            ->whereDate('tanggal', '<=', $endDate)
            ->selectRaw('DATE(tanggal) as day_date, SUM(jumlah_protein) as p, SUM(kalori) as cal, SUM(lemak) as f, SUM(karbohidrat) as c')
            ->groupBy('day_date')
            ->get();

        $activeDays = $dailyRows->count();
        if ($activeDays === 0) {
            return $result;
        }

        $map = [
            'protein' => 'p',
            'kalori' => 'cal',
            'lemak' => 'f',
            'karbohidrat' => 'c',
        ];

        foreach ($map as $key => $col) {
            $sum = round((float) $dailyRows->sum($col), 1);
            $max = round((float) ($dailyRows->max($col) ?? 0), 1);
            $avg = round($sum / $activeDays, 1);

            $result[$key]['total'] = $sum;
            $result[$key]['avg'] = $avg;
            $result[$key]['max'] = $max;
            $result[$key]['active_days'] = $activeDays;
        }

        return $result;
    }

    #[Computed]
    public function chartData(): array
    {
        $now = Carbon::now('Asia/Jakarta');
        $daysCount = in_array($this->chartRange, [7, 30], true) ? $this->chartRange : 7;
        $start = $now->copy()->subDays($daysCount - 1);

        $columnMap = [
            'protein' => ['col' => 'jumlah_protein', 'label' => 'Protein (g)', 'unit' => 'g', 'target' => $this->targetProtein],
            'kalori' => ['col' => 'kalori', 'label' => 'Kalori (kkal)', 'unit' => 'kkal', 'target' => $this->targetCalories],
            'lemak' => ['col' => 'lemak', 'label' => 'Lemak (g)', 'unit' => 'g', 'target' => $this->targetFat],
            'karbohidrat' => ['col' => 'karbohidrat', 'label' => 'Karbohidrat (g)', 'unit' => 'g', 'target' => $this->targetCarbs],
        ];

        $meta = $columnMap[$this->chartNutrient] ?? $columnMap['protein'];

        $groupedByDate = collect();
        if (auth()->check()) {
            $groupedByDate = ProteinLog::where('user_id', auth()->id())
                ->whereDate('tanggal', '>=', $start->toDateString())
                ->whereDate('tanggal', '<=', $now->toDateString())
                ->selectRaw("DATE(tanggal) as day_date, SUM({$meta['col']}) as total_val")
                ->groupBy('day_date')
                ->pluck('total_val', 'day_date');
        }

        $points = [];
        $maxVal = max((float) $meta['target'], 10.0);

        for ($i = 0; $i < $daysCount; $i++) {
            $cursor = $start->copy()->addDays($i);
            $dateStr = $cursor->toDateString();
            $val = round((float) ($groupedByDate[$dateStr] ?? 0), 1);
            if ($val > $maxVal) {
                $maxVal = $val;
            }

            $points[] = [
                'date' => $dateStr,
                'short' => $cursor->format('d/m'),
                'label' => $cursor->format('d M Y'),
                'value' => $val,
                'target' => round((float) $meta['target'], 1),
            ];
        }

        return [
            'label' => $meta['label'],
            'unit' => $meta['unit'],
            'target' => round((float) $meta['target'], 1),
            'max_y' => round($maxVal * 1.15, 0),
            'has_data' => collect($points)->sum('value') > 0,
            'points' => $points,
        ];
    }

    #[Computed]
    public function historyLogs()
    {
        if (! auth()->check()) {
            return collect();
        }

        $now = Carbon::now('Asia/Jakarta');
        $today = $now->toDateString();

        $query = ProteinLog::where('user_id', auth()->id());

        if ($this->historyRange === 'today') {
            $query->whereDate('tanggal', $today);
        } elseif ($this->historyRange === '7') {
            $query->whereDate('tanggal', '>=', $now->copy()->subDays(6)->toDateString())
                ->whereDate('tanggal', '<=', $today);
        } elseif ($this->historyRange === '30') {
            $query->whereDate('tanggal', '>=', $now->copy()->subDays(29)->toDateString())
                ->whereDate('tanggal', '<=', $today);
        } elseif ($this->historyRange === 'custom') {
            if ($this->historyFromDate) {
                $query->whereDate('tanggal', '>=', $this->historyFromDate);
            }
            if ($this->historyToDate) {
                $query->whereDate('tanggal', '<=', $this->historyToDate);
            }
        }

        return $query->orderByDesc('tanggal')->orderByDesc('created_at')->limit(60)->get();
    }

    public function saveLog(): void
    {
        if (! auth()->check()) {
            session()->flash('error_auth', 'Silakan masuk ke akun Anda terlebih dahulu untuk menyimpan catatan nutrisi pribadi.');

            return;
        }

        $rules = [
            'tanggal' => 'required|date',
            'waktu_makan' => 'required|in:Sarapan,Makan Siang,Makan Malam,Camilan',
            'berat' => 'required|numeric|min:1|max:5000',
        ];

        if ($this->isCustomFood) {
            $rules['custom_food_name'] = 'required|string|max:120';
            $rules['custom_protein'] = 'required|numeric|min:0|max:2000';
            $rules['custom_kalori'] = 'required|numeric|min:0|max:10000';
            $rules['custom_lemak'] = 'required|numeric|min:0|max:1000';
            $rules['custom_karbo'] = 'required|numeric|min:0|max:2000';
        } else {
            $rules['sumber_makanan'] = 'required|string';
        }

        $this->validate($rules, [
            'berat.min' => 'Berat makanan minimal 1 gram.',
            'custom_food_name.required' => 'Nama makanan wajib diisi.',
        ]);

        $macros = $this->calculatedMacros();
        $foodName = $this->isCustomFood ? trim($this->custom_food_name) : $this->sumber_makanan;

        $payload = [
            'sumber_makanan' => $foodName,
            'berat_gram' => $this->berat,
            'jumlah_protein' => $macros['protein'],
            'kalori' => $macros['kalori'],
            'lemak' => $macros['lemak'],
            'karbohidrat' => $macros['karbohidrat'],
            'tanggal' => $this->tanggal,
            'waktu_makan' => $this->waktu_makan,
            'user_weight' => $this->user_weight,
            'user_height' => $this->user_height,
        ];

        if ($this->editingLogId) {
            $log = ProteinLog::where('id', $this->editingLogId)
                ->where('user_id', auth()->id())
                ->first();

            if ($log) {
                $log->update($payload);
                session()->flash('success', "Berhasil memperbarui catatan nutrisi {$foodName}.");
            }
            $this->cancelEdit();
        } else {
            $payload['user_id'] = auth()->id();
            ProteinLog::create($payload);

            session()->flash('success', "Tersimpan: {$foodName} ({$macros['protein']}g P • {$macros['kalori']} kkal).");
            $this->berat = 100;
            if ($this->isCustomFood) {
                $this->reset(['custom_food_name', 'custom_protein', 'custom_kalori', 'custom_lemak', 'custom_karbo']);
            }
        }

        unset($this->dailyLogs, $this->todayTotals, $this->totalAchieved, $this->nutrientSummary, $this->chartData, $this->historyLogs);
    }

    public function editLog(int $id): void
    {
        if (! auth()->check()) {
            return;
        }

        $log = ProteinLog::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (! $log) {
            return;
        }

        $this->editingLogId = $log->id;
        $this->tanggal = Carbon::parse($log->tanggal)->toDateString();
        $this->waktu_makan = $log->waktu_makan ?? 'Makan Siang';

        $source = $this->foodSources->where('name', $log->sumber_makanan)->first();
        if ($source) {
            $this->isCustomFood = false;
            $this->sumber_makanan = $log->sumber_makanan;
            if ($log->berat_gram && $log->berat_gram > 0) {
                $this->berat = (float) $log->berat_gram;
            } elseif ($source->protein_per_100g > 0) {
                $this->berat = round(($log->jumlah_protein / $source->protein_per_100g) * 100, 1);
            } else {
                $this->berat = 100;
            }
        } else {
            $this->isCustomFood = true;
            $this->custom_food_name = $log->sumber_makanan;
            $this->berat = (float) ($log->berat_gram ?? 100);
            $this->custom_protein = (float) $log->jumlah_protein;
            $this->custom_kalori = (float) ($log->kalori ?? 0);
            $this->custom_lemak = (float) ($log->lemak ?? 0);
            $this->custom_karbo = (float) ($log->karbohidrat ?? 0);
        }
    }

    public function cancelEdit(): void
    {
        $this->editingLogId = null;
        $this->berat = 100;
        $this->reset(['custom_food_name', 'custom_protein', 'custom_kalori', 'custom_lemak', 'custom_karbo']);
    }

    public function deleteLog(int $id): void
    {
        if (! auth()->check()) {
            return;
        }

        $log = ProteinLog::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if ($log) {
            $log->delete();
            session()->flash('info', 'Catatan nutrisi berhasil dihapus.');
            unset($this->dailyLogs, $this->todayTotals, $this->totalAchieved, $this->nutrientSummary, $this->chartData, $this->historyLogs);
        }
    }

    public function render()
    {
        return view('livewire.protein-calculator')
            ->layout('components.layouts.app');
    }
}
