<div>
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tight uppercase">Kelola Kalkulator Protein</h1>
            <p class="text-zinc-400 mt-2">Database sumber makanan untuk fitur Kalkulator Protein publik.</p>
        </div>
        <button wire:click="openModal" class="px-5 py-2.5 bg-lime-400 text-zinc-950 font-bold rounded-xl hover:bg-lime-500 transition-colors shadow-[0_0_15px_rgba(163,230,53,0.3)]">
            + Tambah Makanan
        </button>
    </div>

    @if (session()->has('success'))
        <div class="mb-6 p-4 bg-lime-400/10 border border-lime-400/20 rounded-xl text-lime-400">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-zinc-300">
                <thead class="text-xs text-zinc-400 uppercase bg-zinc-950 border-b border-zinc-800">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Nama Sumber Makanan</th>
                        <th class="px-6 py-4 font-semibold text-center">Protein (per 100g)</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">
                    @forelse ($sources as $source)
                        <tr class="hover:bg-zinc-800/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-white">
                                {{ $source->name }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 bg-lime-400/10 text-lime-400 border border-lime-400/20 rounded-lg font-bold">
                                    {{ $source->protein_per_100g }} g
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button wire:click="edit({{ $source->id }})" class="text-zinc-400 hover:text-white transition-colors mr-3 font-medium">
                                    Edit
                                </button>
                                <button wire:click="delete({{ $source->id }})" wire:confirm="Yakin ingin menghapus sumber makanan ini?" class="text-red-400 hover:text-red-300 transition-colors font-medium">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-zinc-500">
                                Belum ada sumber makanan di database.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Form -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl relative">
                
                <div class="p-6 border-b border-zinc-800 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-white uppercase">{{ $editId ? 'Edit Sumber Makanan' : 'Tambah Sumber Makanan' }}</h2>
                    <button wire:click="closeModal" class="text-zinc-500 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-zinc-400 mb-2">Nama Sumber Makanan</label>
                        <input type="text" wire:model="name" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition-all placeholder-zinc-600" placeholder="Contoh: Dada Kalkun">
                        @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-400 mb-2">Protein per 100 gram (g)</label>
                        <input type="number" step="0.1" wire:model="protein_per_100g" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition-all placeholder-zinc-600" placeholder="Contoh: 29.5">
                        @error('protein_per_100g') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="p-6 border-t border-zinc-800 flex justify-end gap-3 bg-zinc-950/50">
                    <button wire:click="closeModal" class="px-5 py-2.5 text-zinc-400 font-medium hover:text-white transition-colors">
                        Batal
                    </button>
                    <button wire:click="save" class="px-5 py-2.5 bg-lime-400 text-zinc-950 font-bold rounded-xl hover:bg-lime-500 transition-colors shadow-[0_0_15px_rgba(163,230,53,0.2)]">
                        Simpan Data
                    </button>
                </div>

            </div>
        </div>
    @endif
</div>
