<div x-data="{ open: false }" 
     x-on:open-modal-form.window="open = true"
     x-on:close-modal-form.window="open = false"
     class="space-y-12 relative pb-20">
     
    <!-- HERO PLANNER HEADER WITH PROMINENT GRADIENT ACTION BUTTON -->
    <div class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-red-950 dark:from-zinc-900 dark:via-zinc-850 dark:to-lime-950 p-8 sm:p-12 rounded-3xl border border-gray-800 dark:border-zinc-800 shadow-2xl transition-all duration-300">
        <div class="absolute -right-10 top-0 w-96 h-96 rounded-full bg-red-500/10 dark:bg-lime-400/10 blur-3xl pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
            <div class="space-y-3 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-red-500/20 dark:bg-lime-400/20 text-red-400 dark:text-lime-300 text-xs font-black uppercase tracking-wider border border-red-500/30 dark:border-lime-400/30 shadow-sm backdrop-blur-md">
                    <span>⚡ Arsitek Rutinitas Juara</span>
                </div>
                <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white leading-tight">
                    Jadwal Latihan <span class="text-red-500 dark:text-lime-400">Workout Anda</span>
                </h1>
                <p class="text-sm sm:text-base text-gray-300 dark:text-zinc-300 font-medium leading-relaxed">
                    Rancang program latihan harian Anda dari Senin hingga Minggu dengan ketepatan strategis. Didukung performa query super kilat Eager Loading, tanpa lelet, demi percepatan transformasi otot Anda!
                </p>
            </div>
            
            <div class="shrink-0 flex flex-col sm:flex-row gap-3">
                <button type="button" @click="open = true; $wire.resetForm()" 
                        class="px-8 py-4 bg-gradient-to-r from-red-600 to-red-500 hover:from-red-500 hover:to-red-600 dark:from-lime-400 dark:to-emerald-400 dark:hover:from-lime-300 dark:hover:to-emerald-300 text-white dark:text-zinc-950 rounded-2xl font-black text-sm uppercase tracking-wider shadow-2xl shadow-red-600/30 dark:shadow-lime-400/30 transition-all duration-300 transform hover:scale-105 active:scale-95 flex items-center justify-center gap-2.5">
                    <span class="text-xl">🔥</span>
                    <span>Tambah Jadwal Latihan</span>
                </button>
            </div>
        </div>
    </div>

    <!-- FLOATING ACTION BUTTON (FAB) FOR MOBILE & DESKTOP QUICK ACCESS -->
    <button type="button" @click="open = true; $wire.resetForm()" 
            class="fixed bottom-20 right-6 sm:bottom-8 sm:right-8 z-40 px-6 py-4 rounded-full bg-gradient-to-r from-red-600 via-red-500 to-amber-500 dark:from-lime-400 dark:via-emerald-400 dark:to-teal-400 text-white dark:text-zinc-950 font-black uppercase tracking-wider text-xs sm:text-sm shadow-2xl shadow-red-600/50 dark:shadow-lime-400/50 transition-all duration-300 transform hover:scale-110 active:scale-95 flex items-center gap-2.5 border-2 border-white/20 dark:border-zinc-950/20 backdrop-blur-md">
        <span class="text-lg font-black">+</span>
        <span class="hidden sm:inline">Tambah Jadwal Baru</span>
        <span class="sm:hidden">Tambah</span>
    </button>

    <!-- WIRE:LOADING FEEDBACK BAR FOR OPERATIONS -->
    <div wire:loading.flex class="w-full justify-center py-4">
        <div class="inline-flex items-center gap-3 px-6 py-3 rounded-2xl bg-zinc-900 border border-lime-400/50 text-white text-sm font-black shadow-2xl shadow-lime-400/10 animate-pulse">
            <span class="w-2.5 h-2.5 rounded-full bg-lime-400 animate-ping"></span>
            <span>⚡ Merekam sinkronisasi jadwal latihan ke database...</span>
        </div>
    </div>

    <!-- WEEKLY SCHEDULE TIMELINE & SEGMENTED CARDS -->
    <div wire:loading.remove class="space-y-10">
        @php
            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
            $groupedRoutines = $routines->groupBy('day_of_week');
            foreach ($days as $day) {
                if (!isset($groupedRoutines[$day])) {
                    $groupedRoutines[$day] = collect();
                }
            }
        @endphp

        <!-- Segments Grid by Day -->
        <div class="grid grid-cols-1 gap-10">
            @foreach($days as $index => $day)
                <div class="relative pl-6 sm:pl-10 border-l-4 border-red-600/40 dark:border-lime-400/40 space-y-6 transition-all duration-300 group">
                    
                    <!-- Timeline Node Indicator -->
                    <div class="absolute -left-[13px] top-1 w-6 h-6 rounded-full bg-red-600 dark:bg-lime-400 border-4 border-white dark:border-zinc-950 shadow-lg group-hover:scale-125 transition-transform duration-300"></div>

                    <div class="bg-white/90 dark:bg-zinc-900/90 backdrop-blur-xl p-6 sm:p-8 rounded-3xl border border-gray-200/80 dark:border-zinc-800 shadow-xl space-y-6 transition-all duration-300">
                        
                        <!-- Day Header & Stats -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-200/80 dark:border-zinc-800/80 pb-5">
                            <div class="flex items-center gap-3.5">
                                <span class="w-11 h-11 rounded-2xl bg-red-100 dark:bg-lime-950 text-red-600 dark:text-lime-400 font-black text-xl flex items-center justify-center border border-red-200/50 dark:border-lime-800/60 shadow-inner">
                                    {{ $index + 1 }}
                                </span>
                                <div>
                                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900 dark:text-white uppercase">
                                        {{ $day }}
                                    </h2>
                                    <span class="text-xs font-bold text-gray-500 dark:text-zinc-400">
                                        {{ $groupedRoutines[$day]->count() > 0 ? '🔥 Jadwal aktif siap diesekusi' : '🛌 Hari Pemulihan / Rest Day' }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <span class="px-4 py-1.5 rounded-xl bg-slate-100 dark:bg-zinc-950 text-slate-800 dark:text-zinc-300 font-black text-xs uppercase tracking-wider border border-gray-200 dark:border-zinc-800 shadow-inner">
                                    ⚡ <span class="text-red-600 dark:text-lime-400 font-extrabold">{{ $groupedRoutines[$day]->count() }}</span> Gerakan Terjadwal
                                </span>
                                <button type="button" @click="open = true; $wire.set('day_of_week', '{{ $day }}'); $wire.resetForm()" 
                                        class="px-3.5 py-1.5 rounded-xl bg-red-50 hover:bg-red-100 dark:bg-lime-950/60 dark:hover:bg-lime-900/60 text-red-600 dark:text-lime-400 font-black text-xs transition-all uppercase">
                                    + Tambah Ke {{ $day }}
                                </button>
                            </div>
                        </div>

                        <!-- Routines Cards Grid -->
                        @if($groupedRoutines[$day]->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($groupedRoutines[$day] as $routine)
                                    <div class="bg-slate-50/80 dark:bg-zinc-950 rounded-3xl p-6 border border-gray-200/80 dark:border-zinc-800 shadow-sm hover:-translate-y-1 hover:shadow-2xl hover:border-red-500/30 dark:hover:border-lime-400/40 transition-all duration-300 flex flex-col justify-between group relative overflow-hidden">
                                        
                                        <div class="space-y-4">
                                            <div class="flex justify-between items-center">
                                                <span class="text-[11px] font-extrabold px-2.5 py-1 rounded-lg bg-red-100 dark:bg-lime-950/80 text-red-700 dark:text-lime-400 uppercase tracking-wider border border-red-200/50 dark:border-lime-800/50">
                                                    🎯 {{ $routine->exercise->target_muscle ?? 'Core' }}
                                                </span>
                                                <span class="text-[11px] font-black px-2.5 py-1 rounded-lg bg-gray-200/70 dark:bg-zinc-900 text-gray-600 dark:text-zinc-400 border border-gray-200 dark:border-zinc-800">
                                                    🔥 {{ $routine->exercise->difficulty ?? 'Menengah' }}
                                                </span>
                                            </div>

                                            <div class="flex items-center gap-4 pt-1">
                                                <div class="w-16 h-16 rounded-2xl bg-white dark:bg-zinc-900 p-1.5 flex items-center justify-center border border-gray-200/80 dark:border-zinc-800 shrink-0 shadow-inner group-hover:scale-105 transition-transform overflow-hidden">
                                                    @php
                                                        $videoUrl = preg_replace('/^\[(.*?)\]\(.*?\)$/', '$1', $routine->exercise->video_male ?? '');
                                                    @endphp
                                                    @if($videoUrl)
                                                        <video src="{{ $videoUrl }}" class="w-full h-full object-cover mix-blend-multiply dark:mix-blend-normal" autoplay loop muted playsinline></video>
                                                    @else
                                                        <span class="text-4xl">💪</span>
                                                    @endif
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <h3 class="text-lg font-black tracking-tight text-slate-900 dark:text-white group-hover:text-red-600 dark:group-hover:text-lime-400 transition-colors duration-200 truncate">
                                                        {{ $routine->exercise->name ?? 'Gerakan Tanpa Nama' }}
                                                    </h3>
                                                    <div class="inline-flex items-center gap-1.5 mt-1 text-xs font-extrabold px-2.5 py-1 rounded-xl bg-white dark:bg-zinc-900 text-slate-800 dark:text-zinc-200 border border-gray-200 dark:border-zinc-800 shadow-sm">
                                                        <span class="text-red-600 dark:text-lime-400 font-black">{{ $routine->sets }} Set</span> &times; {{ $routine->reps }} Reps
                                                    </div>
                                                </div>
                                            </div>

                                            @if($routine->notes)
                                                <div class="p-3.5 rounded-2xl bg-white dark:bg-zinc-900/80 border border-gray-200/60 dark:border-zinc-800 text-xs text-slate-600 dark:text-zinc-300 font-medium italic shadow-inner">
                                                    &ldquo;{{ $routine->notes }}&rdquo;
                                                </div>
                                            @endif
                                        </div>

                                        <div class="mt-6 pt-4 border-t border-gray-200/60 dark:border-zinc-800 flex justify-between items-center text-xs">
                                            <span class="text-[10px] font-black tracking-wider uppercase text-emerald-600 dark:text-lime-400 flex items-center gap-1">
                                                <span>⚡ Eager Loaded</span>
                                            </span>
                                            <div class="flex gap-2">
                                                <button type="button" wire:click="edit({{ $routine->id }})" 
                                                        class="px-3 py-1.5 rounded-xl bg-white hover:bg-slate-200 dark:bg-zinc-900 dark:hover:bg-zinc-800 text-slate-800 dark:text-zinc-200 font-black text-xs transition-all duration-200 border border-gray-200 dark:border-zinc-800 shadow-sm">
                                                    ✏️ Edit
                                                </button>
                                                <button type="button" wire:click="delete({{ $routine->id }})" 
                                                        wire:confirm="Yakin ingin menghapus gerakan ini dari hari {{ $routine->day_of_week }}?" 
                                                        class="px-3 py-1.5 rounded-xl bg-red-50 hover:bg-red-100 dark:bg-red-950/40 dark:hover:bg-red-900/50 text-red-600 dark:text-red-400 font-black text-xs transition-all duration-200 border border-red-200/50 dark:border-red-800/50 shadow-sm">
                                                    🗑️ Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <!-- Empty Rest Day State -->
                            <div class="p-8 rounded-2xl bg-slate-50/50 dark:bg-zinc-950/50 border border-dashed border-gray-300 dark:border-zinc-800 text-center flex flex-col sm:flex-row items-center justify-between gap-4">
                                <div class="flex items-center gap-4 text-left">
                                    <span class="text-4xl">🧘‍♂️</span>
                                    <div>
                                        <h4 class="text-base font-black tracking-tight text-slate-800 dark:text-zinc-200">Belum Ada Sesi Terjadwal Pada Hari Ini</h4>
                                        <p class="text-xs text-gray-500 dark:text-zinc-400 font-medium">Jadikan sebagai hari istirahat pemulihan otot atau tambahkan rutinitas baru!</p>
                                    </div>
                                </div>
                                <button type="button" @click="open = true; $wire.set('day_of_week', '{{ $day }}'); $wire.resetForm()"
                                        class="px-5 py-2.5 rounded-xl bg-slate-900 dark:bg-zinc-800 hover:bg-red-600 dark:hover:bg-lime-400 text-white dark:text-zinc-200 dark:hover:text-zinc-950 font-black text-xs uppercase tracking-wider transition-all duration-200 shadow">
                                    ⚡ Rancang Latihan Hari Ini
                                </button>
                            </div>
                        @endif

                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- ALPINE MODAL FORM WITH BACKDROP BLUR & SLEEK ZINC-800 INPUTS -->
    <div x-show="open" x-cloak
         @keydown.escape.window="open = false; $wire.resetForm()"
         class="fixed inset-0 z-[120] flex items-center justify-center p-4 sm:p-6 overflow-y-auto bg-black/80 backdrop-blur-md"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <div @click.away="open = false; $wire.resetForm()"
             class="bg-white dark:bg-zinc-900 w-full max-w-xl rounded-3xl p-6 sm:p-9 border border-gray-200 dark:border-zinc-800 shadow-2xl transform transition-all space-y-6 relative overflow-hidden max-h-[90vh] overflow-y-auto"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95 translate-y-6"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-6">

            <!-- Modal Glowing Top Accent -->
            <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-red-600 via-amber-500 to-red-500 dark:from-lime-400 dark:via-emerald-400 dark:to-teal-400"></div>

            <!-- Modal Header -->
            <div class="flex justify-between items-start border-b border-gray-200/80 dark:border-zinc-800/80 pb-4 pt-1">
                <div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-red-600 dark:text-lime-400 bg-red-50 dark:bg-lime-950/70 px-3 py-1 rounded-full border border-red-200/50 dark:border-lime-800/50 shadow-sm">
                        {{ $routine_id ? '🔄 Update Sesi Workout' : '⚡ Sesi Latihan Baru' }}
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900 dark:text-white mt-2">
                        {{ $routine_id ? 'Perbarui Sesi Latihan' : 'Rancang Jadwal Workout' }}
                    </h2>
                </div>
                <button type="button" @click="open = false; $wire.resetForm()" class="p-2 text-gray-400 hover:text-red-600 dark:hover:text-lime-400 font-black text-2xl rounded-xl transition-colors shrink-0">
                    &times;
                </button>
            </div>

            <!-- Modal Form with Custom Sleek Inputs -->
            <form wire:submit.prevent="save" class="space-y-5 text-sm font-bold text-slate-800 dark:text-zinc-200">
                
                <!-- Pilih Gerakan (Visual Selector dengan Live Search & Animasi) -->
                <div class="relative space-y-2"
                     x-data="{
                         openDropdown: false,
                         search: '',
                         selectedId: @entangle('exercise_id'),
                         exercises: {{ $exercises->map(fn($ex) => [
                             'id' => $ex->id,
                             'name' => $ex->name,
                             'target' => $ex->target_muscle ?? 'Core',
                             'difficulty' => $ex->difficulty ?? 'Menengah',
                             'video' => preg_replace('/^\[(.*?)\]\(.*?\)$/', '$1', $ex->video_male ?? '')
                         ])->toJson() }},
                         get selectedExercise() {
                             if (!this.selectedId && this.exercises.length > 0) return this.exercises[0];
                             return this.exercises.find(e => e.id == this.selectedId) || this.exercises[0] || null;
                         },
                         get filteredExercises() {
                             if (!this.search.trim()) return this.exercises;
                             const q = this.search.toLowerCase();
                             return this.exercises.filter(e => e.name.toLowerCase().includes(q) || e.target.toLowerCase().includes(q) || e.difficulty.toLowerCase().includes(q));
                         },
                         selectExercise(id) {
                             this.selectedId = id;
                             $wire.set('exercise_id', id);
                             this.openDropdown = false;
                             this.search = '';
                         },
                         playing: false,
                         init() {
                             this.$watch('selectedId', (val) => { 
                                 this.playing = false; 
                                 if (this.$refs.previewVideo) this.$refs.previewVideo.pause();
                             });
                         },
                         toggleAnim() {
                             if (!this.selectedExercise || !this.$refs.previewVideo) return;
                             this.playing = !this.playing;
                             if (this.playing) {
                                 this.$refs.previewVideo.play();
                             } else {
                                 this.$refs.previewVideo.pause();
                             }
                         }
                     }">
                    
                    <label class="block text-xs font-black text-gray-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5 flex justify-between items-center">
                        <span>1. Pilih Gerakan Workout</span>
                        <span class="text-red-600 dark:text-lime-400 font-extrabold text-[11px]">(310 Database Tersedia)</span>
                    </label>

                    <!-- Card Preview -->
                    <div class="relative p-4 rounded-2xl bg-slate-100 dark:bg-zinc-800/90 border border-gray-200/80 dark:border-zinc-700 shadow-inner flex items-center gap-4 transition-all">
                        <div @click="toggleAnim()" 
                             title="Klik untuk memutar / menghentikan animasi gerakan ini!"
                             class="w-20 h-20 sm:w-24 sm:h-24 rounded-xl bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-700 p-1.5 shrink-0 flex items-center justify-center relative cursor-pointer group shadow-md hover:border-red-500 dark:hover:border-lime-400 transition-all">
                            <template x-if="selectedExercise && selectedExercise.video">
                                <video x-ref="previewVideo" :src="selectedExercise.video" class="w-full h-full object-cover mix-blend-multiply dark:mix-blend-normal group-hover:scale-105 transition-transform rounded-lg" loop muted playsinline></video>
                            </template>
                            <template x-if="!selectedExercise || !selectedExercise.video">
                                <span class="text-4xl">💪</span>
                            </template>
                            <div class="absolute bottom-1 right-1 px-1.5 py-0.5 rounded bg-slate-900/80 text-white text-[8px] font-black tracking-tighter uppercase shadow">
                                <span x-text="playing ? '⏸️ Stop' : '▶️ Animasi'"></span>
                            </div>
                        </div>

                        <div class="flex-1 min-w-0 space-y-2.5">
                            <template x-if="selectedExercise">
                                <div>
                                    <div class="text-base font-black tracking-tight text-slate-900 dark:text-white truncate" x-text="selectedExercise.name"></div>
                                    <div class="flex flex-wrap items-center gap-2 mt-1.5">
                                        <span class="text-[10px] font-black px-2 py-0.5 rounded-md bg-red-100 dark:bg-lime-950/80 text-red-700 dark:text-lime-400 uppercase border border-red-200/50 dark:border-lime-800/50">
                                            🎯 Target: <span x-text="selectedExercise.target"></span>
                                        </span>
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-gray-200 dark:bg-zinc-900 text-gray-700 dark:text-zinc-300 uppercase" x-text="selectedExercise.difficulty"></span>
                                    </div>
                                </div>
                            </template>
                            
                            <button type="button" @click="openDropdown = !openDropdown; if(openDropdown) $nextTick(() => $refs.searchInput.focus())"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-900 hover:bg-red-600 dark:bg-zinc-900 dark:hover:bg-lime-400 text-white dark:text-zinc-200 dark:hover:text-zinc-950 font-extrabold text-xs transition-colors shadow-sm border border-transparent dark:border-zinc-700">
                                <span>🔍 Cari / Ganti Gerakan...</span>
                                <span x-text="openDropdown ? '▲' : '▼'"></span>
                            </button>
                        </div>
                    </div>

                    <!-- Dropdown Daftar Gerakan dengan Fitur Cari (Live Search) -->
                    <div x-show="openDropdown" @click.away="openDropdown = false" x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         class="absolute z-50 left-0 right-0 top-full mt-2 p-3 bg-white dark:bg-zinc-900 border-2 border-red-500/40 dark:border-lime-400/40 rounded-2xl shadow-2xl space-y-2 max-h-80 flex flex-col">
                        
                        <div class="relative shrink-0">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-sm">🔍</span>
                            <input x-ref="searchInput" x-model="search" type="text" 
                                   placeholder="Ketik nama gerakan atau target otot (cth: Push, Dada, Squat)..." 
                                   class="w-full pl-10 pr-8 py-2.5 text-xs font-extrabold bg-slate-100 dark:bg-zinc-950 text-slate-900 dark:text-white rounded-xl border border-gray-300 dark:border-zinc-700 focus:ring-2 focus:ring-red-600 dark:focus:ring-lime-400 outline-none placeholder-gray-400 shadow-inner">
                            <button type="button" x-show="search" @click="search = ''" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-red-500 font-bold">✕</button>
                        </div>

                        <div class="overflow-y-auto space-y-1.5 pr-1 flex-1 min-h-[160px] max-h-56 border-t border-gray-100 dark:border-zinc-800 pt-2">
                            <template x-for="item in filteredExercises" :key="item.id">
                                <div @click="selectExercise(item.id)"
                                     :class="selectedId == item.id ? 'bg-red-50/80 border-red-500 dark:bg-lime-950/60 dark:border-lime-400 text-red-600 dark:text-lime-400 font-black' : 'bg-transparent hover:bg-slate-50 dark:hover:bg-zinc-800/70 border-transparent text-slate-800 dark:text-zinc-200'"
                                     class="flex items-center gap-3 p-2 rounded-xl border cursor-pointer transition-all group">
                                    <template x-if="item.video">
                                        <video :src="item.video" class="w-11 h-11 rounded-lg object-cover bg-slate-50 dark:bg-zinc-950 p-0.5 border border-gray-200 dark:border-zinc-800 shrink-0 group-hover:scale-105 transition-transform" autoplay loop muted playsinline></video>
                                    </template>
                                    <template x-if="!item.video">
                                        <div class="w-11 h-11 rounded-lg flex items-center justify-center bg-slate-50 dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 shrink-0">💪</div>
                                    </template>
                                    <div class="flex-1 min-w-0">
                                        <div class="font-extrabold text-xs truncate group-hover:text-red-600 dark:group-hover:text-lime-400 transition-colors" x-text="item.name"></div>
                                        <div class="flex items-center gap-1.5 mt-0.5 text-[10px] text-gray-400 dark:text-zinc-400 font-bold">
                                            <span class="text-red-500 dark:text-lime-400">●</span> <span x-text="item.target"></span> &bull; <span x-text="item.difficulty"></span>
                                        </div>
                                    </div>
                                    <span x-show="selectedId == item.id" class="text-xs font-black px-2 text-red-600 dark:text-lime-400 shrink-0">✓ Dipilih</span>
                                </div>
                            </template>
                            <div x-show="filteredExercises.length === 0" class="p-6 text-center text-xs text-gray-500 dark:text-zinc-500 font-semibold space-y-1">
                                <div class="text-xl">🙇‍♂️</div>
                                <div>Gerakan yang dicari tidak ditemukan.</div>
                            </div>
                        </div>
                    </div>
                    @error('exercise_id') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Hari Dalam Seminggu -->
                <div>
                    <label class="block text-xs font-black text-gray-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">2. Hari Latihan Rutin</label>
                    <select wire:model="day_of_week" 
                            class="w-full p-4 border border-gray-200 dark:border-zinc-700 rounded-2xl bg-slate-100 dark:bg-zinc-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-red-600 dark:focus:ring-lime-400 outline-none font-extrabold transition-colors shadow-inner">
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                        <option value="Minggu">Minggu</option>
                    </select>
                </div>

                <!-- Sets & Reps -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-gray-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">3. Jumlah Set</label>
                        <input type="number" wire:model="sets" min="1" max="50" 
                               class="w-full p-4 border border-gray-200 dark:border-zinc-700 rounded-2xl bg-slate-100 dark:bg-zinc-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-red-600 dark:focus:ring-lime-400 outline-none font-black text-base shadow-inner">
                        @error('sets') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">4. Target Repetisi (Reps)</label>
                        <input type="text" wire:model="reps" placeholder="Cth: 12-15 / Failure" 
                               class="w-full p-4 border border-gray-200 dark:border-zinc-700 rounded-2xl bg-slate-100 dark:bg-zinc-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-red-600 dark:focus:ring-lime-400 outline-none font-bold shadow-inner">
                        @error('reps') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Catatan Tambahan -->
                <div>
                    <label class="block text-xs font-black text-gray-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">5. Catatan Strategi Latihan (Opsional)</label>
                    <textarea wire:model="notes" rows="3" placeholder="Contoh: Fokus eccentric lambat 3 detik, rest antar set 60 detik..." 
                              class="w-full p-4 border border-gray-200 dark:border-zinc-700 rounded-2xl bg-slate-100 dark:bg-zinc-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-red-600 dark:focus:ring-lime-400 outline-none font-medium shadow-inner text-sm"></textarea>
                    @error('notes') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-4 border-t border-gray-200/80 dark:border-zinc-800/80">
                    <button type="button" @click="open = false; $wire.resetForm()" 
                            class="px-6 py-3.5 rounded-2xl bg-slate-100 dark:bg-zinc-800 hover:bg-slate-200 dark:hover:bg-zinc-700 text-slate-700 dark:text-zinc-300 font-black text-xs uppercase tracking-wider transition-colors">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-8 py-3.5 rounded-2xl bg-gradient-to-r from-red-600 to-red-500 hover:from-red-500 hover:to-red-600 dark:from-lime-400 dark:to-emerald-400 text-white dark:text-zinc-950 font-black text-xs uppercase tracking-wider shadow-xl shadow-red-500/25 dark:shadow-lime-400/25 transition-all duration-200 transform hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2">
                        <span wire:loading.remove wire:target="save">🔥 {{ $routine_id ? 'Simpan Perubahan Sesi' : 'Simpan ke Jadwal Latihan' }}</span>
                        <span wire:loading wire:target="save" class="animate-pulse">⏳ Sedang Merekam ke Database...</span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
