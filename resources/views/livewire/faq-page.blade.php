<div class="max-w-4xl mx-auto px-4 sm:px-6 py-8 sm:py-12 space-y-10 pb-20">

    <!-- HEADER SECTION (GAMBAR 5) -->
    <div class="space-y-4">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#E54855]/10 text-[#E54855] text-xs font-bold uppercase tracking-wider">
            Pusat Bantuan PraxisFit
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-[#202124] dark:text-[#F5F5F5]">
            Pertanyaan yang Sering Diajukan
        </h1>
        <p class="text-sm sm:text-base text-[#777777] dark:text-[#AAA0A2] max-w-2xl leading-relaxed">
            Semua yang perlu Anda ketahui tentang penggunaan aplikasi PraxisFit, kalkulator nutrisi TKPI, latihan fisik, hingga sumber rujukan tepercaya dari Indonesia.
        </p>

        <!-- Search Input -->
        <div class="relative pt-2">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pt-2 pointer-events-none">
                <svg class="w-4 h-4 text-[#777777] dark:text-[#AAA0A2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text"
                   wire:model.live.debounce.250ms="search"
                   placeholder="Cari pertanyaan, topik latihan, nutrisi, atau sumber..."
                   class="w-full pl-11 pr-10 py-3.5 rounded-2xl bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] text-sm text-[#202124] dark:text-[#F5F5F5] placeholder-[#777777] dark:placeholder-[#AAA0A2] shadow-xs focus:outline-none focus:border-[#E54855] transition-colors">
            @if($search)
                <button type="button" wire:click="$set('search', '')"
                        class="absolute right-3.5 top-5 text-[#777777] hover:text-[#E54855] text-sm font-bold cursor-pointer">&times;</button>
            @endif
        </div>

        <!-- Category Filter Pills (Gambar 5) -->
        <div class="flex flex-wrap items-center gap-2 pt-1">
            <button type="button" wire:click="setCategory('')"
                    class="px-4 py-2 rounded-full text-xs font-bold transition-all cursor-pointer {{ $activeCategory === '' ? 'bg-[#E54855] text-white shadow-xs' : 'bg-white dark:bg-[#1A1012] text-[#777777] dark:text-[#AAA0A2] border border-[#E9E9EC] dark:border-[#342427] hover:border-[#E54855]/50 hover:text-[#202124] dark:hover:text-[#F5F5F5]' }}">
                Semua ({{ \App\Models\Faq::count() }})
            </button>

            @foreach($allCategories as $catKey => $catLabel)
                <button type="button" wire:click="setCategory('{{ $catKey }}')"
                        class="px-4 py-2 rounded-full text-xs font-bold transition-all cursor-pointer {{ $activeCategory === $catKey ? 'bg-[#E54855] text-white shadow-xs' : 'bg-white dark:bg-[#1A1012] text-[#777777] dark:text-[#AAA0A2] border border-[#E9E9EC] dark:border-[#342427] hover:border-[#E54855]/50 hover:text-[#202124] dark:hover:text-[#F5F5F5]' }}">
                    {{ $catLabel }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- COLLAPSIBLE PANDUAN PENGGUNAAN APLIKASI -->
    <div x-data="{ showGuides: false, activeGuide: null }" class="bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] overflow-hidden shadow-xs">
        <button type="button" @click="showGuides = !showGuides"
                class="w-full px-5 py-4 flex items-center justify-between text-left hover:bg-[#F7F7F8]/60 dark:hover:bg-[#251518]/60 transition-colors cursor-pointer">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-[#E54855]/10 text-[#E54855] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-extrabold text-[#202124] dark:text-[#F5F5F5]">Panduan Cepat Menggunakan Fitur PraxisFit</h2>
                    <p class="text-xs text-[#777777] dark:text-[#AAA0A2]">Langkah singkat menggunakan Kalkulator Nutrisi, Katalog Gerakan, dan Workout Planner.</p>
                </div>
            </div>
            <span class="text-xs font-bold text-[#E54855] shrink-0 ml-3" x-text="showGuides ? 'Tutup' : 'Buka Panduan'"></span>
        </button>

        <div x-show="showGuides" x-collapse x-cloak class="px-5 pb-5 pt-2 border-t border-[#E9E9EC] dark:border-[#342427]">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 pt-2">
                <div class="p-4 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] space-y-2">
                    <h3 class="text-sm font-bold text-[#202124] dark:text-[#F5F5F5]">1. Profil & Kebutuhan Makro</h3>
                    <p class="text-xs text-[#777777] dark:text-[#AAA0A2] leading-relaxed">
                        Isi jenis kelamin, berat, tinggi, usia, tingkat aktivitas, dan target (Cutting/Maintenance/Bulking) di menu <a href="{{ route('calculator') }}" wire:navigate class="text-[#E54855] font-semibold hover:underline">Kalkulator Nutrisi</a> untuk mendapatkan hitungan Mifflin-St Jeor dan rasio protein aman.
                    </p>
                </div>
                <div class="p-4 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] space-y-2">
                    <h3 class="text-sm font-bold text-[#202124] dark:text-[#F5F5F5]">2. Filter Multi-Alat di Katalog</h3>
                    <p class="text-xs text-[#777777] dark:text-[#AAA0A2] leading-relaxed">
                        Gunakan filter kombinasi peralatan (Bodyweight, Dumbbell, Barbell, Cable, Resistance Band), tingkat kesulitan, dan otot target pada <a href="{{ route('catalog') }}" wire:navigate class="text-[#E54855] font-semibold hover:underline">Katalog Gerakan</a>.
                    </p>
                </div>
                <div class="p-4 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] space-y-2">
                    <h3 class="text-sm font-bold text-[#202124] dark:text-[#F5F5F5]">3. Kalender & Peringatan Jadwal</h3>
                    <p class="text-xs text-[#777777] dark:text-[#AAA0A2] leading-relaxed">
                        Jadwalkan sesi pada kalender aktual di <a href="{{ route('workout.planner') }}" wire:navigate class="text-[#E54855] font-semibold hover:underline">Workout Planner</a>. Jika tanggal mulai berbeda dari jadwal, sistem memberi konfirmasi agar histori kepatuhan tercatat jujur.
                    </p>
                </div>
                <div class="p-4 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] space-y-2">
                    <h3 class="text-sm font-bold text-[#202124] dark:text-[#F5F5F5]">4. Catatan Pangan Lokal (TKPI)</h3>
                    <p class="text-xs text-[#777777] dark:text-[#AAA0A2] leading-relaxed">
                        Pilih bahan makanan lokal Indonesia (Dada Ayam, Tempe, Telur, Ikan Kembung, dll.) atau masukkan makanan kustom setiap selesai makan.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- NUMBERED ACCORDION LIST (GAMBAR 5) -->
    <div x-data="{ activeId: {{ $faqs->first()?->id ?? 'null' }} }"
         class="bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] divide-y divide-[#E9E9EC] dark:divide-[#342427] shadow-xs overflow-hidden">

        @forelse($faqs as $idx => $faq)
            @php $numLabel = str_pad((string) ($idx + 1), 2, '0', STR_PAD_LEFT); @endphp
            <div wire:key="faq-row-{{ $faq->id }}" class="transition-colors">
                <button type="button"
                        @click="activeId = activeId === {{ $faq->id }} ? null : {{ $faq->id }}"
                        class="w-full px-5 sm:px-6 py-5 flex items-center justify-between gap-4 text-left hover:bg-[#F7F7F8]/60 dark:hover:bg-[#251518]/60 transition-colors cursor-pointer">
                    <div class="flex items-start sm:items-center gap-4 min-w-0">
                        <span class="text-xs font-extrabold font-mono shrink-0 pt-0.5 sm:pt-0 transition-colors"
                              :class="activeId === {{ $faq->id }} ? 'text-[#E54855]' : 'text-[#777777] dark:text-[#AAA0A2]'">
                            {{ $numLabel }}
                        </span>
                        <div class="space-y-1 min-w-0">
                            <span class="text-sm sm:text-base font-bold leading-snug block transition-colors"
                                  :class="activeId === {{ $faq->id }} ? 'text-[#E54855]' : 'text-[#202124] dark:text-[#F5F5F5]'">
                                {{ $faq->pertanyaan }}
                            </span>
                            <span class="inline-block text-[11px] font-semibold text-[#777777] dark:text-[#AAA0A2]">
                                {{ \App\Models\Faq::categoryLabel($faq->kategori) }}
                            </span>
                        </div>
                    </div>

                    <!-- + / x Circular Red Toggle Icon (Gambar 5) -->
                    <span class="shrink-0 w-8 h-8 rounded-full flex items-center justify-center transition-all duration-200"
                          :class="activeId === {{ $faq->id }} ? 'bg-[#E54855] text-white' : 'bg-[#F7F7F8] dark:bg-[#251518] text-[#777777] dark:text-[#AAA0A2] border border-[#E9E9EC] dark:border-[#342427]'">
                        <svg x-show="activeId !== {{ $faq->id }}" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        <svg x-show="activeId === {{ $faq->id }}" x-cloak class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </span>
                </button>

                <div x-show="activeId === {{ $faq->id }}" x-collapse x-cloak>
                    <div class="px-5 sm:px-6 pb-6 pl-12 sm:pl-14 space-y-4 text-sm text-[#777777] dark:text-[#AAA0A2] leading-relaxed">
                        <p class="text-[#202124]/90 dark:text-[#F5F5F5]/90">{{ $faq->jawaban_singkat }}</p>

                        @if($faq->contoh)
                            <div class="p-4 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] flex items-start gap-3">
                                <span class="w-6 h-6 rounded-lg bg-[#E54855]/10 text-[#E54855] flex items-center justify-center shrink-0 mt-0.5 text-xs font-extrabold">!</span>
                                <div class="text-xs leading-relaxed">
                                    <span class="font-bold text-[#202124] dark:text-[#F5F5F5] block mb-0.5">Contoh Praktis:</span>
                                    {{ $faq->contoh }}
                                </div>
                            </div>
                        @endif

                        @if($faq->sumber_nama)
                            <div class="flex flex-wrap items-center gap-2 text-xs pt-1">
                                <span class="font-semibold text-[#777777] dark:text-[#AAA0A2]">Sumber Referensi:</span>
                                <span class="font-bold text-[#202124] dark:text-[#F5F5F5]">{{ $faq->sumber_nama }}</span>
                                @if($faq->sumber_url)
                                    <a href="{{ $faq->sumber_url }}" target="_blank" rel="noopener noreferrer"
                                       class="text-[#E54855] hover:text-[#C93646] font-bold hover:underline inline-flex items-center gap-1">
                                        <span>Buka Sumber</span>
                                        <span>&nearr;</span>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="p-12 text-center space-y-2">
                <h3 class="text-base font-bold text-[#202124] dark:text-[#F5F5F5]">Pertanyaan tidak ditemukan</h3>
                <p class="text-xs text-[#777777] dark:text-[#AAA0A2]">Coba kata kunci lain atau pilih kategori Semua.</p>
                <button type="button" wire:click="$set('search', ''); setCategory('')"
                        class="mt-2 px-4 py-2 rounded-xl bg-[#E54855] text-white text-xs font-bold cursor-pointer">
                    Tampilkan Semua FAQ
                </button>
            </div>
        @endforelse
    </div>

    <!-- BOTTOM CARD: MASIH MEMBUTUHKAN BANTUAN? (GAMBAR 5) -->
    <div class="bg-[#F1F1F4] dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] p-6 sm:p-8 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="space-y-1">
                <h2 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">
                    Masih Membutuhkan Bantuan?
                </h2>
                <p class="text-sm text-[#777777] dark:text-[#AAA0A2]">
                    Belum menemukan jawaban yang Anda cari? Kirim pertanyaan langsung ke tim PraxisFit melalui formulir bantuan.
                </p>
            </div>

            <button type="button" wire:click="openContactForm"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white text-sm font-bold shadow-sm transition-colors shrink-0 cursor-pointer">
                <span>{{ $showContactForm ? 'Tutup Formulir' : 'Hubungi Bantuan' }}</span>
                <span>&rarr;</span>
            </button>
        </div>

        @if($showContactForm)
            <div class="pt-5 border-t border-[#E9E9EC] dark:border-[#342427]">
                @if($contactSubmitted)
                    <div class="p-4 rounded-xl bg-[#E54855]/10 border border-[#E54855]/30 text-[#C93646] dark:text-[#E54855] text-sm font-semibold mb-4">
                        Terima kasih! Pesan bantuan Anda telah tersimpan dan akan ditinjau oleh tim PraxisFit.
                    </div>
                @endif

                <form wire:submit="submitSupportMessage" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="contact-name" class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1">Nama Lengkap</label>
                            <input id="contact-name" type="text" wire:model="contactName" required placeholder="Nama Anda..."
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-sm text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]">
                            @error('contactName') <span class="text-xs text-[#E54855] mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="contact-email" class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1">Email</label>
                            <input id="contact-email" type="email" wire:model="contactEmail" required placeholder="email@contoh.com"
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-sm text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]">
                            @error('contactEmail') <span class="text-xs text-[#E54855] mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="contact-subject" class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1">Subjek Pertanyaan</label>
                        <input id="contact-subject" type="text" wire:model="contactSubject" required placeholder="Cth: Kendala kalkulator nutrisi atau jadwal latihan..."
                               class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-sm text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]">
                        @error('contactSubject') <span class="text-xs text-[#E54855] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="contact-message" class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1">Detail Pesan</label>
                        <textarea id="contact-message" wire:model="contactMessage" rows="3" required placeholder="Tuliskan pertanyaan atau kendala Anda secara jelas (minimal 10 karakter)..."
                                  class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-sm text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]"></textarea>
                        @error('contactMessage') <span class="text-xs text-[#E54855] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" wire:loading.attr="disabled"
                                class="px-6 py-2.5 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white text-sm font-bold shadow-sm transition-colors cursor-pointer disabled:opacity-60">
                            <span wire:loading.remove wire:target="submitSupportMessage">Kirim Pesan Bantuan</span>
                            <span wire:loading wire:target="submitSupportMessage">Mengirim...</span>
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>

</div>
