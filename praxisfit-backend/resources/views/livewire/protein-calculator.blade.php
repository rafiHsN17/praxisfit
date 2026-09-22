<div class="space-y-8">
    <!-- Header Badge & Title -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm transition-colors duration-300">
        <div>
            <span class="text-xs font-black uppercase tracking-wider bg-red-100 dark:bg-lime-900/40 text-red-600 dark:text-lime-400 px-3 py-1 rounded-full">
                USDA Nutrition Center
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-zinc-900 dark:text-zinc-100 mt-2">
                Kalkulator & Log Protein Faktual
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Catat asupan protein dengan tingkat keakuratan medis berstandar United States Department of Agriculture (USDA).
            </p>
        </div>

        <!-- Dynamic Progress Display Card -->
        <div class="flex items-center gap-6 bg-slate-50 dark:bg-zinc-800 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 min-w-[240px]">
            <div class="space-y-1 flex-1">
                <div class="text-xs font-semibold text-zinc-500 dark:text-zinc-400">Total Harian</div>
                <div class="text-3xl font-black text-zinc-900 dark:text-zinc-100">
                    {{ number_format($this->totalAchieved ?? 0, 1) }}<span class="text-sm font-bold text-red-600 dark:text-lime-400">g</span>
                </div>
                <div class="text-xs font-medium text-zinc-500 dark:text-zinc-400">
                    Target Tubuh: <span class="font-bold text-zinc-900 dark:text-zinc-100">{{ $targetProtein ?? 150 }}g</span>
                </div>
            </div>
            <div class="text-right">
                @php
                    $target = $targetProtein ?? 150;
                    $achieved = $this->totalAchieved ?? 0;
                    $remaining = $target - $achieved;
                @endphp
                @if($remaining <= 0)
                    <span class="text-xs font-extrabold px-2 py-1 bg-emerald-100 dark:bg-lime-400/20 text-emerald-700 dark:text-lime-400 rounded-lg block text-center">
                        🎯 Tercapai!
                    </span>
                @else
                    <span class="text-xl font-extrabold text-orange-500 dark:text-orange-400 block">
                        -{{ number_format($remaining, 1) }}g
                    </span>
                    <span class="text-[10px] text-zinc-500 dark:text-zinc-400 uppercase font-semibold">Sisa Target</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Session Flash Notifications -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 dark:bg-lime-900/30 border border-emerald-200 dark:border-lime-700 text-emerald-700 dark:text-lime-300 rounded-xl font-medium flex items-center gap-2 shadow-sm transition-all animate-fade-in">
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('info'))
        <div class="p-4 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-300 rounded-xl font-medium flex items-center gap-2 shadow-sm">
            <span>{{ session('info') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- LEFT COLUMN: Input Form with wire:model and wire:click / wire:submit -->
        <div class="md:col-span-1 bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm h-fit space-y-5 transition-colors duration-300">
            <h2 class="text-lg font-bold text-zinc-900 dark:text-zinc-100 border-b border-zinc-200 dark:border-zinc-800 pb-3">
                ➕ Catat Asupan Baru
            </h2>

            <form wire:submit.prevent="saveLog" class="space-y-4">
                <!-- Tanggal Input -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">Tanggal</label>
                    <input type="date" wire:model.live="tanggal" 
                           class="w-full p-3 border border-zinc-300 dark:border-zinc-700 rounded-xl focus:ring-2 focus:ring-lime-500 dark:focus:ring-lime-500 outline-none bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 font-medium transition-all">
                </div>

                <!-- Sumber Makanan Select (Real-time reactivity) -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">Sumber Makanan (USDA)</label>
                    <select wire:model.live="sumber_makanan" 
                            class="w-full p-3 border border-zinc-300 dark:border-zinc-700 rounded-xl focus:ring-2 focus:ring-lime-500 dark:focus:ring-lime-500 outline-none bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 font-medium transition-all">
                        @foreach($foodDatabase as $food => $protein)
                            <option value="{{ $food }}">{{ $food }} (~{{ $protein }}g/100g)</option>
                        @endforeach
                    </select>
                </div>

                <!-- Berat Makanan -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">Berat Makanan (Gram)</label>
                    <input type="number" step="0.5" wire:model.live="berat" 
                           class="w-full p-3 border border-zinc-300 dark:border-zinc-700 rounded-xl focus:ring-2 focus:ring-lime-500 dark:focus:ring-lime-500 outline-none bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 font-medium transition-all"
                           placeholder="Contoh: 150">
                    @error('berat') <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Live Computed Preview Box -->
                <div class="p-4 bg-slate-50 dark:bg-zinc-800 rounded-xl flex items-center justify-between border border-zinc-200 dark:border-zinc-800">
                    <span class="text-xs font-bold text-zinc-500 dark:text-zinc-400">Estimasi Protein:</span>
                    <span class="text-xl font-black text-red-600 dark:text-lime-400">
                        {{ $this->calculatedProtein ?? 0 }}g
                    </span>
                </div>

                <!-- Button with wire:click="saveLog" as requested -->
                <button type="button" wire:click="saveLog" 
                        class="w-full bg-red-600 dark:bg-lime-400 text-white dark:text-zinc-900 font-extrabold p-3.5 rounded-xl hover:bg-red-700 dark:hover:bg-lime-500 active:scale-[0.99] transition-all shadow-md flex justify-center items-center gap-2">
                    <span wire:loading.remove wire:target="saveLog">Simpan ke Catatan</span>
                    <span wire:loading wire:target="saveLog">Menyimpan... ⏳</span>
                </button>
            </form>
        </div>

        <!-- RIGHT COLUMN: Daily Logs Table & FAQ Accordion -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden transition-colors duration-300">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-800 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">
                        📋 Catatan Hari Ini (<span class="text-red-600 dark:text-lime-400">{{ \Carbon\Carbon::parse($tanggal ?? now())->translatedFormat('d M Y') }}</span>)
                    </h2>
                    <span class="text-xs bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 font-bold px-3 py-1 rounded-full border border-zinc-200 dark:border-zinc-700">
                        {{ is_countable($this->dailyLogs) ? $this->dailyLogs->count() : 0 }} Entri
                    </span>
                </div>

                <!-- Table Content -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800 text-[11px] font-extrabold uppercase text-zinc-500 dark:text-zinc-400 border-b border-zinc-200 dark:border-zinc-800">
                                <th class="p-4">Makanan</th>
                                <th class="p-4">Protein</th>
                                <th class="p-4">Waktu Input</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800 text-sm font-medium">
                            @forelse($this->dailyLogs ?? [] as $log)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="log-item-{{ $log->id }}">
                                    <td class="p-4 font-semibold text-zinc-900 dark:text-zinc-100">
                                        {{ $log->sumber_makanan }}
                                    </td>
                                    <td class="p-4 font-black text-red-600 dark:text-lime-400">
                                        {{ number_format($log->jumlah_protein, 1) }}g
                                    </td>
                                    <td class="p-4 text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $log->created_at ? $log->created_at->format('H:i') : '-' }} WIB
                                    </td>
                                    <td class="p-4 text-center">
                                        <button wire:click="deleteLog({{ $log->id }})" 
                                                wire:confirm="Yakin ingin menghapus entri nutrisi ini?"
                                                class="px-2.5 py-1.5 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/40 rounded-lg font-bold text-xs transition-all">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-zinc-500 dark:text-zinc-400">
                                        <div class="text-3xl mb-2">🍽️</div>
                                        <div class="font-bold">Belum ada catatan protein hari ini.</div>
                                        <div class="text-xs mt-1">Gunakan form di sebelah kiri untuk merekam asupan nutrisi Anda!</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- FAQ ACCORDION (Pure Alpine.js) -->
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm space-y-4 transition-colors duration-300">
                <h3 class="font-extrabold text-zinc-900 dark:text-zinc-100 flex items-center gap-2">
                    <span>💬 Edukasi Kebugaran: Sains Seputar Nutrisi & Protein</span>
                </h3>

                <div class="space-y-3">
                    <!-- Accordion 1 -->
                    <div x-data="{ open: false }" class="border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden transition-all duration-200">
                        <button @click="open = !open" class="w-full p-4 text-left font-bold text-sm text-zinc-900 dark:text-zinc-100 flex justify-between items-center hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                            <span>Mengapa penting memenuhi target protein setelah angkat beban (Hypertrophy)?</span>
                            <span x-text="open ? '−' : '+'" class="font-black text-red-600 dark:text-lime-400 text-lg leading-none"></span>
                        </button>
                        <div x-show="open" x-collapse x-cloak class="px-4 pb-4 text-xs leading-relaxed text-zinc-500 dark:text-zinc-400 border-t border-zinc-200 dark:border-zinc-800 pt-3 bg-zinc-50 dark:bg-zinc-800/50">
                            Latihan resistensi atau angkat beban menghasilkan trauma mikro (micro-tears) pada serat otot Anda. Asimilasi asam amino dari makanan berprotein tinggi merangsang sintesis protein otot (Muscle Protein Synthesis / MPS), memperbaiki jaringan, dan membuatnya lebih besar serta lebih kuat.
                        </div>
                    </div>

                    <!-- Accordion 2 -->
                    <div x-data="{ open: false }" class="border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden transition-all duration-200">
                        <button @click="open = !open" class="w-full p-4 text-left font-bold text-sm text-zinc-900 dark:text-zinc-100 flex justify-between items-center hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                            <span>Berapa rasio protein optimal untuk Membangun Otot (Muscle Gain)?</span>
                            <span x-text="open ? '−' : '+'" class="font-black text-red-600 dark:text-lime-400 text-lg leading-none"></span>
                        </button>
                        <div x-show="open" x-collapse x-cloak class="px-4 pb-4 text-xs leading-relaxed text-zinc-500 dark:text-zinc-400 border-t border-zinc-200 dark:border-zinc-800 pt-3 bg-zinc-50 dark:bg-zinc-800/50">
                            Berdasarkan literatur nutrisi olahraga terkini dari ISSN (International Society of Sports Nutrition), individu yang melakukan latihan beban secara intensif sangat disarankan mengonsumsi antara 1.6 gram hingga 2.2 gram protein per kilogram berat badan setiap hari, dibagi secara merata ke 4-5 waktu makan.
                        </div>
                    </div>

                    <!-- Accordion 3 -->
                    <div x-data="{ open: false }" class="border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden transition-all duration-200">
                        <button @click="open = !open" class="w-full p-4 text-left font-bold text-sm text-zinc-900 dark:text-zinc-100 flex justify-between items-center hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                            <span>Mengapa mengacu pada standar USDA (United States Department of Agriculture)?</span>
                            <span x-text="open ? '−' : '+'" class="font-black text-red-600 dark:text-lime-400 text-lg leading-none"></span>
                        </button>
                        <div x-show="open" x-collapse x-cloak class="px-4 pb-4 text-xs leading-relaxed text-zinc-500 dark:text-zinc-400 border-t border-zinc-200 dark:border-zinc-800 pt-3 bg-zinc-50 dark:bg-zinc-800/50">
                            USDA FoodData Central adalah database nutrisi ilmiah paling komprehensif di dunia. Dengan menggunakan rasio USDA (seperti 31g protein untuk 100g dada ayam fillet masak), Anda menghindari perkiraan mentega atau asumsi kalengan, memastikan diet surplus/defisit kalori Anda presisi.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
