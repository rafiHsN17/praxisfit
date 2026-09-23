<div class="space-y-12">
    
    <!-- HIGHLY MOTIVATING WELCOME BANNER (PREMIUM) -->
    <div class="bg-white dark:bg-zinc-900 p-6 sm:p-14 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-xl dark:shadow-2xl relative overflow-hidden group transition-all duration-500 hover:shadow-2xl">
        <div class="absolute -right-10 -bottom-10 text-[150px] sm:text-[200px] opacity-[0.03] dark:opacity-[0.02] select-none pointer-events-none font-black text-zinc-900 dark:text-zinc-100 transform group-hover:scale-110 group-hover:rotate-3 transition-transform duration-700">
            PRX
        </div>

        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-600 dark:from-emerald-400 dark:via-teal-400 dark:to-emerald-500"></div>

        <div class="relative z-10 max-w-3xl space-y-6">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-50 dark:bg-emerald-400/10 text-emerald-700 dark:text-emerald-400 text-[10px] sm:text-xs font-bold uppercase tracking-wider border border-emerald-200 dark:border-emerald-400/20 shadow-sm">
                <svg class="w-3 h-3 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span>Command Center Aktif</span>
            </div>
            
            <h1 class="text-4xl sm:text-6xl font-black tracking-tight text-zinc-900 dark:text-zinc-100 leading-tight transition-colors">
                Siap Menghancurkan <br class="hidden sm:block"><span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500 dark:from-emerald-400 dark:to-teal-400">Batasmu Hari Ini?</span>
            </h1>

            <p class="text-base sm:text-lg text-zinc-600 dark:text-zinc-400 font-medium leading-relaxed transition-colors max-w-2xl">
                Tidak ada kejayaan tanpa konsistensi. Pantau asupan nutrisi protein Anda dan eksekusi jadwal latihan dengan presisi maksimal.
            </p>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 pt-4">
                <a href="{{ url('/rutinku') }}" wire:navigate 
                   class="px-6 py-4 rounded-2xl bg-emerald-600 text-white hover:bg-emerald-700 dark:bg-emerald-500 dark:text-white dark:hover:bg-emerald-600 font-extrabold text-sm uppercase tracking-wider shadow-lg hover:shadow-emerald-500/30 dark:hover:shadow-emerald-400/30 transition-all duration-300 transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2">
                    <span>Mulai Latihan Sekarang</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </a>
                <a href="{{ url('/kalkulator') }}" wire:navigate 
                   class="px-6 py-4 rounded-2xl bg-white dark:bg-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-700 text-zinc-900 dark:text-zinc-100 font-extrabold text-sm uppercase tracking-wider border border-zinc-200 dark:border-zinc-700 shadow-sm transition-all duration-300 flex items-center justify-center gap-2 group">
                    <span>Catat Nutrisi</span>
                    <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 3 SUMMARY STATISTIC CARDS DENGAN GLASSMORPHISM & HOVER EFFECTS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- CARD 1: Nutrisi -->
        <a href="{{ url('/kalkulator') }}" wire:navigate 
           class="bg-white/80 dark:bg-zinc-900/80 backdrop-blur-xl rounded-3xl p-8 border border-zinc-200/80 dark:border-zinc-800/80 shadow-lg hover:-translate-y-2 hover:shadow-2xl hover:border-emerald-500/50 dark:hover:border-emerald-400/50 transition-all duration-500 flex flex-col justify-between group relative overflow-hidden">
            
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 dark:bg-emerald-400/5 rounded-full blur-3xl -translate-y-10 translate-x-10 group-hover:bg-emerald-500/10 dark:group-hover:bg-emerald-400/10 transition-colors duration-500"></div>

            <div class="space-y-5 relative z-10">
                <div class="flex justify-between items-start">
                    <span class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-100 to-emerald-50 dark:from-emerald-500/20 dark:to-emerald-500/5 text-emerald-600 dark:text-emerald-400 flex items-center justify-center border border-emerald-200 dark:border-emerald-500/20 group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </span>
                    <span class="px-3 py-1 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 font-extrabold text-[10px] uppercase tracking-wider border border-zinc-200 dark:border-zinc-700">
                        Nutrisi Harian
                    </span>
                </div>
                
                <div>
                    <span class="block text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400 mb-1">Total Protein Masuk</span>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-5xl font-black tracking-tight text-zinc-900 dark:text-zinc-100 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                            {{ $totalProteinToday }}<span class="text-xl text-zinc-400 dark:text-zinc-600 font-bold">/{{ $targetProtein }}</span>
                        </h3>
                        <span class="text-sm font-bold text-zinc-500">g</span>
                    </div>
                </div>

                <!-- Progress Bar Nutrisi -->
                <div class="space-y-2 pt-2">
                    @php
                        $percentage = $targetProtein > 0 ? min(100, round(($totalProteinToday / $targetProtein) * 100)) : 0;
                    @endphp
                    <div class="w-full bg-zinc-100 dark:bg-zinc-950 h-3 rounded-full overflow-hidden p-0.5 border border-zinc-200 dark:border-zinc-800 shadow-inner">
                        <div class="h-full bg-gradient-to-r from-emerald-500 to-emerald-600 dark:from-emerald-500 dark:to-teal-400 rounded-full transition-all duration-1000 ease-out relative overflow-hidden" 
                             style="width: {{ $percentage }}%">
                        </div>
                    </div>
                    <div class="flex justify-between items-center text-xs font-bold">
                        <span class="text-zinc-500">Pencapaian Target</span>
                        <span class="text-emerald-600 dark:text-emerald-400">{{ $percentage }}%</span>
                    </div>
                </div>
            </div>
        </a>

        <!-- CARD 2: Jadwal Latihan -->
        <a href="{{ url('/rutinku') }}" wire:navigate 
           class="bg-white/80 dark:bg-zinc-900/80 backdrop-blur-xl rounded-3xl p-8 border border-zinc-200/80 dark:border-zinc-800/80 shadow-lg hover:-translate-y-2 hover:shadow-2xl hover:border-teal-500/50 dark:hover:border-teal-400/50 transition-all duration-500 flex flex-col justify-between group relative overflow-hidden">
            
            <div class="absolute top-0 right-0 w-32 h-32 bg-teal-500/5 dark:bg-teal-400/5 rounded-full blur-3xl -translate-y-10 translate-x-10 group-hover:bg-teal-500/10 dark:group-hover:bg-teal-400/10 transition-colors duration-500"></div>

            <div class="space-y-5 relative z-10">
                <div class="flex justify-between items-start">
                    <span class="w-12 h-12 rounded-2xl bg-gradient-to-br from-teal-100 to-teal-50 dark:from-teal-500/20 dark:to-teal-500/5 text-teal-600 dark:text-teal-400 flex items-center justify-center border border-teal-200 dark:border-teal-500/20 group-hover:scale-110 group-hover:-rotate-6 transition-transform duration-500 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </span>
                    <span class="px-3 py-1 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 font-extrabold text-[10px] uppercase tracking-wider border border-zinc-200 dark:border-zinc-700">
                        Aktivitas
                    </span>
                </div>
                
                <div>
                    <span class="block text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400 mb-1">Sesi Terjadwal</span>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-5xl font-black tracking-tight text-zinc-900 dark:text-zinc-100 group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors">
                            {{ $totalRoutines ?? 0 }}
                        </h3>
                        <span class="text-sm font-bold text-zinc-500">Sesi</span>
                    </div>
                </div>

                <p class="text-sm text-zinc-500 dark:text-zinc-400 font-medium leading-relaxed">
                    Kelola rotasi latihan mingguan dan pantau progres repetisi Anda. Konsistensi adalah kunci hipertrofi.
                </p>
            </div>

            <div class="mt-8 pt-4 border-t border-zinc-200 dark:border-zinc-800 flex items-center justify-between text-sm font-bold text-teal-600 dark:text-teal-400 group-hover:translate-x-1 transition-transform">
                <span>Kelola Jadwal</span>
                <span>&rarr;</span>
            </div>
        </a>

        <!-- CARD 3: Katalog -->
        <a href="{{ url('/katalog') }}" wire:navigate 
           class="bg-white/80 dark:bg-zinc-900/80 backdrop-blur-xl rounded-3xl p-8 border border-zinc-200/80 dark:border-zinc-800/80 shadow-lg hover:-translate-y-2 hover:shadow-2xl hover:border-cyan-500/50 dark:hover:border-cyan-400/50 transition-all duration-500 flex flex-col justify-between group relative overflow-hidden">
            
            <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-500/5 dark:bg-cyan-400/5 rounded-full blur-3xl -translate-y-10 translate-x-10 group-hover:bg-cyan-500/10 dark:group-hover:bg-cyan-400/10 transition-colors duration-500"></div>

            <div class="space-y-5 relative z-10">
                <div class="flex justify-between items-start">
                    <span class="w-12 h-12 rounded-2xl bg-gradient-to-br from-cyan-100 to-cyan-50 dark:from-cyan-500/20 dark:to-cyan-500/5 text-cyan-600 dark:text-cyan-400 flex items-center justify-center border border-cyan-200 dark:border-cyan-500/20 group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </span>
                    <span class="px-3 py-1 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 font-extrabold text-[10px] uppercase tracking-wider border border-zinc-200 dark:border-zinc-700">
                        Database
                    </span>
                </div>
                
                <div>
                    <span class="block text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400 mb-1">Total Koleksi Gerakan</span>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-5xl font-black tracking-tight text-zinc-900 dark:text-zinc-100 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">
                            {{ $totalExercises ?: 310 }}<span class="text-3xl text-cyan-600 dark:text-cyan-400">+</span>
                        </h3>
                    </div>
                </div>

                <p class="text-sm text-zinc-500 dark:text-zinc-400 font-medium leading-relaxed">
                    Eksplorasi ratusan gerakan presisi lengkap dengan panduan anatomi otot.
                </p>
            </div>

            <div class="mt-8 pt-4 border-t border-zinc-200 dark:border-zinc-800 flex items-center justify-between text-sm font-bold text-cyan-600 dark:text-cyan-400 group-hover:translate-x-1 transition-transform">
                <span>Eksplorasi Katalog</span>
                <span>&rarr;</span>
            </div>
        </a>

    </div>

    <!-- QUICK INSPIRATION & FAQ SECTION -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <!-- Inspiration Card -->
        <div class="lg:col-span-1 bg-gradient-to-br from-zinc-100 to-white dark:from-zinc-800 dark:to-zinc-950 p-8 rounded-3xl shadow-2xl relative overflow-hidden flex flex-col justify-between border border-zinc-200 dark:border-zinc-700">
            <div class="absolute top-0 right-0 p-6 opacity-10 dark:opacity-20">
                <svg class="w-24 h-24 text-zinc-900 dark:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
            </div>
            
            <div class="space-y-4 relative z-10">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-zinc-200 dark:bg-white/10 text-zinc-800 dark:text-white text-[10px] font-bold uppercase tracking-wider backdrop-blur-md border border-zinc-300 dark:border-white/20">
                    <span>Strategi & Tips Pro</span>
                </div>
                <h3 class="text-2xl sm:text-3xl font-black tracking-tight text-zinc-900 dark:text-white leading-tight">
                    Progressif Overload Adalah Kunci.
                </h3>
            </div>
            
            <div class="relative z-10 mt-8">
                <p class="text-sm font-medium text-zinc-600 dark:text-zinc-300 leading-relaxed italic">
                    "Hipertrofi otot utamanya didorong oleh tegangan mekanik yang optimal. Penerapan progressive overload secara konsisten, dipadukan dengan asupan protein yang adekuat, adalah mekanisme utama untuk pertumbuhan otot."
                </p>
                <div class="mt-6 pt-6 border-t border-zinc-300 dark:border-white/10 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center shadow-lg text-white">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                    <div>
                        <p class="text-zinc-900 dark:text-white font-bold text-sm">Dr. Brad Schoenfeld, Ph.D.</p>
                        <p class="text-zinc-500 dark:text-zinc-400 text-xs">J. Strength & Conditioning Research</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mini FAQ -->
        <div class="lg:col-span-2 bg-white dark:bg-zinc-900 p-8 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-xl">
            <h3 class="text-2xl font-extrabold text-zinc-900 dark:text-zinc-100 mb-6 flex items-center gap-3">
                <span class="bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 p-2 rounded-xl">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                Edukasi Kebugaran Cepat
            </h3>
            
            <div class="space-y-4" x-data="{ activeAccordion: 'faq1' }">
                <!-- FAQ 1 -->
                <div class="border border-zinc-200 dark:border-zinc-700/50 rounded-2xl overflow-hidden transition-all duration-300">
                    <button @click="activeAccordion = activeAccordion === 'faq1' ? '' : 'faq1'" class="w-full flex justify-between items-center p-5 text-left font-bold text-zinc-800 dark:text-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors focus:outline-none">
                        <span>Seberapa sering saya harus latihan dalam seminggu?</span>
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 transform transition-transform duration-300" :class="{'rotate-180': activeAccordion === 'faq1'}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="activeAccordion === 'faq1'" x-collapse class="bg-zinc-50 dark:bg-zinc-900/30">
                        <div class="p-5 text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed border-t border-zinc-100 dark:border-zinc-800">
                            Penelitian menunjukkan melatih setiap kelompok otot 2 kali seminggu memberikan respons hipertrofi lebih baik daripada 1 kali seminggu. Volume latihan (total set mingguan) adalah faktor penentu paling utama. <br><br>
                            <span class="text-xs font-semibold text-zinc-500 dark:text-zinc-500">Sumber: Sports Medicine Journal - "Influence of Resistance Training Frequency on Muscular Adaptations"</span>
                        </div>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="border border-zinc-200 dark:border-zinc-700/50 rounded-2xl overflow-hidden transition-all duration-300">
                    <button @click="activeAccordion = activeAccordion === 'faq2' ? '' : 'faq2'" class="w-full flex justify-between items-center p-5 text-left font-bold text-zinc-800 dark:text-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors focus:outline-none">
                        <span>Apakah suplemen Whey Protein itu wajib?</span>
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 transform transition-transform duration-300" :class="{'rotate-180': activeAccordion === 'faq2'}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="activeAccordion === 'faq2'" x-collapse class="bg-zinc-50 dark:bg-zinc-900/30">
                        <div class="p-5 text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed border-t border-zinc-100 dark:border-zinc-800">
                            Tidak wajib. Whey protein hanyalah bentuk turunan susu sapi bubuk yang praktis dicerna. Profil asam aminonya bagus, namun secara fungsi metabolisme, 30g protein dari dada ayam atau tempe memiliki efek pembentukan otot yang sama persis. <br><br>
                            <span class="text-xs font-semibold text-zinc-500 dark:text-zinc-500">Sumber: International Society of Sports Nutrition (ISSN)</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 text-center">
                <a href="{{ url('/faq') }}" wire:navigate class="inline-flex items-center gap-2 text-sm font-bold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors hover:underline">
                    Lihat Semua Pusat Bantuan
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>
    </div>
</div>
