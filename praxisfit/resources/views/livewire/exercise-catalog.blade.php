<div class="space-y-8 sm:space-y-12">
     
    <!-- HEADER CATALOG -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-white to-zinc-50 dark:from-zinc-900 dark:to-black p-8 sm:p-12 border border-zinc-200 dark:border-zinc-800 shadow-xl dark:shadow-2xl">
        <!-- Abstract Background Shapes -->
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-emerald-500/10 dark:bg-emerald-500/20 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 rounded-full bg-teal-500/10 dark:bg-teal-500/20 blur-3xl pointer-events-none"></div>
        
        <div class="relative z-10 space-y-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-600 dark:text-emerald-400 text-xs font-bold uppercase tracking-widest mb-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                Database Gerakan
            </div>
            <h1 class="text-4xl sm:text-5xl font-black tracking-tight text-zinc-900 dark:text-white drop-shadow-sm dark:drop-shadow-md">
                Katalog <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500 dark:from-emerald-400 dark:to-teal-400">Latihan</span>
            </h1>
            <p class="text-base text-zinc-600 dark:text-zinc-400 leading-relaxed max-w-2xl font-medium">
                Koleksi panduan biomekanika gerakan yang tervalidasi sains. Temukan gerakan yang tepat untuk hipertrofi maksimal berdasarkan kelompok otot.
            </p>
        </div>
    </div>

    <!-- FILTERS & SEARCH -->
    <div class="space-y-6">
        <!-- Search Bar -->
        <div class="max-w-2xl relative group">
            <div class="absolute -inset-1 bg-gradient-to-r from-emerald-600 to-teal-500 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-500"></div>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-zinc-400">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16.5 10.5a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                </span>
                <input type="text" wire:model.live.debounce.300ms="search" 
                       placeholder="Cari gerakan (contoh: Bench Press, Squat)..." 
                       class="w-full pl-12 pr-4 py-4 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-md text-zinc-900 dark:text-white rounded-xl border border-zinc-200 dark:border-zinc-700 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/50 shadow-sm transition-all text-base placeholder-zinc-400">
            </div>
        </div>

        <!-- Muscle Target Filters -->
        <div class="flex overflow-x-auto gap-3 py-2 hide-scrollbar -mx-4 px-4 sm:mx-0 sm:px-0">
            <button type="button" wire:click="$set('filterMuscle', '')" 
                    class="px-5 py-2.5 rounded-xl text-sm shrink-0 transition-all duration-300 font-bold shadow-sm flex items-center gap-2 {{ $filterMuscle === '' ? 'bg-gradient-to-r from-zinc-800 to-zinc-700 text-white dark:from-zinc-100 dark:to-zinc-300 dark:text-zinc-900 border-none scale-105 shadow-md' : 'bg-white dark:bg-zinc-900 text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-800 hover:bg-zinc-50 hover:text-zinc-900 dark:hover:bg-zinc-800 dark:hover:text-white' }}">
                <svg class="w-4 h-4 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                Semua Otot
            </button>
            @foreach($muscleTargets as $muscle)
                <button type="button" wire:click="$set('filterMuscle', '{{ $muscle }}')" 
                        class="px-5 py-2.5 rounded-xl text-sm shrink-0 transition-all duration-300 font-bold shadow-sm {{ $filterMuscle === $muscle ? 'bg-gradient-to-r from-emerald-600 to-teal-500 text-white border-none scale-105 shadow-emerald-500/25 shadow-lg' : 'bg-white dark:bg-zinc-900 text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-800 hover:bg-zinc-50 hover:text-emerald-600 dark:hover:bg-zinc-800 dark:hover:text-emerald-400' }}">
                    {{ $muscle }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- EXERCISES GRID -->
    <div wire:loading.class="opacity-50 scale-[0.98]" wire:target="search, filterMuscle" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 transition-all duration-500 ease-out">
        @forelse($exercises as $exercise)
            <div wire:click="openExerciseDetail({{ $exercise->id }})"
                 wire:key="exercise-{{ $exercise->id }}"
                 x-data="{ 
                     timer: null, 
                     frame: 0, 
                     images: [
                         '{{ $exercise->image_1 ?? $exercise->icon }}',
                         '{{ $exercise->image_2 ?? null }}',
                         '{{ $exercise->image_3 ?? null }}'
                     ].filter(Boolean)
                 }"
                 @mouseenter="if(images.length > 1) { timer = setInterval(() => { frame = (frame + 1) % images.length }, 600) }"
                 @mouseleave="clearInterval(timer); frame = 0"
                 class="group relative bg-white dark:bg-zinc-900 rounded-3xl overflow-hidden border border-zinc-200/80 dark:border-zinc-800/80 hover:border-emerald-500/50 dark:hover:border-emerald-500/50 hover:shadow-2xl hover:shadow-emerald-500/10 transition-all duration-500 hover:-translate-y-2 cursor-pointer flex flex-col">
                
                <!-- Media -->
                <div class="relative overflow-hidden bg-zinc-100 dark:bg-zinc-950 h-56 w-full flex items-center justify-center p-4">
                    <!-- Subtle background glow on hover -->
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/0 to-teal-500/0 group-hover:from-emerald-500/10 group-hover:to-teal-500/10 transition-colors duration-500"></div>
                    
                    <img :src="images[frame]" src="{{ $exercise->image_1 ?? $exercise->icon }}" class="w-full h-full object-contain filter drop-shadow-md transition-transform duration-700 group-hover:scale-110" alt="{{ $exercise->name }}">
                    
                    <!-- Play Overlay -->
                    <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px] flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="w-14 h-14 rounded-full bg-white/20 backdrop-blur-md border border-white/30 flex items-center justify-center transform scale-75 group-hover:scale-100 transition-transform duration-500 delay-75 shadow-xl">
                            <svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Info -->
                <div class="p-6 flex-1 flex flex-col justify-between space-y-4 bg-white dark:bg-zinc-900 border-t border-zinc-100 dark:border-zinc-800/50 relative z-10">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="px-2.5 py-1 rounded-md bg-zinc-100 dark:bg-zinc-800 text-[11px] font-bold text-zinc-600 dark:text-zinc-300 uppercase tracking-wider">
                                {{ $exercise->target_muscle }}
                            </span>
                            @if($exercise->alternative_equipment)
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-amber-100 dark:bg-amber-900/50 text-amber-600 dark:text-amber-400 animate-pulse" title="Ada Alternatif Alat">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                </span>
                            @endif
                        </div>
                        <h3 class="text-lg font-bold text-zinc-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                            {{ $exercise->name }}
                        </h3>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-semibold text-zinc-500 dark:text-zinc-400">
                        <svg class="w-4 h-4 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Tingkat: <span class="text-zinc-700 dark:text-zinc-300">{{ $exercise->difficulty ?? 'Menengah' }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-24 flex flex-col items-center justify-center text-center space-y-4 bg-zinc-50 dark:bg-zinc-900/50 rounded-3xl border border-dashed border-zinc-300 dark:border-zinc-700">
                <div class="w-20 h-20 bg-zinc-200 dark:bg-zinc-800 rounded-full flex items-center justify-center mb-2">
                    <svg class="w-10 h-10 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-zinc-800 dark:text-zinc-200">Gerakan tidak ditemukan</h3>
                <p class="text-zinc-500 dark:text-zinc-400 max-w-sm">Mungkin Anda salah ketik, atau gerakan belum tersedia di database kami.</p>
                <button type="button" wire:click="resetFilters" class="mt-4 px-6 py-2.5 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-xl font-bold hover:scale-105 transition-transform shadow-lg">Reset Pencarian</button>
            </div>
        @endforelse
    </div>

    <!-- PAGINATION -->
    <div class="pt-8 flex justify-center">
        {{ $exercises->links() }}
    </div>

    <!-- Context-Specific FAQ -->
    <section class="mt-12 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl p-6 sm:p-10 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 blur-3xl rounded-full"></div>
        <h3 class="text-3xl font-black text-zinc-900 dark:text-white mb-8 flex items-center gap-3 relative z-10">
            <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Fakta Medis Latihan
        </h3>
        <div class="space-y-4 relative z-10" x-data="{ activeAccordion: '' }">
            <div class="group bg-zinc-50 dark:bg-zinc-950 border border-zinc-200/80 dark:border-zinc-800 rounded-2xl overflow-hidden transition-all duration-300 hover:border-emerald-500/30 hover:shadow-md">
                <button @click="activeAccordion = activeAccordion === 'faq1' ? '' : 'faq1'" class="w-full flex justify-between items-center p-6 text-left font-bold text-zinc-900 dark:text-white focus:outline-none">
                    <span class="text-lg">Mengapa set dan repetisi sangat penting?</span>
                    <span class="w-8 h-8 rounded-full bg-white dark:bg-zinc-800 flex items-center justify-center text-emerald-600 dark:text-emerald-500 transform transition-transform duration-500 shadow-sm border border-zinc-100 dark:border-zinc-700" :class="{'rotate-180': activeAccordion === 'faq1'}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                    </span>
                </button>
                <div x-show="activeAccordion === 'faq1'" x-collapse class="border-t border-zinc-200 dark:border-zinc-800">
                    <div class="p-6 text-zinc-600 dark:text-zinc-400 leading-relaxed bg-white dark:bg-zinc-900">
                        Repetisi adalah satu siklus gerakan, sementara set adalah sekumpulan repetisi. Untuk hipertrofi, rentang 8-12 repetisi sangat ideal untuk menumpuk metabolit otot, sementara 1-5 repetisi berfokus pada adaptasi transmisi saraf motorik (strength). <br><br>
                        <div class="mt-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                            <span class="text-xs font-bold text-zinc-800 dark:text-zinc-300">Sumber: American College of Sports Medicine (ACSM) - "Resistance Training Guidelines"</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="group bg-zinc-50 dark:bg-zinc-950 border border-zinc-200/80 dark:border-zinc-800 rounded-2xl overflow-hidden transition-all duration-300 hover:border-emerald-500/30 hover:shadow-md">
                <button @click="activeAccordion = activeAccordion === 'faq2' ? '' : 'faq2'" class="w-full flex justify-between items-center p-6 text-left font-bold text-zinc-900 dark:text-white focus:outline-none">
                    <span class="text-lg">Apakah saya harus melatih otot yang sama tiap hari?</span>
                    <span class="w-8 h-8 rounded-full bg-white dark:bg-zinc-800 flex items-center justify-center text-emerald-600 dark:text-emerald-500 transform transition-transform duration-500 shadow-sm border border-zinc-100 dark:border-zinc-700" :class="{'rotate-180': activeAccordion === 'faq2'}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                    </span>
                </button>
                <div x-show="activeAccordion === 'faq2'" x-collapse class="border-t border-zinc-200 dark:border-zinc-800">
                    <div class="p-6 text-zinc-600 dark:text-zinc-400 leading-relaxed bg-white dark:bg-zinc-900">
                        Sangat tidak direkomendasikan. Sintesis Protein Otot (MPS) berlangsung selama 24-48 jam pasca-latihan beban. Memberikan tekanan mekanik berulang di masa perbaikan tersebut justru akan memicu overtraining dan atrofi otot. <br><br>
                        <div class="mt-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                            <span class="text-xs font-bold text-zinc-800 dark:text-zinc-300">Sumber: Dr. Brad Schoenfeld - "Muscle Recovery Timecourse"</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PREMIUM MODAL -->
    @if($selectedExercise)
        <template x-teleport="body">
            <div x-data="{ 
                    open: true,
                    termModalOpen: false,
                    activeTerm: '',
                    activeDef: '',
                    modalTimer: null,
                    frame: 0,
                    images: [
                        '{{ $selectedExercise->image_1 ?? $selectedExercise->icon }}',
                        '{{ $selectedExercise->image_2 ?? null }}',
                        '{{ $selectedExercise->image_3 ?? null }}'
                    ].filter(Boolean)
                 }"
                 x-show="open" 
                 x-init="
                     if(images.length > 1) { modalTimer = setInterval(() => { frame = (frame + 1) % images.length }, 600); }
                     $watch('open', value => { if(!value) { clearInterval(modalTimer); setTimeout(() => $wire.closeExerciseDetail(), 300); } })
                 "
                 @keydown.escape.window="if(termModalOpen) { termModalOpen = false; } else { open = false; }"
                 class="fixed inset-0 z-[9999] flex items-center justify-center p-0 sm:p-6"
                 x-cloak>
                
                <!-- Glass Backdrop -->
                <div x-show="open" 
                     x-transition.opacity.duration.400ms
                     @click="if(!termModalOpen) open = false"
                     class="absolute inset-0 bg-zinc-900/20 dark:bg-black/80 backdrop-blur-md"></div>

                <!-- Modal Content -->
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-400"
                     x-transition:enter-start="opacity-0 translate-y-12 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-12 sm:scale-95"
                     class="relative w-full h-full max-w-2xl bg-white dark:bg-zinc-900 sm:rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.3)] overflow-hidden max-h-screen sm:max-h-[90vh] flex flex-col z-10 border border-zinc-200/50 dark:border-zinc-700/50">
                    
                    <button @click="open = false" class="absolute top-4 right-4 sm:top-5 sm:right-5 z-50 bg-white/50 hover:bg-white/80 dark:bg-black/20 dark:hover:bg-black/50 backdrop-blur-md text-zinc-900 dark:text-white p-2.5 rounded-full transition-all hover:scale-110 active:scale-95">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>

                    <div class="flex-1 overflow-y-auto hide-scrollbar">
                        
                        <!-- Media Showcase -->
                        <div class="w-full aspect-video bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-zinc-950 dark:to-zinc-900 flex items-center justify-center relative overflow-hidden">
                            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjEiIGZpbGw9InJnYmEoMCwwLDAsMC4wNSkiLz48L3N2Zz4=')] dark:bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wNSkiLz48L3N2Zz4=')] z-0"></div>
                            @if($selectedExercise->icon || $selectedExercise->image_1)
                                <img :src="images[frame]" src="{{ $selectedExercise->image_1 ?? $selectedExercise->icon }}" class="w-full h-full object-contain filter drop-shadow-2xl relative z-10" alt="{{ $selectedExercise->name }}">
                            @endif
                            <!-- Gradient overlay for smooth transition to content -->
                            <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-white dark:from-zinc-900 to-transparent z-10"></div>
                        </div>

                        <!-- Content Area -->
                        <div class="p-6 sm:p-10 -mt-6 relative z-20 space-y-8 bg-white dark:bg-zinc-900 rounded-t-3xl">
                            
                            <!-- Header -->
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <span class="px-3 py-1 rounded-lg bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 font-bold text-xs uppercase tracking-widest">{{ $selectedExercise->target_muscle }}</span>
                                    <span class="px-3 py-1 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-bold text-xs uppercase tracking-widest">{{ $selectedExercise->difficulty ?? 'Menengah' }}</span>
                                </div>
                                <h3 class="text-3xl font-black text-zinc-900 dark:text-white tracking-tight">
                                    {{ $selectedExercise->name }}
                                </h3>
                            </div>

                            <!-- Instructions -->
                            <div class="space-y-5">
                                @if($selectedExercise->alternative_equipment)
                                    <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/10 border border-amber-200/50 dark:border-amber-700/30 flex gap-4 shadow-inner">
                                        <div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-900/50 flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                        <div class="text-sm text-amber-900 dark:text-amber-100 leading-relaxed">
                                            <span class="font-bold block mb-1">Alternatif Alat (Home Workout):</span>
                                            {{ $selectedExercise->alternative_equipment }}
                                        </div>
                                    </div>
                                @endif

                                <div>
                                    <h4 class="text-sm font-black text-zinc-900 dark:text-white uppercase tracking-widest mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                        Instruksi Eksekusi
                                    </h4>
                                    
                                    @php
                                        $terms = [
                                            'hipertrofi' => 'Peningkatan volume sel otot yang menghasilkan otot lebih besar.',
                                            'hypertrophy' => 'Peningkatan volume sel otot yang menghasilkan otot lebih besar.',
                                            'core' => 'Otot inti tubuh meliputi perut, punggung bawah, dan panggul.',
                                            'barbell' => 'Bilah besi panjang untuk mengangkat beban dengan dua tangan.',
                                            'dumbbell' => 'Beban bebas berukuran pendek untuk satu tangan.',
                                            'rep' => 'Repetisi; satu hitungan penuh eksekusi gerakan (naik-turun).',
                                            'repetisi' => 'Satu hitungan penuh eksekusi gerakan (naik-turun).',
                                            'set' => 'Satu rangkaian repetisi yang dilakukan berturut-turut.',
                                            'tempo' => 'Kecepatan atau ritme dalam mengeksekusi gerakan.',
                                            'concentric' => 'Fase saat otot memendek dan berkontraksi (misal mendorong).',
                                            'eccentric' => 'Fase saat otot memanjang terkontrol (misal menahan turun).',
                                            'isometric' => 'Kontraksi otot tanpa perubahan panjang (menahan beban diam).',
                                            'failure' => 'Titik di mana otot gagal menyelesaikan satu repetisi tambahan.',
                                            'form' => 'Teknik atau postur yang benar saat melakukan gerakan.',
                                            'spotter' => 'Orang yang membantu menjaga pengangkat beban agar aman.',
                                            'compound' => 'Latihan gabungan yang melibatkan banyak sendi dan otot.',
                                            'isolation' => 'Latihan isolasi yang menargetkan satu otot spesifik.',
                                            'torso' => 'Batang tubuh (dada, perut, punggung tanpa lengan/kaki).',
                                        ];
                                        
                                        $instructionsList = collect(preg_split('/[\n\.]+/', $selectedExercise->instructions))
                                            ->map(fn($item) => trim($item))
                                            ->filter(fn($item) => strlen($item) > 2)
                                            ->map(function($item) use ($terms) {
                                                $text = htmlspecialchars($item, ENT_QUOTES);
                                                foreach($terms as $term => $def) {
                                                    $pattern = '/\b(' . preg_quote($term, '/') . ')\b/i';
                                                    $replacement = '<span @click.stop="activeTerm = \'$1\'; activeDef = \'' . addslashes($def) . '\'; termModalOpen = true;" class="cursor-pointer border-b-2 border-dashed border-emerald-400 text-emerald-600 dark:text-emerald-400 font-bold hover:bg-emerald-50 dark:hover:bg-emerald-500/10 transition-colors" title="Klik untuk penjelasan medis">$1</span>';
                                                    $text = preg_replace($pattern, $replacement, $text);
                                                }
                                                return $text;
                                            })
                                            ->all();
                                    @endphp

                                    @if(count($instructionsList) > 0)
                                        <ol class="space-y-4">
                                            @foreach($instructionsList as $index => $instruction)
                                                <li class="flex gap-4">
                                                    <span class="flex-shrink-0 w-8 h-8 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 flex items-center justify-center font-bold text-sm border border-zinc-200 dark:border-zinc-700">
                                                        {{ $index + 1 }}
                                                    </span>
                                                    <p class="text-[15px] text-zinc-700 dark:text-zinc-300 leading-relaxed pt-1">
                                                        {!! $instruction !!}.
                                                    </p>
                                                </li>
                                            @endforeach
                                        </ol>
                                    @else
                                        <p class="text-zinc-600 dark:text-zinc-400 italic bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl">Instruksi belum tersedia, namun pastikan posisi tubuh stabil dan terkontrol.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PREMIUM GLOSSARY POPUP -->
            <div x-show="termModalOpen"
                 x-cloak
                 @click="termModalOpen = false"
                 class="absolute inset-0 z-[10000] flex items-center justify-center p-4 bg-zinc-900/20 dark:bg-black/60 backdrop-blur-md"
                 x-transition.opacity>
                <div @click.stop
                     x-show="termModalOpen"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-90 translate-y-8"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-90 translate-y-8"
                     class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 shadow-2xl rounded-2xl p-6 max-w-sm w-full relative overflow-hidden">
                    
                    <!-- Decorative Element -->
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl"></div>

                    <button @click="termModalOpen = false" class="absolute top-4 right-4 text-zinc-400 hover:text-zinc-900 dark:hover:text-white bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 p-2 rounded-full transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>

                    <div class="flex items-center gap-3 mb-4 relative z-10">
                        <span class="text-white bg-gradient-to-br from-emerald-500 to-teal-500 p-2 rounded-xl shadow-lg shadow-emerald-500/30">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        <h4 class="font-black text-zinc-900 dark:text-white capitalize text-xl tracking-tight" x-text="activeTerm"></h4>
                    </div>
                    <p class="text-base text-zinc-600 dark:text-zinc-300 leading-relaxed relative z-10" x-text="activeDef"></p>
                </div>
            </div>

        </template>
    @endif
</div>
