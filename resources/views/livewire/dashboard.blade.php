<div class="space-y-10">

    <!-- 1. WELCOME HERO BANNER (TETAP PADA POSISI UTAMA DENGAN INTEGRASI WORKOUT TRACKING REAL) -->
    <div class="bg-white dark:bg-[#1A1012] p-6 sm:p-10 lg:p-12 rounded-3xl border border-[#E9E9EC] dark:border-[#342427] shadow-sm relative overflow-hidden group transition-colors duration-200">
        <!-- Garis Aksen Merah Atas -->
        <div class="absolute top-0 left-0 w-full h-1 bg-[#E54855]"></div>

        <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <!-- Left Hero Content (Original Hierarchy Preserved) -->
            <div class="lg:col-span-7 space-y-5">
                <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-[#202124] dark:text-[#F5F5F5] leading-tight">
                    Siap Menghancurkan <br class="hidden sm:block">
                    <span class="text-[#E54855]">Batasmu Hari Ini?</span>
                </h1>

                <p class="text-sm sm:text-base text-[#777777] dark:text-[#AAA0A2] font-medium leading-relaxed max-w-2xl">
                    Tidak ada kejayaan tanpa konsistensi. Pantau asupan nutrisi harian Anda dan eksekusi jadwal latihan dengan presisi kalender aktual.
                </p>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-2">
                    <a href="{{ url('/rutinku') }}" wire:navigate
                       class="px-6 py-3.5 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white font-bold text-xs sm:text-sm uppercase tracking-wider shadow-md shadow-[#E54855]/25 transition-all active:scale-95 flex items-center justify-center gap-2">
                        <span>Mulai Latihan Sekarang</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </a>
                    <a href="{{ url('/kalkulator') }}" wire:navigate
                       class="px-6 py-3.5 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] hover:bg-[#E9E9EC] dark:hover:bg-[#342427] text-[#202124] dark:text-[#F5F5F5] font-bold text-xs sm:text-sm uppercase tracking-wider border border-[#E9E9EC] dark:border-[#342427] transition-colors flex items-center justify-center gap-2 group">
                        <span>Catat Nutrisi</span>
                        <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                    </a>
                </div>
            </div>

            <!-- Right Slot Inside Hero: Tracking Latihan Hari Ini & Notifikasi Jadwal (Ruang Tersedia Hero) -->
            <div class="lg:col-span-5 bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] rounded-2xl p-5 space-y-4">
                <div class="flex items-center justify-between gap-2 border-b border-[#E9E9EC] dark:border-[#342427] pb-3">
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-[#777777] dark:text-[#AAA0A2]">Pelacakan Latihan Hari Ini</span>
                        <h2 class="text-base font-bold text-[#202124] dark:text-[#F5F5F5]">
                            @if($isGuest)
                                Mode Pratinjau Tamu
                            @elseif($todaySessionsCount > 0)
                                {{ $todaySessions[0]['name'] }}
                            @else
                                Belum Ada Jadwal Hari Ini
                            @endif
                        </h2>
                    </div>
                    @if(!$isGuest && $todaySessionsCount > 0)
                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wide {{ $todaySessions[0]['status'] === 'completed' ? 'bg-[#E54855] text-white' : ($todaySessions[0]['status'] === 'in_progress' ? 'bg-[#E54855]/15 text-[#E54855] border border-[#E54855]/30' : 'bg-white dark:bg-[#1A1012] text-[#202124] dark:text-[#F5F5F5] border border-[#E9E9EC] dark:border-[#342427]') }}">
                            {{ $todaySessions[0]['status_label'] }}
                        </span>
                    @else
                        <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-white dark:bg-[#1A1012] text-[#777777] dark:text-[#AAA0A2] border border-[#E9E9EC] dark:border-[#342427]">
                            Asia/Jakarta
                        </span>
                    @endif
                </div>

                @if($isGuest)
                    <div class="py-3 space-y-3">
                        <p class="text-xs text-[#777777] dark:text-[#AAA0A2] leading-relaxed">
                            Masuk ke akun PraxisFit untuk menyinkronkan jadwal kalender aktual, progres latihan harian, dan riwayat sesi Anda secara permanen.
                        </p>
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center gap-1.5 text-xs font-bold text-[#E54855] hover:text-[#C93646] hover:underline">
                            <span>Masuk ke Akun Sekarang</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                @else
                    <!-- Progres Harian -->
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between text-xs font-semibold">
                            <span class="text-[#777777] dark:text-[#AAA0A2]">Progres Latihan Harian</span>
                            <span class="text-[#E54855] font-bold">{{ $dailyWorkoutProgress }}%</span>
                        </div>
                        <div class="w-full h-2.5 rounded-full bg-white dark:bg-[#100809] border border-[#E9E9EC] dark:border-[#342427] overflow-hidden">
                            <div class="h-full bg-[#E54855] rounded-full transition-all duration-500" style="width: {{ $dailyWorkoutProgress }}%"></div>
                        </div>
                    </div>

                    <!-- Counter Selesai vs Belum Selesai -->
                    <div class="grid grid-cols-3 gap-2 text-center">
                        <div class="bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] rounded-xl p-2.5">
                            <span class="block text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">{{ $todaySessionsCount }}</span>
                            <span class="block text-[10px] font-semibold uppercase tracking-wide text-[#777777] dark:text-[#AAA0A2]">Hari Ini</span>
                        </div>
                        <div class="bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] rounded-xl p-2.5">
                            <span class="block text-lg font-extrabold text-[#E54855]">{{ $completedSessionsCount }}</span>
                            <span class="block text-[10px] font-semibold uppercase tracking-wide text-[#777777] dark:text-[#AAA0A2]">Selesai</span>
                        </div>
                        <div class="bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] rounded-xl p-2.5">
                            <span class="block text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">{{ $unfinishedSessionsCount }}</span>
                            <span class="block text-[10px] font-semibold uppercase tracking-wide text-[#777777] dark:text-[#AAA0A2]">Belum Selesai</span>
                        </div>
                    </div>

                    <!-- Notifikasi Jadwal & Riwayat Terakhir -->
                    @if(count($scheduleNotifications) > 0)
                        <div class="space-y-1.5">
                            @foreach($scheduleNotifications as $notif)
                                <div class="px-3 py-2 rounded-xl bg-white dark:bg-[#1A1012] border {{ $notif['level'] === 'warning' ? 'border-[#E54855]/50' : 'border-[#E9E9EC] dark:border-[#342427]' }} flex items-start gap-2">
                                    <span class="w-2 h-2 rounded-full mt-1.5 shrink-0 {{ $notif['level'] === 'warning' ? 'bg-[#C93646]' : 'bg-[#E54855]' }}"></span>
                                    <div class="min-w-0">
                                        <p class="text-[11px] font-bold text-[#202124] dark:text-[#F5F5F5]">{{ $notif['title'] }}</p>
                                        <p class="text-[11px] text-[#777777] dark:text-[#AAA0A2] leading-snug">{{ $notif['detail'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @elseif($nextScheduledSession)
                        <div class="px-3 py-2.5 rounded-xl bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] text-xs">
                            <span class="font-bold text-[#E54855]">Jadwal Berikutnya:</span>
                            <span class="text-[#202124] dark:text-[#F5F5F5] font-semibold">{{ $nextScheduledSession['name'] }}</span>
                            <span class="block text-[11px] text-[#777777] dark:text-[#AAA0A2] mt-0.5">{{ $nextScheduledSession['date_label'] }}</span>
                        </div>
                    @else
                        <div class="px-3 py-2.5 rounded-xl bg-white dark:bg-[#1A1012] border border-dashed border-[#E9E9EC] dark:border-[#342427] text-xs text-[#777777] dark:text-[#AAA0A2]">
                            Belum ada sesi latihan terkalender. <a href="{{ url('/rutinku') }}" wire:navigate class="font-bold text-[#E54855] hover:underline">Buat jadwal di Workout Planner &rarr;</a>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <!-- 2. THREE SUMMARY STATISTIC CARDS (STRUKTUR 3 KOLOM DIPERTAHANKAN) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- CARD 1: Nutrisi Harian -->
        <a href="{{ url('/kalkulator') }}" wire:navigate
           class="bg-white dark:bg-[#1A1012] rounded-3xl p-7 border border-[#E9E9EC] dark:border-[#342427] shadow-sm hover:-translate-y-1 hover:shadow-lg hover:border-[#E54855]/60 transition-all duration-300 flex flex-col justify-between group">

            <div class="space-y-5">
                <div class="flex justify-between items-start">
                    <span class="w-11 h-11 rounded-2xl bg-[#E54855]/10 text-[#E54855] flex items-center justify-center border border-[#E54855]/25 group-hover:bg-[#E54855] group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </span>
                    <span class="px-3 py-1 rounded-full bg-[#F7F7F8] dark:bg-[#251518] text-[#777777] dark:text-[#AAA0A2] font-bold text-[10px] uppercase tracking-wider border border-[#E9E9EC] dark:border-[#342427]">
                        Nutrisi Harian
                    </span>
                </div>

                <div>
                    <span class="block text-xs font-bold uppercase tracking-wider text-[#777777] dark:text-[#AAA0A2] mb-1">Total Protein Masuk</span>
                    <div class="flex items-baseline gap-1.5">
                        <h3 class="text-4xl font-extrabold tracking-tight text-[#202124] dark:text-[#F5F5F5] group-hover:text-[#E54855] transition-colors">
                            {{ number_format($totalProteinToday, 1) }}<span class="text-lg text-[#777777] dark:text-[#AAA0A2] font-bold">/{{ number_format($targetProtein, 0) }}</span>
                        </h3>
                        <span class="text-sm font-bold text-[#777777] dark:text-[#AAA0A2]">g</span>
                    </div>
                    <p class="text-xs text-[#777777] dark:text-[#AAA0A2] mt-1">
                        @if($isGuest)
                            Masuk untuk mencatat konsumsi nutrisi harian Anda.
                        @else
                            Kalori hari ini: <strong class="text-[#202124] dark:text-[#F5F5F5]">{{ number_format($totalCaloriesToday, 0) }}</strong> / {{ number_format($targetCalories, 0) }} kkal
                        @endif
                    </p>
                </div>

                <!-- Progress Bar Nutrisi -->
                <div class="space-y-1.5 pt-1">
                    @php
                        $percentage = $targetProtein > 0 ? min(100, round(($totalProteinToday / $targetProtein) * 100)) : 0;
                    @endphp
                    <div class="w-full bg-[#F7F7F8] dark:bg-[#100809] h-2.5 rounded-full overflow-hidden border border-[#E9E9EC] dark:border-[#342427]">
                        <div class="h-full bg-[#E54855] rounded-full transition-all duration-700" style="width: {{ $percentage }}%"></div>
                    </div>
                    <div class="flex justify-between items-center text-xs font-bold">
                        <span class="text-[#777777] dark:text-[#AAA0A2]">Pencapaian Target</span>
                        <span class="text-[#E54855]">{{ $percentage }}%</span>
                    </div>
                </div>
            </div>
        </a>

        <!-- CARD 2: Jadwal & Tracking Latihan -->
        <a href="{{ url('/rutinku') }}" wire:navigate
           class="bg-white dark:bg-[#1A1012] rounded-3xl p-7 border border-[#E9E9EC] dark:border-[#342427] shadow-sm hover:-translate-y-1 hover:shadow-lg hover:border-[#E54855]/60 transition-all duration-300 flex flex-col justify-between group">

            <div class="space-y-4">
                <div class="flex justify-between items-start">
                    <span class="w-11 h-11 rounded-2xl bg-[#E54855]/10 text-[#E54855] flex items-center justify-center border border-[#E54855]/25 group-hover:bg-[#E54855] group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </span>
                    <span class="px-3 py-1 rounded-full bg-[#F7F7F8] dark:bg-[#251518] text-[#777777] dark:text-[#AAA0A2] font-bold text-[10px] uppercase tracking-wider border border-[#E9E9EC] dark:border-[#342427]">
                        Aktivitas & Tracking
                    </span>
                </div>

                <div>
                    <span class="block text-xs font-bold uppercase tracking-wider text-[#777777] dark:text-[#AAA0A2] mb-1">Sesi Selesai & Terjadwal</span>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-4xl font-extrabold tracking-tight text-[#202124] dark:text-[#F5F5F5] group-hover:text-[#E54855] transition-colors">
                            {{ $completedSessionsCount }}
                        </h3>
                        <span class="text-sm font-bold text-[#777777] dark:text-[#AAA0A2]">Selesai</span>
                        <span class="text-xs font-semibold text-[#777777] dark:text-[#AAA0A2]">&bull; {{ $unfinishedSessionsCount }} Aktif</span>
                    </div>
                </div>

                @if(!$isGuest && $latestHistorySession)
                    <div class="p-3 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-xs space-y-0.5">
                        <div class="flex items-center justify-between gap-2">
                            <span class="font-bold text-[#777777] dark:text-[#AAA0A2] uppercase text-[10px]">Riwayat Terakhir</span>
                            @if($latestHistorySession['is_off_schedule'])
                                <span class="px-1.5 py-0.5 rounded bg-[#E54855]/15 text-[#E54855] text-[10px] font-bold">Di Luar Jadwal</span>
                            @endif
                        </div>
                        <p class="font-bold text-[#202124] dark:text-[#F5F5F5] truncate">{{ $latestHistorySession['name'] }}</p>
                        <p class="text-[11px] text-[#777777] dark:text-[#AAA0A2]">
                            {{ $latestHistorySession['actual_label'] }}
                            @if($latestHistorySession['duration'])
                                &bull; {{ $latestHistorySession['duration'] }}
                            @endif
                        </p>
                    </div>
                @elseif(!$isGuest)
                    <p class="text-xs text-[#777777] dark:text-[#AAA0A2] leading-relaxed">
                        Anda memiliki <strong>{{ $totalRoutines }}</strong> rutinitas mingguan ({{ $missedSessionsCount }} sesi terlewat). Mulai sesi di Workout Planner.
                    </p>
                @else
                    <p class="text-xs text-[#777777] dark:text-[#AAA0A2] leading-relaxed">
                        Belum ada sesi latihan tercatat. Masuk untuk menyusun kalender latihan dan riwayat sesi permanen.
                    </p>
                @endif
            </div>

            <div class="mt-6 pt-4 border-t border-[#E9E9EC] dark:border-[#342427] flex items-center justify-between text-sm font-bold text-[#E54855] group-hover:translate-x-1 transition-transform">
                <span>Kelola Jadwal & Riwayat</span>
                <span>&rarr;</span>
            </div>
        </a>

        <!-- CARD 3: Katalog Gerakan -->
        <a href="{{ url('/katalog') }}" wire:navigate
           class="bg-white dark:bg-[#1A1012] rounded-3xl p-7 border border-[#E9E9EC] dark:border-[#342427] shadow-sm hover:-translate-y-1 hover:shadow-lg hover:border-[#E54855]/60 transition-all duration-300 flex flex-col justify-between group">

            <div class="space-y-4">
                <div class="flex justify-between items-start">
                    <span class="w-11 h-11 rounded-2xl bg-[#E54855]/10 text-[#E54855] flex items-center justify-center border border-[#E54855]/25 group-hover:bg-[#E54855] group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </span>
                    <span class="px-3 py-1 rounded-full bg-[#F7F7F8] dark:bg-[#251518] text-[#777777] dark:text-[#AAA0A2] font-bold text-[10px] uppercase tracking-wider border border-[#E9E9EC] dark:border-[#342427]">
                        Database Gerakan
                    </span>
                </div>

                <div>
                    <span class="block text-xs font-bold uppercase tracking-wider text-[#777777] dark:text-[#AAA0A2] mb-1">Total Koleksi Gerakan</span>
                    <div class="flex items-baseline gap-1">
                        <h3 class="text-4xl font-extrabold tracking-tight text-[#202124] dark:text-[#F5F5F5] group-hover:text-[#E54855] transition-colors">
                            {{ $totalExercises }}
                        </h3>
                        <span class="text-2xl font-extrabold text-[#E54855]">+</span>
                    </div>
                </div>

                <p class="text-xs text-[#777777] dark:text-[#AAA0A2] leading-relaxed">
                    Eksplorasi ratusan gerakan lengkap dengan filter alat, level kesulitan, dan anatomi target otot.
                </p>
            </div>

            <div class="mt-6 pt-4 border-t border-[#E9E9EC] dark:border-[#342427] flex items-center justify-between text-sm font-bold text-[#E54855] group-hover:translate-x-1 transition-transform">
                <span>Eksplorasi Katalog</span>
                <span>&rarr;</span>
            </div>
        </a>
    </div>

    <!-- 3. QUICK INSPIRATION & MINI FAQ SECTION (POSISI ASLI DIPERTAHANKAN) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 pb-4">
        <!-- Inspiration Card -->
        <div class="lg:col-span-1 bg-white dark:bg-[#1A1012] p-7 rounded-3xl shadow-sm relative overflow-hidden flex flex-col justify-between border border-[#E9E9EC] dark:border-[#342427]">
            <div class="space-y-4 relative z-10">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#E54855]/10 text-[#E54855] text-[10px] font-bold uppercase tracking-wider border border-[#E54855]/25">
                    <span>Strategi & Tips Pro</span>
                </div>
                <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-[#202124] dark:text-[#F5F5F5] leading-tight">
                    Progressif Overload Adalah Kunci.
                </h3>
            </div>

            <div class="relative z-10 mt-6">
                <p class="text-sm font-medium text-[#777777] dark:text-[#AAA0A2] leading-relaxed italic">
                    "Otot yang sehat dan kuat dibangun lewat konsistensi latihan beban secara bertahap (progressive overload), pola makan tinggi protein alami, serta istirahat yang cukup. Jadikan olahraga sebagai investasi jangka panjang tubuh kita."
                </p>
                <div class="mt-6 pt-5 border-t border-[#E9E9EC] dark:border-[#342427] flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-full bg-[#E54855] flex items-center justify-center shadow-sm text-white shrink-0 font-bold text-sm">
                        AR
                    </div>
                    <div>
                        <p class="text-[#202124] dark:text-[#F5F5F5] font-bold text-sm">Ade Rai</p>
                        <p class="text-[#777777] dark:text-[#AAA0A2] text-xs">Binaragawan Natural & Edukator Kebugaran Indonesia</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mini FAQ -->
        <div class="lg:col-span-2 bg-white dark:bg-[#1A1012] p-7 rounded-3xl border border-[#E9E9EC] dark:border-[#342427] shadow-sm">
            <h3 class="text-xl sm:text-2xl font-extrabold text-[#202124] dark:text-[#F5F5F5] mb-5 flex items-center gap-3">
                <span class="bg-[#E54855]/10 text-[#E54855] p-2 rounded-xl border border-[#E54855]/25">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
                Edukasi Kebugaran Cepat
            </h3>

            <div class="space-y-3.5" x-data="{ activeAccordion: 'faq1' }">
                <!-- FAQ 1 -->
                <div class="border border-[#E9E9EC] dark:border-[#342427] rounded-2xl overflow-hidden transition-all">
                    <button type="button" @click="activeAccordion = activeAccordion === 'faq1' ? '' : 'faq1'"
                            class="w-full flex justify-between items-center p-4 sm:p-5 text-left font-bold text-sm sm:text-base text-[#202124] dark:text-[#F5F5F5] hover:bg-[#F7F7F8] dark:hover:bg-[#251518] transition-colors focus:outline-none">
                        <span>Seberapa sering sebaiknya saya latihan dalam seminggu?</span>
                        <svg class="w-5 h-5 text-[#E54855] transform transition-transform duration-300 shrink-0 ml-3" :class="{'rotate-180': activeAccordion === 'faq1'}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 'faq1'" x-collapse class="bg-[#F7F7F8] dark:bg-[#251518]">
                        <div class="p-4 sm:p-5 text-sm text-[#777777] dark:text-[#AAA0A2] leading-relaxed border-t border-[#E9E9EC] dark:border-[#342427]">
                            Melatih setiap kelompok otot 2 kali seminggu dengan pembagian jadwal yang terarah terbukti memberikan hasil pembentukan otot yang jauh lebih optimal dibandingkan hanya 1 kali seminggu, selama diselingi hari istirahat (Rest Day) yang cukup.
                            <span class="block mt-2.5 text-xs font-semibold text-[#202124] dark:text-[#F5F5F5]">Sumber: dr. Andi Kurniawan, Sp.KO (Dokter Spesialis Kedokteran Olahraga) via Hello Sehat</span>
                        </div>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="border border-[#E9E9EC] dark:border-[#342427] rounded-2xl overflow-hidden transition-all">
                    <button type="button" @click="activeAccordion = activeAccordion === 'faq2' ? '' : 'faq2'"
                            class="w-full flex justify-between items-center p-4 sm:p-5 text-left font-bold text-sm sm:text-base text-[#202124] dark:text-[#F5F5F5] hover:bg-[#F7F7F8] dark:hover:bg-[#251518] transition-colors focus:outline-none">
                        <span>Apakah suplemen Whey Protein itu wajib untuk membentuk otot?</span>
                        <svg class="w-5 h-5 text-[#E54855] transform transition-transform duration-300 shrink-0 ml-3" :class="{'rotate-180': activeAccordion === 'faq2'}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 'faq2'" x-collapse class="bg-[#F7F7F8] dark:bg-[#251518]">
                        <div class="p-4 sm:p-5 text-sm text-[#777777] dark:text-[#AAA0A2] leading-relaxed border-t border-[#E9E9EC] dark:border-[#342427]">
                            Sama sekali tidak wajib. Whey protein hanyalah pelengkap praktis saat Anda sibuk. Sumber protein pangan lokal seperti dada ayam, telur rebus, tahu, dan tempe murni memberikan manfaat pembentukan otot yang setara dengan harga jauh lebih terjangkau.
                            <span class="block mt-2.5 text-xs font-semibold text-[#202124] dark:text-[#F5F5F5]">Sumber: Ade Rai & dr. Dion Haryadi, PN1 via Alodokter</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ url('/faq') }}" wire:navigate class="inline-flex items-center gap-2 text-sm font-bold text-[#E54855] hover:text-[#C93646] transition-colors hover:underline">
                    <span>Lihat Semua Pusat Bantuan</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
