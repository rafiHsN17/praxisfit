<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-2 pb-16 space-y-6">
    <div class="bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider bg-[#E54855]/10 text-[#E54855] mb-1.5">
                Pengaturan Akun &amp; Fisik
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#202124] dark:text-[#F5F5F5] tracking-tight">
                Profil &amp; <span class="text-[#E54855]">Tujuan Latihan</span>
            </h1>
            <p class="text-sm text-[#777777] dark:text-[#AAA0A2] mt-1">
                Lengkapi data fisik untuk personalisasi jadwal rutinitas mingguan PraxisFit.
            </p>
        </div>
        <div class="shrink-0 flex items-center gap-2 text-xs font-bold px-3.5 py-2 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5]">
            <span class="w-2 h-2 rounded-full bg-[#E54855]"></span>
            <span>{{ Auth::user()->name }}</span>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="p-4 bg-[#E54855]/10 text-[#C93646] dark:text-[#E54855] rounded-xl border border-[#E54855]/30 text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
        <!-- Form Data Fisik -->
        <div class="bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] rounded-2xl p-6 shadow-xs">
            <h2 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5] mb-5 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-[#E54855]/10 text-[#E54855] flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </span>
                Data Fisik
            </h2>

            <form wire:submit.prevent="saveProfile" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1.5">Jenis Kelamin</label>
                    <select wire:model="gender" class="w-full px-3.5 py-2.5 rounded-xl border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#251518] text-sm text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]">
                        <option value="">Pilih</option>
                        <option value="M">Laki-laki</option>
                        <option value="F">Perempuan</option>
                    </select>
                    @error('gender') <span class="text-[#E54855] text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1.5">Tinggi Badan (cm)</label>
                        <input type="number" step="0.1" wire:model="height" class="w-full px-3.5 py-2.5 rounded-xl border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#251518] text-sm text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]">
                        @error('height') <span class="text-[#E54855] text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1.5">Berat Badan (kg)</label>
                        <input type="number" step="0.1" wire:model="weight" class="w-full px-3.5 py-2.5 rounded-xl border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#251518] text-sm text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]">
                        @error('weight') <span class="text-[#E54855] text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="pt-5 border-t border-[#E9E9EC] dark:border-[#342427]">
                    <h3 class="text-base font-extrabold text-[#202124] dark:text-[#F5F5F5] mb-3">Pilih Tujuan Latihan</h3>

                    <div class="space-y-3">
                        @foreach($fitnessGoals as $goal)
                            <label class="relative block bg-[#F7F7F8] dark:bg-[#251518] border rounded-xl p-4 cursor-pointer transition-colors hover:border-[#E54855] {{ $fitness_goal_id == $goal->id ? 'border-[#E54855] bg-[#E54855]/8 dark:bg-[#E54855]/12' : 'border-[#E9E9EC] dark:border-[#342427]' }}">
                                <div class="flex items-start gap-3">
                                    <div class="pt-0.5">
                                        <input type="radio" wire:model="fitness_goal_id" value="{{ $goal->id }}" class="text-[#E54855] focus:ring-[#E54855] bg-white dark:bg-[#1A1012] border-[#E9E9EC] dark:border-[#342427]">
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-sm text-[#202124] dark:text-[#F5F5F5]">{{ $goal->name }}</h4>
                                        <p class="text-xs text-[#777777] dark:text-[#AAA0A2] mt-1 leading-relaxed">{{ $goal->description }}</p>
                                        <span class="inline-block mt-2 px-2.5 py-0.5 bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] text-[#E54855] text-[11px] rounded-md font-bold">
                                            Split: {{ $goal->split_type }}
                                        </span>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('fitness_goal_id') <span class="text-[#E54855] text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="pt-3">
                    <button type="submit" class="w-full bg-[#E54855] hover:bg-[#C93646] text-white font-bold py-3 px-4 rounded-xl shadow-sm shadow-[#E54855]/20 transition-colors flex justify-center items-center gap-2 cursor-pointer text-sm">
                        <span wire:loading.remove wire:target="saveProfile">Simpan &amp; Terapkan Rutinitas</span>
                        <span wire:loading wire:target="saveProfile">Menyimpan...</span>
                    </button>
                    <p class="text-xs text-[#777777] dark:text-[#AAA0A2] text-center mt-3 leading-relaxed">
                        Catatan: Menyimpan tujuan latihan baru akan <strong>memperbarui template rutinitas mingguan Anda</strong> sesuai split rekomendasi.
                    </p>
                </div>
            </form>
        </div>

        <!-- Info / Tips (Konsisten Light Merah/Putih & Dark Merah/Hitam) -->
        <div class="space-y-5">
            <div class="bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] rounded-2xl p-6 shadow-xs space-y-4">
                <div class="flex items-center gap-2.5">
                    <span class="w-9 h-9 rounded-xl bg-[#E54855]/10 text-[#E54855] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </span>
                    <h3 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">
                        Jadwal Cerdas PraxisFit
                    </h3>
                </div>
                <p class="text-[#777777] dark:text-[#AAA0A2] text-sm leading-relaxed">
                    Tujuan latihan di PraxisFit dirancang terstruktur agar kelompok otot memiliki jeda pemulihan (<em>recovery</em>) optimal, baik untuk latihan calisthenics di rumah maupun latihan beban di gym.
                </p>
                <div class="flex flex-wrap gap-2.5 pt-1">
                    <a href="{{ route('workout.planner') }}" wire:navigate class="inline-flex items-center gap-2 bg-[#E54855] hover:bg-[#C93646] text-white text-xs font-bold py-2.5 px-4 rounded-xl shadow-xs transition-colors">
                        Lihat Workout Planner Saya &rarr;
                    </a>
                    <a href="{{ route('program.generator') }}" wire:navigate class="inline-flex items-center gap-2 bg-[#F7F7F8] dark:bg-[#251518] hover:border-[#E54855] border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5] text-xs font-bold py-2.5 px-4 rounded-xl transition-colors">
                        Buat Program Otomatis
                    </a>
                </div>
            </div>

            @if($height && $weight && $height > 0)
                @php
                    $heightM = ((float) $height) / 100;
                    $bmi = $heightM > 0 ? round(((float) $weight) / ($heightM * $heightM), 1) : 0;
                    $bmiCategory = match (true) {
                        $bmi < 18.5 => 'Berat Badan Kurang',
                        $bmi < 25.0 => 'Normal / Ideal',
                        $bmi < 30.0 => 'Kelebihan Berat Badan',
                        default => 'Obesitas',
                    };
                @endphp
                <div class="bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] rounded-2xl p-6 shadow-xs space-y-3">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-[#777777] dark:text-[#AAA0A2]">Indeks Massa Tubuh (BMI)</span>
                    <div class="flex items-baseline justify-between gap-3">
                        <div class="text-3xl font-extrabold text-[#202124] dark:text-[#F5F5F5]">
                            {{ number_format($bmi, 1) }}
                        </div>
                        <span class="px-3 py-1 rounded-full bg-[#E54855]/10 text-[#E54855] text-xs font-bold">
                            {{ $bmiCategory }}
                        </span>
                    </div>
                    <p class="text-xs text-[#777777] dark:text-[#AAA0A2]">
                        Dihitung dari tinggi {{ $height }} cm dan berat {{ $weight }} kg. Gunakan <a href="{{ route('calculator') }}" wire:navigate class="font-bold text-[#E54855] hover:underline">Kalkulator Nutrisi</a> untuk target kalori &amp; protein harian.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
