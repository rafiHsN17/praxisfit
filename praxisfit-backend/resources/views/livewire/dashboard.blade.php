<div class="space-y-12">
    
    <!-- HIGHLY MOTIVATING WELCOME BANNER (MINIMALIST) -->
    <div class="bg-white dark:bg-zinc-900 p-6 sm:p-14 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-sm dark:shadow-none relative overflow-hidden group transition-colors duration-300">
        <div class="absolute right-10 bottom-0 text-[120px] sm:text-[180px] opacity-[0.03] select-none pointer-events-none translate-y-10 font-black text-zinc-900 dark:text-zinc-100">
            PRX
        </div>

        <div class="relative z-10 max-w-3xl space-y-5 sm:space-y-6">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 sm:px-4 rounded-full bg-red-100 dark:bg-lime-400/10 text-red-700 dark:text-lime-400 text-[10px] sm:text-xs font-bold uppercase tracking-wider border border-red-200 dark:border-lime-400/20">
                <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-red-600 dark:bg-lime-400 animate-pulse"></span>
                <span>PraxisFit Command Center</span>
            </div>
            
            <h1 class="text-3xl sm:text-6xl font-black tracking-tight text-zinc-900 dark:text-zinc-100 leading-tight transition-colors">
                Selamat Datang, <br class="sm:hidden"><span class="text-red-600 dark:text-lime-400">Waktunya Bergerak.</span>
            </h1>

            <p class="text-sm sm:text-lg text-zinc-600 dark:text-zinc-400 font-medium leading-relaxed transition-colors">
                Tidak ada kejayaan tanpa konsistensi. Rancang rutinitas latihan harian Anda dari database 300+ gerakan presisi dan penuhi asupan nutrisi protein Anda sekarang.
            </p>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 pt-4">
                <a href="{{ url('/rutinku') }}" wire:navigate 
                   class="px-5 py-3.5 sm:px-8 sm:py-4 rounded-xl sm:rounded-2xl bg-red-600 text-white hover:bg-red-700 dark:bg-lime-400 dark:text-zinc-950 dark:hover:bg-lime-500 font-bold text-[11px] sm:text-sm uppercase tracking-wider transition-all duration-300 transform hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2">
                    <span>Buka Jadwal Latihan</span>
                </a>
                <a href="{{ url('/katalog') }}" wire:navigate 
                   class="px-5 py-3.5 sm:px-8 sm:py-4 rounded-xl sm:rounded-2xl bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 text-zinc-900 dark:text-zinc-100 font-bold text-[11px] sm:text-sm uppercase tracking-wider border border-zinc-200 dark:border-zinc-700 transition-all duration-300 flex items-center justify-center gap-2">
                    <span>Eksplorasi Katalog</span>
                </a>
            </div>
        </div>
    </div>

    <!-- WIRE:LOADING STATE OVERLAY FOR STATISTICS -->
    <div wire:loading class="w-full text-center py-4">
        <div class="inline-flex items-center gap-3 px-6 py-3 rounded-2xl bg-white dark:bg-zinc-900 border border-red-500/50 dark:border-lime-400/50 text-zinc-900 dark:text-zinc-100 text-sm font-black shadow-2xl animate-pulse">
            <span class="w-3 h-3 rounded-full bg-red-600 dark:bg-lime-400 animate-ping"></span>
            <span>Mengambil pemutakhiran data real-time...</span>
        </div>
    </div>

    <!-- 3 SUMMARY STATISTIC CARDS WITH ELEVATED HOVER -->
    <div wire:loading.remove class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- CARD 1: Total Gerakan di Katalog -->
        <a href="{{ url('/katalog') }}" wire:navigate 
           class="bg-white dark:bg-zinc-900 rounded-3xl p-8 border border-zinc-200 dark:border-zinc-800 shadow-sm dark:shadow-none hover:-translate-y-1 hover:shadow-xl hover:border-red-600 dark:hover:border-lime-400/40 transition-all duration-300 flex flex-col justify-between group relative overflow-hidden">
            
            <div class="space-y-4">
                <div class="flex justify-between items-start">
                    <span class="w-10 h-10 rounded-xl bg-red-50 dark:bg-lime-400/10 text-red-600 dark:text-lime-400 flex items-center justify-center text-sm font-bold border border-red-200 dark:border-lime-400/20 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    </span>
                    <span class="px-3 py-1 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 font-extrabold text-[10px] uppercase tracking-wider border border-zinc-200 dark:border-zinc-700 transition-colors">
                        Database Aktif
                    </span>
                </div>
                
                <div>
                    <span class="block text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Total Gerakan</span>
                    <div class="flex items-baseline gap-2 mt-1">
                        <h3 class="text-4xl sm:text-5xl font-black tracking-tight text-zinc-900 dark:text-zinc-100 group-hover:text-red-600 dark:group-hover:text-lime-400 transition-colors">
                            {{ $totalExercises ?: 310 }}<span class="text-2xl text-red-600 dark:text-lime-400">+</span>
                        </h3>
                        <span class="text-xs font-bold text-zinc-500 dark:text-zinc-400">Gerakan</span>
                    </div>
                </div>

                <p class="text-xs text-zinc-500 dark:text-zinc-400 font-medium leading-relaxed transition-colors">
                    Perpustakaan gerakan lengkap dengan demonstrasi visual, klasifikasi level kesulitan, dan target otot presisi.
                </p>
            </div>

            <div class="mt-8 pt-4 border-t border-zinc-200 dark:border-zinc-800 flex items-center justify-between text-xs font-bold text-red-600 dark:text-lime-400 group-hover:translate-x-1 transition-transform">
                <span>Eksplorasi Sekarang</span>
                <span>&rarr;</span>
            </div>
        </a>

        <!-- CARD 2: Jadwal Latihanmu -->
        <a href="{{ url('/rutinku') }}" wire:navigate 
           class="bg-white dark:bg-zinc-900 rounded-3xl p-8 border border-zinc-200 dark:border-zinc-800 shadow-sm dark:shadow-none hover:-translate-y-1 hover:shadow-xl hover:border-red-600 dark:hover:border-lime-400/40 transition-all duration-300 flex flex-col justify-between group relative overflow-hidden">
            
            <div class="space-y-4">
                <div class="flex justify-between items-start">
                    <span class="w-10 h-10 rounded-xl bg-red-50 dark:bg-lime-400/10 text-red-600 dark:text-lime-400 flex items-center justify-center text-sm font-bold border border-red-200 dark:border-lime-400/20 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </span>
                    <span class="px-3 py-1 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 font-extrabold text-[10px] uppercase tracking-wider border border-zinc-200 dark:border-zinc-700 transition-colors">
                        Senin - Minggu
                    </span>
                </div>
                
                <div>
                    <span class="block text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Jadwal Latihanmu</span>
                    <div class="flex items-baseline gap-2 mt-1">
                        <h3 class="text-4xl sm:text-5xl font-black tracking-tight text-zinc-900 dark:text-zinc-100 group-hover:text-red-600 dark:group-hover:text-lime-400 transition-colors">
                            {{ $totalRoutines }}
                        </h3>
                        <span class="text-xs font-bold text-zinc-500 dark:text-zinc-400">Sesi Terjadwal</span>
                    </div>
                </div>

                <p class="text-xs text-zinc-500 dark:text-zinc-400 font-medium leading-relaxed transition-colors">
                    Kelola rotasi latihan mingguan dengan fitur kustomisasi set dan repetisi agar progres kebugaran makin terstruktur.
                </p>
            </div>

            <div class="mt-8 pt-4 border-t border-zinc-200 dark:border-zinc-800 flex items-center justify-between text-xs font-bold text-red-600 dark:text-lime-400 group-hover:translate-x-1 transition-transform">
                <span>Kelola Jadwal</span>
                <span>&rarr;</span>
            </div>
        </a>

        <!-- CARD 3: Catatan Protein -->
        <a href="{{ url('/kalkulator') }}" wire:navigate 
           class="bg-white dark:bg-zinc-900 rounded-3xl p-8 border border-zinc-200 dark:border-zinc-800 shadow-sm dark:shadow-none hover:-translate-y-1 hover:shadow-xl hover:border-red-600 dark:hover:border-lime-400/40 transition-all duration-300 flex flex-col justify-between group relative overflow-hidden">
            
            <div class="space-y-4">
                <div class="flex justify-between items-start">
                    <span class="w-10 h-10 rounded-xl bg-red-50 dark:bg-lime-400/10 text-red-600 dark:text-lime-400 flex items-center justify-center text-sm font-bold border border-red-200 dark:border-lime-400/20 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                    </span>
                    <span class="px-3 py-1 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 font-extrabold text-[10px] uppercase tracking-wider border border-zinc-200 dark:border-zinc-700 transition-colors">
                        Nutrisi Harian
                    </span>
                </div>
                
                <div>
                    <span class="block text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Catatan Protein Hari Ini</span>
                    <div class="flex items-baseline gap-2 mt-1">
                        <h3 class="text-4xl sm:text-5xl font-black tracking-tight text-zinc-900 dark:text-zinc-100 group-hover:text-red-600 dark:group-hover:text-lime-400 transition-colors">
                            {{ $totalProteinToday }}<span class="text-xl font-bold text-zinc-400 dark:text-zinc-600">/{{ $targetProtein }}</span>
                        </h3>
                        <span class="text-xs font-bold text-zinc-500 dark:text-zinc-400">gram</span>
                    </div>
                </div>

                <!-- Progress Bar Nutrisi -->
                <div class="space-y-1 pt-1">
                    @php
                        $percentage = $targetProtein > 0 ? min(100, round(($totalProteinToday / $targetProtein) * 100)) : 0;
                    @endphp
                    <div class="w-full bg-zinc-100 dark:bg-zinc-800 h-2.5 rounded-full overflow-hidden p-0.5 border border-zinc-200 dark:border-zinc-700">
                        <div class="h-full bg-red-600 dark:bg-lime-400 rounded-full transition-all duration-500" 
                             style="width: {{ $percentage }}%"></div>
                    </div>
                    <div class="flex justify-between items-center text-[11px] font-bold text-zinc-500 dark:text-zinc-500">
                        <span>Ketercapaian</span>
                        <span class="text-zinc-700 dark:text-zinc-300">{{ $percentage }}%</span>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-4 border-t border-zinc-200 dark:border-zinc-800 flex items-center justify-between text-xs font-bold text-red-600 dark:text-lime-400 group-hover:translate-x-1 transition-transform">
                <span>Catat Asupan</span>
                <span>&rarr;</span>
            </div>
        </a>

    </div>

    <!-- QUICK INSPIRATION & TIPS CARD -->
    <div class="bg-white dark:bg-zinc-900 p-8 sm:p-10 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-sm dark:shadow-none flex flex-col md:flex-row md:items-center justify-between gap-6 transition-colors duration-300">
        <div class="space-y-2 max-w-2xl">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 dark:bg-lime-400/10 text-red-600 dark:text-lime-400 text-[10px] font-bold uppercase tracking-wider border border-red-200 dark:border-lime-400/20">
                <span>Strategi & Tips Pro</span>
            </div>
            <h3 class="text-2xl font-black tracking-tight text-zinc-900 dark:text-zinc-100 transition-colors">
                Progressif Overload Adalah Kunci
            </h3>
            <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400 leading-relaxed transition-colors">
                Usahakan untuk selalu menambah jumlah repetisi atau mengontrol tempo yang lebih lambat setiap minggu. Gabungkan dengan istirahat 7-8 jam agar proses pemulihan otot berjalan sempurna.
            </p>
        </div>
        
        <div class="shrink-0">
            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 shadow-inner flex items-center justify-center transform transition-transform">
                <svg class="w-8 h-8 text-red-600 dark:text-lime-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
        </div>
    </div>

</div>
