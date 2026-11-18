@php
    $summary = $this->nutrientSummary;
    $chart = $this->chartData;
    $macrosPreview = $this->calculatedMacros;
    $historyLogs = $this->historyLogs;

    // Real Macro Calorie Proportions for Donut Chart
    $pCal = max(0, $targetProtein * 4);
    $fCal = max(0, $targetFat * 9);
    $cCal = max(0, $targetCarbs * 4);
    $macroCalTotal = max(1, $pCal + $fCal + $cCal);
    $pPct = round(($pCal / $macroCalTotal) * 100, 1);
    $fPct = round(($fCal / $macroCalTotal) * 100, 1);
    $cPct = round(max(0, 100 - $pPct - $fPct), 1);

    // SVG Donut circumference = 2 * pi * 42 ~= 263.89
    $circ = 263.89;
    $pDash = ($pPct / 100) * $circ;
    $fDash = ($fPct / 100) * $circ;
    $cDash = ($cPct / 100) * $circ;
@endphp

<div class="space-y-8 pb-10">

    <!-- PAGE HEADER -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-[#E54855]/10 text-[#E54855] border border-[#E54855]/25 mb-2">
                TKPI Kemenkes RI &bull; Mifflin-St Jeor
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-[#202124] dark:text-[#F5F5F5]">
                Kalkulator & Pemantau <span class="text-[#E54855]">Nutrisi</span>
            </h1>
            <p class="text-sm text-[#777777] dark:text-[#AAA0A2] mt-1">
                Hitung estimasi kebutuhan energi & makronutrien, lalu catat konsumsi harian Anda secara terpisah dan terukur.
            </p>
        </div>

        <button type="button" wire:click="$toggle('showCalculatorModal')"
                class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white text-xs sm:text-sm font-bold shadow-sm transition-colors cursor-pointer shrink-0">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            <span>{{ $showCalculatorModal ? 'Tutup Kalkulator Target' : 'Hitung Kebutuhan Nutrisi' }}</span>
        </button>
    </div>

    <!-- FLASH NOTIFICATIONS -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-[#E54855]/10 border border-[#E54855]/30 text-[#202124] dark:text-[#F5F5F5] text-sm font-semibold flex items-center gap-3">
            <span class="w-2.5 h-2.5 rounded-full bg-[#E54855] shrink-0"></span>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('success_confirm'))
        <div class="p-4 rounded-2xl bg-[#E54855]/10 border border-[#E54855]/30 text-[#202124] dark:text-[#F5F5F5] text-sm font-semibold flex items-center gap-3">
            <span class="w-2.5 h-2.5 rounded-full bg-[#E54855] shrink-0"></span>
            <span>{{ session('success_confirm') }}</span>
        </div>
    @endif
    @if(session('info'))
        <div class="p-4 rounded-2xl bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5] text-sm font-semibold">
            {{ session('info') }}
        </div>
    @endif
    @if(session('error_auth'))
        <div class="p-4 rounded-2xl bg-[#C93646]/15 border border-[#E54855] text-[#C93646] dark:text-[#F5F5F5] text-sm font-semibold flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <span>{{ session('error_auth') }}</span>
            <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl bg-[#E54855] text-white text-xs font-bold text-center">Masuk Sekarang</a>
        </div>
    @endif

    <!-- KALKULATOR MIFFLIN-ST JEOR (OTOMATIS TERBUKA BILA BELUM DIHITUNG ATAU DITEKAN) -->
    @if(!$is_confirmed || $showCalculatorModal)
        <div class="bg-white dark:bg-[#1A1012] rounded-3xl border border-[#E9E9EC] dark:border-[#342427] p-6 sm:p-8 shadow-sm space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-[#E9E9EC] dark:border-[#342427] pb-4">
                <div>
                    <h2 class="text-lg sm:text-xl font-extrabold text-[#202124] dark:text-[#F5F5F5]">
                        Kalkulator Kebutuhan Energi & Makronutrien Harian
                    </h2>
                    <p class="text-xs text-[#777777] dark:text-[#AAA0A2] mt-1">
                        Menggunakan persamaan <strong class="text-[#202124] dark:text-[#F5F5F5]">Mifflin-St Jeor</strong> (BMR &times; Aktivitas) + penyesuaian tujuan dan AKG Kemenkes RI.
                    </p>
                </div>
                @if($is_confirmed)
                    <button type="button" wire:click="$set('showCalculatorModal', false)" class="text-xs font-bold text-[#777777] hover:text-[#E54855] self-start sm:self-center">
                        Sembunyikan &times;
                    </button>
                @endif
            </div>

            <form wire:submit.prevent="confirmPhysicalData" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
                <div>
                    <label class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1.5">Berat Badan (kg)</label>
                    <input type="number" step="0.1" wire:model="user_weight" placeholder="Contoh: 68"
                           class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855] focus:ring-2 focus:ring-[#E54855]/20">
                    @error('user_weight') <span class="text-xs text-[#E54855] font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1.5">Tinggi Badan (cm)</label>
                    <input type="number" step="0.5" wire:model="user_height" placeholder="Contoh: 172"
                           class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855] focus:ring-2 focus:ring-[#E54855]/20">
                    @error('user_height') <span class="text-xs text-[#E54855] font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1.5">Usia (tahun)</label>
                    <input type="number" wire:model="user_age" placeholder="Contoh: 24"
                           class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855] focus:ring-2 focus:ring-[#E54855]/20">
                    @error('user_age') <span class="text-xs text-[#E54855] font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1.5">Jenis Kelamin</label>
                    <select wire:model="user_gender"
                            class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]">
                        <option value="M">Laki-laki</option>
                        <option value="F">Perempuan</option>
                    </select>
                    @error('user_gender') <span class="text-xs text-[#E54855] font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1.5">Tingkat Aktivitas</label>
                    <select wire:model="activity_level"
                            class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]">
                        @foreach(\App\Livewire\ProteinCalculator::ACTIVITY_FACTORS as $key => $info)
                            <option value="{{ $key }}">{{ $info['label'] }}</option>
                        @endforeach
                    </select>
                    @error('activity_level') <span class="text-xs text-[#E54855] font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1.5">Tujuan Fitness</label>
                    <select wire:model="fitness_goal"
                            class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]">
                        @foreach(\App\Livewire\ProteinCalculator::GOAL_LABELS as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('fitness_goal') <span class="text-xs text-[#E54855] font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="sm:col-span-2 lg:col-span-3 flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-2 border-t border-[#E9E9EC] dark:border-[#342427]">
                    <p class="text-xs text-[#777777] dark:text-[#AAA0A2] max-w-2xl leading-relaxed">
                        <strong class="text-[#E54855]">Disclaimer Medis:</strong> Angka yang dihasilkan adalah <em>estimasi kebutuhan nutrisi harian</em> berbasis data antropometri, bukan merupakan diagnosis atau resep medis klinis.
                    </p>
                    <button type="submit" wire:loading.attr="disabled"
                            class="px-6 py-3 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white text-sm font-bold shadow-sm transition-colors cursor-pointer shrink-0">
                        <span wire:loading.remove wire:target="confirmPhysicalData">Hitung & Terapkan Target</span>
                        <span wire:loading wire:target="confirmPhysicalData">Menghitung...</span>
                    </button>
                </div>
            </form>
        </div>
    @endif

    <!-- 1. FOUR NUTRIENT KPI SUMMARY CARDS (GAMBAR 2 TOP ROW: TOTAL, RATA-RATA, TERTINGGI + HARI INI VS TARGET) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @php
            $kpiConfigs = [
                'protein' => ['title' => 'Protein', 'accent' => true],
                'kalori' => ['title' => 'Kalori', 'accent' => false],
                'lemak' => ['title' => 'Lemak', 'accent' => false],
                'karbohidrat' => ['title' => 'Karbohidrat', 'accent' => false],
            ];
        @endphp

        @foreach($kpiConfigs as $key => $cfg)
            @php
                $item = $summary[$key];
                $isActiveChart = $chartNutrient === $key;
                $isRedCard = $cfg['accent'];
            @endphp
            <button type="button"
                    wire:click="$set('chartNutrient', '{{ $key }}')"
                    class="text-left rounded-3xl p-6 transition-all duration-200 cursor-pointer relative overflow-hidden {{ $isRedCard ? 'bg-gradient-to-br from-[#E54855] to-[#C93646] text-white shadow-lg shadow-[#E54855]/25' : 'bg-white dark:bg-[#1A1012] text-[#202124] dark:text-[#F5F5F5] border ' . ($isActiveChart ? 'border-[#E54855] ring-2 ring-[#E54855]/20' : 'border-[#E9E9EC] dark:border-[#342427] hover:border-[#E54855]/50') }}">

                <div class="flex items-center justify-between gap-2 mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider {{ $isRedCard ? 'text-white/90' : 'text-[#777777] dark:text-[#AAA0A2]' }}">
                        {{ $cfg['title'] }}
                    </span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $isRedCard ? 'bg-white/20 text-white' : 'bg-[#E54855]/10 text-[#E54855]' }}">
                        Hari Ini: {{ number_format($item['today'], $key === 'kalori' ? 0 : 1) }} {{ $item['unit'] }}
                    </span>
                </div>

                <!-- Konsumsi Aktual vs Target -->
                <div class="flex items-baseline gap-1.5">
                    <span class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                        {{ number_format($item['total'], $key === 'kalori' ? 0 : 1) }}
                    </span>
                    <span class="text-xs font-bold {{ $isRedCard ? 'text-white/80' : 'text-[#777777] dark:text-[#AAA0A2]' }}">
                        {{ $item['unit'] }} ({{ $chartRange }}H)
                    </span>
                </div>
                <p class="text-[11px] font-medium mt-0.5 {{ $isRedCard ? 'text-white/85' : 'text-[#777777] dark:text-[#AAA0A2]' }}">
                    Target harian: <strong class="{{ $isRedCard ? 'text-white' : 'text-[#202124] dark:text-[#F5F5F5]' }}">{{ number_format($item['target'], $key === 'kalori' ? 0 : 1) }} {{ $item['unit'] }}</strong>
                </p>

                <!-- 3 Required Metrics: Total, Rata-rata/hari, Tertinggi/hari -->
                <div class="grid grid-cols-3 gap-2 mt-4 pt-3.5 border-t {{ $isRedCard ? 'border-white/20' : 'border-[#E9E9EC] dark:border-[#342427]' }}">
                    <div>
                        <span class="block text-[10px] font-semibold uppercase {{ $isRedCard ? 'text-white/75' : 'text-[#777777] dark:text-[#AAA0A2]' }}">Total</span>
                        <span class="block text-xs font-extrabold">{{ number_format($item['total'], $key === 'kalori' ? 0 : 1) }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] font-semibold uppercase {{ $isRedCard ? 'text-white/75' : 'text-[#777777] dark:text-[#AAA0A2]' }}">Rata-rata</span>
                        <span class="block text-xs font-extrabold">{{ number_format($item['avg'], $key === 'kalori' ? 0 : 1) }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] font-semibold uppercase {{ $isRedCard ? 'text-white/75' : 'text-[#777777] dark:text-[#AAA0A2]' }}">Tertinggi</span>
                        <span class="block text-xs font-extrabold">{{ number_format($item['max'], $key === 'kalori' ? 0 : 1) }}</span>
                    </div>
                </div>
            </button>
        @endforeach
    </div>

    <!-- 2. MIDDLE ROW: INTERACTIVE CHART + TARGET MACRO BREAKDOWN (GAMBAR 2 MIDDLE ROW) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Left Chart Card (lg:col-span-8) -->
        <div class="lg:col-span-8 bg-white dark:bg-[#1A1012] rounded-3xl border border-[#E9E9EC] dark:border-[#342427] p-6 sm:p-7 shadow-sm space-y-5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">
                        Konsumsi Aktual vs Target Harian — <span class="text-[#E54855]">{{ $chart['label'] }}</span>
                    </h2>
                    <div class="flex flex-wrap items-center gap-4 mt-1.5 text-xs font-semibold text-[#777777] dark:text-[#AAA0A2]">
                        <span class="inline-flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded-sm bg-[#E54855] inline-block"></span>
                            Konsumsi Aktual
                        </span>
                        <span class="inline-flex items-center gap-1.5">
                            <span class="w-4 border-t-2 border-dashed border-[#777777] dark:border-[#AAA0A2] inline-block"></span>
                            Target ({{ number_format($chart['target'], 0) }} {{ $chart['unit'] }})
                        </span>
                    </div>
                </div>

                <!-- Controls: 7H / 30H & Line / Bar -->
                <div class="flex flex-wrap items-center gap-2">
                    <div class="inline-flex rounded-xl bg-[#F7F7F8] dark:bg-[#251518] p-1 border border-[#E9E9EC] dark:border-[#342427] text-xs font-bold">
                        <button type="button" wire:click="$set('chartRange', 7)"
                                class="px-3 py-1.5 rounded-lg transition-colors cursor-pointer {{ $chartRange === 7 ? 'bg-[#E54855] text-white' : 'text-[#777777] dark:text-[#AAA0A2]' }}">
                            7 Hari
                        </button>
                        <button type="button" wire:click="$set('chartRange', 30)"
                                class="px-3 py-1.5 rounded-lg transition-colors cursor-pointer {{ $chartRange === 30 ? 'bg-[#E54855] text-white' : 'text-[#777777] dark:text-[#AAA0A2]' }}">
                            30 Hari
                        </button>
                    </div>

                    <div class="inline-flex rounded-xl bg-[#F7F7F8] dark:bg-[#251518] p-1 border border-[#E9E9EC] dark:border-[#342427] text-xs font-bold">
                        <button type="button" wire:click="$set('chartType', 'line')"
                                class="px-3 py-1.5 rounded-lg transition-colors cursor-pointer {{ $chartType === 'line' ? 'bg-[#202124] dark:bg-[#F5F5F5] text-white dark:text-[#100809]' : 'text-[#777777] dark:text-[#AAA0A2]' }}">
                            Garis
                        </button>
                        <button type="button" wire:click="$set('chartType', 'bar')"
                                class="px-3 py-1.5 rounded-lg transition-colors cursor-pointer {{ $chartType === 'bar' ? 'bg-[#202124] dark:bg-[#F5F5F5] text-white dark:text-[#100809]' : 'text-[#777777] dark:text-[#AAA0A2]' }}">
                            Batang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Nutrient Switcher Pills -->
            <div class="flex flex-wrap gap-2">
                @foreach(['protein' => 'Protein (g)', 'kalori' => 'Kalori (kkal)', 'lemak' => 'Lemak (g)', 'karbohidrat' => 'Karbohidrat (g)'] as $nKey => $nLabel)
                    <button type="button" wire:click="$set('chartNutrient', '{{ $nKey }}')"
                            class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-colors cursor-pointer {{ $chartNutrient === $nKey ? 'bg-[#E54855] text-white' : 'bg-[#F7F7F8] dark:bg-[#251518] text-[#777777] dark:text-[#AAA0A2] border border-[#E9E9EC] dark:border-[#342427] hover:text-[#E54855]' }}">
                        {{ $nLabel }}
                    </button>
                @endforeach
            </div>

            <!-- SVG Interactive Chart (Zero External CDN Failure Risk, Responsive) -->
            @php
                $pts = $chart['points'];
                $nPts = max(1, count($pts));
                $svgW = 680;
                $svgH = 250;
                $padL = 52;
                $padR = 16;
                $padT = 18;
                $padB = 34;
                $plotW = $svgW - $padL - $padR;
                $plotH = $svgH - $padT - $padB;
                $maxY = max(10, (float) $chart['max_y']);
                $targetY = $padT + $plotH - (min($maxY, (float) $chart['target']) / $maxY) * $plotH;

                $coords = [];
                foreach ($pts as $idx => $p) {
                    $cx = $nPts === 1
                        ? $padL + ($plotW / 2)
                        : $padL + ($idx / ($nPts - 1)) * $plotW;
                    $cy = $padT + $plotH - (min($maxY, (float) $p['value']) / $maxY) * $plotH;
                    $coords[] = array_merge($p, [
                        'cx' => round($cx, 2),
                        'cy' => round($cy, 2),
                        'barH' => round(($p['value'] / $maxY) * $plotH, 2),
                    ]);
                }

                $polylinePts = collect($coords)->map(fn($c) => "{$c['cx']},{$c['cy']}")->implode(' ');
                $areaPath = '';
                if (count($coords) > 0) {
                    $first = $coords[0];
                    $last = $coords[count($coords) - 1];
                    $baseY = $padT + $plotH;
                    $areaPath = "M {$first['cx']},{$baseY} L " . collect($coords)->map(fn($c) => "{$c['cx']},{$c['cy']}")->implode(' L ') . " L {$last['cx']},{$baseY} Z";
                }
            @endphp

            <div class="relative w-full"
                 x-data="{ hoveredIdx: null, points: @js($coords), unit: @js($chart['unit']) }">
                <!-- Interactive Hover Tooltip -->
                <div x-show="hoveredIdx !== null" x-cloak
                     class="mb-2 px-3.5 py-2 rounded-xl bg-[#202124] dark:bg-[#251518] text-white text-xs flex flex-wrap items-center justify-between gap-3 border border-[#342427]">
                    <span class="font-bold" x-text="hoveredIdx !== null ? points[hoveredIdx].label : ''"></span>
                    <div class="flex items-center gap-4">
                        <span>Aktual: <strong class="text-[#E54855]" x-text="hoveredIdx !== null ? (points[hoveredIdx].value + ' ' + unit) : ''"></strong></span>
                        <span>Target: <strong x-text="hoveredIdx !== null ? (points[hoveredIdx].target + ' ' + unit) : ''"></strong></span>
                    </div>
                </div>

                <div class="w-full overflow-hidden">
                    <svg viewBox="0 0 {{ $svgW }} {{ $svgH }}" class="w-full h-auto block select-none" role="img" aria-label="Grafik Konsumsi Nutrisi">
                        <defs>
                            <linearGradient id="pfAreaGrad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#E54855" stop-opacity="0.28"/>
                                <stop offset="100%" stop-color="#E54855" stop-opacity="0.02"/>
                            </linearGradient>
                        </defs>

                        <!-- Horizontal Gridlines & Y Ticks -->
                        @for($step = 0; $step <= 4; $step++)
                            @php
                                $yPos = $padT + ($plotH / 4) * $step;
                                $yTickVal = round($maxY - ($maxY / 4) * $step);
                            @endphp
                            <line x1="{{ $padL }}" y1="{{ $yPos }}" x2="{{ $svgW - $padR }}" y2="{{ $yPos }}" stroke="currentColor" class="text-[#E9E9EC] dark:text-[#342427]" stroke-width="1"/>
                            <text x="{{ $padL - 8 }}" y="{{ $yPos + 4 }}" text-anchor="end" class="fill-[#777777] dark:fill-[#AAA0A2] text-[10px] font-semibold">{{ $yTickVal }}</text>
                        @endfor

                        <!-- Target Reference Dashed Line -->
                        <line x1="{{ $padL }}" y1="{{ $targetY }}" x2="{{ $svgW - $padR }}" y2="{{ $targetY }}" stroke="#777777" stroke-width="1.5" stroke-dasharray="5,4"/>

                        @if($chartType === 'bar')
                            @php
                                $barSlot = $plotW / $nPts;
                                $barW = max(5, min(32, $barSlot * 0.58));
                            @endphp
                            @foreach($coords as $idx => $c)
                                @php $bx = $c['cx'] - ($barW / 2); $by = ($padT + $plotH) - $c['barH']; @endphp
                                <rect x="{{ $bx }}" y="{{ $by }}" width="{{ $barW }}" height="{{ max(2, $c['barH']) }}" rx="4"
                                      fill="#E54855"
                                      class="transition-opacity cursor-pointer"
                                      :opacity="hoveredIdx === null || hoveredIdx === {{ $idx }} ? 1 : 0.45"
                                      @mouseenter="hoveredIdx = {{ $idx }}"
                                      @mouseleave="hoveredIdx = null"/>
                            @endforeach
                        @else
                            @if($areaPath)
                                <path d="{{ $areaPath }}" fill="url(#pfAreaGrad)"/>
                            @endif
                            <polyline fill="none" stroke="#E54855" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" points="{{ $polylinePts }}"/>
                            @foreach($coords as $idx => $c)
                                <circle cx="{{ $c['cx'] }}" cy="{{ $c['cy'] }}" r="{{ $chartRange === 7 ? 4.5 : 3 }}"
                                        fill="#E54855" stroke="#FFFFFF" stroke-width="1.5"
                                        class="cursor-pointer"
                                        @mouseenter="hoveredIdx = {{ $idx }}"
                                        @mouseleave="hoveredIdx = null"/>
                            @endforeach
                        @endif

                        <!-- X-Axis Date Labels (Prevent crowding on 30D) -->
                        @foreach($coords as $idx => $c)
                            @if($chartRange === 7 || $idx === 0 || $idx === count($coords) - 1 || $idx % 5 === 0)
                                <text x="{{ $c['cx'] }}" y="{{ $svgH - 8 }}" text-anchor="middle" class="fill-[#777777] dark:fill-[#AAA0A2] text-[10px] font-semibold">
                                    {{ $c['short'] }}
                                </text>
                            @endif
                        @endforeach
                    </svg>
                </div>

                @if(!$chart['has_data'])
                    <div class="mt-2 text-center py-2 px-4 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-dashed border-[#E9E9EC] dark:border-[#342427] text-xs text-[#777777] dark:text-[#AAA0A2]">
                        Belum ada data konsumsi pada rentang {{ $chartRange }} hari terakhir. Catat makanan pertama Anda di bawah untuk mengisi grafik.
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Card: Target Breakdown Donut + Progress Hari Ini (lg:col-span-4) -->
        <div class="lg:col-span-4 bg-white dark:bg-[#1A1012] rounded-3xl border border-[#E9E9EC] dark:border-[#342427] p-6 sm:p-7 shadow-sm flex flex-col justify-between space-y-5">
            <div>
                <div class="flex items-center justify-between gap-2 mb-1">
                    <h2 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">Proporsi Target Makro</h2>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase bg-[#E54855]/10 text-[#E54855]">Estimasi</span>
                </div>
                <p class="text-xs text-[#777777] dark:text-[#AAA0A2]">
                    Target kebutuhan harian vs konsumsi aktual tanggal <strong class="text-[#202124] dark:text-[#F5F5F5]">{{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}</strong>.
                </p>
            </div>

            <!-- Donut Chart -->
            <div class="flex items-center justify-center py-1">
                <div class="relative w-40 h-40">
                    <svg viewBox="0 0 120 120" class="w-full h-full -rotate-90">
                        <circle cx="60" cy="60" r="42" fill="none" stroke="currentColor" class="text-[#F7F7F8] dark:text-[#251518]" stroke-width="14"/>
                        <!-- Protein Segment -->
                        <circle cx="60" cy="60" r="42" fill="none" stroke="#E54855" stroke-width="14"
                                stroke-dasharray="{{ $pDash }} {{ $circ }}" stroke-dashoffset="0"/>
                        <!-- Karbohidrat Segment -->
                        <circle cx="60" cy="60" r="42" fill="none" stroke="#202124" class="dark:stroke-[#F5F5F5]" stroke-width="14"
                                stroke-dasharray="{{ $cDash }} {{ $circ }}" stroke-dashoffset="-{{ $pDash }}"/>
                        <!-- Lemak Segment -->
                        <circle cx="60" cy="60" r="42" fill="none" stroke="#9CA3AF" stroke-width="14"
                                stroke-dasharray="{{ $fDash }} {{ $circ }}" stroke-dashoffset="-{{ $pDash + $cDash }}"/>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                        <span class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">{{ number_format($targetCalories, 0) }}</span>
                        <span class="text-[10px] font-bold uppercase text-[#777777] dark:text-[#AAA0A2]">kkal / hari</span>
                    </div>
                </div>
            </div>

            <!-- Target vs Aktual Progress Bars -->
            <div class="space-y-3">
                @foreach(['protein', 'kalori', 'lemak', 'karbohidrat'] as $mKey)
                    @php
                        $m = $summary[$mKey];
                        $mPct = $m['target'] > 0 ? min(100, round(($m['today'] / $m['target']) * 100)) : 0;
                    @endphp
                    <div class="space-y-1">
                        <div class="flex justify-between text-xs font-semibold">
                            <span class="text-[#202124] dark:text-[#F5F5F5]">
                                {{ $m['label'] }}
                                @if($mKey === 'protein')
                                    <span class="text-[10px] text-[#E54855]">({{ $pPct }}%)</span>
                                @elseif($mKey === 'karbohidrat')
                                    <span class="text-[10px] text-[#777777] dark:text-[#AAA0A2]">({{ $cPct }}%)</span>
                                @elseif($mKey === 'lemak')
                                    <span class="text-[10px] text-[#777777] dark:text-[#AAA0A2]">({{ $fPct }}%)</span>
                                @endif
                            </span>
                            <span class="text-[#777777] dark:text-[#AAA0A2]">
                                <strong class="text-[#202124] dark:text-[#F5F5F5]">{{ number_format($m['today'], $mKey === 'kalori' ? 0 : 1) }}</strong> / {{ number_format($m['target'], 0) }} {{ $m['unit'] }}
                            </span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-[#F7F7F8] dark:bg-[#251518] overflow-hidden">
                            <div class="h-full bg-[#E54855] rounded-full transition-all duration-500" style="width: {{ $mPct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($bmrValue && $tdeeValue)
                <div class="p-3 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-xs space-y-1">
                    <div class="flex justify-between">
                        <span class="text-[#777777] dark:text-[#AAA0A2]">BMR Basal:</span>
                        <strong class="text-[#202124] dark:text-[#F5F5F5]">{{ number_format($bmrValue, 0) }} kkal</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#777777] dark:text-[#AAA0A2]">TDEE Harian:</span>
                        <strong class="text-[#E54855]">{{ number_format($tdeeValue, 0) }} kkal</strong>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- 3. LOG KONSUMSI HARIAN & RIWAYAT NUTRISI -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Left Form: Catat Makanan Aktual (lg:col-span-5) -->
        <div class="lg:col-span-5 bg-white dark:bg-[#1A1012] rounded-3xl border border-[#E9E9EC] dark:border-[#342427] p-6 sm:p-7 shadow-sm space-y-5">
            <div class="flex items-center justify-between border-b border-[#E9E9EC] dark:border-[#342427] pb-4">
                <div>
                    <h2 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">
                        {{ $editingLogId ? 'Edit Catatan Makanan' : 'Catat Konsumsi Makanan' }}
                    </h2>
                    <p class="text-xs text-[#777777] dark:text-[#AAA0A2]">Simpan konsumsi aktual Anda ke database</p>
                </div>
                <span class="px-3 py-1 rounded-xl bg-[#E54855]/10 text-[#E54855] text-xs font-extrabold">
                    {{ $macrosPreview['protein'] }}g P &bull; {{ number_format($macrosPreview['kalori'], 0) }} kkal
                </span>
            </div>

            @guest
                <div class="p-3.5 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E54855]/40 text-xs text-[#777777] dark:text-[#AAA0A2] flex items-center justify-between gap-3">
                    <span>Masuk agar catatan konsumsi tersimpan permanen di akun Anda.</span>
                    <a href="{{ route('login') }}" class="px-3 py-1.5 rounded-lg bg-[#E54855] text-white font-bold shrink-0">Masuk</a>
                </div>
            @endguest

            <!-- Toggle Mode Bahan TKPI vs Manual -->
            <div class="grid grid-cols-2 gap-2 p-1 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-xs font-bold">
                <button type="button" wire:click="$set('isCustomFood', false)"
                        class="py-2 rounded-lg transition-colors cursor-pointer {{ !$isCustomFood ? 'bg-[#E54855] text-white' : 'text-[#777777] dark:text-[#AAA0A2]' }}">
                    Database TKPI
                </button>
                <button type="button" wire:click="$set('isCustomFood', true)"
                        class="py-2 rounded-lg transition-colors cursor-pointer {{ $isCustomFood ? 'bg-[#E54855] text-white' : 'text-[#777777] dark:text-[#AAA0A2]' }}">
                    Input Manual
                </button>
            </div>

            <form wire:submit.prevent="saveLog" class="space-y-4">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1">Tanggal</label>
                        <input type="date" wire:model.live="tanggal"
                               class="w-full px-3 py-2.5 rounded-xl text-sm bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1">Waktu Makan</label>
                        <select wire:model="waktu_makan"
                                class="w-full px-3 py-2.5 rounded-xl text-sm bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]">
                            <option value="Sarapan">Sarapan</option>
                            <option value="Makan Siang">Makan Siang</option>
                            <option value="Makan Malam">Makan Malam</option>
                            <option value="Camilan">Camilan</option>
                        </select>
                    </div>
                </div>

                @if(!$isCustomFood)
                    <!-- Searchable Food Source Dropdown -->
                    <div x-data="{
                            open: false,
                            selected: @entangle('sumber_makanan').live,
                            search: '',
                            sources: @js($foodSources->map(fn($s) => [
                                'name' => $s->name,
                                'label' => $s->name . ' (' . number_format($s->protein_per_100g, 1) . 'g P • ' . number_format($s->calories_per_100g, 0) . ' kkal)',
                            ])->values()->all()),
                            get filteredSources() {
                                if (!this.search.trim()) return this.sources;
                                const q = this.search.toLowerCase();
                                return this.sources.filter(s => s.label.toLowerCase().includes(q));
                            },
                            get selectedLabel() {
                                const found = this.sources.find(s => s.name === this.selected);
                                return found ? found.label : 'Pilih Sumber Makanan...';
                            }
                         }"
                         @click.away="open = false"
                         class="relative">
                        <label class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1">Bahan Makanan (per 100g TKPI)</label>
                        <button type="button" @click="open = !open"
                                class="w-full flex justify-between items-center px-3.5 py-2.5 rounded-xl text-sm bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5] text-left cursor-pointer">
                            <span x-text="selectedLabel" class="truncate font-medium"></span>
                            <svg class="w-4 h-4 text-[#777777] shrink-0 transition-transform" :class="open ? 'rotate-180 text-[#E54855]' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open" x-cloak
                             class="absolute z-40 w-full mt-1.5 bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] rounded-xl shadow-xl overflow-hidden flex flex-col max-h-60">
                            <div class="p-2 border-b border-[#E9E9EC] dark:border-[#342427]">
                                <input type="text" x-model="search" placeholder="Cari makanan TKPI..."
                                       class="w-full px-3 py-2 text-xs rounded-lg bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]">
                            </div>
                            <div class="overflow-y-auto divide-y divide-[#E9E9EC]/60 dark:divide-[#342427]/60">
                                <template x-for="src in filteredSources" :key="src.name">
                                    <button type="button" @click="selected = src.name; open = false; search = '';"
                                            class="w-full text-left px-3.5 py-2.5 text-xs font-semibold flex items-center justify-between hover:bg-[#F7F7F8] dark:hover:bg-[#251518]"
                                            :class="selected === src.name ? 'text-[#E54855] bg-[#E54855]/5' : 'text-[#202124] dark:text-[#F5F5F5]'">
                                        <span x-text="src.label"></span>
                                    </button>
                                </template>
                                <div x-show="filteredSources.length === 0" class="px-4 py-4 text-center text-xs text-[#777777]">
                                    Makanan tidak ditemukan.
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div>
                        <label class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1">Nama Makanan</label>
                        <input type="text" wire:model="custom_food_name" placeholder="Contoh: Nasi Goreng Ayam"
                               class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]">
                        @error('custom_food_name') <span class="text-xs text-[#E54855] font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-[#777777] dark:text-[#AAA0A2] mb-1">Protein (g)</label>
                            <input type="number" step="0.1" wire:model.live="custom_protein"
                                   class="w-full px-3 py-2 rounded-xl text-sm bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5]">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-[#777777] dark:text-[#AAA0A2] mb-1">Kalori (kkal)</label>
                            <input type="number" step="1" wire:model.live="custom_kalori"
                                   class="w-full px-3 py-2 rounded-xl text-sm bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5]">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-[#777777] dark:text-[#AAA0A2] mb-1">Lemak (g)</label>
                            <input type="number" step="0.1" wire:model.live="custom_lemak"
                                   class="w-full px-3 py-2 rounded-xl text-sm bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5]">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-[#777777] dark:text-[#AAA0A2] mb-1">Karbohidrat (g)</label>
                            <input type="number" step="0.1" wire:model.live="custom_karbo"
                                   class="w-full px-3 py-2 rounded-xl text-sm bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5]">
                        </div>
                    </div>
                @endif

                <div>
                    <label class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1">Berat Porsi (gram)</label>
                    <div class="relative">
                        <input type="number" step="0.5" wire:model.live="berat"
                               class="w-full px-3.5 py-2.5 pr-14 rounded-xl text-sm bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]">
                        <span class="absolute right-3.5 top-2.5 text-xs font-bold text-[#777777] dark:text-[#AAA0A2]">gram</span>
                    </div>
                    @error('berat') <span class="text-xs text-[#E54855] font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Live 4-Macro Calculation Preview -->
                <div class="grid grid-cols-4 gap-2 p-3 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-center">
                    <div>
                        <span class="block text-[10px] font-semibold text-[#777777] dark:text-[#AAA0A2]">Protein</span>
                        <span class="text-xs font-extrabold text-[#E54855]">{{ $macrosPreview['protein'] }}g</span>
                    </div>
                    <div>
                        <span class="block text-[10px] font-semibold text-[#777777] dark:text-[#AAA0A2]">Kalori</span>
                        <span class="text-xs font-extrabold text-[#202124] dark:text-[#F5F5F5]">{{ number_format($macrosPreview['kalori'], 0) }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] font-semibold text-[#777777] dark:text-[#AAA0A2]">Lemak</span>
                        <span class="text-xs font-extrabold text-[#202124] dark:text-[#F5F5F5]">{{ $macrosPreview['lemak'] }}g</span>
                    </div>
                    <div>
                        <span class="block text-[10px] font-semibold text-[#777777] dark:text-[#AAA0A2]">Karbo</span>
                        <span class="text-xs font-extrabold text-[#202124] dark:text-[#F5F5F5]">{{ $macrosPreview['karbohidrat'] }}g</span>
                    </div>
                </div>

                <div class="flex gap-2.5 pt-1">
                    @if($editingLogId)
                        <button type="button" wire:click="cancelEdit"
                                class="w-1/3 py-3 rounded-xl text-xs font-bold bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5] cursor-pointer">
                            Batal
                        </button>
                    @endif
                    <button type="submit" wire:loading.attr="disabled"
                            class="flex-1 py-3 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white text-sm font-bold shadow-sm transition-colors cursor-pointer">
                        <span wire:loading.remove wire:target="saveLog">{{ $editingLogId ? 'Perbarui Catatan' : 'Simpan Catatan Nutrisi' }}</span>
                        <span wire:loading wire:target="saveLog">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Right Card: Riwayat Nutrisi & Filter Tanggal (lg:col-span-7) -->
        <div class="lg:col-span-7 bg-white dark:bg-[#1A1012] rounded-3xl border border-[#E9E9EC] dark:border-[#342427] p-6 sm:p-7 shadow-sm space-y-5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-[#E9E9EC] dark:border-[#342427] pb-4">
                <div>
                    <h2 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">Riwayat Catatan Nutrisi</h2>
                    <p class="text-xs text-[#777777] dark:text-[#AAA0A2]">Data tersimpan permanen per akun pengguna</p>
                </div>

                <!-- Filter Rentang Riwayat -->
                <div class="flex flex-wrap gap-1.5 text-xs font-bold">
                    @foreach(['today' => 'Hari Ini', '7' => '7 Hari', '30' => '30 Hari', 'all' => 'Semua', 'custom' => 'Tanggal'] as $rKey => $rLabel)
                        <button type="button" wire:click="$set('historyRange', '{{ $rKey }}')"
                                class="px-3 py-1.5 rounded-lg transition-colors cursor-pointer {{ $historyRange === $rKey ? 'bg-[#E54855] text-white' : 'bg-[#F7F7F8] dark:bg-[#251518] text-[#777777] dark:text-[#AAA0A2] border border-[#E9E9EC] dark:border-[#342427]' }}">
                            {{ $rLabel }}
                        </button>
                    @endforeach
                </div>
            </div>

            @if($historyRange === 'custom')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-3.5 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427]">
                    <div>
                        <label class="block text-[11px] font-bold text-[#777777] dark:text-[#AAA0A2] mb-1">Dari Tanggal</label>
                        <input type="date" wire:model.live="historyFromDate" class="w-full px-3 py-2 rounded-lg text-xs bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-[#777777] dark:text-[#AAA0A2] mb-1">Sampai Tanggal</label>
                        <input type="date" wire:model.live="historyToDate" class="w-full px-3 py-2 rounded-lg text-xs bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427]">
                    </div>
                </div>
            @endif

            <!-- Ringkasan Filter -->
            @if($historyLogs->isNotEmpty())
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 p-3.5 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-xs">
                    <div>
                        <span class="block text-[10px] font-semibold text-[#777777] dark:text-[#AAA0A2]">Protein ({{ $historyLogs->count() }} log)</span>
                        <strong class="text-sm text-[#E54855]">{{ number_format($historyLogs->sum('jumlah_protein'), 1) }} g</strong>
                    </div>
                    <div>
                        <span class="block text-[10px] font-semibold text-[#777777] dark:text-[#AAA0A2]">Total Kalori</span>
                        <strong class="text-sm text-[#202124] dark:text-[#F5F5F5]">{{ number_format($historyLogs->sum('kalori'), 0) }} kkal</strong>
                    </div>
                    <div>
                        <span class="block text-[10px] font-semibold text-[#777777] dark:text-[#AAA0A2]">Total Lemak</span>
                        <strong class="text-sm text-[#202124] dark:text-[#F5F5F5]">{{ number_format($historyLogs->sum('lemak'), 1) }} g</strong>
                    </div>
                    <div>
                        <span class="block text-[10px] font-semibold text-[#777777] dark:text-[#AAA0A2]">Total Karbohidrat</span>
                        <strong class="text-sm text-[#202124] dark:text-[#F5F5F5]">{{ number_format($historyLogs->sum('karbohidrat'), 1) }} g</strong>
                    </div>
                </div>
            @endif

            <div class="overflow-x-auto rounded-2xl border border-[#E9E9EC] dark:border-[#342427]">
                <table class="w-full text-left text-xs sm:text-sm">
                    <thead class="bg-[#F7F7F8] dark:bg-[#251518] border-b border-[#E9E9EC] dark:border-[#342427] text-[#777777] dark:text-[#AAA0A2] text-xs">
                        <tr>
                            <th class="p-3.5 font-bold">Tanggal & Sesi</th>
                            <th class="p-3.5 font-bold">Makanan</th>
                            <th class="p-3.5 font-bold text-right">P (g)</th>
                            <th class="p-3.5 font-bold text-right">Kal</th>
                            <th class="p-3.5 font-bold text-right">L (g)</th>
                            <th class="p-3.5 font-bold text-right">K (g)</th>
                            <th class="p-3.5 font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E9E9EC] dark:divide-[#342427]">
                        @forelse($historyLogs as $log)
                            <tr wire:key="nutrition-log-{{ $log->id }}" class="hover:bg-[#F7F7F8]/80 dark:hover:bg-[#251518]/60 transition-colors">
                                <td class="p-3.5 whitespace-nowrap">
                                    <span class="font-bold text-[#202124] dark:text-[#F5F5F5] block">{{ \Carbon\Carbon::parse($log->tanggal)->format('d M Y') }}</span>
                                    <span class="text-[11px] text-[#777777] dark:text-[#AAA0A2]">{{ $log->waktu_makan ?? 'Harian' }}</span>
                                </td>
                                <td class="p-3.5">
                                    <span class="font-semibold text-[#202124] dark:text-[#F5F5F5] block">{{ $log->sumber_makanan }}</span>
                                    @if($log->berat_gram)
                                        <span class="text-[11px] text-[#777777] dark:text-[#AAA0A2]">{{ number_format($log->berat_gram, 0) }} g porsi</span>
                                    @endif
                                </td>
                                <td class="p-3.5 text-right font-extrabold text-[#E54855]">{{ number_format($log->jumlah_protein, 1) }}</td>
                                <td class="p-3.5 text-right font-semibold text-[#202124] dark:text-[#F5F5F5]">{{ number_format($log->kalori ?? 0, 0) }}</td>
                                <td class="p-3.5 text-right text-[#777777] dark:text-[#AAA0A2]">{{ number_format($log->lemak ?? 0, 1) }}</td>
                                <td class="p-3.5 text-right text-[#777777] dark:text-[#AAA0A2]">{{ number_format($log->karbohidrat ?? 0, 1) }}</td>
                                <td class="p-3.5 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5">
                                        <button type="button" wire:click="editLog({{ $log->id }})"
                                                class="px-2.5 py-1 rounded-lg bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] hover:border-[#E54855] text-xs font-bold text-[#202124] dark:text-[#F5F5F5] cursor-pointer">
                                            Edit
                                        </button>
                                        <button type="button" wire:click="deleteLog({{ $log->id }})"
                                                wire:confirm="Yakin ingin menghapus catatan nutrisi ini?"
                                                class="px-2.5 py-1 rounded-lg bg-[#E54855]/10 hover:bg-[#E54855] hover:text-white text-xs font-bold text-[#E54855] transition-colors cursor-pointer">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-10 text-center text-sm text-[#777777] dark:text-[#AAA0A2]">
                                    @guest
                                        Silakan masuk terlebih dahulu untuk melihat riwayat nutrisi pribadi Anda.
                                    @else
                                        Belum ada catatan konsumsi pada rentang waktu ini. Mulai catat makanan Anda di formulir sebelah kiri!
                                    @endguest
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 4. REFERENSI TKPI & CATATAN GIZI -->
    <section class="bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] rounded-3xl p-6 sm:p-8 shadow-sm">
        <h3 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5] mb-4 flex items-center gap-2">
            <span class="w-2 h-5 rounded-full bg-[#E54855] inline-block"></span>
            Referensi Ilmiah & Panduan TKPI
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-[#777777] dark:text-[#AAA0A2]">
            <div class="p-4 rounded-2xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] space-y-2">
                <h4 class="font-bold text-[#202124] dark:text-[#F5F5F5]">Standar TKPI Kemenkes RI</h4>
                <p class="leading-relaxed text-xs sm:text-sm">
                    Nilai protein, energi, lemak, dan karbohidrat per 100g pangan mengacu pada <em>Tabel Komposisi Pangan Indonesia</em> (TKPI) Kemenkes RI agar akurat dengan makanan sehari-hari Indonesia.
                </p>
                <span class="block text-[11px] font-semibold text-[#E54855]">Sumber: Kementerian Kesehatan Republik Indonesia</span>
            </div>
            <div class="p-4 rounded-2xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] space-y-2">
                <h4 class="font-bold text-[#202124] dark:text-[#F5F5F5]">Kebutuhan Protein Individu Aktif</h4>
                <p class="leading-relaxed text-xs sm:text-sm">
                    Individu aktif yang berlatih beban umumnya membutuhkan 1,6–2,0 g protein/kg berat badan (disesuaikan BBI), sisa energi dibagi seimbang ke lemak esensial dan karbohidrat.
                </p>
                <span class="block text-[11px] font-semibold text-[#E54855]">Sumber: dr. Dion Haryadi, PN1 & Alodokter</span>
            </div>
        </div>
    </section>
</div>
