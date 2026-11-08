<div class="max-w-3xl mx-auto space-y-12 px-4 sm:px-0">
    
    <!-- Hero / Header -->
    <div class="space-y-4">
        <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
            Pusat Bantuan PraxisFit
        </h1>
        <p class="text-zinc-500 dark:text-zinc-400 text-sm sm:text-base">
            Bagaimana kami bisa membantu Anda hari ini? Temukan panduan aplikasi atau cari jawaban atas pertanyaan Anda di bawah ini.
        </p>
    </div>

    <!-- Panduan Penggunaan Aplikasi (Help Guides) -->
    <div class="space-y-6">
        <h2 class="text-xl font-bold text-zinc-800 dark:text-zinc-200 border-b border-zinc-200 dark:border-zinc-800 pb-2">
            Panduan Penggunaan Aplikasi
        </h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" x-data="{ guide: null }">
            
            <!-- Guide 1: Memulai Perjalanan -->
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-5 hover:border-red-500 dark:hover:border-emerald-500 transition-colors cursor-pointer group" @click="guide = guide === 1 ? null : 1">
                <div class="flex items-start gap-4">
                    <div class="shrink-0 p-3 bg-red-50 dark:bg-emerald-400/10 rounded-xl text-red-600 dark:text-emerald-400">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-zinc-900 dark:text-zinc-100 group-hover:text-red-600 dark:group-hover:text-emerald-400 transition-colors">1. Memulai Perjalanan (Onboarding)</h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Cara daftar, login, dan atur profil fisik Anda.</p>
                    </div>
                </div>
                <div x-show="guide === 1" x-collapse x-cloak class="mt-4 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                    <ul class="space-y-3 text-sm text-zinc-600 dark:text-zinc-400 list-decimal list-inside marker:text-red-600 dark:marker:text-emerald-400">
                        <li><strong>Daftar/Login:</strong> Klik tombol "Masuk" di pojok kanan atas lalu pilih "Daftar di sini". Cukup isi nama, email contoh (tidak wajib Gmail asli), dan password untuk langsung aktif tanpa kode OTP.</li>
                        <li><strong>Pengisian Profil:</strong> Buka menu <a href="{{ route('profile.edit') }}" class="text-red-600 dark:text-emerald-400 hover:underline" @click.stop>Profil</a> untuk melengkapi Tinggi, Berat Badan, dan Tingkat Aktivitas. Data ini penting agar kalkulator kalori harian akurat.</li>
                        <li><strong>Pilih Tujuan:</strong> Tentukan apakah Anda ingin <em>Bulking</em> (tambah berat), <em>Cutting</em> (turun berat), atau <em>Maintenance</em>.</li>
                    </ul>
                </div>
            </div>

            <!-- Guide 2: Workout Planner -->
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-5 hover:border-red-500 dark:hover:border-emerald-500 transition-colors cursor-pointer group" @click="guide = guide === 2 ? null : 2">
                <div class="flex items-start gap-4">
                    <div class="shrink-0 p-3 bg-red-50 dark:bg-emerald-400/10 rounded-xl text-red-600 dark:text-emerald-400">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-zinc-900 dark:text-zinc-100 group-hover:text-red-600 dark:group-hover:text-emerald-400 transition-colors">2. Menggunakan Workout Planner</h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Cara mencari dan menyusun jadwal latihan.</p>
                    </div>
                </div>
                <div x-show="guide === 2" x-collapse x-cloak class="mt-4 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                    <ul class="space-y-3 text-sm text-zinc-600 dark:text-zinc-400 list-decimal list-inside marker:text-red-600 dark:marker:text-emerald-400">
                        <li><strong>Buka Planner:</strong> Akses menu <a href="{{ route('workout.planner') }}" class="text-red-600 dark:text-emerald-400 hover:underline" @click.stop>Workout Planner</a> dari navigasi.</li>
                        <li><strong>Cari Latihan:</strong> Gunakan kotak pencarian atau filter untuk menemukan gerakan yang Anda inginkan (misalnya: Bench Press).</li>
                        <li><strong>Tambahkan Rencana:</strong> Klik tombol Tambah untuk memasukkan latihan ke jadwal hari ini.</li>
                        <li><strong>Catat Progress:</strong> Isi jumlah Set, Repetisi, dan Beban (kg), lalu simpan untuk memonitor perkembangan angkatan Anda.</li>
                    </ul>
                </div>
            </div>

            <!-- Guide 3: Protein Log -->
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-5 hover:border-red-500 dark:hover:border-emerald-500 transition-colors cursor-pointer group" @click="guide = guide === 3 ? null : 3">
                <div class="flex items-start gap-4">
                    <div class="shrink-0 p-3 bg-red-50 dark:bg-emerald-400/10 rounded-xl text-red-600 dark:text-emerald-400">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-zinc-900 dark:text-zinc-100 group-hover:text-red-600 dark:group-hover:text-emerald-400 transition-colors">3. Mencatat Nutrisi (Protein)</h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Cara memantau target kalori dan protein.</p>
                    </div>
                </div>
                <div x-show="guide === 3" x-collapse x-cloak class="mt-4 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                    <ul class="space-y-3 text-sm text-zinc-600 dark:text-zinc-400 list-decimal list-inside marker:text-red-600 dark:marker:text-emerald-400">
                        <li><strong>Buka Protein Log:</strong> Kunjungi halaman <a href="{{ route('calculator') }}" class="text-red-600 dark:text-emerald-400 hover:underline" @click.stop>Protein Log / Kalkulator</a>.</li>
                        <li><strong>Pilih Makanan:</strong> Cari makanan atau bahan makanan dari database.</li>
                        <li><strong>Tentukan Porsi:</strong> Masukkan jumlah gram atau porsi yang Anda konsumsi.</li>
                        <li><strong>Catat:</strong> Sistem otomatis menghitung kalori dan protein, serta menyesuaikannya dengan target harian Anda.</li>
                    </ul>
                </div>
            </div>

            <!-- Guide 4: Kalkulator 1RM -->
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-5 hover:border-red-500 dark:hover:border-emerald-500 transition-colors cursor-pointer group" @click="guide = guide === 4 ? null : 4">
                <div class="flex items-start gap-4">
                    <div class="shrink-0 p-3 bg-red-50 dark:bg-emerald-400/10 rounded-xl text-red-600 dark:text-emerald-400">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-zinc-900 dark:text-zinc-100 group-hover:text-red-600 dark:group-hover:text-emerald-400 transition-colors">4. Kalkulator 1RM</h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Estimasi kekuatan maksimal Anda.</p>
                    </div>
                </div>
                <div x-show="guide === 4" x-collapse x-cloak class="mt-4 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                    <ul class="space-y-3 text-sm text-zinc-600 dark:text-zinc-400 list-decimal list-inside marker:text-red-600 dark:marker:text-emerald-400">
                        <li><strong>Akses Kalkulator:</strong> Buka halaman <a href="{{ route('calculator') }}" class="text-red-600 dark:text-emerald-400 hover:underline" @click.stop>1RM Calculator</a>.</li>
                        <li><strong>Masukkan Data:</strong> Ketik beban (kg) yang biasa Anda angkat dan jumlah repetisi maksimal dengan beban tersebut.</li>
                        <li><strong>Lihat Hasil:</strong> Sistem akan mengestimasi 1 Rep Max (beban maksimal 1x angkat) beserta persentasenya untuk memandu latihan.</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <!-- Divider & FAQ Asli -->
    <div class="border-t border-zinc-200 dark:border-zinc-800 pt-8 mt-4">
        <div class="space-y-2 mb-6">
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">
                Pertanyaan Seputar Fitness (FAQ)
            </h2>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm">
                Temukan jawaban seputar nutrisi, latihan, dan mitos dari database kami.
            </p>
        </div>

        <!-- Search Bar -->
        <div class="relative max-w-md mb-6">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-zinc-400 dark:text-zinc-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input type="text" wire:model.live="search" class="block w-full p-3 pl-10 text-sm text-zinc-900 dark:text-zinc-100 border border-zinc-300 dark:border-zinc-800 rounded-xl bg-white dark:bg-zinc-900 focus:ring-red-600 focus:border-red-600 dark:focus:ring-emerald-500 dark:focus:border-emerald-500 placeholder-zinc-400 dark:placeholder-zinc-500 transition-colors shadow-sm" placeholder="Cari pertanyaan atau jawaban...">
        </div>
    </div>

    <div x-data="{ active: null }" class="space-y-10 pb-10">
        @forelse($faqsByCategory as $kategori => $faqs)
            <div class="animate-fade-in-up">
                <h2 class="text-lg sm:text-xl font-bold text-red-600 dark:text-emerald-400 mb-4 flex items-center gap-2">
                    {{ $categoryNames[$kategori] ?? ucwords(str_replace('_', ' ', $kategori)) }}
                </h2>
                
                <div class="border-t border-zinc-200 dark:border-zinc-800">
                    @foreach($faqs as $faq)
                        <div class="border-b border-zinc-200 dark:border-zinc-800 transition-all duration-300" x-data="{ id: {{ $faq->id }} }">
                            <button @click="active = active === id ? null : id" class="flex w-full items-center justify-between py-5 text-left focus:outline-none hover:bg-slate-50 dark:hover:bg-zinc-800/50 transition-colors group px-2">
                                <span class="text-sm sm:text-base font-medium text-zinc-800 dark:text-zinc-200 group-hover:text-red-600 dark:group-hover:text-emerald-400 transition-colors duration-200" :class="active === id ? 'text-red-600 dark:text-emerald-400' : ''">
                                    {{ $faq->pertanyaan }}
                                </span>
                                <span class="ml-4 shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 transition-all duration-300" :class="active === id ? 'bg-red-50 dark:bg-emerald-400/10 text-red-600 dark:text-emerald-400 rotate-180' : ''">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </button>
                            
                            <div x-show="active === id" 
                                 x-collapse 
                                 x-cloak
                                 class="bg-transparent">
                                <div class="pb-5 px-2 text-sm sm:text-base text-zinc-600 dark:text-zinc-400 leading-relaxed">
                                    <p>{{ $faq->jawaban_singkat }}</p>
                                    
                                    @if($faq->contoh)
                                        <div class="mt-4 p-4 bg-zinc-50 dark:bg-zinc-900 rounded-xl text-sm border border-zinc-200 dark:border-zinc-800 flex flex-col sm:flex-row gap-3">
                                            <div class="shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-red-50 dark:bg-emerald-400/10 text-red-600 dark:text-emerald-400">
                                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <span class="font-bold text-zinc-800 dark:text-zinc-200 block mb-1">Contoh Praktis:</span>
                                                <span class="text-zinc-600 dark:text-zinc-400">{{ $faq->contoh }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if($faq->sumber_nama)
                                        <div class="mt-4 flex items-start gap-2 text-xs">
                                            <svg class="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                            <div>
                                                <span class="font-semibold text-zinc-500 dark:text-zinc-400">Sumber Referensi Tepercaya:</span><br>
                                                <span class="text-zinc-700 dark:text-zinc-300 font-medium">{{ $faq->sumber_nama }}</span>
                                                @if($faq->sumber_url)
                                                    <a href="{{ $faq->sumber_url }}" target="_blank" rel="noopener noreferrer" class="ml-1 text-red-600 dark:text-emerald-400 hover:underline inline-flex items-center gap-0.5">
                                                        <span>(Lihat Sumber)</span>
                                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="py-12 text-center bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm dark:shadow-none">
                <svg class="mx-auto h-12 w-12 text-zinc-400 dark:text-zinc-500 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-zinc-900 dark:text-zinc-100">Tidak ada hasil</h3>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Kami tidak menemukan pertanyaan yang cocok dengan pencarian Anda.</p>
            </div>
        @endforelse
    </div>
</div>
