<div>
    <div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tight uppercase">Kelola Gerakan Latihan</h1>
            <p class="text-zinc-400 mt-2">Daftar semua katalog gerakan. Anda dapat menambahkan gambar sekuensial (fase awal, inti, akhir).</p>
        </div>
        <button wire:click="openModal" class="px-5 py-2.5 bg-lime-400 text-zinc-950 font-bold rounded-xl hover:bg-lime-500 transition-colors shadow-[0_0_15px_rgba(163,230,53,0.3)]">
            + Tambah Gerakan Baru
        </button>
    </div>

    @if (session()->has('success'))
        <div class="mb-6 p-4 bg-lime-400/10 border border-lime-400/20 rounded-xl text-lime-400">
            {{ session('success') }}
        </div>
    @endif
    
    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-red-400/10 border border-red-400/20 rounded-xl text-red-400">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-zinc-300">
                <thead class="text-xs text-zinc-400 uppercase bg-zinc-950 border-b border-zinc-800">
                    <tr>
                        <th class="px-6 py-4 font-semibold w-16">Icon</th>
                        <th class="px-6 py-4 font-semibold">Nama Gerakan</th>
                        <th class="px-6 py-4 font-semibold text-center">Fokus Otot</th>
                        <th class="px-6 py-4 font-semibold text-center">Tingkat</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">
                    @forelse ($exercises as $exercise)
                        <tr class="hover:bg-zinc-800/50 transition-colors">
                            <td class="px-6 py-4">
                                @if($exercise->image_1)
                                    <img src="{{ $exercise->image_1 }}" class="w-12 h-12 object-cover rounded-lg bg-white/10" alt="Icon">
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-zinc-800 flex items-center justify-center text-xl">
                                        🏋️
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-white">
                                {{ $exercise->name }}
                                <div class="text-xs font-normal text-zinc-500 mt-1">Alat: {{ $exercise->equipment }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 bg-blue-500/10 text-blue-400 border border-blue-500/20 rounded-lg font-bold">
                                    {{ $exercise->target_muscle }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $colorClass = match(strtolower($exercise->difficulty)) {
                                        'pemula' => 'text-lime-400 bg-lime-400/10 border-lime-400/20',
                                        'menengah' => 'text-orange-400 bg-orange-400/10 border-orange-400/20',
                                        'lanjut' => 'text-red-400 bg-red-400/10 border-red-400/20',
                                        default => 'text-zinc-400 bg-zinc-400/10 border-zinc-400/20',
                                    };
                                @endphp
                                <span class="px-3 py-1 border rounded-lg font-bold text-xs uppercase {{ $colorClass }}">
                                    {{ $exercise->difficulty }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button wire:click="edit({{ $exercise->id }})" class="text-zinc-400 hover:text-white transition-colors mr-3 font-medium">
                                    Edit
                                </button>
                                <button wire:click="delete({{ $exercise->id }})" wire:confirm="Yakin ingin menghapus gerakan ini secara permanen?" class="text-red-400 hover:text-red-300 transition-colors font-medium">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-zinc-500">
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
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm overflow-y-auto">
            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl w-full max-w-4xl shadow-2xl relative my-8">
                
                <div class="p-6 border-b border-zinc-800 flex justify-between items-center sticky top-0 bg-zinc-900/95 backdrop-blur z-10 rounded-t-2xl">
                    <h2 class="text-xl font-bold text-white uppercase tracking-tight">{{ $editId ? 'Edit Gerakan' : 'Tambah Gerakan' }}</h2>
                    <button wire:click="closeModal" class="text-zinc-500 hover:text-white transition-colors p-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="p-6">
                    <form wire:submit.prevent="save" class="space-y-6">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Kolom Kiri: Informasi Dasar -->
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-sm font-semibold text-zinc-400 mb-2">Nama Gerakan <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="name" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition-all placeholder-zinc-700" placeholder="Cth: Push Up">
                                    @error('name') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-zinc-400 mb-2">Fokus Otot <span class="text-red-500">*</span></label>
                                        <input type="text" wire:model="target_muscle" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition-all placeholder-zinc-700" placeholder="Cth: Dada">
                                        @error('target_muscle') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-zinc-400 mb-2">Tingkat Kesulitan</label>
                                        <select wire:model="difficulty" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition-all appearance-none">
                                            <option value="Pemula">🟢 Pemula</option>
                                            <option value="Menengah">🟡 Menengah</option>
                                            <option value="Lanjut">🔴 Lanjut</option>
                                        </select>
                                        @error('difficulty') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-zinc-400 mb-2">Alat yang Digunakan</label>
                                    <input type="text" wire:model="equipment" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition-all placeholder-zinc-700" placeholder="Kosongkan jika Bodyweight">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-zinc-400 mb-2">Instruksi Eksekusi <span class="text-red-500">*</span></label>
                                    <textarea wire:model="instructions" rows="5" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition-all placeholder-zinc-700 resize-none" placeholder="Jelaskan langkah demi langkah..."></textarea>
                                    @error('instructions') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Kolom Kanan: Upload Sekuensi Gambar -->
                            <div class="space-y-5 bg-zinc-950/50 p-5 rounded-2xl border border-zinc-800/50">
                                <h3 class="text-md font-bold text-white border-b border-zinc-800 pb-2 mb-4">📸 Sekuensi Gambar</h3>
                                <p class="text-xs text-zinc-500 mb-4 leading-relaxed">
                                    Upload gambar secara berurutan untuk mendemonstrasikan gerakan. Minimal isi Fase Awal dan Inti.
                                </p>
                                
                                <!-- Image 1 -->
                                <div>
                                    <label class="block text-sm font-semibold text-zinc-400 mb-2">Fase Awal (Start)</label>
                                    <input type="file" wire:model="image_1_file" accept="image/*" class="block w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-lime-400/10 file:text-lime-400 hover:file:bg-lime-400/20 cursor-pointer">
                                    <div class="mt-2 text-center" wire:loading wire:target="image_1_file">
                                        <span class="text-xs text-lime-400 font-bold animate-pulse">Mengunggah...</span>
                                    </div>
                                    @if ($image_1_file)
                                        <div class="mt-2 h-32 w-full rounded-xl overflow-hidden bg-black/50 border border-zinc-700">
                                            <img src="{{ $image_1_file->temporaryUrl() }}" class="w-full h-full object-contain">
                                        </div>
                                    @elseif ($image_1_preview)
                                        <div class="mt-2 h-32 w-full rounded-xl overflow-hidden bg-black/50 border border-zinc-700 relative group">
                                            <img src="{{ $image_1_preview }}" class="w-full h-full object-contain">
                                            <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-xs font-bold text-white">Gambar Saat Ini</div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Image 2 -->
                                <div class="pt-2">
                                    <label class="block text-sm font-semibold text-zinc-400 mb-2">Fase Inti (Puncak Kontraksi)</label>
                                    <input type="file" wire:model="image_2_file" accept="image/*" class="block w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-lime-400/10 file:text-lime-400 hover:file:bg-lime-400/20 cursor-pointer">
                                    <div class="mt-2 text-center" wire:loading wire:target="image_2_file">
                                        <span class="text-xs text-lime-400 font-bold animate-pulse">Mengunggah...</span>
                                    </div>
                                    @if ($image_2_file)
                                        <div class="mt-2 h-32 w-full rounded-xl overflow-hidden bg-black/50 border border-zinc-700">
                                            <img src="{{ $image_2_file->temporaryUrl() }}" class="w-full h-full object-contain">
                                        </div>
                                    @elseif ($image_2_preview)
                                        <div class="mt-2 h-32 w-full rounded-xl overflow-hidden bg-black/50 border border-zinc-700 relative group">
                                            <img src="{{ $image_2_preview }}" class="w-full h-full object-contain">
                                            <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-xs font-bold text-white">Gambar Saat Ini</div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Image 3 -->
                                <div class="pt-2">
                                    <label class="block text-sm font-semibold text-zinc-400 mb-2">Fase Akhir (Opsional)</label>
                                    <input type="file" wire:model="image_3_file" accept="image/*" class="block w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-lime-400/10 file:text-lime-400 hover:file:bg-lime-400/20 cursor-pointer">
                                    <div class="mt-2 text-center" wire:loading wire:target="image_3_file">
                                        <span class="text-xs text-lime-400 font-bold animate-pulse">Mengunggah...</span>
                                    </div>
                                    @if ($image_3_file)
                                        <div class="mt-2 h-32 w-full rounded-xl overflow-hidden bg-black/50 border border-zinc-700">
                                            <img src="{{ $image_3_file->temporaryUrl() }}" class="w-full h-full object-contain">
                                        </div>
                                    @elseif ($image_3_preview)
                                        <div class="mt-2 h-32 w-full rounded-xl overflow-hidden bg-black/50 border border-zinc-700 relative group">
                                            <img src="{{ $image_3_preview }}" class="w-full h-full object-contain">
                                            <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-xs font-bold text-white">Gambar Saat Ini</div>
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>

                        <div class="pt-6 border-t border-zinc-800 flex justify-end gap-4 mt-6 sticky bottom-0 bg-zinc-900 pb-2">
                            <button type="button" wire:click="closeModal" class="px-6 py-3 rounded-xl text-zinc-400 font-bold hover:bg-zinc-800 hover:text-white transition-colors">
                                Batal
                            </button>
                            <!-- Disable button while uploading any image -->
                            <button type="submit" 
                                    wire:loading.attr="disabled"
                                    wire:target="image_1_file, image_2_file, image_3_file"
                                    class="px-8 py-3 bg-lime-400 text-zinc-950 font-black rounded-xl hover:bg-lime-500 transition-colors shadow-[0_0_20px_rgba(163,230,53,0.3)] disabled:opacity-50 disabled:cursor-not-allowed">
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
