<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#202124] dark:text-[#F5F5F5] tracking-tight">
                Kelola <span class="text-[#E54855]">Sumber Nutrisi (TKPI)</span>
            </h1>
            <p class="text-sm text-[#777777] dark:text-[#AAA0A2] mt-1">
                Database bahan makanan Indonesia untuk fitur Kalkulator Nutrisi &amp; Catatan Makan Harian.
            </p>
        </div>
        <button type="button" wire:click="openModal" class="px-5 py-2.5 bg-[#E54855] hover:bg-[#C93646] text-white text-sm font-bold rounded-xl shadow-sm transition-colors shrink-0 cursor-pointer">
            + Tambah Sumber Makanan
        </button>
    </div>

    @if (session()->has('success'))
        <div class="p-4 bg-[#E54855]/10 border border-[#E54855]/30 rounded-xl text-[#C93646] dark:text-[#E54855] text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] rounded-2xl overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-xs text-[#777777] dark:text-[#AAA0A2] uppercase bg-[#F7F7F8] dark:bg-[#251518] border-b border-[#E9E9EC] dark:border-[#342427]">
                    <tr>
                        <th class="px-5 py-3.5 font-bold">Nama Bahan Makanan (per 100g)</th>
                        <th class="px-5 py-3.5 font-bold text-center">Protein</th>
                        <th class="px-5 py-3.5 font-bold text-center">Kalori</th>
                        <th class="px-5 py-3.5 font-bold text-center">Lemak</th>
                        <th class="px-5 py-3.5 font-bold text-center">Karbohidrat</th>
                        <th class="px-5 py-3.5 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E9E9EC] dark:divide-[#342427]">
                    @forelse ($sources as $source)
                        <tr class="hover:bg-[#F7F7F8]/60 dark:hover:bg-[#251518]/60 transition-colors">
                            <td class="px-5 py-3.5 font-bold text-[#202124] dark:text-[#F5F5F5]">
                                {{ $source->name }}
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="px-2.5 py-1 bg-[#E54855]/10 text-[#E54855] rounded-lg text-xs font-extrabold">
                                    {{ $source->protein_per_100g }} g
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center font-semibold text-[#202124] dark:text-[#F5F5F5]">
                                {{ $source->calories_per_100g }} kkal
                            </td>
                            <td class="px-5 py-3.5 text-center text-[#777777] dark:text-[#AAA0A2]">
                                {{ $source->fat_per_100g }} g
                            </td>
                            <td class="px-5 py-3.5 text-center text-[#777777] dark:text-[#AAA0A2]">
                                {{ $source->carbs_per_100g }} g
                            </td>
                            <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                <button type="button" wire:click="edit({{ $source->id }})" class="text-xs font-bold text-[#202124] dark:text-[#F5F5F5] hover:text-[#E54855] transition-colors mr-3 cursor-pointer">
                                    Edit
                                </button>
                                <button type="button" wire:click="delete({{ $source->id }})" wire:confirm="Yakin ingin menghapus sumber makanan ini?" class="text-xs font-bold text-[#C93646] dark:text-[#E54855] hover:underline transition-colors cursor-pointer">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-[#777777] dark:text-[#AAA0A2]">
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
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-xs">
            <div class="bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] rounded-2xl w-full max-w-md overflow-hidden shadow-2xl">
                <div class="p-5 border-b border-[#E9E9EC] dark:border-[#342427] flex justify-between items-center">
                    <h2 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">{{ $editId ? 'Edit Sumber Nutrisi' : 'Tambah Sumber Nutrisi' }}</h2>
                    <button type="button" wire:click="closeModal" class="text-[#777777] hover:text-[#E54855] text-xl font-bold cursor-pointer">&times;</button>
                </div>

                <form wire:submit="save" class="p-5 space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1.5">Nama Sumber Makanan</label>
                        <input type="text" wire:model="name" required class="w-full bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] rounded-xl px-3.5 py-2.5 text-sm text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]" placeholder="Contoh: Ikan Kembung Segar">
                        @error('name') <span class="text-[#E54855] text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1.5">Protein / 100g (g)</label>
                            <input type="number" step="0.1" wire:model="protein_per_100g" required class="w-full bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] rounded-xl px-3.5 py-2.5 text-sm text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]" placeholder="22">
                            @error('protein_per_100g') <span class="text-[#E54855] text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1.5">Kalori / 100g (kkal)</label>
                            <input type="number" step="0.1" wire:model="calories_per_100g" class="w-full bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] rounded-xl px-3.5 py-2.5 text-sm text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]" placeholder="167">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1.5">Lemak / 100g (g)</label>
                            <input type="number" step="0.1" wire:model="fat_per_100g" class="w-full bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] rounded-xl px-3.5 py-2.5 text-sm text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]" placeholder="9">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1.5">Karbohidrat / 100g (g)</label>
                            <input type="number" step="0.1" wire:model="carbs_per_100g" class="w-full bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] rounded-xl px-3.5 py-2.5 text-sm text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]" placeholder="0">
                        </div>
                    </div>

                    <div class="pt-3 border-t border-[#E9E9EC] dark:border-[#342427] flex justify-end gap-2.5">
                        <button type="button" wire:click="closeModal" class="px-4 py-2.5 rounded-xl bg-[#F1F1F4] dark:bg-[#251518] text-sm font-semibold text-[#202124] dark:text-[#F5F5F5] cursor-pointer">Batal</button>
                        <button type="submit" class="px-5 py-2.5 bg-[#E54855] hover:bg-[#C93646] text-white text-sm font-bold rounded-xl cursor-pointer">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
