<div class="space-y-8 sm:space-y-12">
     
    <!-- HEADER CATALOG -->
    <div class="space-y-4">
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-zinc-900 dark:text-zinc-100">
            Katalog Latihan
        </h1>
        <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed max-w-2xl">
            Ikuti panduan repetisi ini untuk hasil otot yang maksimal. Temukan panduan latihan yang tepat untukmu berdasarkan nama gerakan atau target otot.
        </p>
    </div>

    <!-- FILTERS -->
    <div class="space-y-5 sm:space-y-6">
        <!-- Search Bar -->
        <div class="max-w-md relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400 dark:text-zinc-500">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-4.35-4.35M16.5 10.5a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
            </span>
            <input type="text" wire:model.live.debounce.300ms="search" 
                   placeholder="Cari gerakan..." 
                   class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 rounded-md border border-zinc-300 dark:border-zinc-800 focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 dark:focus:border-lime-500 dark:focus:ring-lime-500 text-sm transition-colors placeholder-zinc-400 dark:placeholder-zinc-500">
        </div>

        <!-- Muscle Target Filters -->
        <div class="flex overflow-x-auto gap-2.5 py-4 hide-scrollbar border-y border-zinc-200 dark:border-zinc-800 -mx-4 px-4 sm:mx-0 sm:px-0">
            <button type="button" wire:click="$set('filterMuscle', '')" 
                    class="px-4 py-2 sm:py-1.5 rounded-full text-xs shrink-0 transition-colors {{ $filterMuscle === '' ? 'bg-red-600 text-white dark:bg-lime-400 dark:text-zinc-950 font-semibold border-transparent' : 'bg-white dark:bg-zinc-900 text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-800 hover:bg-zinc-50 hover:text-red-600 dark:hover:bg-zinc-800 dark:hover:text-lime-400' }}">
                Semua Otot
            </button>
            @foreach($muscleTargets as $muscle)
                <button type="button" wire:click="$set('filterMuscle', '{{ $muscle }}')" 
                        class="px-4 py-2 sm:py-1.5 rounded-full text-xs shrink-0 transition-colors {{ $filterMuscle === $muscle ? 'bg-red-600 text-white dark:bg-lime-400 dark:text-zinc-950 font-semibold border-transparent' : 'bg-white dark:bg-zinc-900 text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-800 hover:bg-zinc-50 hover:text-red-600 dark:hover:bg-zinc-800 dark:hover:text-lime-400' }}">
                    {{ $muscle }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- EXERCISES GRID -->
    <div wire:loading.class="opacity-50" wire:target="search, filterMuscle" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 transition-opacity duration-300">
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
                 class="group bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden hover:border-red-600 dark:hover:border-lime-400 hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 cursor-pointer flex flex-col">
                
                <!-- Media -->
                <div class="relative overflow-hidden border-b border-zinc-200 dark:border-zinc-800 h-52">
                    <img :src="images[frame]" src="{{ $exercise->image_1 ?? $exercise->icon }}" class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-110 bg-white dark:bg-zinc-800" alt="{{ $exercise->name }}">
                    
                    <div class="absolute inset-0 bg-zinc-900/10 dark:bg-zinc-950/40 transition-colors duration-500 group-hover:bg-transparent pointer-events-none"></div>
                    <div class="absolute bottom-2 right-2 bg-black/60 backdrop-blur-sm text-white text-[10px] px-2 py-1 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                        Sekuensi diputar
                    </div>
                </div>

                <!-- Info -->
                <div class="p-5 flex-1 space-y-1.5">
                    <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100 group-hover:text-red-600 dark:group-hover:text-lime-400 transition-colors">
                        {{ $exercise->name }}
                    </h3>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 flex items-center flex-wrap gap-2">
                        <span>{{ $exercise->target_muscle }}</span>
                        <span class="w-1 h-1 rounded-full bg-zinc-300 dark:bg-zinc-700"></span>
                        <span>{{ $exercise->difficulty ?? 'Menengah' }}</span>
                        @if($exercise->alternative_equipment)
                            <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-700 dark:bg-amber-900/50 dark:text-amber-400">Ada Alternatif Alat</span>
                        @endif
                    </p>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center space-y-2 text-sm text-zinc-500 dark:text-zinc-400">
                <p>Tidak ada gerakan yang sesuai kriteria pencarian.</p>
                <button type="button" wire:click="resetFilters" class="text-zinc-600 dark:text-zinc-200 hover:text-red-600 dark:hover:text-lime-400 transition-colors hover:underline">Reset Filter</button>
            </div>
        @endforelse
    </div>

    <!-- PAGINATION -->
    <div class="pt-4">
        {{ $exercises->links() }}
    </div>

    <!-- Context-Specific FAQ -->
    <section class="mt-8">
        <h3 class="text-2xl font-extrabold text-gray-800 dark:text-white mb-6 transition-colors duration-300 flex items-center gap-2">
            <span>💡</span> FAQ Seputar Latihan
        </h3>
        <div class="space-y-4" x-data="{ activeAccordion: '' }">
            <div class="faq-item bg-white dark:bg-zinc-800 border border-gray-100 dark:border-zinc-700 rounded-2xl overflow-hidden shadow-sm transition-colors duration-300">
                <button @click="activeAccordion = activeAccordion === 'faq1' ? '' : 'faq1'" class="faq-button w-full flex justify-between items-center p-5 text-left font-bold text-gray-800 dark:text-white hover:bg-gray-50 dark:hover:bg-zinc-700/50 transition-colors focus:outline-none">
                    <span>Mengapa set dan repetisi sangat penting?</span>
                    <span class="faq-icon text-red-600 dark:text-lime-400 transform transition-transform duration-300 text-xl" :class="{'rotate-45': activeAccordion === 'faq1'}">+</span>
                </button>
                <div class="faq-content overflow-hidden transition-all duration-300 ease-in-out bg-gray-50 dark:bg-zinc-900/30" :style="activeAccordion === 'faq1' ? 'max-height: 500px;' : 'max-height: 0px;'">
                    <div class="p-5 text-gray-600 dark:text-zinc-400 leading-relaxed border-t border-gray-100 dark:border-zinc-700">
                        Repetisi adalah satu siklus gerakan, sementara set adalah sekumpulan repetisi. Untuk hipertrofi, rentang 8-12 repetisi sangat ideal untuk menumpuk metabolit otot, sementara 1-5 repetisi berfokus pada adaptasi transmisi saraf motorik (strength). <br><br>
                        <span class="text-xs font-semibold text-zinc-500 dark:text-zinc-500">Sumber: American College of Sports Medicine (ACSM) - "Resistance Training Guidelines"</span>
                    </div>
                </div>
            </div>

            <div class="faq-item bg-white dark:bg-zinc-800 border border-gray-100 dark:border-zinc-700 rounded-2xl overflow-hidden shadow-sm transition-colors duration-300">
                <button @click="activeAccordion = activeAccordion === 'faq2' ? '' : 'faq2'" class="faq-button w-full flex justify-between items-center p-5 text-left font-bold text-gray-800 dark:text-white hover:bg-gray-50 dark:hover:bg-zinc-700/50 transition-colors focus:outline-none">
                    <span>Apakah saya harus melatih otot yang sama tiap hari?</span>
                    <span class="faq-icon text-red-600 dark:text-lime-400 transform transition-transform duration-300 text-xl" :class="{'rotate-45': activeAccordion === 'faq2'}">+</span>
                </button>
                <div class="faq-content overflow-hidden transition-all duration-300 ease-in-out bg-gray-50 dark:bg-zinc-900/30" :style="activeAccordion === 'faq2' ? 'max-height: 500px;' : 'max-height: 0px;'">
                    <div class="p-5 text-gray-600 dark:text-zinc-400 leading-relaxed border-t border-gray-100 dark:border-zinc-700">
                        Sangat tidak direkomendasikan. Sintesis Protein Otot (MPS) berlangsung selama 24-48 jam pasca-latihan beban. Memberikan tekanan mekanik berulang di masa perbaikan tersebut justru akan memicu overtraining dan atrofi otot. <br><br>
                        <span class="text-xs font-semibold text-zinc-500 dark:text-zinc-500">Sumber: Dr. Brad Schoenfeld - "Muscle Recovery Timecourse"</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MINIMALIST MODAL -->
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
                
                <!-- Blurred Backdrop -->
                <div x-show="open" 
                     x-transition.opacity.duration.300ms
                     @click="if(!termModalOpen) open = false"
                     class="absolute inset-0 bg-zinc-900/60 dark:bg-zinc-950/80 backdrop-blur-sm"></div>

                <!-- Modal Content -->
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
                     class="relative w-full h-full max-w-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-none sm:rounded-xl shadow-2xl overflow-hidden max-h-screen sm:max-h-[90vh] flex flex-col z-10">
                    
                    <button @click="open = false" class="absolute top-4 right-4 sm:top-5 sm:right-5 z-50 bg-white/90 dark:bg-zinc-900/90 backdrop-blur-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 p-2 rounded-full border border-zinc-200 dark:border-zinc-800 transition-all hover:scale-105 active:scale-95 shadow-lg">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>

                    <div class="p-4 sm:p-6 overflow-y-auto hide-scrollbar space-y-5 sm:space-y-6">
                        
                        <!-- Media Showcase -->
                        <div class="w-full aspect-video bg-white dark:bg-zinc-950 rounded-lg flex items-center justify-center relative border border-zinc-200 dark:border-zinc-800 overflow-hidden">
                            @if($selectedExercise->icon || $selectedExercise->image_1)
                                <img :src="images[frame]" src="{{ $selectedExercise->image_1 ?? $selectedExercise->icon }}" class="w-full h-full object-contain bg-zinc-900" alt="{{ $selectedExercise->name }}">
                            @else
                                <span class="text-6xl text-zinc-300 dark:text-zinc-500">•</span>
                            @endif
                        </div>

                        <!-- Header -->
                    <div class="space-y-2">
                        <h3 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">
                            {{ $selectedExercise->name }}
                        </h3>
                        <div class="flex items-center flex-wrap gap-3 text-xs text-zinc-500 dark:text-zinc-400">
                            <span class="px-2 py-0.5 rounded bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300">{{ $selectedExercise->target_muscle }}</span>
                            <span>Level: {{ $selectedExercise->difficulty ?? 'Menengah' }}</span>
                            @if($selectedExercise->alternative_equipment)
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-700 dark:bg-amber-900/50 dark:text-amber-400">Ada Alternatif Alat</span>
                            @endif
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="space-y-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                        @if($selectedExercise->alternative_equipment)
                            <div class="p-3 mb-4 rounded-lg bg-yellow-100 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-700/50 flex items-start gap-3">
                                <span class="text-yellow-600 dark:text-yellow-400 text-lg">💡</span>
                                <div class="text-sm font-medium text-yellow-800 dark:text-yellow-200 leading-relaxed">
                                    <span class="font-bold block mb-1">Alternatif Alat:</span>
                                    {{ $selectedExercise->alternative_equipment }}
                                </div>
                            </div>
                        @endif

                        <h4 class="text-xs font-semibold text-zinc-900 dark:text-zinc-300 uppercase tracking-wider">Instruksi</h4>
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
                                        $replacement = '<span @click.stop="activeTerm = \'$1\'; activeDef = \'' . addslashes($def) . '\'; termModalOpen = true;" class="cursor-pointer border-b border-dashed border-lime-500/50 text-lime-600 dark:text-lime-400 font-semibold hover:bg-lime-50 dark:hover:bg-lime-500/10 transition-colors" title="Klik untuk penjelasan">$1</span>';
                                        $text = preg_replace($pattern, $replacement, $text);
                                    }
                                    return $text;
                                })
                                ->all();
                        @endphp
                        @if(count($instructionsList) > 0)
                            <ol class="list-decimal pl-5 space-y-2 text-sm text-zinc-700 dark:text-zinc-300 leading-relaxed">
                                @foreach($instructionsList as $instruction)
                                    <li>{!! $instruction !!}.</li>
                                @endforeach
                            </ol>
                        @else
                            <p class="text-sm text-zinc-700 dark:text-zinc-300">Ikuti gerakan secara perlahan dan pastikan posisi tubuh stabil.</p>
                        @endif
                    </div>

                </div>
            </div>

            <!-- WIKIPEDIA-LIKE TERM POPUP -->
            <div x-show="termModalOpen"
                 x-cloak
                 @click="termModalOpen = false"
                 class="absolute inset-0 z-[110] flex items-center justify-center p-4 bg-zinc-900/40 dark:bg-zinc-950/40 backdrop-blur-sm"
                 x-transition.opacity>
                <div @click.stop
                     x-show="termModalOpen"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                     class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-2xl rounded-xl p-5 max-w-sm w-full relative">
                    
                    <button @click="termModalOpen = false" class="absolute top-4 right-4 text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>

                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-lime-600 dark:text-lime-400 bg-lime-50 dark:bg-lime-400/10 p-1.5 rounded-lg border border-lime-200 dark:border-lime-400/20">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        <h4 class="font-semibold text-zinc-900 dark:text-zinc-100 capitalize text-lg" x-text="activeTerm"></h4>
                    </div>
                    <p class="text-sm text-zinc-600 dark:text-zinc-300 leading-relaxed" x-text="activeDef"></p>
                </div>
            </div>

        </div>
        </template>
    @endif
</div>
