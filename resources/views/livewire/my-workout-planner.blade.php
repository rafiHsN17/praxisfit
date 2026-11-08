<div x-data="{ open: false }"
     x-on:open-modal-form.window="open = true"
     x-on:close-modal-form.window="open = false"
     class="max-w-5xl mx-auto space-y-8 pb-16">

    @php
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $groupedRoutines = $routines->groupBy('day_of_week');
        $activeDaysCount = 0;
        foreach ($days as $day) {
            if (!isset($groupedRoutines[$day])) {
                $groupedRoutines[$day] = collect();
            } elseif ($groupedRoutines[$day]->count() > 0) {
                $activeDaysCount++;
            }
        }
        $totalRoutinesCount = $routines->count();
    @endphp

    <!-- Header Card Berwarna Sesuai Tema Light/Dark -->
    <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
        <div class="h-1 w-full bg-red-600 dark:bg-emerald-500"></div>
        <div class="p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div class="space-y-3">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-600 border border-red-100 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Rutinitas Mingguan
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
                        {{ $activeDaysCount }}/7 Hari Aktif &bull; {{ $totalRoutinesCount }} Gerakan
                    </span>
                </div>

                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                        Jadwal Latihan <span class="text-red-600 dark:text-emerald-400">Anda</span>
                    </h1>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 max-w-xl mt-1">
                        Susun pembagian otot dan target repetisi harian dari Senin hingga Minggu agar progres latihan lebih terukur.
                    </p>
                </div>
            </div>

            <button type="button" @click="open = true; $wire.resetForm()"
                    class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-red-600 hover:bg-red-700 dark:bg-emerald-600 dark:hover:bg-emerald-500 text-white text-sm font-semibold shadow-sm transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Tambah Jadwal</span>
            </button>
        </div>
    </div>

    <!-- Daftar Jadwal Mingguan -->
    <div class="space-y-5">
        @foreach($days as $index => $day)
            @php $hasRoutines = $groupedRoutines[$day]->count() > 0; @endphp
            <div class="bg-white dark:bg-zinc-900 rounded-2xl border {{ $hasRoutines ? 'border-zinc-200 dark:border-zinc-800' : 'border-zinc-200/80 dark:border-zinc-800/70' }} p-5 sm:p-6 shadow-sm space-y-4 transition-colors">

                <!-- Header Hari -->
                <div class="flex items-center justify-between gap-4 border-b border-zinc-100 dark:border-zinc-800 pb-4">
                    <div class="flex items-center gap-3">
                        <span class="w-9 h-9 rounded-xl flex items-center justify-center text-sm font-bold border {{ $hasRoutines ? 'bg-red-50 text-red-600 border-red-100 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20' : 'bg-zinc-100 text-zinc-500 border-zinc-200 dark:bg-zinc-800 dark:text-zinc-400 dark:border-zinc-700' }}">
                            {{ $index + 1 }}
                        </span>
                        <div>
                            <div class="flex items-center gap-2.5">
                                <h2 class="text-base sm:text-lg font-bold text-zinc-900 dark:text-zinc-100">
                                    {{ $day }}
                                </h2>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $hasRoutines ? 'bg-red-50 text-red-600 dark:bg-emerald-500/10 dark:text-emerald-400' : 'bg-zinc-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400' }}">
                                    {{ $hasRoutines ? $groupedRoutines[$day]->count() . ' Gerakan' : 'Rest Day' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <button type="button" @click="open = true; $wire.resetForm('{{ $day }}')"
                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-red-50 hover:bg-red-100 text-red-600 border border-red-200/70 dark:bg-emerald-500/10 dark:hover:bg-emerald-500/20 dark:text-emerald-400 dark:border-emerald-500/25 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Tambah</span>
                    </button>
                </div>

                <!-- Daftar Gerakan per Hari -->
                @if($hasRoutines)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($groupedRoutines[$day] as $routine)
                            <div class="rounded-xl p-4 border border-zinc-200 dark:border-zinc-800 hover:border-red-300 dark:hover:border-emerald-500/40 bg-zinc-50/70 dark:bg-zinc-800/40 flex flex-col justify-between gap-4 transition-colors">
                                <div class="space-y-3">
                                    <div class="flex items-start gap-3">
                                        <div class="w-14 h-14 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700/80 p-1.5 flex items-center justify-center shrink-0 overflow-hidden">
                                            @php
                                                $videoUrl = preg_replace('/^\[(.*?)\]\(.*?\)$/', '$1', $routine->exercise->video_male ?? '');
                                                $thumbImg = $routine->exercise->image_1 ?? $routine->exercise->icon ?? '';
                                            @endphp
                                            @if($videoUrl)
                                                <video src="{{ $videoUrl }}" class="w-full h-full object-cover rounded-lg" autoplay loop muted playsinline></video>
                                            @elseif($thumbImg)
                                                <img src="{{ $thumbImg }}" alt="{{ $routine->exercise->name ?? 'Gerakan' }}" class="w-full h-full object-contain">
                                            @else
                                                <svg class="w-5 h-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                                                </svg>
                                            @endif
                                        </div>

                                        <div class="min-w-0 flex-1 space-y-1.5">
                                            <span class="inline-block px-2 py-0.5 rounded-md text-[10px] font-semibold uppercase tracking-wide bg-red-50 text-red-600 border border-red-100 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20">
                                                {{ $routine->exercise->target_muscle ?? 'Umum' }}
                                            </span>
                                            <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100 truncate">
                                                {{ $routine->exercise->name ?? 'Gerakan Tanpa Nama' }}
                                            </h3>
                                            <div class="inline-flex items-center gap-1.5 text-xs font-semibold text-zinc-700 dark:text-zinc-300">
                                                <span class="text-red-600 dark:text-emerald-400 font-bold">{{ $routine->sets }} Set</span>
                                                <span class="text-zinc-400">&times;</span>
                                                <span>{{ $routine->reps }} Reps</span>
                                            </div>
                                        </div>
                                    </div>

                                    @if($routine->notes)
                                        <p class="text-xs text-zinc-600 dark:text-zinc-400 bg-white dark:bg-zinc-900 border border-zinc-200/70 dark:border-zinc-800 rounded-lg px-3 py-2 italic">
                                            "{{ $routine->notes }}"
                                        </p>
                                    @endif
                                </div>

                                <div class="pt-3 border-t border-zinc-200/70 dark:border-zinc-800 flex justify-end gap-2">
                                    <button type="button" wire:click="edit({{ $routine->id }})"
                                            class="px-3 py-1.5 rounded-lg text-xs font-semibold text-zinc-700 dark:text-zinc-200 bg-white dark:bg-zinc-900 hover:text-red-600 dark:hover:text-emerald-400 hover:border-red-200 dark:hover:border-emerald-500/30 border border-zinc-200 dark:border-zinc-700 transition-colors">
                                        Edit
                                    </button>
                                    <button type="button" wire:click="delete({{ $routine->id }})"
                                            wire:confirm="Hapus gerakan ini dari jadwal hari {{ $routine->day_of_week }}?"
                                            class="px-3 py-1.5 rounded-lg text-xs font-semibold text-red-600 dark:text-red-400 bg-red-50/70 dark:bg-red-950/30 hover:bg-red-100 dark:hover:bg-red-950/50 border border-red-200/70 dark:border-red-900/40 transition-colors">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex items-center justify-between gap-4 py-2.5 px-3.5 rounded-xl bg-zinc-50 dark:bg-zinc-800/30 border border-dashed border-zinc-200 dark:border-zinc-800">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">
                            Belum ada gerakan terjadwal. Jadikan hari istirahat pemulihan otot atau klik <strong>Tambah</strong> di kanan atas.
                        </p>
                    </div>
                @endif

            </div>
        @endforeach
    </div>

    <!-- Modal Form Berwarna Proporsional (Light Red / Dark Emerald) -->
    <div x-show="open" x-cloak
         @keydown.escape.window="open = false; $wire.resetForm()"
         class="fixed inset-0 z-[120] flex items-center justify-center p-4 bg-black/65 backdrop-blur-xs"
         x-transition.opacity.duration.200ms>

        <div @click.away="open = false; $wire.resetForm()"
             class="bg-white dark:bg-zinc-900 w-full max-w-lg rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-2xl max-h-[90vh] overflow-y-auto"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">

            <!-- Garis Aksen Tema Atas Modal -->
            <div class="h-1 w-full bg-red-600 dark:bg-emerald-500"></div>

            <div class="p-6 space-y-5">
                <!-- Modal Header -->
                <div class="flex items-start justify-between gap-4 border-b border-zinc-200 dark:border-zinc-800 pb-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-red-50 dark:bg-emerald-500/10 border border-red-100 dark:border-emerald-500/20 text-red-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">
                                {{ $routine_id ? 'Edit Jadwal Latihan' : 'Tambah Jadwal Latihan' }}
                            </h2>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                                Pilih gerakan dari katalog dan atur target set serta repetisi Anda.
                            </p>
                        </div>
                    </div>
                    <button type="button" @click="open = false; $wire.resetForm()"
                            class="p-1.5 rounded-lg text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Modal Form -->
                <form wire:submit.prevent="save" class="space-y-4">

                    <!-- 1. Pilih Gerakan -->
                    <div class="relative space-y-1.5"
                         x-data="{
                             openDropdown: false,
                             search: '',
                             selectedId: @entangle('exercise_id'),
                             exercises: {{ $exercises->map(fn($ex) => [
                                 'id' => $ex->id,
                                 'name' => $ex->name,
                                 'target' => $ex->target_muscle ?? 'Lainnya',
                                 'difficulty' => $ex->difficulty ?? 'Menengah',
                                 'animation' => $ex->image_1 ?? $ex->icon ?? ''
                             ])->toJson() }},
                             get selectedExercise() {
                                 if (!this.selectedId && this.exercises.length > 0) return this.exercises[0];
                                 return this.exercises.find(e => e.id == this.selectedId) || this.exercises[0] || null;
                             },
                             get filteredExercises() {
                                 let results = this.exercises;
                                 if (this.search.trim()) {
                                     const q = this.search.toLowerCase();
                                     results = results.filter(e => e.name.toLowerCase().includes(q) || e.target.toLowerCase().includes(q) || e.difficulty.toLowerCase().includes(q));
                                 }
                                 return results.slice(0, 30);
                             },
                             selectExercise(id) {
                                 this.selectedId = id;
                                 $wire.set('exercise_id', id);
                                 this.openDropdown = false;
                                 this.search = '';
                             }
                         }">

                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300">
                                Gerakan Latihan
                            </label>
                            <span class="text-[11px] font-medium text-red-600 dark:text-emerald-400">
                                {{ $exercises->count() }} gerakan tersedia
                            </span>
                        </div>

                        <!-- Card Preview -->
                        <div class="p-3.5 rounded-xl bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3.5 min-w-0">
                                <div class="w-14 h-14 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 p-1.5 shrink-0 flex items-center justify-center overflow-hidden">
                                    <template x-if="selectedExercise && selectedExercise.animation">
                                        <img :src="selectedExercise.animation" class="w-full h-full object-contain" alt="Preview Gerakan" loading="lazy">
                                    </template>
                                    <template x-if="!selectedExercise || !selectedExercise.animation">
                                        <svg class="w-6 h-6 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </template>
                                </div>

                                <template x-if="selectedExercise">
                                    <div class="min-w-0 space-y-1">
                                        <div class="text-sm font-bold text-zinc-900 dark:text-zinc-100 truncate" x-text="selectedExercise.name"></div>
                                        <div class="flex flex-wrap items-center gap-1.5">
                                            <span class="px-2 py-0.5 rounded-md text-[11px] font-semibold bg-red-50 text-red-600 border border-red-100 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20" x-text="selectedExercise.target"></span>
                                            <span class="px-2 py-0.5 rounded-md text-[11px] font-medium bg-zinc-200/70 dark:bg-zinc-700/70 text-zinc-600 dark:text-zinc-300" x-text="selectedExercise.difficulty"></span>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <button type="button" @click="openDropdown = !openDropdown; if(openDropdown) $nextTick(() => $refs.searchInput.focus())"
                                    class="shrink-0 inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-red-50 hover:bg-red-100 text-red-600 border border-red-200/80 dark:bg-emerald-500/10 dark:hover:bg-emerald-500/20 dark:text-emerald-400 dark:border-emerald-500/25 text-xs font-semibold transition-colors">
                                <span>Ganti</span>
                                <svg class="w-3.5 h-3.5 transition-transform" :class="openDropdown ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Dropdown Daftar Gerakan -->
                        <div x-show="openDropdown" @click.away="openDropdown = false" x-cloak
                             x-transition.opacity.duration.150ms
                             class="absolute z-50 left-0 right-0 top-full mt-1.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden flex flex-col">

                            <div class="relative border-b border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-800/40">
                                <svg class="w-4 h-4 text-red-500 dark:text-emerald-400 absolute left-3.5 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input x-ref="searchInput" x-model.debounce.250ms="search" type="text"
                                       placeholder="Cari nama gerakan atau otot..."
                                       class="w-full pl-9 pr-8 py-2.5 text-sm bg-transparent text-zinc-900 dark:text-zinc-100 outline-none placeholder-zinc-400 dark:placeholder-zinc-500">
                                <button type="button" x-show="search" @click="search = ''" class="absolute inset-y-0 right-0 pr-3 flex items-center text-zinc-400 hover:text-zinc-600">
                                    &times;
                                </button>
                            </div>

                            <div class="overflow-y-auto max-h-60 p-1.5 space-y-1">
                                <template x-for="item in filteredExercises" :key="item.id">
                                    <div @click="selectExercise(item.id)"
                                         :class="selectedId == item.id ? 'bg-red-50 dark:bg-emerald-500/10 border-red-200 dark:border-emerald-500/30' : 'border-transparent hover:bg-zinc-50 dark:hover:bg-zinc-800/70'"
                                         class="flex items-center gap-3 p-2 rounded-lg border cursor-pointer transition-colors">
                                        <template x-if="item.animation">
                                            <img :src="item.animation" class="w-10 h-10 rounded-md object-contain bg-white dark:bg-zinc-950 p-1 border border-zinc-200 dark:border-zinc-800 shrink-0" alt="" loading="lazy">
                                        </template>
                                        <div class="flex-1 min-w-0">
                                            <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 truncate" x-text="item.name"></div>
                                            <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                                <span class="text-red-600 dark:text-emerald-400 font-medium" x-text="item.target"></span> &bull; <span x-text="item.difficulty"></span>
                                            </div>
                                        </div>
                                        <svg x-show="selectedId == item.id" class="w-4 h-4 text-red-600 dark:text-emerald-400 shrink-0 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                </template>
                                <div x-show="filteredExercises.length === 0" class="py-6 text-center text-xs text-zinc-500">
                                    Gerakan tidak ditemukan.
                                </div>
                            </div>
                        </div>
                        @error('exercise_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- 2. Hari Latihan (Berwarna Sesuai Light Red / Dark Emerald) -->
                    <div class="space-y-1.5" x-data="{ selectedDay: @entangle('day_of_week') }">
                        <label class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300">
                            Hari Latihan
                        </label>
                        <div class="grid grid-cols-4 sm:grid-cols-7 gap-1.5">
                            @foreach(['Senin' => 'Sen', 'Selasa' => 'Sel', 'Rabu' => 'Rab', 'Kamis' => 'Kam', 'Jumat' => 'Jum', 'Sabtu' => 'Sab', 'Minggu' => 'Min'] as $namaHari => $singkatan)
                                <button type="button"
                                        @click="selectedDay = '{{ $namaHari }}'"
                                        :class="selectedDay === '{{ $namaHari }}'
                                            ? 'bg-red-600 text-white border-red-600 dark:bg-emerald-600 dark:text-white dark:border-emerald-500 font-semibold shadow-sm'
                                            : 'bg-zinc-50 dark:bg-zinc-800/60 text-zinc-600 dark:text-zinc-300 border-zinc-200 dark:border-zinc-700/80 hover:border-red-300 hover:text-red-600 dark:hover:border-emerald-500/50 dark:hover:text-emerald-400 font-medium'"
                                        class="py-2 px-2 rounded-xl text-xs border transition-colors text-center">
                                    {{ $singkatan }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- 3. Jumlah Set & Repetisi -->
                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300">
                                Jumlah Set
                            </label>
                            <div class="relative">
                                <input type="number" wire:model="sets" min="1" max="50"
                                       class="w-full pl-3.5 pr-11 py-2.5 rounded-xl border border-zinc-300 dark:border-zinc-700/80 bg-zinc-50 dark:bg-zinc-800/60 text-sm font-medium text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-red-500 dark:focus:border-emerald-500 focus:ring-2 focus:ring-red-500/15 dark:focus:ring-emerald-500/15 transition-colors">
                                <span class="absolute inset-y-0 right-3 flex items-center text-xs font-semibold text-red-600 dark:text-emerald-400 pointer-events-none">Set</span>
                            </div>
                            @error('sets') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300">
                                Target Repetisi
                            </label>
                            <div class="relative">
                                <input type="text" wire:model="reps" placeholder="10-12"
                                       class="w-full pl-3.5 pr-13 py-2.5 rounded-xl border border-zinc-300 dark:border-zinc-700/80 bg-zinc-50 dark:bg-zinc-800/60 text-sm font-medium text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 dark:placeholder-zinc-500 focus:outline-none focus:border-red-500 dark:focus:border-emerald-500 focus:ring-2 focus:ring-red-500/15 dark:focus:ring-emerald-500/15 transition-colors">
                                <span class="absolute inset-y-0 right-3 flex items-center text-xs font-semibold text-red-600 dark:text-emerald-400 pointer-events-none">Reps</span>
                            </div>
                            @error('reps') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- 4. Catatan (Opsional) -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300">
                            Catatan Latihan <span class="text-zinc-400 font-normal">(Opsional)</span>
                        </label>
                        <textarea wire:model="notes" rows="2" placeholder="Contoh: Istirahat antar set 60 detik..."
                                  class="w-full px-3.5 py-2.5 rounded-xl border border-zinc-300 dark:border-zinc-700/80 bg-zinc-50 dark:bg-zinc-800/60 text-sm text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 dark:placeholder-zinc-500 focus:outline-none focus:border-red-500 dark:focus:border-emerald-500 focus:ring-2 focus:ring-red-500/15 dark:focus:ring-emerald-500/15 transition-colors"></textarea>
                        @error('notes') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Tombol Aksi Berwarna Sesuai Tema Light/Dark -->
                    <div class="flex justify-end gap-2.5 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                        <button type="button" @click="open = false; $wire.resetForm()"
                                class="px-4 py-2.5 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 text-sm font-medium transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 dark:bg-emerald-600 dark:hover:bg-emerald-500 text-white text-sm font-semibold shadow-sm transition-colors">
                            <svg wire:loading.remove wire:target="save" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span wire:loading.remove wire:target="save">
                                {{ $routine_id ? 'Simpan Perubahan' : 'Simpan Jadwal' }}
                            </span>
                            <span wire:loading wire:target="save">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
