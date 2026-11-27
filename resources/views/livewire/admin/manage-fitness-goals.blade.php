<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#202124] dark:text-[#F5F5F5] tracking-tight">
                Kelola <span class="text-[#E54855]">Tujuan Latihan</span>
            </h1>
            <p class="text-sm text-[#777777] dark:text-[#AAA0A2] mt-1">
                Samakan daftar tujuan latihan (Hypertrophy, Strength, Endurance, Fat Loss) beserta rekomendasi gerakan &amp; split mingguan untuk halaman Profil pengguna.
            </p>
        </div>
        @if(!$isEditing)
            <button type="button" wire:click="openCreateGoal"
                    class="px-5 py-2.5 bg-[#E54855] hover:bg-[#C93646] text-white text-sm font-bold rounded-xl shadow-sm transition-colors shrink-0 cursor-pointer">
                + Tambah Tujuan Baru
            </button>
        @endif
    </div>

    @if (session()->has('success'))
        <div class="p-4 bg-[#E54855]/10 text-[#C93646] dark:text-[#E54855] rounded-xl border border-[#E54855]/30 text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if($isEditing)
        <div class="bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] p-6 shadow-xs">
            <h2 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5] mb-4">
                {{ $goalId ? 'Edit Tujuan: ' . $name : 'Tambah Tujuan Latihan Baru' }}
            </h2>
            <form wire:submit.prevent="saveGoal" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1.5">Nama Tujuan</label>
                    <input type="text" wire:model="name" placeholder="Cth: Strength Training / Kekuatan Otot"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#251518] text-sm text-[#202124] dark:text-[#F5F5F5]">
                    @error('name') <span class="text-xs text-[#E54855] mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1.5">Deskripsi</label>
                    <textarea wire:model="description" rows="3" placeholder="Jelaskan fokus latihan dan jadwal pemulihannya..."
                              class="w-full px-3.5 py-2.5 rounded-xl border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#251518] text-sm text-[#202124] dark:text-[#F5F5F5]"></textarea>
                    @error('description') <span class="text-xs text-[#E54855] mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1.5">Tipe Split</label>
                    <input type="text" wire:model="split_type" placeholder="Cth: Upper/Lower Split / Full Body Kekuatan"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#251518] text-sm text-[#202124] dark:text-[#F5F5F5]">
                    @error('split_type') <span class="text-xs text-[#E54855] mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div class="flex gap-2.5 pt-2">
                    <button type="submit" class="bg-[#E54855] hover:bg-[#C93646] text-white text-sm font-bold py-2.5 px-5 rounded-xl cursor-pointer">
                        {{ $goalId ? 'Simpan Perubahan' : 'Simpan Tujuan Baru' }}
                    </button>
                    <button type="button" wire:click="cancelEdit" class="bg-[#F1F1F4] dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] text-sm font-semibold py-2.5 px-5 rounded-xl cursor-pointer">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    @else
        <div class="bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-[#F7F7F8] dark:bg-[#251518] text-xs uppercase text-[#777777] dark:text-[#AAA0A2] border-b border-[#E9E9EC] dark:border-[#342427]">
                        <tr>
                            <th class="px-6 py-4 font-bold">Nama Tujuan</th>
                            <th class="px-6 py-4 font-bold">Split</th>
                            <th class="px-6 py-4 font-bold text-center">Rekomendasi Gerakan</th>
                            <th class="px-6 py-4 font-bold">Deskripsi</th>
                            <th class="px-6 py-4 font-bold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E9E9EC] dark:divide-[#342427]">
                        @forelse($goals as $goal)
                            <tr class="hover:bg-[#F7F7F8]/60 dark:hover:bg-[#251518]/60 transition-colors">
                                <td class="px-6 py-4 font-bold text-[#202124] dark:text-[#F5F5F5]">{{ $goal->name }}</td>
                                <td class="px-6 py-4">
                                    <span class="bg-[#E54855]/10 text-[#E54855] px-2.5 py-1 rounded-lg text-xs font-bold">{{ $goal->split_type }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button type="button" wire:click="openRoutinesModal({{ $goal->id }})"
                                            class="px-3 py-1 rounded-lg bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] hover:border-[#E54855] text-xs font-bold text-[#202124] dark:text-[#F5F5F5] cursor-pointer">
                                        {{ $goal->routines->count() }} Gerakan &bull; Kelola
                                    </button>
                                </td>
                                <td class="px-6 py-4 text-[#777777] dark:text-[#AAA0A2]">{{ \Illuminate\Support\Str::limit($goal->description, 65) }}</td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <button type="button" wire:click="editGoal({{ $goal->id }})" class="text-[#E54855] hover:text-[#C93646] font-bold text-xs mr-3 cursor-pointer">Edit</button>
                                    <button type="button" wire:click="deleteGoal({{ $goal->id }})" wire:confirm="Hapus tujuan latihan ini?" class="text-[#C93646] hover:underline font-bold text-xs cursor-pointer">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-xs text-[#777777] dark:text-[#AAA0A2]">
                                    Belum ada tujuan latihan. Klik + Tambah Tujuan Baru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- MODAL KELOLA REKOMENDASI GERAKAN UNTUK TUJUAN LATIHAN -->
    @if($managedGoal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/75 backdrop-blur-xs">
            <div class="bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] rounded-2xl w-full max-w-2xl shadow-2xl max-h-[88vh] flex flex-col overflow-hidden">
                <div class="p-5 border-b border-[#E9E9EC] dark:border-[#342427] flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">Rekomendasi Gerakan: {{ $managedGoal->name }}</h3>
                        <p class="text-xs text-[#777777] dark:text-[#AAA0A2]">Gerakan ini otomatis diterapkan saat pengguna memilih tujuan ini di halaman Profil.</p>
                    </div>
                    <button type="button" wire:click="closeRoutinesModal" class="text-[#777777] hover:text-[#E54855] p-1 text-xl font-bold cursor-pointer">&times;</button>
                </div>

                <div class="p-5 overflow-y-auto space-y-5 flex-1">
                    <!-- Form Tambah Rekomendasi Gerakan -->
                    <form wire:submit="addGoalRoutine" class="p-4 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] space-y-3">
                        <div class="text-xs font-extrabold text-[#202124] dark:text-[#F5F5F5]">+ Tambah Rekomendasi Gerakan</div>
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-2.5">
                            <div class="sm:col-span-5">
                                <select wire:model="routineExerciseId" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] text-xs font-semibold text-[#202124] dark:text-[#F5F5F5]">
                                    @foreach($allExercises as $ex)
                                        <option value="{{ $ex->id }}">{{ $ex->name }} ({{ $ex->target_muscle }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="sm:col-span-3">
                                <select wire:model="routineDay" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] text-xs font-semibold text-[#202124] dark:text-[#F5F5F5]">
                                    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $d)
                                        <option value="{{ $d }}">{{ $d }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="sm:col-span-2">
                                <input type="number" wire:model="routineSets" min="1" placeholder="Set" class="w-full px-2.5 py-2 rounded-xl bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] text-xs text-[#202124] dark:text-[#F5F5F5]">
                            </div>
                            <div class="sm:col-span-2">
                                <input type="text" wire:model="routineReps" placeholder="Reps" class="w-full px-2.5 py-2 rounded-xl bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] text-xs text-[#202124] dark:text-[#F5F5F5]">
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <input type="text" wire:model="routineNotes" placeholder="Catatan singkat (opsional)..." class="flex-1 px-3 py-2 rounded-xl bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] text-xs text-[#202124] dark:text-[#F5F5F5]">
                            <button type="submit" class="px-4 py-2 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white text-xs font-bold cursor-pointer shrink-0">
                                Tambah
                            </button>
                        </div>
                    </form>

                    <!-- Daftar Rekomendasi Saat Ini -->
                    <div class="space-y-2">
                        @forelse($managedGoal->routines as $rt)
                            <div class="p-3 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] flex items-center justify-between gap-3 text-xs">
                                <div>
                                    <span class="px-2 py-0.5 rounded bg-[#E54855]/10 text-[#E54855] font-bold mr-1.5">{{ $rt->day_of_week }}</span>
                                    <strong class="text-[#202124] dark:text-[#F5F5F5]">{{ $rt->exercise?->name ?? 'Gerakan' }}</strong>
                                    <span class="text-[#777777] dark:text-[#AAA0A2] ml-1.5">{{ $rt->sets }} Set &times; {{ $rt->reps }}</span>
                                    @if($rt->notes)
                                        <p class="text-[11px] text-[#777777] dark:text-[#AAA0A2] mt-0.5 italic">"{{ $rt->notes }}"</p>
                                    @endif
                                </div>
                                <button type="button" wire:click="deleteGoalRoutine({{ $rt->id }})" class="text-[#C93646] font-bold hover:underline cursor-pointer shrink-0">Hapus</button>
                            </div>
                        @empty
                            <p class="text-xs text-center text-[#777777] dark:text-[#AAA0A2] py-4">Belum ada rekomendasi gerakan untuk tujuan ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
