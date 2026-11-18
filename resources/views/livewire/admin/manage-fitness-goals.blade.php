<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#202124] dark:text-[#F5F5F5] tracking-tight">
                Kelola <span class="text-[#E54855]">Tujuan Latihan</span>
            </h1>
            <p class="text-sm text-[#777777] dark:text-[#AAA0A2] mt-1">
                Sesuaikan deskripsi dan rekomendasi pembagian jadwal mingguan (split) untuk pengguna.
            </p>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="p-4 bg-[#E54855]/10 text-[#C93646] dark:text-[#E54855] rounded-xl border border-[#E54855]/30 text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if($isEditing)
        <div class="bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] p-6 shadow-xs">
            <h2 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5] mb-4">Edit Tujuan: {{ $name }}</h2>
            <form wire:submit.prevent="saveGoal" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1.5">Nama Tujuan</label>
                    <input type="text" wire:model="name" class="w-full px-3.5 py-2.5 rounded-xl border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#251518] text-sm text-[#202124] dark:text-[#F5F5F5]">
                    @error('name') <span class="text-xs text-[#E54855] mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1.5">Deskripsi</label>
                    <textarea wire:model="description" rows="3" class="w-full px-3.5 py-2.5 rounded-xl border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#251518] text-sm text-[#202124] dark:text-[#F5F5F5]"></textarea>
                    @error('description') <span class="text-xs text-[#E54855] mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1.5">Tipe Split</label>
                    <input type="text" wire:model="split_type" class="w-full px-3.5 py-2.5 rounded-xl border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#251518] text-sm text-[#202124] dark:text-[#F5F5F5]">
                    @error('split_type') <span class="text-xs text-[#E54855] mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div class="flex gap-2.5 pt-2">
                    <button type="submit" class="bg-[#E54855] hover:bg-[#C93646] text-white text-sm font-bold py-2.5 px-5 rounded-xl cursor-pointer">Simpan Perubahan</button>
                    <button type="button" wire:click="cancelEdit" class="bg-[#F1F1F4] dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] text-sm font-semibold py-2.5 px-5 rounded-xl cursor-pointer">Batal</button>
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
                            <th class="px-6 py-4 font-bold">Deskripsi</th>
                            <th class="px-6 py-4 font-bold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E9E9EC] dark:divide-[#342427]">
                        @foreach($goals as $goal)
                            <tr class="hover:bg-[#F7F7F8]/60 dark:hover:bg-[#251518]/60 transition-colors">
                                <td class="px-6 py-4 font-bold text-[#202124] dark:text-[#F5F5F5]">{{ $goal->name }}</td>
                                <td class="px-6 py-4">
                                    <span class="bg-[#E54855]/10 text-[#E54855] px-2.5 py-1 rounded-lg text-xs font-bold">{{ $goal->split_type }}</span>
                                </td>
                                <td class="px-6 py-4 text-[#777777] dark:text-[#AAA0A2]">{{ \Illuminate\Support\Str::limit($goal->description, 70) }}</td>
                                <td class="px-6 py-4 text-right">
                                    <button type="button" wire:click="editGoal({{ $goal->id }})" class="text-[#E54855] hover:text-[#C93646] font-bold text-xs cursor-pointer">Edit</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
