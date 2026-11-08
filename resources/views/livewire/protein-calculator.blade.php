<div class="space-y-8">
    <div class="mb-2 flex justify-between items-end">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-800 dark:text-white transition-colors duration-300">Kalkulator Protein</h2>
            <p class="text-gray-500 dark:text-zinc-400 transition-colors duration-300">Pantau asupan protein harianmu berdasarkan Tabel Komposisi Pangan Indonesia (TKPI) Kemenkes RI.</p>
        </div>
    </div>
    
    <!-- Progress / Deficit Section -->
    <div class="bg-white dark:bg-zinc-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-zinc-700 mb-8 transition-colors duration-300 flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="text-center md:text-left">
            <p class="text-sm text-gray-500 dark:text-zinc-400 font-medium uppercase tracking-wide">Target Harian</p>
            <p class="text-3xl font-extrabold text-gray-800 dark:text-white mt-1"><span>{{ $targetProtein ?? 150 }}</span><span class="text-lg text-gray-400 font-medium">g</span></p>
        </div>
        <div class="text-center">
            <p class="text-sm text-gray-500 dark:text-zinc-400 font-medium uppercase tracking-wide">Konsumsi Hari Ini</p>
            <p class="text-3xl font-extrabold text-red-600 dark:text-emerald-400 mt-1"><span>{{ number_format($this->totalAchieved ?? 0, 1) }}</span><span class="text-lg font-medium">g</span></p>
        </div>
        <div class="text-center md:text-right">
            <p class="text-sm text-gray-500 dark:text-zinc-400 font-medium uppercase tracking-wide">Sisa / Kurang</p>
            @php
                $target = $targetProtein ?? 150;
                $achieved = $this->totalAchieved ?? 0;
                $remaining = $target - $achieved;
            @endphp
            @if($remaining <= 0)
                <p class="text-3xl font-extrabold text-amber-500 mt-1"><span>Tercapai!</span></p>
            @else
                <p class="text-3xl font-extrabold text-amber-500 dark:text-teal-400 mt-1"><span>{{ number_format($remaining, 1) }}</span><span class="text-lg font-medium">g</span></p>
            @endif
        </div>
    </div>

    <!-- Session Flash Notifications -->
    @if(session('success'))
        <div class="p-4 bg-red-50 dark:bg-lime-900/30 border border-red-200 dark:border-lime-700 text-red-700 dark:text-lime-300 rounded-xl font-medium flex items-center gap-2 shadow-sm transition-all animate-fade-in mb-4">
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('success_confirm'))
        <div class="p-4 bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 rounded-xl font-medium flex items-center gap-2 shadow-sm mb-4">
            <span>{{ session('success_confirm') }}</span>
        </div>
    @endif
    @if(session('info'))
        <div class="p-4 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-300 rounded-xl font-medium flex items-center gap-2 shadow-sm mb-4">
            <span>{{ session('info') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- LEFT COLUMN: Input Form -->
        <div class="md:col-span-1 bg-white dark:bg-zinc-800 p-6 rounded-2xl border border-gray-100 dark:border-zinc-700 shadow-sm h-fit space-y-5 transition-colors duration-300 relative">
            @if(!$is_confirmed)
                <div class="absolute inset-0 bg-white/95 dark:bg-zinc-800/95 backdrop-blur-sm z-10 flex flex-col items-center justify-center p-6 rounded-2xl text-center border border-gray-200 dark:border-zinc-600 shadow-xl">
                    <h3 class="font-bold text-lg text-gray-800 dark:text-white mb-2">Verifikasi Data Fisik</h3>
                    <p class="text-sm text-gray-500 dark:text-zinc-400 mb-5">Untuk menentukan target protein akurat (berbasis standar Angka Kecukupan Gizi Kemenkes RI & Perhimpunan Dokter Gizi Klinik Indonesia), kami butuh data Anda.</p>
                    
                    <form wire:submit.prevent="confirmPhysicalData" class="w-full space-y-4">
                        <div class="flex gap-4">
                            <div class="w-1/2 text-left">
                                <label class="text-xs font-semibold text-gray-600 dark:text-zinc-300">Berat (kg)</label>
                                <input type="number" wire:model="user_weight" step="0.1" class="w-full mt-1 border border-gray-200 dark:border-zinc-600 bg-gray-50 dark:bg-zinc-900/50 text-slate-800 dark:text-white p-2 rounded-lg focus:ring-2 focus:ring-red-500 outline-none text-sm">
                                @error('user_weight') <span class="text-[10px] text-rose-500">{{ $message }}</span> @enderror
                            </div>
                            <div class="w-1/2 text-left">
                                <label class="text-xs font-semibold text-gray-600 dark:text-zinc-300">Tinggi (cm)</label>
                                <input type="number" wire:model="user_height" step="1" class="w-full mt-1 border border-gray-200 dark:border-zinc-600 bg-gray-50 dark:bg-zinc-900/50 text-slate-800 dark:text-white p-2 rounded-lg focus:ring-2 focus:ring-red-500 outline-none text-sm">
                                @error('user_height') <span class="text-[10px] text-rose-500">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="text-left">
                            <label class="text-xs font-semibold text-gray-600 dark:text-zinc-300">Gender</label>
                            <select wire:model="user_gender" class="w-full mt-1 border border-gray-200 dark:border-zinc-600 bg-gray-50 dark:bg-zinc-900/50 text-slate-800 dark:text-white p-2 rounded-lg focus:ring-2 focus:ring-red-500 outline-none text-sm">
                                <option value="M">Pria</option>
                                <option value="F">Wanita</option>
                            </select>
                            @error('user_gender') <span class="text-[10px] text-rose-500">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="w-full bg-slate-800 dark:bg-white text-white dark:text-slate-900 font-bold p-2.5 rounded-xl hover:bg-slate-700 transition-colors shadow mt-2 text-sm">
                            Hitung Target Akurat
                        </button>
                    </form>
                </div>
            @endif

            <div class="flex justify-between items-center border-b border-gray-100 dark:border-zinc-700 pb-3">
                <h3 class="font-bold text-red-600 dark:text-emerald-400 transition-colors duration-300 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Log Protein
                </h3>
                <span class="text-sm font-bold bg-red-100 dark:bg-emerald-900/30 text-red-700 dark:text-emerald-400 px-3 py-1.5 rounded-lg transition-colors duration-300">{{ $this->calculatedProtein ?? 0 }}g</span>
            </div>

            <form wire:submit.prevent="saveLog" class="space-y-4">
                <div>
                    <input type="date" wire:model.live="tanggal" 
                           class="w-full border border-gray-200 dark:border-zinc-600 bg-gray-50 dark:bg-zinc-900/50 text-slate-800 dark:text-white p-3 rounded-xl focus:ring-2 focus:ring-red-500 dark:focus:ring-emerald-400 outline-none transition-colors duration-300">
                </div>

                <div x-data="{ 
                        open: false, 
                        selected: @entangle('sumber_makanan').live,
                        search: '',
                        sources: [
                            @foreach($foodSources as $source)
                                { name: '{{ $source->name }}', label: '{{ $source->name }} (~{{ number_format($source->protein_per_100g, 1) }}g/100g)' },
                            @endforeach
                        ],
                        get filteredSources() {
                            if (this.search === '') return this.sources;
                            return this.sources.filter(s => s.label.toLowerCase().includes(this.search.toLowerCase()));
                        },
                        get selectedLabel() {
                            if(!this.selected) return 'Pilih Sumber Makanan...';
                            const s = this.sources.find(s => s.name === this.selected);
                            return s ? s.label : 'Pilih Sumber Makanan...';
                        }
                    }" 
                    class="relative w-full"
                    @click.away="open = false"
                >
                    <!-- Trigger Button -->
                    <button type="button" @click="open = !open" 
                            class="w-full flex justify-between items-center border border-gray-200 dark:border-zinc-600 bg-gray-50 dark:bg-zinc-900/50 text-slate-800 dark:text-white p-3 rounded-xl focus:ring-2 focus:ring-red-500 dark:focus:ring-emerald-400 outline-none transition-all duration-300 text-left shadow-sm hover:border-red-300 dark:hover:border-emerald-500/50">
                        <span x-text="selectedLabel" class="truncate font-medium text-sm"></span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-300" :class="{'rotate-180 text-red-500 dark:text-emerald-400': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                         class="absolute z-50 w-full mt-2 bg-white dark:bg-zinc-800 border border-gray-100 dark:border-zinc-700 rounded-xl shadow-2xl max-h-60 flex flex-col overflow-hidden"
                         x-cloak>
                        
                        <!-- Search Box (Bonus UX) -->
                        <div class="p-2 border-b border-gray-100 dark:border-zinc-700">
                            <input type="text" x-model="search" placeholder="Cari makanan..." class="w-full p-2 text-sm bg-gray-50 dark:bg-zinc-900/50 border border-gray-200 dark:border-zinc-600 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-500 dark:focus:ring-emerald-400 text-slate-800 dark:text-white placeholder-gray-400">
                        </div>

                        <div class="overflow-y-auto hide-scrollbar">
                            <template x-for="source in filteredSources" :key="source.name">
                                <div @click="selected = source.name; open = false; search = '';" 
                                     class="px-4 py-3 cursor-pointer text-sm font-medium transition-colors hover:bg-red-50 dark:hover:bg-zinc-700/80 flex items-center justify-between"
                                     :class="{'bg-red-50 text-red-600 dark:bg-zinc-700/50 dark:text-emerald-400': selected === source.name, 'text-gray-700 dark:text-zinc-300': selected !== source.name}">
                                    <span x-text="source.label"></span>
                                    <svg x-show="selected === source.name" class="w-4 h-4 text-red-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            </template>
                            <div x-show="filteredSources.length === 0" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-zinc-500">
                                Makanan tidak ditemukan.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <input type="number" step="0.5" wire:model.live="berat" 
                           class="w-full border border-gray-200 dark:border-zinc-600 bg-gray-50 dark:bg-zinc-900/50 text-slate-800 dark:text-white p-3 pr-16 rounded-xl focus:ring-2 focus:ring-red-500 dark:focus:ring-emerald-400 outline-none transition-colors duration-300"
                           placeholder="Berat Makanan">
                    <span class="absolute right-4 top-3.5 text-gray-400 dark:text-zinc-500 font-semibold pointer-events-none">gram</span>
                    @error('berat') <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>

                @if($editingLogId)
                    <div class="flex gap-2">
                        <button type="button" wire:click="saveLog" 
                                class="w-2/3 bg-amber-500 dark:bg-amber-600 text-white font-bold p-3 rounded-xl hover:bg-amber-600 dark:hover:bg-amber-700 transition-colors duration-300 shadow-md flex justify-center items-center gap-2">
                            <span wire:loading.remove wire:target="saveLog">Perbarui Log</span>
                            <span wire:loading wire:target="saveLog">Memperbarui...</span>
                        </button>
                        <button type="button" wire:click="cancelEdit" 
                                class="w-1/3 bg-gray-200 dark:bg-zinc-700 text-gray-700 dark:text-zinc-200 font-bold p-3 rounded-xl hover:bg-gray-300 dark:hover:bg-zinc-600 transition-colors duration-300 shadow-md">
                            Batal
                        </button>
                    </div>
                @else
                    <button type="button" wire:click="saveLog" 
                            class="w-full bg-red-600 dark:bg-emerald-500 text-white font-bold p-3 rounded-xl hover:bg-red-700 dark:hover:bg-emerald-600 transition-colors duration-300 shadow-md flex justify-center items-center gap-2">
                        <span wire:loading.remove wire:target="saveLog">Simpan ke Log</span>
                        <span wire:loading wire:target="saveLog">Menyimpan...</span>
                    </button>
                @endif
            </form>
        </div>

        <!-- RIGHT COLUMN: Daily Logs Table & FAQ -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-gray-100 dark:border-zinc-700 shadow-sm overflow-hidden transition-colors duration-300">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 dark:bg-zinc-900/50 border-b dark:border-zinc-700 transition-colors duration-300">
                            <tr>
                                <th class="p-4 text-gray-600 dark:text-zinc-400 font-semibold text-sm">Waktu</th>
                                <th class="p-4 text-gray-600 dark:text-zinc-400 font-semibold text-sm">Makanan</th>
                                <th class="p-4 text-gray-600 dark:text-zinc-400 font-semibold text-sm">Fisik (BB/TB)</th>
                                <th class="p-4 text-gray-600 dark:text-zinc-400 font-semibold text-sm">Protein</th>
                                <th class="p-4 text-gray-600 dark:text-zinc-400 font-semibold text-sm text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-zinc-700">
                            @forelse($this->dailyLogs ?? [] as $log)
                                <tr class="hover:bg-gray-50 dark:hover:bg-zinc-700/30 transition-colors" wire:key="log-item-{{ $log->id }}">
                                    <td class="p-4 text-gray-500 dark:text-zinc-400 text-sm">
                                        {{ \Carbon\Carbon::parse($log->tanggal)->format('d M') }} {{ $log->created_at ? $log->created_at->format('H:i') : '' }}
                                    </td>
                                    <td class="p-4 font-semibold text-gray-800 dark:text-zinc-200">
                                        {{ $log->sumber_makanan }}
                                    </td>
                                    <td class="p-4 text-gray-500 dark:text-zinc-400 text-sm">
                                        @if($log->user_weight && $log->user_height)
                                            {{ $log->user_weight }}kg / {{ $log->user_height }}cm
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="p-4 font-bold text-red-600 dark:text-emerald-400">
                                        {{ number_format($log->jumlah_protein, 1) }}g
                                    </td>
                                    <td class="p-4 text-center space-x-1 flex justify-center items-center">
                                        <button wire:click="editLog({{ $log->id }})" 
                                                class="px-3 py-1.5 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/40 rounded-lg font-bold text-xs transition-all">
                                            Edit
                                        </button>
                                        <button wire:click="deleteLog({{ $log->id }})" 
                                                wire:confirm="Yakin ingin menghapus entri nutrisi ini?"
                                                class="px-3 py-1.5 bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 hover:bg-rose-100 dark:hover:bg-rose-900/40 rounded-lg font-bold text-xs transition-all">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-10 text-center text-gray-400 dark:text-zinc-500">
                                        Belum ada riwayat nutrisi untuk tanggal ini. Mulai catat makananmu!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Context-Specific FAQ -->
            <section class="mt-8">
                <h3 class="text-2xl font-extrabold text-gray-800 dark:text-white mb-6 transition-colors duration-300 flex items-center gap-2">
                    <svg class="w-6 h-6 text-red-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> FAQ Nutrisi & Protein
                </h3>
                <div class="space-y-4" x-data="{ activeAccordion: '' }">
                    <div class="faq-item bg-white dark:bg-zinc-800 border border-gray-100 dark:border-zinc-700 rounded-2xl overflow-hidden shadow-sm transition-colors duration-300">
                        <button @click="activeAccordion = activeAccordion === 'faq1' ? '' : 'faq1'" class="faq-button w-full flex justify-between items-center p-5 text-left font-bold text-gray-800 dark:text-white hover:bg-gray-50 dark:hover:bg-zinc-700/50 transition-colors focus:outline-none">
                            <span>Mengapa perhitungan mengacu pada standar TKPI Kemenkes RI?</span>
                            <span class="faq-icon text-red-600 dark:text-emerald-400 transform transition-transform duration-300 text-xl" :class="{'rotate-45': activeAccordion === 'faq1'}">+</span>
                        </button>
                        <div class="faq-content overflow-hidden transition-all duration-300 ease-in-out bg-gray-50 dark:bg-zinc-900/30" :style="activeAccordion === 'faq1' ? 'max-height: 500px;' : 'max-height: 0px;'">
                            <div class="p-5 text-sm text-gray-600 dark:text-zinc-400 leading-relaxed border-t border-gray-100 dark:border-zinc-700">
                                Data dari <em>Tabel Komposisi Pangan Indonesia</em> (TKPI) milik Kementerian Kesehatan RI dirancang khusus sesuai profil gizi bahan makanan lokal sehari-hari seperti tempe murni, tahu, telur ayam, dan dada ayam. Dengan begitu, estimasi protein harian yang Anda catat jauh lebih relevan dan akurat. <br><br>
                                <span class="text-xs font-semibold text-zinc-500 dark:text-zinc-500">Sumber: Tabel Komposisi Pangan Indonesia (TKPI) - Kementerian Kesehatan RI</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="faq-item bg-white dark:bg-zinc-800 border border-gray-100 dark:border-zinc-700 rounded-2xl overflow-hidden shadow-sm transition-colors duration-300">
                        <button @click="activeAccordion = activeAccordion === 'faq2' ? '' : 'faq2'" class="faq-button w-full flex justify-between items-center p-5 text-left font-bold text-gray-800 dark:text-white hover:bg-gray-50 dark:hover:bg-zinc-700/50 transition-colors focus:outline-none">
                            <span>Berapa sebenarnya target protein harian saya?</span>
                            <span class="faq-icon text-red-600 dark:text-emerald-400 transform transition-transform duration-300 text-xl" :class="{'rotate-45': activeAccordion === 'faq2'}">+</span>
                        </button>
                        <div class="faq-content overflow-hidden transition-all duration-300 ease-in-out bg-gray-50 dark:bg-zinc-900/30" :style="activeAccordion === 'faq2' ? 'max-height: 500px;' : 'max-height: 0px;'">
                            <div class="p-5 text-sm text-gray-600 dark:text-zinc-400 leading-relaxed border-t border-gray-100 dark:border-zinc-700">
                                Untuk mengoptimalkan pemulihan dan pembentukan massa otot, individu yang rutin berlatih beban disarankan mengonsumsi sekitar 1,6 gram hingga 2,2 gram protein per kilogram berat badan setiap harinya. Jadi jika berat badanmu 70 kg, targetkan sekitar 112g – 154g protein per hari. <br><br>
                                <span class="text-xs font-semibold text-zinc-500 dark:text-zinc-500">Sumber: dr. Dion Haryadi, PN1 & Tim Medis Alodokter</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
