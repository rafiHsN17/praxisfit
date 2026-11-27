<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-6 pb-20">

    <!-- HEADER BAR -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] p-5 sm:p-6 shadow-xs">
        <div class="space-y-1.5">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider bg-[#E54855]/10 text-[#E54855]">
                Smart Workout Program Generator
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-[#202124] dark:text-[#F5F5F5]">
                Buat Program <span class="text-[#E54855]">Latihan Otomatis</span>
            </h1>
            <p class="text-sm text-[#777777] dark:text-[#AAA0A2]">
                Susun satu paket program lengkap 1 minggu (7 hari) atau 1 bulan (28 hari) sesuai metode latihan, kemampuan, target otot, dan alat yang Anda miliki.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5 shrink-0">
            <a href="{{ route('workout.planner') }}" wire:navigate
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] hover:border-[#E54855] text-[#202124] dark:text-[#F5F5F5] border border-[#E9E9EC] dark:border-[#342427] text-xs sm:text-sm font-bold transition-colors">
                <span>Buka Rutinku &amp; Kalender</span>
                <span>&rarr;</span>
            </a>
        </div>
    </div>

    @if (session()->has('error'))
        <div class="p-4 rounded-xl bg-[#C93646]/15 border border-[#C93646]/40 text-[#C93646] dark:text-[#E54855] text-sm font-semibold">
            {{ session('error') }}
        </div>
    @endif

    @if($generationError)
        <div class="bg-white dark:bg-[#1A1012] rounded-2xl border-2 border-[#E54855] p-5 sm:p-6 space-y-3 shadow-sm">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#E54855]/10 text-[#E54855] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="space-y-1">
                    <h3 class="text-base font-extrabold text-[#202124] dark:text-[#F5F5F5]">Gerakan di Database Belum Mencukupi Kombinasi Filter</h3>
                    <p class="text-sm text-[#777777] dark:text-[#AAA0A2]">{{ $generationError['message'] }}</p>
                    <p class="text-xs font-bold text-[#E54855]">Gerakan tersedia yang cocok: {{ $generationError['available_count'] ?? 0 }}</p>
                </div>
            </div>

            @if(!empty($generationError['suggestions']))
                <ul class="list-disc list-inside text-xs sm:text-sm text-[#202124] dark:text-[#F5F5F5] space-y-1 pl-2">
                    @foreach($generationError['suggestions'] as $sug)
                        <li>{{ $sug }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif

    @if(!$previewData)
        <!-- FORM BUAT PROGRAM LATIHAN -->
        <form wire:submit="generateProgram" class="space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

                <!-- KOLOM KIRI (8 COLS): PARAMETER PROGRAM -->
                <div class="lg:col-span-8 space-y-5">

                    <!-- 1. Metode Latihan & Tingkat Kemampuan -->
                    <div class="bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] p-5 sm:p-6 space-y-5 shadow-xs">
                        <div>
                            <h2 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">1. Metode Latihan &amp; Kemampuan</h2>
                            <p class="text-xs text-[#777777] dark:text-[#AAA0A2] mt-0.5">
                                Setiap metode memiliki pendekatan set, repetisi, istirahat, dan urutan gerakan yang berbeda.
                            </p>
                        </div>

                        <!-- Nama Program Opsional -->
                        <div>
                            <label for="program-name" class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1.5">
                                Nama Program (Opsional)
                            </label>
                            <input id="program-name" type="text" wire:model="programName"
                                   placeholder="Otomatis dibuat jika dikosongkan (misal: Program Hipertrofi Pemula)"
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-sm text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]">
                        </div>

                        <!-- Metode Latihan Cards -->
                        <div>
                            <label class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-2">Pilih Metode Latihan</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                @php
                                    $methodDescriptions = [
                                        'hypertrophy' => 'Volume terarah untuk pertumbuhan massa otot.',
                                        'strength' => 'Prioritas gerakan utama untuk kekuatan maksimal.',
                                        'endurance' => 'Repetisi tinggi dengan jeda istirahat lebih singkat.',
                                        'conditioning' => 'Dukungan pembakaran kalori, kebugaran & fat loss.',
                                    ];
                                @endphp
                                @foreach($methodLabels as $key => $label)
                                    <button type="button" wire:click="$set('trainingMethod', '{{ $key }}')"
                                            class="p-3.5 rounded-xl border text-left transition-all cursor-pointer {{ $trainingMethod === $key ? 'bg-[#E54855]/10 border-[#E54855] ring-1 ring-[#E54855]' : 'bg-[#F7F7F8] dark:bg-[#251518] border-[#E9E9EC] dark:border-[#342427] hover:border-[#E54855]/50' }}">
                                        <div class="text-xs sm:text-sm font-extrabold {{ $trainingMethod === $key ? 'text-[#E54855]' : 'text-[#202124] dark:text-[#F5F5F5]' }}">
                                            {{ $label }}
                                        </div>
                                        <div class="text-[11px] text-[#777777] dark:text-[#AAA0A2] mt-0.5">
                                            {{ $methodDescriptions[$key] ?? '' }}
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                            @error('trainingMethod') <span class="text-xs text-[#E54855] mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Tingkat Kemampuan -->
                        <div>
                            <label class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-2">Tingkat Kemampuan</label>
                            <div class="grid grid-cols-3 gap-2.5">
                                @foreach($levelLabels as $lvlKey => $lvlLabel)
                                    <button type="button" wire:click="$set('level', '{{ $lvlKey }}')"
                                            class="py-2.5 px-3 rounded-xl border text-xs sm:text-sm font-bold text-center transition-all cursor-pointer {{ $level === $lvlKey ? 'bg-[#E54855] border-[#E54855] text-white shadow-xs' : 'bg-[#F7F7F8] dark:bg-[#251518] border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5] hover:border-[#E54855]/50' }}">
                                        {{ $lvlLabel }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- 2. Ketersediaan Peralatan & Target Otot -->
                    <div class="bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] p-5 sm:p-6 space-y-5 shadow-xs">
                        <div>
                            <h2 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">2. Peralatan &amp; Target Otot</h2>
                            <p class="text-xs text-[#777777] dark:text-[#AAA0A2] mt-0.5">
                                Pilihan metode latihan terpisah dari peralatan. Anda bisa memilih Hipertrofi Tanpa Alat maupun Dengan Alat.
                            </p>
                        </div>

                        <!-- Jenis Latihan: Tanpa Alat vs Dengan Alat -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <button type="button" wire:click="$set('equipmentMode', 'bodyweight')"
                                    class="p-4 rounded-xl border text-left transition-all cursor-pointer {{ $equipmentMode === 'bodyweight' ? 'bg-[#E54855]/10 border-[#E54855] ring-1 ring-[#E54855]' : 'bg-[#F7F7F8] dark:bg-[#251518] border-[#E9E9EC] dark:border-[#342427]' }}">
                                <div class="text-sm font-extrabold {{ $equipmentMode === 'bodyweight' ? 'text-[#E54855]' : 'text-[#202124] dark:text-[#F5F5F5]' }}">
                                    Tanpa Alat (Bodyweight)
                                </div>
                                <div class="text-xs text-[#777777] dark:text-[#AAA0A2] mt-0.5">
                                    Hanya gerakan bodyweight murni tanpa barbel, dumbbell, atau pull-up bar.
                                </div>
                            </button>

                            <button type="button" wire:click="$set('equipmentMode', 'with_equipment')"
                                    class="p-4 rounded-xl border text-left transition-all cursor-pointer {{ $equipmentMode === 'with_equipment' ? 'bg-[#E54855]/10 border-[#E54855] ring-1 ring-[#E54855]' : 'bg-[#F7F7F8] dark:bg-[#251518] border-[#E9E9EC] dark:border-[#342427]' }}">
                                <div class="text-sm font-extrabold {{ $equipmentMode === 'with_equipment' ? 'text-[#E54855]' : 'text-[#202124] dark:text-[#F5F5F5]' }}">
                                    Dengan Alat (Multi-Select)
                                </div>
                                <div class="text-xs text-[#777777] dark:text-[#AAA0A2] mt-0.5">
                                    Pilih alat yang benar-benar Anda miliki atau tersedia di tempat latihan.
                                </div>
                            </button>
                        </div>

                        <!-- Multi-Select Peralatan (Hanya muncul saat Dengan Alat) -->
                        @if($equipmentMode === 'with_equipment')
                            <div class="p-4 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] space-y-2.5">
                                <label class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5]">
                                    Pilih Peralatan yang Tersedia ({{ count($selectedEquipments) }} dipilih)
                                </label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($equipmentOptions as $equip)
                                        @php $isPicked = in_array($equip, $selectedEquipments, true); @endphp
                                        <button type="button" wire:click="toggleEquipment('{{ $equip }}')"
                                                class="px-3 py-1.5 rounded-xl text-xs font-bold border transition-colors cursor-pointer {{ $isPicked ? 'bg-[#E54855] border-[#E54855] text-white' : 'bg-white dark:bg-[#1A1012] border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5] hover:border-[#E54855]' }}">
                                            {{ $isPicked ? '✓ ' : '+ ' }}{{ $equip }}
                                        </button>
                                    @endforeach
                                </div>
                                @error('selectedEquipments') <span class="text-xs text-[#E54855] font-semibold block">{{ $message }}</span> @enderror
                            </div>
                        @endif

                        <!-- Target Kelompok Otot -->
                        <div>
                            <label class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-2">
                                Target Kelompok Otot (Bisa Pilih Kombinasi)
                            </label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($targetMuscleOptions as $mKey => $mLabel)
                                    @php $isMusclePicked = in_array($mKey, $targetMuscles, true); @endphp
                                    <button type="button" wire:click="toggleTargetMuscle('{{ $mKey }}')"
                                            class="px-3.5 py-2 rounded-xl text-xs font-bold border transition-colors cursor-pointer {{ $isMusclePicked ? 'bg-[#E54855] border-[#E54855] text-white shadow-xs' : 'bg-[#F7F7F8] dark:bg-[#251518] border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5] hover:border-[#E54855]' }}">
                                        {{ $mLabel }}
                                    </button>
                                @endforeach
                            </div>
                            @error('targetMuscles') <span class="text-xs text-[#E54855] mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- 3. Preferensi Tambahan (Cari Gerakan dari Database) -->
                    <div class="bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] p-5 sm:p-6 space-y-4 shadow-xs">
                        <h2 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">3. Preferensi Tambahan (Opsional)</h2>
                        <div class="space-y-3">
                            <div class="space-y-2.5">
                                <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2]">Cari Gerakan yang Ingin Dihindari (Database)</label>
                                <div class="relative">
                                    <svg class="w-4 h-4 text-[#777777] dark:text-[#AAA0A2] absolute left-3.5 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    <input type="text" wire:model.live.debounce.250ms="avoidSearch"
                                           placeholder="Cari nama gerakan atau otot (cth: Burpee, Squat, Dada)..."
                                           class="w-full pl-10 pr-3.5 py-2.5 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-sm text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]">
                                </div>

                                @if($excludedExercisesList->isNotEmpty())
                                    <div class="flex flex-wrap gap-1.5 pt-1">
                                        @foreach($excludedExercisesList as $exItem)
                                            <button type="button" wire:click="toggleExcludedExercise({{ $exItem->id }})"
                                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-[#E54855]/10 text-[#E54855] border border-[#E54855]/30 text-xs font-bold cursor-pointer hover:bg-[#E54855] hover:text-white transition-colors">
                                                <span>{{ $exItem->name }}</span>
                                                <span>&times;</span>
                                            </button>
                                        @endforeach
                                    </div>
                                @endif

                                @if(trim($avoidSearch) !== '')
                                    <div class="max-h-48 overflow-y-auto rounded-xl border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#251518] divide-y divide-[#E9E9EC] dark:divide-[#342427]">
                                        @forelse($avoidSearchResults as $res)
                                            @php $isExcluded = in_array($res->id, $excludedExerciseIds, true); @endphp
                                            <button type="button" wire:click="toggleExcludedExercise({{ $res->id }})"
                                                    class="w-full px-3 py-2 flex items-center justify-between gap-2.5 text-left hover:bg-white dark:hover:bg-[#1A1012] transition-colors cursor-pointer">
                                                <div class="flex items-center gap-2.5 min-w-0">
                                                    @if($res->image_1 || $res->icon)
                                                        <img src="{{ $res->image_1 ?? $res->icon }}" alt="{{ $res->name }}" class="w-8 h-8 rounded-lg object-contain bg-white dark:bg-[#100809] p-0.5 shrink-0">
                                                    @endif
                                                    <div class="min-w-0">
                                                        <div class="text-xs font-bold text-[#202124] dark:text-[#F5F5F5] truncate">{{ $res->name }}</div>
                                                        <div class="text-[10px] text-[#777777] dark:text-[#AAA0A2]">{{ $res->target_muscle }} &bull; {{ $res->equipment ?? 'Bodyweight' }}</div>
                                                    </div>
                                                </div>
                                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold shrink-0 {{ $isExcluded ? 'bg-[#E54855] text-white' : 'bg-white dark:bg-[#1A1012] text-[#E54855] border border-[#E9E9EC] dark:border-[#342427]' }}">
                                                    {{ $isExcluded ? 'Dihindari ✓' : 'Hindari' }}
                                                </span>
                                            </button>
                                        @empty
                                            <p class="p-3 text-xs text-[#777777] dark:text-[#AAA0A2] text-center">Gerakan tidak ditemukan di database.</p>
                                        @endforelse
                                    </div>
                                @endif
                            </div>

                            <!-- Evaluasi Kelelahan / Kondisi Tubuh Saat Ini (Section 9) -->
                            <div class="pt-2 border-t border-[#E9E9EC] dark:border-[#342427] flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                <div>
                                    <span class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5]">Kondisi Kelelahan Saat Ini</span>
                                    <span class="text-[11px] text-[#777777] dark:text-[#AAA0A2]">Jika tubuh terasa lelah atau sulit menyelesaikan target sebelumnya, volume otomatis diturunkan.</span>
                                </div>
                                <div class="inline-flex p-1 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] shrink-0">
                                    <button type="button" wire:click="$set('fatigueStatus', 'normal')"
                                            class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors cursor-pointer {{ $fatigueStatus === 'normal' ? 'bg-[#E54855] text-white' : 'text-[#777777] dark:text-[#AAA0A2]' }}">
                                        Bugar / Normal
                                    </button>
                                    <button type="button" wire:click="$set('fatigueStatus', 'fatigued')"
                                            class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors cursor-pointer {{ $fatigueStatus === 'fatigued' ? 'bg-[#E54855] text-white' : 'text-[#777777] dark:text-[#AAA0A2]' }}">
                                        Perlu Deload
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- KOLOM KANAN (4 COLS): JADWAL, DURASI & TOMBOL GENERATE -->
                <div class="lg:col-span-4 space-y-5 lg:sticky lg:top-24">
                    <div class="bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] p-5 sm:p-6 space-y-4 shadow-xs">
                        <h2 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">4. Jadwal &amp; Durasi</h2>

                        <!-- Frekuensi -->
                        <div>
                            <label class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1.5">Frekuensi Latihan</label>
                            <select wire:model="frequencyPerWeek"
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-sm font-semibold text-[#202124] dark:text-[#F5F5F5]">
                                <option value="2">2 hari per minggu</option>
                                <option value="3">3 hari per minggu</option>
                                <option value="4">4 hari per minggu</option>
                                <option value="5">5 hari per minggu</option>
                                <option value="6">6 hari per minggu</option>
                            </select>
                        </div>

                        <!-- Durasi per Sesi -->
                        <div>
                            <label class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1.5">Durasi Setiap Sesi</label>
                            <div class="grid grid-cols-5 gap-1.5">
                                @foreach([20, 30, 45, 60, 90] as $mins)
                                    <button type="button" wire:click="$set('sessionDurationMinutes', {{ $mins }})"
                                            class="py-2 rounded-xl border text-xs font-bold transition-colors cursor-pointer {{ (int) $sessionDurationMinutes === $mins ? 'bg-[#E54855] border-[#E54855] text-white' : 'bg-[#F7F7F8] dark:bg-[#251518] border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5]' }}">
                                        {{ $mins }}m
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Durasi Program -->
                        <div>
                            <label class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1.5">Durasi Program</label>
                            <div class="grid grid-cols-2 gap-2.5">
                                <button type="button" wire:click="$set('programDuration', '1_week')"
                                        class="p-3 rounded-xl border text-left transition-colors cursor-pointer {{ $programDuration === '1_week' ? 'bg-[#E54855]/10 border-[#E54855] text-[#E54855]' : 'bg-[#F7F7F8] dark:bg-[#251518] border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5]' }}">
                                    <div class="text-sm font-extrabold">1 Minggu</div>
                                    <div class="text-[11px] opacity-80">7 Hari Terjadwal</div>
                                </button>
                                <button type="button" wire:click="$set('programDuration', '1_month')"
                                        class="p-3 rounded-xl border text-left transition-colors cursor-pointer {{ $programDuration === '1_month' ? 'bg-[#E54855]/10 border-[#E54855] text-[#E54855]' : 'bg-[#F7F7F8] dark:bg-[#251518] border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5]' }}">
                                    <div class="text-sm font-extrabold">1 Bulan</div>
                                    <div class="text-[11px] opacity-80">4 Minggu (28 Hari)</div>
                                </button>
                            </div>
                        </div>

                        <!-- Tanggal Mulai -->
                        <div>
                            <label for="program-start-date" class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1.5">Tanggal Mulai</label>
                            <input id="program-start-date" type="date" wire:model="startDate" required
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-sm font-semibold text-[#202124] dark:text-[#F5F5F5]">
                            @error('startDate') <span class="text-xs text-[#E54855] mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Disclaimer Keamanan -->
                        <div class="p-3.5 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-[11px] text-[#777777] dark:text-[#AAA0A2] leading-relaxed">
                            <strong class="text-[#202124] dark:text-[#F5F5F5] block mb-0.5">Catatan Keamanan Kebugaran:</strong>
                            Rekomendasi program merupakan panduan umum kebugaran, bukan pengganti evaluasi medis/profesional. Hentikan latihan jika timbul nyeri tidak wajar.
                        </div>

                        <button type="submit" wire:loading.attr="disabled"
                                class="w-full py-3.5 px-5 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white font-extrabold text-sm shadow-md shadow-[#E54855]/25 transition-all cursor-pointer disabled:opacity-60">
                            <span wire:loading.remove wire:target="generateProgram">Susun Program Latihan Sekarang &rarr;</span>
                            <span wire:loading wire:target="generateProgram">Menyusun Program...</span>
                        </button>
                    </div>
                </div>

            </div>
        </form>
    @else
        <!-- HALAMAN PREVIEW PROGRAM (SECTIONS A - E) -->
        @php
            $pInfo = $previewData['program'];
            $allDays = $previewData['days'];
            $visibleDays = collect($allDays)->filter(fn ($d) => (int) $d['week_number'] === $selectedWeekFilter)->values();
            $activePreviewDay = $allDays[$selectedDayIndex] ?? $allDays[0] ?? null;
        @endphp

        <div class="space-y-6">

            <!-- A. INFORMASI PROGRAM & B. RINGKASAN PROGRAM + TOMBOL AKSI -->
            <div class="bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] p-5 sm:p-6 space-y-5 shadow-xs">
                <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4 border-b border-[#E9E9EC] dark:border-[#342427] pb-5">
                    <div class="space-y-2 flex-1">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider bg-[#E54855]/10 text-[#E54855]">
                            Preview Program Latihan
                        </span>
                        <input type="text" wire:model="previewData.program.name"
                               class="w-full text-xl sm:text-2xl font-extrabold text-[#202124] dark:text-[#F5F5F5] bg-transparent border-b border-dashed border-[#E9E9EC] dark:border-[#342427] focus:outline-none focus:border-[#E54855] pb-1">
                        <div class="flex flex-wrap gap-2 pt-1 text-xs">
                            <span class="px-2.5 py-1 rounded-lg bg-[#E54855]/10 text-[#E54855] font-bold">{{ $pInfo['method_label'] }}</span>
                            <span class="px-2.5 py-1 rounded-lg bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] font-semibold">{{ $pInfo['level_label'] }}</span>
                            <span class="px-2.5 py-1 rounded-lg bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] font-semibold">{{ $pInfo['equipment_label'] }}</span>
                            <span class="px-2.5 py-1 rounded-lg bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] font-semibold">Target: {{ $pInfo['target_label'] }}</span>
                            <span class="px-2.5 py-1 rounded-lg bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] font-semibold">{{ $pInfo['duration_label'] }} &bull; {{ $pInfo['frequency_per_week'] }}x/minggu</span>
                        </div>
                    </div>

                    <!-- Tombol Aksi Preview -->
                    <div class="flex flex-wrap items-center gap-2.5 shrink-0">
                        <button type="button" wire:click="cancelPreview"
                                class="px-4 py-2.5 rounded-xl bg-[#F1F1F4] dark:bg-[#251518] hover:bg-[#E9E9EC] text-xs sm:text-sm font-bold text-[#777777] dark:text-[#AAA0A2] cursor-pointer">
                            Batalkan
                        </button>
                        <button type="button" wire:click="editProgramSettings"
                                class="px-4 py-2.5 rounded-xl bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] hover:border-[#E54855] text-xs sm:text-sm font-bold text-[#202124] dark:text-[#F5F5F5] cursor-pointer">
                            Edit Pengaturan
                        </button>
                        <button type="button" wire:click="attemptSaveProgram"
                                class="px-5 py-2.5 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white text-xs sm:text-sm font-extrabold shadow-md shadow-[#E54855]/25 cursor-pointer">
                            Simpan Program ke Rutinku &rarr;
                        </button>
                    </div>
                </div>

                <!-- B. Ringkasan Program -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div class="p-3.5 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427]">
                        <span class="block text-[11px] font-bold uppercase text-[#777777] dark:text-[#AAA0A2]">Total Hari Latihan</span>
                        <span class="text-xl font-extrabold text-[#E54855]">{{ $pInfo['total_workout_days'] }} Hari</span>
                    </div>
                    <div class="p-3.5 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427]">
                        <span class="block text-[11px] font-bold uppercase text-[#777777] dark:text-[#AAA0A2]">Total Hari Istirahat</span>
                        <span class="text-xl font-extrabold text-[#202124] dark:text-[#F5F5F5]">{{ $pInfo['total_rest_days'] }} Hari</span>
                    </div>
                    <div class="p-3.5 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427]">
                        <span class="block text-[11px] font-bold uppercase text-[#777777] dark:text-[#AAA0A2]">Total Sesi Gerakan</span>
                        <span class="text-xl font-extrabold text-[#202124] dark:text-[#F5F5F5]">{{ $pInfo['total_exercises'] }} Gerakan</span>
                    </div>
                    <div class="p-3.5 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427]">
                        <span class="block text-[11px] font-bold uppercase text-[#777777] dark:text-[#AAA0A2]">Estimasi per Sesi</span>
                        <span class="text-xl font-extrabold text-[#202124] dark:text-[#F5F5F5]">{{ $pInfo['session_duration_minutes'] }} Menit</span>
                    </div>
                </div>

                @if(!empty($pInfo['safety_notes']))
                    <div class="p-3.5 rounded-xl bg-[#E54855]/8 border border-[#E54855]/25 text-xs text-[#202124] dark:text-[#F5F5F5] leading-relaxed">
                        <strong class="text-[#E54855]">Panduan Keamanan:</strong> {{ $pInfo['safety_notes'] }}
                    </div>
                @endif

                @if(!empty($pInfo['recovery_disclaimer']))
                    <p class="text-[11px] text-[#777777] dark:text-[#AAA0A2]">
                        {{ $pInfo['recovery_disclaimer'] }}
                    </p>
                @endif
            </div>

            <!-- C. KALENDER PROGRAM & D. DETAIL SETIAP HARI -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

                <!-- Kalender Jadwal Program (5 cols) -->
                <div class="lg:col-span-5 bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] p-5 space-y-4 shadow-xs">
                    <div class="flex items-center justify-between gap-2">
                        <h3 class="text-base font-extrabold text-[#202124] dark:text-[#F5F5F5]">Kalender Program</h3>
                        @if($pInfo['total_weeks'] > 1)
                            <div class="flex items-center gap-1">
                                @for($w = 1; $w <= $pInfo['total_weeks']; $w++)
                                    <button type="button" wire:click="selectWeekFilter({{ $w }})"
                                            class="px-2.5 py-1 rounded-lg text-xs font-bold border transition-colors cursor-pointer {{ $selectedWeekFilter === $w ? 'bg-[#E54855] border-[#E54855] text-white' : 'bg-[#F7F7F8] dark:bg-[#251518] border-[#E9E9EC] dark:border-[#342427] text-[#777777] dark:text-[#AAA0A2]' }}">
                                        M{{ $w }}
                                    </button>
                                @endfor
                            </div>
                        @endif
                    </div>

                    <div class="space-y-2">
                        @foreach($allDays as $dayIdx => $d)
                            @if((int) $d['week_number'] === $selectedWeekFilter)
                                @php
                                    $isSelected = $dayIdx === $selectedDayIndex;
                                    $isWorkout = $d['day_type'] === \App\Models\WorkoutProgramDay::TYPE_WORKOUT;
                                @endphp
                                <button type="button" wire:click="selectPreviewDay({{ $dayIdx }})"
                                        class="w-full p-3.5 rounded-xl border text-left transition-all flex items-center justify-between gap-3 cursor-pointer {{ $isSelected ? 'bg-[#E54855] border-[#E54855] text-white shadow-sm' : 'bg-[#F7F7F8] dark:bg-[#251518] border-[#E9E9EC] dark:border-[#342427] hover:border-[#E54855]/60' }}">
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <span class="text-[11px] font-extrabold uppercase {{ $isSelected ? 'text-white/90' : 'text-[#E54855]' }}">
                                                Hari {{ $d['day_number'] }} &bull; {{ $d['day_name'] }}
                                            </span>
                                            <span class="text-[10px] px-2 py-0.5 rounded-md font-bold {{ $isSelected ? 'bg-white/20 text-white' : ($isWorkout ? 'bg-[#E54855]/10 text-[#E54855]' : 'bg-white dark:bg-[#1A1012] text-[#777777]') }}">
                                                {{ $isWorkout ? 'Workout' : 'Rest' }}
                                            </span>
                                        </div>
                                        <div class="text-sm font-bold truncate mt-0.5 {{ $isSelected ? 'text-white' : 'text-[#202124] dark:text-[#F5F5F5]' }}">
                                            {{ $d['focus_label'] }}
                                        </div>
                                        <div class="text-[11px] {{ $isSelected ? 'text-white/80' : 'text-[#777777] dark:text-[#AAA0A2]' }}">
                                            {{ $d['scheduled_date_label'] }}
                                        </div>
                                    </div>
                                    <span class="text-xs font-bold shrink-0 {{ $isSelected ? 'text-white' : 'text-[#777777] dark:text-[#AAA0A2]' }}">
                                        {{ $isWorkout ? count($d['exercises']) . ' Gerakan' : 'Istirahat' }}
                                    </span>
                                </button>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- D & E. Detail Hari Terpilih & Detail Gerakan (7 cols) -->
                <div class="lg:col-span-7 bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] p-5 sm:p-6 space-y-5 shadow-xs">
                    @if($activePreviewDay)
                        <div class="border-b border-[#E9E9EC] dark:border-[#342427] pb-4 space-y-2.5">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="px-2.5 py-0.5 rounded-md bg-[#E54855]/10 text-[#E54855] text-[11px] font-extrabold uppercase">
                                        Minggu {{ $activePreviewDay['week_number'] }} &bull; Fase {{ $activePreviewDay['week_phase'] }}
                                    </span>
                                    <span class="text-xs font-semibold text-[#777777] dark:text-[#AAA0A2]">
                                        {{ $activePreviewDay['scheduled_date_label'] }}
                                    </span>
                                </div>
                                @if(!empty($activePreviewDay['recovery_status']))
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $activePreviewDay['recovery_status'] === 'Jadwal bertabrakan' ? 'bg-[#C93646] text-white border-[#C93646]' : ($activePreviewDay['recovery_status'] === 'Perlu pemulihan tambahan' ? 'bg-[#E54855]/15 text-[#E54855] border-[#E54855]/40' : 'bg-[#F7F7F8] dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] border-[#E9E9EC] dark:border-[#342427]') }}">
                                        {{ $activePreviewDay['recovery_status'] }}
                                    </span>
                                @endif
                            </div>

                            <div>
                                <h3 class="text-xl font-extrabold text-[#202124] dark:text-[#F5F5F5]">
                                    {{ $activePreviewDay['focus_label'] }}
                                </h3>
                                <p class="text-xs text-[#777777] dark:text-[#AAA0A2] mt-1">
                                    {{ $activePreviewDay['notes'] }}
                                </p>
                                @if(!empty($activePreviewDay['placement_reason']))
                                    <p class="text-[11px] text-[#E54855] font-semibold mt-1">
                                        Alasan Penempatan: {{ $activePreviewDay['placement_reason'] }}
                                    </p>
                                @endif
                            </div>

                            <!-- Informasi Pemulihan Otot per Hari (Section 10) -->
                            @if(!empty($activePreviewDay['recovery_summary']))
                                <div class="pt-2">
                                    <span class="block text-[11px] font-bold uppercase tracking-wider text-[#777777] dark:text-[#AAA0A2] mb-2">
                                        Status Pemulihan Kelompok Otot (Jeda 48–72 Jam)
                                    </span>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                        @foreach($activePreviewDay['recovery_summary'] as $rec)
                                            <div class="p-2.5 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-[11px] space-y-0.5">
                                                <div class="flex items-center justify-between gap-2">
                                                    <strong class="text-[#202124] dark:text-[#F5F5F5] uppercase">{{ $rec['muscle'] }}</strong>
                                                    <span class="font-bold text-[#E54855]">{{ $rec['status'] }}</span>
                                                </div>
                                                <div class="text-[#777777] dark:text-[#AAA0A2]">
                                                    Terakhir: {{ $rec['last_trained'] }}
                                                    @if($rec['hours_elapsed'] !== null)
                                                        &bull; Jeda: {{ $rec['hours_elapsed'] }} jam
                                                    @endif
                                                </div>
                                                <div class="text-[#777777] dark:text-[#AAA0A2]">
                                                    Peran: {{ $rec['role'] === 'primary' ? 'Otot Primer' : 'Sekunder' }} ({{ ucfirst($rec['stimulus']) }} Stimulus) &bull; {{ $rec['total_sets'] }} set
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if($activePreviewDay['day_type'] === \App\Models\WorkoutProgramDay::TYPE_REST)
                            <div class="py-10 text-center rounded-2xl bg-[#F7F7F8] dark:bg-[#251518] border border-dashed border-[#E9E9EC] dark:border-[#342427] p-6 space-y-2">
                                <h4 class="text-base font-extrabold text-[#202124] dark:text-[#F5F5F5]">Hari Istirahat &amp; Pemulihan</h4>
                                <p class="text-xs sm:text-sm text-[#777777] dark:text-[#AAA0A2] max-w-md mx-auto">
                                    Pemulihan otot sama pentingnya dengan sesi latihan. Pastikan tidur cukup, hidrasi terjaga, dan penuhi asupan protein harian Anda.
                                </p>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($activePreviewDay['exercises'] as $exIdx => $exItem)
                                    <div wire:key="preview-ex-{{ $selectedDayIndex }}-{{ $exIdx }}"
                                         class="p-4 rounded-2xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] space-y-3">
                                        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                                            <div class="flex items-start gap-3.5 min-w-0">
                                                @if(!empty($exItem['image']))
                                                    <div class="w-20 h-20 rounded-xl bg-white dark:bg-[#100809] border border-[#E9E9EC] dark:border-[#342427] p-1.5 flex items-center justify-center shrink-0">
                                                        <img src="{{ $exItem['image'] }}" alt="{{ $exItem['name'] }}" class="w-full h-full object-contain">
                                                    </div>
                                                @endif
                                                <div class="min-w-0 space-y-1">
                                                    <div class="flex flex-wrap items-center gap-1.5">
                                                        <span class="px-2 py-0.5 rounded bg-[#E54855] text-white text-[10px] font-extrabold">#{{ $exItem['sort_order'] }}</span>
                                                        <span class="px-2 py-0.5 rounded bg-[#E54855]/10 text-[#E54855] text-[10px] font-bold uppercase">{{ $exItem['target_muscle'] }}</span>
                                                        <span class="px-2 py-0.5 rounded bg-white dark:bg-[#1A1012] text-[#777777] dark:text-[#AAA0A2] text-[10px] font-semibold">{{ $exItem['equipment'] }}</span>
                                                        <span class="px-2 py-0.5 rounded bg-white dark:bg-[#1A1012] text-[#777777] dark:text-[#AAA0A2] text-[10px] font-semibold">{{ $exItem['difficulty'] }}</span>
                                                    </div>
                                                    <h4 class="text-base font-extrabold text-[#202124] dark:text-[#F5F5F5]">
                                                        {{ $exItem['name'] }}
                                                    </h4>
                                                    <div class="flex flex-wrap items-center gap-3 text-xs font-bold text-[#202124] dark:text-[#F5F5F5]">
                                                        <span>{{ $exItem['target_sets'] }} Set</span>
                                                        <span>&bull;</span>
                                                        <span class="text-[#E54855]">{{ $exItem['target_reps'] }}{{ $exItem['is_duration_based'] ? '' : ' Reps' }}</span>
                                                        <span>&bull;</span>
                                                        <span>Istirahat {{ $exItem['rest_seconds'] }} detik</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="button" wire:click="openSubstituteModal({{ $selectedDayIndex }}, {{ $exIdx }})"
                                                    class="px-3 py-1.5 rounded-xl bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] hover:border-[#E54855] text-xs font-bold text-[#E54855] shrink-0 cursor-pointer">
                                                Ganti Gerakan
                                            </button>
                                        </div>

                                        @if(!empty($exItem['intensity_note']) || !empty($exItem['progression_note']) || !empty($exItem['secondary_muscles']))
                                            <div class="text-[11px] text-[#777777] dark:text-[#AAA0A2] space-y-1 bg-white dark:bg-[#1A1012] p-2.5 rounded-xl border border-[#E9E9EC] dark:border-[#342427]">
                                                <div>
                                                    <strong class="text-[#202124] dark:text-[#F5F5F5]">Otot Primer:</strong> {{ $exItem['primary_muscle'] ?? $exItem['target_muscle'] }} ({{ ucfirst($exItem['stimulus_level'] ?? 'high') }} Stimulus)
                                                    @if(!empty($exItem['secondary_muscles']))
                                                        &bull; <strong class="text-[#202124] dark:text-[#F5F5F5]">Sekunder:</strong>
                                                        {{ collect($exItem['secondary_muscles'])->map(fn ($s) => $s['sub_muscle'] . ' (' . $s['stimulus'] . ')')->implode(', ') }}
                                                    @endif
                                                </div>
                                                @if(!empty($exItem['intensity_note']))
                                                    <div><strong class="text-[#202124] dark:text-[#F5F5F5]">Intensitas:</strong> {{ $exItem['intensity_note'] }}</div>
                                                @endif
                                                @if(!empty($exItem['progression_note']))
                                                    <div><strong class="text-[#E54855]">Progres:</strong> {{ $exItem['progression_note'] }}</div>
                                                @endif
                                            </div>
                                        @endif

                                        @if(!empty($exItem['instructions']))
                                            <details class="text-xs text-[#777777] dark:text-[#AAA0A2]">
                                                <summary class="font-bold text-[#202124] dark:text-[#F5F5F5] cursor-pointer hover:text-[#E54855]">
                                                    Lihat Instruksi Gerakan
                                                </summary>
                                                <p class="mt-2 leading-relaxed">{{ $exItem['instructions'] }}</p>
                                            </details>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endif
                </div>

            </div>
        </div>
    @endif

    <!-- MODAL GANTI GERAKAN (COMPATIBLE SUBSTITUTES) -->
    @if($replaceDayIndex !== null)
        <div class="fixed inset-0 z-[130] flex items-center justify-center p-4 bg-black/75 backdrop-blur-xs">
            <div class="w-full max-w-xl bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] shadow-2xl max-h-[85vh] flex flex-col overflow-hidden">
                <div class="p-5 border-b border-[#E9E9EC] dark:border-[#342427] flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">Pilih Gerakan Pengganti</h3>
                        <p class="text-xs text-[#777777] dark:text-[#AAA0A2]">Hanya menampilkan gerakan yang sesuai peralatan, level, dan otot target.</p>
                    </div>
                    <button type="button" wire:click="closeSubstituteModal" class="p-1.5 text-[#777777] hover:text-[#E54855] cursor-pointer">&times;</button>
                </div>

                <div class="p-5 overflow-y-auto space-y-2.5 flex-1">
                    @forelse($substituteOptions as $opt)
                        <div class="p-3 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3 min-w-0">
                                @if(!empty($opt['image']))
                                    <div class="w-14 h-14 rounded-lg bg-white dark:bg-[#100809] border border-[#E9E9EC] dark:border-[#342427] p-1 flex items-center justify-center shrink-0">
                                        <img src="{{ $opt['image'] }}" alt="{{ $opt['name'] }}" class="w-full h-full object-contain">
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <div class="text-sm font-bold text-[#202124] dark:text-[#F5F5F5] truncate">{{ $opt['name'] }}</div>
                                    <div class="text-[11px] text-[#777777] dark:text-[#AAA0A2]">
                                        {{ $opt['target_muscle'] }} &bull; {{ $opt['equipment'] }} &bull; {{ $opt['difficulty'] }}
                                    </div>
                                </div>
                            </div>
                            <button type="button" wire:click="applySubstitute({{ $opt['id'] }})"
                                    class="px-3.5 py-2 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white text-xs font-bold shrink-0 cursor-pointer">
                                Pilih
                            </button>
                        </div>
                    @empty
                        <p class="text-sm text-[#777777] dark:text-[#AAA0A2] text-center py-6">Tidak ada gerakan pengganti lain yang memenuhi filter alat dan level saat ini.</p>
                    @endforelse
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL KONFIRMASI PROGRAM AKTIF SUDAH ADA -->
    @if($showActiveConflictModal)
        <div class="fixed inset-0 z-[135] flex items-center justify-center p-4 bg-black/75 backdrop-blur-xs">
            <div class="w-full max-w-md bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] shadow-2xl overflow-hidden">
                <div class="h-1.5 bg-[#E54855] w-full"></div>
                <div class="p-6 space-y-4">
                    <h3 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">Program Aktif Sudah Ada</h3>
                    <p class="text-sm text-[#777777] dark:text-[#AAA0A2] leading-relaxed">
                        Anda saat ini memiliki program aktif: <strong class="text-[#202124] dark:text-[#F5F5F5]">{{ $existingActiveProgramName }}</strong>.
                        Jika Anda menyimpan program baru ini, program sebelumnya akan diarsipkan sebagai riwayat tanpa menghapus jadwal atau riwayat latihan yang sudah tercatat.
                    </p>
                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-2.5 pt-3 border-t border-[#E9E9EC] dark:border-[#342427]">
                        <button type="button" wire:click="cancelActiveConflictModal"
                                class="px-4 py-2.5 rounded-xl bg-[#F1F1F4] dark:bg-[#251518] text-sm font-semibold text-[#202124] dark:text-[#F5F5F5] cursor-pointer">
                            Batal
                        </button>
                        <button type="button" wire:click="confirmSaveProgram"
                                class="px-5 py-2.5 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white text-sm font-bold cursor-pointer">
                            Aktifkan Program Baru
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>

