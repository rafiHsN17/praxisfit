<div class="max-w-4xl mx-auto space-y-8">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">Profil & Tujuan Latihan</h1>
    </div>

    @if (session()->has('success'))
        <div class="p-4 bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400 rounded-xl border border-emerald-200 dark:border-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Form Data Fisik -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 shadow-sm">
            <h2 class="text-xl font-bold text-zinc-800 dark:text-zinc-200 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-red-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                Data Fisik
            </h2>

            <form wire:submit.prevent="saveProfile" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Jenis Kelamin</label>
                    <select wire:model="gender" class="w-full rounded-xl border-zinc-300 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-100 focus:ring-red-500 focus:border-red-500">
                        <option value="">Pilih</option>
                        <option value="M">Laki-laki</option>
                        <option value="F">Perempuan</option>
                    </select>
                    @error('gender') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Tinggi Badan (cm)</label>
                        <input type="number" step="0.1" wire:model="height" class="w-full rounded-xl border-zinc-300 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-100 focus:ring-red-500 focus:border-red-500">
                        @error('height') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Berat Badan (kg)</label>
                        <input type="number" step="0.1" wire:model="weight" class="w-full rounded-xl border-zinc-300 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-100 focus:ring-red-500 focus:border-red-500">
                        @error('weight') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="pt-6 border-t border-zinc-100 dark:border-zinc-800">
                    <h3 class="text-lg font-bold text-zinc-800 dark:text-zinc-200 mb-4">Pilih Tujuan Latihan</h3>
                    
                    <div class="space-y-3">
                        @foreach($fitnessGoals as $goal)
                            <label class="relative block bg-zinc-50 dark:bg-zinc-800/50 border rounded-xl p-4 cursor-pointer transition-colors hover:border-red-400 dark:hover:border-emerald-400 {{ $fitness_goal_id == $goal->id ? 'border-red-500 dark:border-emerald-500 bg-red-50/50 dark:bg-emerald-900/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                <div class="flex items-start gap-3">
                                    <div class="pt-0.5">
                                        <input type="radio" wire:model="fitness_goal_id" value="{{ $goal->id }}" class="text-red-600 focus:ring-red-500 dark:text-emerald-500 dark:bg-zinc-900 dark:border-zinc-700">
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-zinc-900 dark:text-zinc-100">{{ $goal->name }}</h4>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">{{ $goal->description }}</p>
                                        <span class="inline-block mt-2 px-2.5 py-1 bg-zinc-200 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 text-xs rounded-md font-medium">Split: {{ $goal->split_type }}</span>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('fitness_goal_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 dark:bg-emerald-600 dark:hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-xl transition-colors flex justify-center items-center gap-2">
                        <span wire:loading.remove wire:target="saveProfile">Simpan & Terapkan Rutinitas</span>
                        <span wire:loading wire:target="saveProfile">Menyimpan...</span>
                    </button>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 text-center mt-3">
                        Catatan: Menyimpan tujuan latihan baru akan <strong>mengganti jadwal di Workout Planner Anda</strong> dengan rekomendasi jadwal terbaru.
                    </p>
                </div>
            </form>
        </div>

        <!-- Info / Tips -->
        <div class="space-y-6">
            <div class="bg-gradient-to-br from-zinc-800 to-zinc-900 dark:from-zinc-900 dark:to-black border border-zinc-700 rounded-2xl p-6 text-white shadow-lg">
                <h3 class="text-lg font-bold flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    Jadwal Cerdas PraxisFit
                </h3>
                <p class="text-zinc-300 text-sm leading-relaxed mb-4">
                    Tujuan latihan di PraxisFit disusun khusus untuk olahraga <strong>Calisthenics & Home Workout</strong>. 
                    Tidak sekadar satu gerakan *full body*, PraxisFit memecah jadwal menjadi beberapa kali seminggu (misal: Upper/Lower Split) 
                    agar otot memiliki waktu <em>recovery</em> yang cukup, sama seperti berlatih di Gym profesional.
                </p>
                <a href="{{ route('workout.planner') }}" class="inline-block bg-white/10 hover:bg-white/20 text-white text-sm font-semibold py-2 px-4 rounded-lg transition-colors border border-white/20">
                    Lihat Planner Latihan Saya &rarr;
                </a>
            </div>
        </div>
    </div>
</div>
