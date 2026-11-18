<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#202124] dark:text-[#F5F5F5] tracking-tight">
                Kelola <span class="text-[#E54855]">Gerakan Latihan</span>
            </h1>
            <p class="text-sm text-[#777777] dark:text-[#AAA0A2] mt-1">
                Tambah atau perbarui gerakan katalog, kategori, alat, dan gambar sekuensial (awal, inti, akhir).
            </p>
        </div>
        <button type="button" wire:click="openModal" class="px-5 py-2.5 bg-[#E54855] hover:bg-[#C93646] text-white text-sm font-bold rounded-xl shadow-sm transition-colors shrink-0 cursor-pointer">
            + Tambah Gerakan Baru
        </button>
    </div>

    @if (session()->has('success'))
        <div class="p-4 bg-[#E54855]/10 border border-[#E54855]/30 rounded-xl text-[#C93646] dark:text-[#E54855] text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-4 bg-[#C93646]/15 border border-[#C93646]/40 rounded-xl text-[#C93646] dark:text-[#E54855] text-sm font-semibold">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] rounded-2xl overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-xs text-[#777777] dark:text-[#AAA0A2] uppercase bg-[#F7F7F8] dark:bg-[#251518] border-b border-[#E9E9EC] dark:border-[#342427]">
                    <tr>
                        <th class="px-5 py-3.5 font-bold w-16">Media</th>
                        <th class="px-5 py-3.5 font-bold">Nama Gerakan</th>
                        <th class="px-5 py-3.5 font-bold text-center">Fokus Otot</th>
                        <th class="px-5 py-3.5 font-bold text-center">Tingkat</th>
                        <th class="px-5 py-3.5 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E9E9EC] dark:divide-[#342427]">
                    @forelse ($exercises as $exercise)
                        <tr class="hover:bg-[#F7F7F8]/60 dark:hover:bg-[#251518]/60 transition-colors">
                            <td class="px-5 py-3.5">
                                @if($exercise->image_1)
                                    <img src="{{ $exercise->image_1 }}" class="w-11 h-11 object-cover rounded-lg bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427]" alt="{{ $exercise->name }}">
                                @else
                                    <div class="w-11 h-11 rounded-lg bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] flex items-center justify-center text-xs font-bold text-[#E54855]">
                                        PF
                                    </div>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 font-bold text-[#202124] dark:text-[#F5F5F5]">
                                {{ $exercise->name }}
                                <div class="text-xs font-medium text-[#777777] dark:text-[#AAA0A2] mt-0.5">
                                    Alat: {{ $exercise->equipment ?: 'Bodyweight' }} &bull; {{ $exercise->category ?: 'Kekuatan & Hipertrofi' }}
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="px-2.5 py-1 bg-[#E54855]/10 text-[#E54855] rounded-lg text-xs font-bold">
                                    {{ $exercise->target_muscle }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5]">
                                    {{ $exercise->difficulty }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                <button type="button" wire:click="edit({{ $exercise->id }})" class="text-xs font-bold text-[#202124] dark:text-[#F5F5F5] hover:text-[#E54855] transition-colors mr-3 cursor-pointer">
                                    Edit
                                </button>
                                <button type="button" wire:click="delete({{ $exercise->id }})" wire:confirm="Yakin ingin menghapus gerakan ini secara permanen?" class="text-xs font-bold text-[#C93646] dark:text-[#E54855] hover:underline transition-colors cursor-pointer">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-sm text-[#777777] dark:text-[#AAA0A2]">
                                Belum ada gerakan di database.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Form -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/75 backdrop-blur-xs overflow-y-auto">
            <div class="bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] rounded-2xl w-full max-w-4xl shadow-2xl relative my-8 overflow-hidden">

                <div class="p-5 sm:p-6 border-b border-[#E9E9EC] dark:border-[#342427] flex justify-between items-center bg-white dark:bg-[#1A1012]">
                    <h2 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">{{ $editId ? 'Edit Gerakan' : 'Tambah Gerakan Baru' }}</h2>
                    <button type="button" wire:click="closeModal" class="text-[#777777] hover:text-[#E54855] p-1 text-xl font-bold cursor-pointer">&times;</button>
                </div>

                <div class="p-5 sm:p-6 max-h-[80vh] overflow-y-auto">
                    <form wire:submit.prevent="save" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Kolom Kiri -->
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1.5">Nama Gerakan <span class="text-[#E54855]">*</span></label>
                                    <input type="text" wire:model="name" class="w-full bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] rounded-xl px-3.5 py-2.5 text-sm text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]" placeholder="Cth: Push Up">
                                    @error('name') <span class="text-[#E54855] text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1.5">Fokus Otot <span class="text-[#E54855]">*</span></label>
                                        <input type="text" wire:model="target_muscle" class="w-full bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] rounded-xl px-3.5 py-2.5 text-sm text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]" placeholder="Cth: Dada">
                                        @error('target_muscle') <span class="text-[#E54855] text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1.5">Tingkat Kesulitan</label>
                                        <select wire:model="difficulty" class="w-full bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] rounded-xl px-3.5 py-2.5 text-sm text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]">
                                            <option value="Pemula">Pemula</option>
                                            <option value="Menengah">Menengah</option>
                                            <option value="Lanjut">Lanjut</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1.5">Alat yang Digunakan</label>
                                        <input type="text" wire:model="equipment" class="w-full bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] rounded-xl px-3.5 py-2.5 text-sm text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]" placeholder="Bodyweight / Dumbbell">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1.5">Kategori Latihan</label>
                                        <select wire:model="category" class="w-full bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] rounded-xl px-3.5 py-2.5 text-sm text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]">
                                            <option value="Kekuatan & Hipertrofi">Kekuatan &amp; Hipertrofi</option>
                                            <option value="Kardio & Daya Tahan">Kardio &amp; Daya Tahan</option>
                                            <option value="Mobilitas & Peregangan">Mobilitas &amp; Peregangan</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1.5">Instruksi Eksekusi <span class="text-[#E54855]">*</span></label>
                                    <textarea wire:model="instructions" rows="5" class="w-full bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] rounded-xl px-3.5 py-2.5 text-sm text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]" placeholder="Jelaskan langkah eksekusi..."></textarea>
                                    @error('instructions') <span class="text-[#E54855] text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Kolom Kanan: Sekuensi Gambar -->
                            <div class="space-y-4 bg-[#F7F7F8] dark:bg-[#251518] p-4 sm:p-5 rounded-2xl border border-[#E9E9EC] dark:border-[#342427]">
                                <h3 class="text-sm font-extrabold text-[#202124] dark:text-[#F5F5F5] border-b border-[#E9E9EC] dark:border-[#342427] pb-2">Sekuensi Gambar</h3>

                                <div>
                                    <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1.5">Fase Awal (Start)</label>
                                    <input type="file" wire:model="image_1_file" accept="image/*" class="block w-full text-xs text-[#777777] file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#E54855]/10 file:text-[#E54855] cursor-pointer">
                                    @if ($image_1_file)
                                        <img src="{{ $image_1_file->temporaryUrl() }}" class="mt-2 h-24 w-full object-contain rounded-lg bg-white dark:bg-[#1A1012]">
                                    @elseif ($image_1_preview)
                                        <img src="{{ $image_1_preview }}" class="mt-2 h-24 w-full object-contain rounded-lg bg-white dark:bg-[#1A1012]">
                                    @endif
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1.5">Fase Inti</label>
                                    <input type="file" wire:model="image_2_file" accept="image/*" class="block w-full text-xs text-[#777777] file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#E54855]/10 file:text-[#E54855] cursor-pointer">
                                    @if ($image_2_file)
                                        <img src="{{ $image_2_file->temporaryUrl() }}" class="mt-2 h-24 w-full object-contain rounded-lg bg-white dark:bg-[#1A1012]">
                                    @elseif ($image_2_preview)
                                        <img src="{{ $image_2_preview }}" class="mt-2 h-24 w-full object-contain rounded-lg bg-white dark:bg-[#1A1012]">
                                    @endif
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1.5">Fase Akhir (Opsional)</label>
                                    <input type="file" wire:model="image_3_file" accept="image/*" class="block w-full text-xs text-[#777777] file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#E54855]/10 file:text-[#E54855] cursor-pointer">
                                    @if ($image_3_file)
                                        <img src="{{ $image_3_file->temporaryUrl() }}" class="mt-2 h-24 w-full object-contain rounded-lg bg-white dark:bg-[#1A1012]">
                                    @elseif ($image_3_preview)
                                        <img src="{{ $image_3_preview }}" class="mt-2 h-24 w-full object-contain rounded-lg bg-white dark:bg-[#1A1012]">
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-[#E9E9EC] dark:border-[#342427] flex justify-end gap-3">
                            <button type="button" wire:click="closeModal" class="px-5 py-2.5 rounded-xl bg-[#F1F1F4] dark:bg-[#251518] text-sm font-semibold text-[#202124] dark:text-[#F5F5F5] cursor-pointer">
                                Batal
                            </button>
                            <button type="submit" wire:loading.attr="disabled" wire:target="image_1_file, image_2_file, image_3_file"
                                    class="px-6 py-2.5 bg-[#E54855] hover:bg-[#C93646] text-white text-sm font-bold rounded-xl shadow-sm transition-colors cursor-pointer disabled:opacity-60">
                                <span wire:loading.remove wire:target="save">Simpan Gerakan</span>
                                <span wire:loading wire:target="save">Menyimpan...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
