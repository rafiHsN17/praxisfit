<div class="space-y-8 pb-10">

    <!-- HEADER CATALOG -->
    <div class="rounded-3xl bg-white dark:bg-[#1A1012] p-6 sm:p-10 border border-[#E9E9EC] dark:border-[#342427] shadow-sm relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-[#E54855]"></div>
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#E54855]/10 border border-[#E54855]/25 text-[#E54855] text-xs font-bold uppercase tracking-wider">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                    </svg>
                    Exercise Library
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-[#202124] dark:text-[#F5F5F5]">
                    Katalog <span class="text-[#E54855]">Gerakan Latihan</span>
                </h1>
                <p class="text-sm text-[#777777] dark:text-[#AAA0A2] max-w-2xl leading-relaxed">
                    Jelajahi ratusan gerakan dengan filter multi-kriteria (alat, tingkat kesulitan, kelompok otot, dan kategori) langsung dari database.
                </p>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <span class="px-3.5 py-2 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-xs font-bold text-[#202124] dark:text-[#F5F5F5]">
                    Menampilkan <span class="text-[#E54855]">{{ $exercises->total() }}</span> Gerakan
                </span>
                @if($hasActiveFilters)
                    <button type="button" wire:click="resetFilters"
                            class="px-4 py-2 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white text-xs font-bold shadow-sm transition-colors cursor-pointer">
                        Reset Filter
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- MULTI-FILTER PANEL (SEARCH + SEARCHABLE DROPDOWNS + MUSCLE + CATEGORY) -->
    <div class="bg-white dark:bg-[#1A1012] rounded-3xl border border-[#E9E9EC] dark:border-[#342427] p-5 sm:p-6 shadow-sm space-y-5">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3.5">
            <!-- 1. Search Bar -->
            <div class="sm:col-span-2 lg:col-span-4">
                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#777777] dark:text-[#AAA0A2] mb-1.5">Cari Gerakan</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#777777] dark:text-[#AAA0A2]">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16.5 10.5a6 6 0 11-12 0 6 6 0 0112 0z"/>
                        </svg>
                    </span>
                    <input type="text"
                           wire:model.live.debounce.300ms="search"
                           placeholder="Nama gerakan, otot, instruksi..."
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm bg-[#F7F7F8] dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] border border-[#E9E9EC] dark:border-[#342427] focus:outline-none focus:border-[#E54855] focus:ring-2 focus:ring-[#E54855]/20 placeholder-[#777777] dark:placeholder-[#AAA0A2]">
                </div>
            </div>

            <!-- 2. Searchable Dropdown: Equipment -->
            <div class="lg:col-span-3"
                 x-data="{
                    open: false,
                    search: '',
                    selected: @entangle('filterEquipment').live,
                    options: @js($equipments->values()->all()),
                    get filtered() {
                        if (!this.search.trim()) return this.options;
                        const q = this.search.toLowerCase();
                        return this.options.filter(o => o.toLowerCase().includes(q));
                    }
                 }"
                 @click.away="open = false">
                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#777777] dark:text-[#AAA0A2] mb-1.5">Alat Olahraga</label>
                <div class="relative">
                    <button type="button" @click="open = !open"
                            class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-left cursor-pointer {{ $filterEquipment !== '' ? 'border-[#E54855] text-[#E54855] font-bold' : 'text-[#202124] dark:text-[#F5F5F5] font-medium' }}">
                        <span class="truncate" x-text="selected ? selected : 'Semua Alat'"></span>
                        <svg class="w-4 h-4 shrink-0 transition-transform" :class="open ? 'rotate-180 text-[#E54855]' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="open" x-cloak
                         class="absolute z-40 w-full mt-1.5 bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] rounded-xl shadow-xl overflow-hidden">
                        <div class="p-2 border-b border-[#E9E9EC] dark:border-[#342427]">
                            <input type="text" x-model="search" placeholder="Cari alat..."
                                   class="w-full px-3 py-1.5 text-xs rounded-lg bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]">
                        </div>
                        <div class="max-h-56 overflow-y-auto divide-y divide-[#E9E9EC]/50 dark:divide-[#342427]/50">
                            <button type="button" @click="selected = ''; open = false; search = '';"
                                    class="w-full text-left px-3.5 py-2 text-xs font-bold hover:bg-[#F7F7F8] dark:hover:bg-[#251518]"
                                    :class="selected === '' ? 'text-[#E54855]' : 'text-[#777777] dark:text-[#AAA0A2]'">
                                Semua Alat
                            </button>
                            <template x-for="eq in filtered" :key="eq">
                                <button type="button" @click="selected = eq; open = false; search = '';"
                                        class="w-full text-left px-3.5 py-2 text-xs font-semibold hover:bg-[#F7F7F8] dark:hover:bg-[#251518]"
                                        :class="selected === eq ? 'text-[#E54855] bg-[#E54855]/5 font-bold' : 'text-[#202124] dark:text-[#F5F5F5]'"
                                        x-text="eq">
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Searchable Dropdown: Level Kesulitan -->
            <div class="lg:col-span-3"
                 x-data="{
                    open: false,
                    search: '',
                    selected: @entangle('filterDifficulty').live,
                    options: [
                        { value: 'Pemula', label: 'Beginner (Pemula)' },
                        { value: 'Menengah', label: 'Intermediate (Menengah)' },
                        { value: 'Lanjut', label: 'Advanced (Lanjut)' }
                    ],
                    get filtered() {
                        if (!this.search.trim()) return this.options;
                        const q = this.search.toLowerCase();
                        return this.options.filter(o => o.label.toLowerCase().includes(q) || o.value.toLowerCase().includes(q));
                    },
                    get selectedLabel() {
                        const found = this.options.find(o => o.value === this.selected);
                        return found ? found.label : 'Semua Level';
                    }
                 }"
                 @click.away="open = false">
                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#777777] dark:text-[#AAA0A2] mb-1.5">Level Kesulitan</label>
                <div class="relative">
                    <button type="button" @click="open = !open"
                            class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-left cursor-pointer {{ $filterDifficulty !== '' ? 'border-[#E54855] text-[#E54855] font-bold' : 'text-[#202124] dark:text-[#F5F5F5] font-medium' }}">
                        <span class="truncate" x-text="selectedLabel"></span>
                        <svg class="w-4 h-4 shrink-0 transition-transform" :class="open ? 'rotate-180 text-[#E54855]' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="open" x-cloak
                         class="absolute z-40 w-full mt-1.5 bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] rounded-xl shadow-xl overflow-hidden">
                        <div class="p-2 border-b border-[#E9E9EC] dark:border-[#342427]">
                            <input type="text" x-model="search" placeholder="Cari level..."
                                   class="w-full px-3 py-1.5 text-xs rounded-lg bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]">
                        </div>
                        <div class="divide-y divide-[#E9E9EC]/50 dark:divide-[#342427]/50">
                            <button type="button" @click="selected = ''; open = false; search = '';"
                                    class="w-full text-left px-3.5 py-2 text-xs font-bold hover:bg-[#F7F7F8] dark:hover:bg-[#251518]"
                                    :class="selected === '' ? 'text-[#E54855]' : 'text-[#777777] dark:text-[#AAA0A2]'">
                                Semua Level
                            </button>
                            <template x-for="opt in filtered" :key="opt.value">
                                <button type="button" @click="selected = opt.value; open = false; search = '';"
                                        class="w-full text-left px-3.5 py-2 text-xs font-semibold hover:bg-[#F7F7F8] dark:hover:bg-[#251518]"
                                        :class="selected === opt.value ? 'text-[#E54855] bg-[#E54855]/5 font-bold' : 'text-[#202124] dark:text-[#F5F5F5]'"
                                        x-text="opt.label">
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. Kategori Latihan -->
            <div class="lg:col-span-2">
                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#777777] dark:text-[#AAA0A2] mb-1.5">Kategori</label>
                <select wire:model.live="filterCategory"
                        class="w-full px-3 py-2.5 rounded-xl text-sm bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5] font-medium focus:outline-none focus:border-[#E54855]">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- 5. Kelompok Otot Filter: Horizontal Pills + Searchable Dropdown Option -->
        <div class="space-y-2.5 pt-2 border-t border-[#E9E9EC] dark:border-[#342427]">
            <div class="flex items-center justify-between gap-2">
                <span class="text-[11px] font-bold uppercase tracking-wider text-[#777777] dark:text-[#AAA0A2]">Kelompok Otot Target</span>
                <select wire:model.live="filterMuscle" aria-label="Pilih Kelompok Otot"
                        class="sm:hidden px-3 py-1.5 rounded-lg text-xs bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5]">
                    <option value="">Semua Otot</option>
                    @foreach($muscleTargets as $muscle)
                        <option value="{{ $muscle }}">{{ $muscle }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex overflow-x-auto gap-2 py-1 hide-scrollbar">
                <button type="button" wire:click="$set('filterMuscle', '')"
                        class="px-4 py-2 rounded-xl text-xs font-bold shrink-0 transition-colors cursor-pointer {{ $filterMuscle === '' ? 'bg-[#E54855] text-white shadow-sm' : 'bg-[#F7F7F8] dark:bg-[#251518] text-[#777777] dark:text-[#AAA0A2] border border-[#E9E9EC] dark:border-[#342427] hover:text-[#E54855]' }}">
                    Semua Otot
                </button>
                @foreach($muscleTargets as $muscle)
                    <button type="button" wire:click="$set('filterMuscle', '{{ $muscle }}')"
                            class="px-4 py-2 rounded-xl text-xs font-bold shrink-0 transition-colors cursor-pointer {{ $filterMuscle === $muscle ? 'bg-[#E54855] text-white shadow-sm' : 'bg-[#F7F7F8] dark:bg-[#251518] text-[#777777] dark:text-[#AAA0A2] border border-[#E9E9EC] dark:border-[#342427] hover:text-[#E54855]' }}">
                        {{ $muscle }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- EXERCISES GRID CARDS -->
    <div wire:loading.class="opacity-60" wire:target="search, filterMuscle, filterEquipment, filterDifficulty, filterCategory, resetFilters"
         class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 transition-opacity duration-200">
        @forelse($exercises as $exercise)
            <div wire:click="openExerciseDetail({{ $exercise->id }})"
                 wire:key="exercise-{{ $exercise->id }}"
                 x-data="{
                     timer: null,
                     frame: 0,
                     images: @js(collect([$exercise->image_1 ?? $exercise->icon, $exercise->image_2, $exercise->image_3])->filter()->values()->all())
                 }"
                 @mouseenter="if(images.length > 1) { frame = 1; timer = setInterval(() => { frame = (frame + 1) % images.length }, 500) }"
                 @mouseleave="clearInterval(timer); frame = 0"
                 class="group bg-white dark:bg-[#1A1012] rounded-3xl overflow-hidden border border-[#E9E9EC] dark:border-[#342427] hover:border-[#E54855]/70 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 cursor-pointer flex flex-col">

                <!-- Media Fokus Utama -->
                <div class="relative overflow-hidden bg-[#F7F7F8] dark:bg-[#100809] h-52 w-full flex items-center justify-center p-4">
                    <img :src="images[frame] || '{{ $exercise->image_1 ?? $exercise->icon }}'"
                         src="{{ $exercise->image_1 ?? $exercise->icon }}"
                         class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-105"
                         alt="{{ $exercise->name }}"
                         loading="lazy">

                    <span class="absolute top-3 left-3 px-2.5 py-1 rounded-lg bg-white/95 dark:bg-[#1A1012]/95 text-[#202124] dark:text-[#F5F5F5] border border-[#E9E9EC] dark:border-[#342427] text-[10px] font-bold uppercase tracking-wider">
                        {{ $exercise->equipment ?? 'Bodyweight' }}
                    </span>

                    @if($exercise->alternative_equipment)
                        <span class="absolute top-3 right-3 px-2 py-1 rounded-lg bg-[#E54855] text-white text-[10px] font-bold" title="Tersedia Alternatif Alat Rumah">
                            Home Alt
                        </span>
                    @endif
                </div>

                <!-- Card Metadata -->
                <div class="p-5 flex-1 flex flex-col justify-between space-y-3 border-t border-[#E9E9EC] dark:border-[#342427]">
                    <div class="space-y-2">
                        <div class="flex flex-wrap items-center gap-1.5">
                            <span class="px-2.5 py-0.5 rounded-md bg-[#E54855]/10 text-[#E54855] text-[11px] font-bold uppercase tracking-wide">
                                {{ $exercise->target_muscle }}
                            </span>
                            @if($exercise->category)
                                <span class="px-2 py-0.5 rounded-md bg-[#F7F7F8] dark:bg-[#251518] text-[#777777] dark:text-[#AAA0A2] text-[10px] font-semibold">
                                    {{ $exercise->category }}
                                </span>
                            @endif
                        </div>

                        <h3 class="text-base sm:text-lg font-bold text-[#202124] dark:text-[#F5F5F5] group-hover:text-[#E54855] transition-colors line-clamp-2">
                            {{ $exercise->name }}
                        </h3>
                    </div>

                    <div class="flex items-center justify-between pt-2 border-t border-[#E9E9EC]/60 dark:border-[#342427]/60 text-xs font-semibold text-[#777777] dark:text-[#AAA0A2]">
                        <span>Level: <strong class="text-[#202124] dark:text-[#F5F5F5]">{{ $exercise->difficulty ?? 'Menengah' }}</strong></span>
                        <span class="text-[#E54855] font-bold group-hover:translate-x-1 transition-transform">Detail &rarr;</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 flex flex-col items-center justify-center text-center space-y-4 bg-white dark:bg-[#1A1012] rounded-3xl border border-dashed border-[#E9E9EC] dark:border-[#342427] p-6">
                <div class="w-16 h-16 bg-[#E54855]/10 text-[#E54855] rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-4.35-4.35M16.5 10.5a6 6 0 11-12 0 6 6 0 0112 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">Tidak ada gerakan yang sesuai filter</h3>
                <p class="text-sm text-[#777777] dark:text-[#AAA0A2] max-w-md">
                    Coba ubah kombinasi alat, level kesulitan, kelompok otot, atau klik tombol di bawah untuk mengembalikan seluruh daftar gerakan.
                </p>
                <button type="button" wire:click="resetFilters"
                        class="px-6 py-2.5 bg-[#E54855] hover:bg-[#C93646] text-white rounded-xl text-sm font-bold transition-colors cursor-pointer">
                    Reset Filter
                </button>
            </div>
        @endforelse
    </div>

    <!-- PAGINATION -->
    <div class="pt-4">
        {{ $exercises->links() }}
    </div>

    <!-- MEDICAL FACTS SECTION (ORIGINAL INDONESIAN SOURCES PRESERVED) -->
    <section class="bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] rounded-3xl p-6 sm:p-8 shadow-sm">
        <h3 class="text-xl sm:text-2xl font-extrabold text-[#202124] dark:text-[#F5F5F5] mb-6 flex items-center gap-3">
            <span class="p-2 rounded-xl bg-[#E54855]/10 text-[#E54855]">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </span>
            Fakta Medis Latihan
        </h3>
        <div class="space-y-3" x-data="{ activeAccordion: '' }">
            <div class="bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] rounded-2xl overflow-hidden">
                <button type="button" @click="activeAccordion = activeAccordion === 'faq1' ? '' : 'faq1'"
                        class="w-full flex justify-between items-center p-5 text-left font-bold text-[#202124] dark:text-[#F5F5F5] focus:outline-none">
                    <span class="text-sm sm:text-base">Mengapa pengaturan set dan repetisi sangat penting?</span>
                    <svg class="w-5 h-5 text-[#E54855] transform transition-transform duration-300 shrink-0 ml-3" :class="{'rotate-180': activeAccordion === 'faq1'}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="activeAccordion === 'faq1'" x-collapse class="border-t border-[#E9E9EC] dark:border-[#342427] bg-white dark:bg-[#1A1012]">
                    <div class="p-5 text-sm text-[#777777] dark:text-[#AAA0A2] leading-relaxed">
                        Repetisi adalah satu kali gerakan penuh, sedangkan set adalah kumpulan repetisi sebelum Anda beristirahat sejenak. Untuk membentuk volume otot (hipertrofi), rentang 8–12 repetisi dengan kontrol gerakan yang rapi sangat efektif merangsang serat otot tanpa membebani sendi berlebihan.
                        <span class="block mt-3 text-xs font-bold text-[#E54855]">Sumber: Bobby Ida (Binaragawan Natural & Certified Fitness Trainer Indonesia) & Hello Sehat</span>
                    </div>
                </div>
            </div>

            <div class="bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] rounded-2xl overflow-hidden">
                <button type="button" @click="activeAccordion = activeAccordion === 'faq2' ? '' : 'faq2'"
                        class="w-full flex justify-between items-center p-5 text-left font-bold text-[#202124] dark:text-[#F5F5F5] focus:outline-none">
                    <span class="text-sm sm:text-base">Apakah boleh melatih bagian otot yang sama berturut-turut tiap hari?</span>
                    <svg class="w-5 h-5 text-[#E54855] transform transition-transform duration-300 shrink-0 ml-3" :class="{'rotate-180': activeAccordion === 'faq2'}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="activeAccordion === 'faq2'" x-collapse class="border-t border-[#E9E9EC] dark:border-[#342427] bg-white dark:bg-[#1A1012]">
                    <div class="p-5 text-sm text-[#777777] dark:text-[#AAA0A2] leading-relaxed">
                        Tidak disarankan. Setelah latihan beban, jaringan otot memerlukan waktu pemulihan sekitar 24–48 jam untuk memperbaiki serat mikro yang bekerja keras. Melatih otot yang sama terus-menerus setiap hari justru berisiko memicu overtraining dan menghambat perkembangan otot Anda.
                        <span class="block mt-3 text-xs font-bold text-[#E54855]">Sumber: dr. Sophia Hage, Sp.KO (Dokter Spesialis Kedokteran Olahraga) via KlikDokter</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- DETAIL EXERCISE MODAL -->
    @if($selectedExercise)
        <template x-teleport="body">
            <div x-data="{
                    open: true,
                    termModalOpen: false,
                    activeTerm: '',
                    activeDef: '',
                    modalTimer: null,
                    frame: 0,
                    images: @js(collect([$selectedExercise->image_1 ?? $selectedExercise->icon, $selectedExercise->image_2, $selectedExercise->image_3])->filter()->values()->all())
                 }"
                 x-show="open"
                 x-init="
                     if(images.length > 1) { modalTimer = setInterval(() => { frame = (frame + 1) % images.length }, 600); }
                     $watch('open', value => { if(!value) { clearInterval(modalTimer); setTimeout(() => $wire.closeExerciseDetail(), 200); } })
                 "
                 @keydown.escape.window="if(termModalOpen) { termModalOpen = false; } else { open = false; }"
                 class="fixed inset-0 z-[9999] flex items-center justify-center p-0 sm:p-6"
                 x-cloak>

                <div x-show="open" x-transition.opacity @click="if(!termModalOpen) open = false"
                     class="absolute inset-0 bg-black/75 backdrop-blur-sm"></div>

                <div x-show="open"
                     class="relative w-full h-full max-w-2xl bg-white dark:bg-[#1A1012] sm:rounded-3xl shadow-2xl overflow-hidden max-h-screen sm:max-h-[90vh] flex flex-col z-10 border border-[#E9E9EC] dark:border-[#342427]">

                    <button type="button" @click="open = false"
                            class="absolute top-4 right-4 z-50 bg-white/90 dark:bg-[#251518]/90 text-[#202124] dark:text-[#F5F5F5] hover:text-[#E54855] p-2.5 rounded-full border border-[#E9E9EC] dark:border-[#342427] transition-all cursor-pointer">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>

                    <div class="flex-1 overflow-y-auto hide-scrollbar">
                        <div class="w-full aspect-video bg-[#F7F7F8] dark:bg-[#100809] flex items-center justify-center relative p-4">
                            @if($selectedExercise->icon || $selectedExercise->image_1)
                                <img :src="images[frame]" src="{{ $selectedExercise->image_1 ?? $selectedExercise->icon }}" class="w-full h-full object-contain" alt="{{ $selectedExercise->name }}">
                            @endif
                        </div>

                        <div class="p-6 sm:p-8 space-y-6">
                            <div class="space-y-3">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="px-3 py-1 rounded-lg bg-[#E54855]/10 text-[#E54855] font-bold text-xs uppercase tracking-wider">{{ $selectedExercise->target_muscle }}</span>
                                    <span class="px-3 py-1 rounded-lg bg-[#F7F7F8] dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] border border-[#E9E9EC] dark:border-[#342427] font-bold text-xs uppercase tracking-wider">{{ $selectedExercise->difficulty ?? 'Menengah' }}</span>
                                    <span class="px-3 py-1 rounded-lg bg-[#F7F7F8] dark:bg-[#251518] text-[#777777] dark:text-[#AAA0A2] border border-[#E9E9EC] dark:border-[#342427] font-bold text-xs uppercase tracking-wider">{{ $selectedExercise->equipment ?? 'Bodyweight' }}</span>
                                    @if($selectedExercise->category)
                                        <span class="px-3 py-1 rounded-lg bg-[#F7F7F8] dark:bg-[#251518] text-[#777777] dark:text-[#AAA0A2] font-semibold text-xs">{{ $selectedExercise->category }}</span>
                                    @endif
                                </div>
                                <h3 class="text-2xl sm:text-3xl font-extrabold text-[#202124] dark:text-[#F5F5F5] tracking-tight">
                                    {{ $selectedExercise->name }}
                                </h3>
                            </div>

                            @if($selectedExercise->alternative_equipment)
                                <div class="p-4 rounded-2xl bg-[#E54855]/10 border border-[#E54855]/30 flex gap-3.5">
                                    <div class="w-9 h-9 rounded-xl bg-[#E54855] text-white flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div class="text-sm text-[#202124] dark:text-[#F5F5F5] leading-relaxed">
                                        <span class="font-bold block mb-0.5 text-[#E54855]">Alternatif Alat (Home Workout):</span>
                                        {{ $selectedExercise->alternative_equipment }}
                                    </div>
                                </div>
                            @endif

                            <div>
                                <h4 class="text-xs font-extrabold text-[#202124] dark:text-[#F5F5F5] uppercase tracking-widest mb-4 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-[#E54855]"></span>
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

                                    $instructionsList = collect(preg_split('/[\n\.]+/', (string) $selectedExercise->instructions))
                                        ->map(fn($item) => trim($item))
                                        ->filter(fn($item) => strlen($item) > 2)
                                        ->map(function($item) use ($terms) {
                                            $text = htmlspecialchars($item, ENT_QUOTES);
                                            foreach($terms as $term => $def) {
                                                $pattern = '/\b(' . preg_quote($term, '/') . ')\b/i';
                                                $replacement = '<span @click.stop="activeTerm = \'$1\'; activeDef = \'' . addslashes($def) . '\'; termModalOpen = true;" class="cursor-pointer border-b-2 border-dashed border-[#E54855] text-[#E54855] font-bold hover:bg-[#E54855]/10 transition-colors" title="Klik untuk penjelasan istilah">$1</span>';
                                                $text = preg_replace($pattern, $replacement, $text);
                                            }
                                            return $text;
                                        })
                                        ->all();
                                @endphp

                                @if(count($instructionsList) > 0)
                                    <ol class="space-y-3.5">
                                        @foreach($instructionsList as $index => $instruction)
                                            <li class="flex gap-3.5">
                                                <span class="shrink-0 w-7 h-7 rounded-full bg-[#F7F7F8] dark:bg-[#251518] text-[#E54855] flex items-center justify-center font-bold text-xs border border-[#E9E9EC] dark:border-[#342427]">
                                                    {{ $index + 1 }}
                                                </span>
                                                <p class="text-sm text-[#777777] dark:text-[#AAA0A2] leading-relaxed pt-0.5">
                                                    {!! $instruction !!}.
                                                </p>
                                            </li>
                                        @endforeach
                                    </ol>
                                @else
                                    <p class="text-sm text-[#777777] dark:text-[#AAA0A2] italic">Instruksi belum tersedia, pastikan postur tubuh tetap stabil dan terkontrol.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- GLOSSARY POPUP -->
                <div x-show="termModalOpen" x-cloak @click="termModalOpen = false"
                     class="fixed inset-0 z-[10000] flex items-center justify-center p-4 bg-black/70 backdrop-blur-xs">
                    <div @click.stop class="bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] shadow-2xl rounded-2xl p-6 max-w-sm w-full relative">
                        <button type="button" @click="termModalOpen = false"
                                class="absolute top-3.5 right-3.5 text-[#777777] hover:text-[#E54855] p-1.5 rounded-lg cursor-pointer">
                            &times;
                        </button>
                        <h4 class="font-extrabold text-[#E54855] capitalize text-lg mb-2" x-text="activeTerm"></h4>
                        <p class="text-sm text-[#202124] dark:text-[#F5F5F5] leading-relaxed" x-text="activeDef"></p>
                    </div>
                </div>
            </div>
        </template>
    @endif
</div>
