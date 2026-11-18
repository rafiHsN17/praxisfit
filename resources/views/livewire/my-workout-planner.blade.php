<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-6 pb-20">

    <!-- HEADER BAR -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] p-5 sm:p-6 shadow-xs">
        <div class="space-y-1.5">
            <div class="flex flex-wrap items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider bg-[#E54855]/10 text-[#E54855]">
                    Workout Plan &bull; Asia/Jakarta
                </span>
                <span class="text-xs font-medium text-[#777777] dark:text-[#AAA0A2]">
                    Hari ini: <strong class="text-[#202124] dark:text-[#F5F5F5]">{{ $todayLabel }}</strong>
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-[#202124] dark:text-[#F5F5F5]">
                Jadwal & Riwayat <span class="text-[#E54855]">Latihan</span>
            </h1>
            <p class="text-sm text-[#777777] dark:text-[#AAA0A2]">
                Atur sesi latihan pada kalender aktual, jalankan latihan dengan pengingat jadwal, dan simpan riwayat otomatis.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5 shrink-0">
            @if($isAuthenticated)
                <div class="hidden sm:flex items-center gap-3 px-3.5 py-2 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-xs font-semibold">
                    <span class="text-[#777777] dark:text-[#AAA0A2]">Total: <strong class="text-[#202124] dark:text-[#F5F5F5]">{{ $stats['total'] }}</strong></span>
                    <span class="text-[#E9E9EC] dark:text-[#342427]">|</span>
                    <span class="text-[#777777] dark:text-[#AAA0A2]">Selesai: <strong class="text-[#E54855]">{{ $stats['completed'] }}</strong></span>
                </div>

                @if($routines->count() > 0)
                    <button type="button" wire:click="generateFromWeeklyRoutines"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#F1F1F4] dark:bg-[#251518] hover:bg-[#E9E9EC] dark:hover:bg-[#342427] text-[#202124] dark:text-[#F5F5F5] border border-[#E9E9EC] dark:border-[#342427] text-xs sm:text-sm font-semibold transition-colors cursor-pointer">
                        <svg class="w-4 h-4 text-[#E54855]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span>Terapkan Rutinitas Minggu Ini</span>
                    </button>
                @endif

                <button type="button" wire:click="openCreateSessionModal"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white text-xs sm:text-sm font-bold shadow-sm shadow-[#E54855]/20 transition-colors cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Tambah Jadwal</span>
                </button>
            @else
                <a href="{{ route('login') }}" wire:navigate
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white text-sm font-bold shadow-sm transition-colors">
                    Masuk untuk Mengelola Jadwal &rarr;
                </a>
            @endif
        </div>
    </div>

    <!-- FLASH MESSAGES -->
    @if (session()->has('success'))
        <div class="p-4 rounded-xl bg-[#E54855]/10 border border-[#E54855]/30 text-[#C93646] dark:text-[#E54855] text-sm font-semibold flex items-center justify-between gap-3">
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="p-4 rounded-xl bg-[#C93646]/15 border border-[#C93646]/40 text-[#C93646] dark:text-[#E54855] text-sm font-semibold">
            {{ session('error') }}
        </div>
    @endif

    @if(!$isAuthenticated)
        <!-- ISOLATED GUEST STATE -->
        <div class="bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] p-8 sm:p-10 text-center space-y-4">
            <div class="w-14 h-14 mx-auto rounded-2xl bg-[#E54855]/10 text-[#E54855] flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-[#202124] dark:text-[#F5F5F5]">Masuk untuk Akses Workout Planner Pribadi</h2>
            <p class="text-sm text-[#777777] dark:text-[#AAA0A2] max-w-md mx-auto">
                Jadwal latihan, pelacakan sesi aktif, pengingat tanggal, dan riwayat latihan tersimpan terpisah dan pribadi untuk setiap akun PraxisFit.
            </p>
            <div class="flex justify-center gap-3 pt-2">
                <a href="{{ route('login') }}" wire:navigate class="px-5 py-2.5 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white text-sm font-bold transition-colors">
                    Masuk Sekarang
                </a>
                <a href="{{ route('register') }}" wire:navigate class="px-5 py-2.5 rounded-xl bg-[#F1F1F4] dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] border border-[#E9E9EC] dark:border-[#342427] text-sm font-semibold transition-colors">
                    Daftar Akun
                </a>
            </div>
        </div>
    @else
        <!-- AUTHENTICATED 2-COLUMN WORKSPACE (GAMBAR 4) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- LEFT COLUMN (8 COLS): SUB-TABS, PLAN LIST, HISTORY, OR WEEKLY ROUTINES -->
            <div class="lg:col-span-8 space-y-5">

                <!-- Sub-Tab Switcher -->
                <div class="flex flex-wrap items-center justify-between gap-3 bg-white dark:bg-[#1A1012] p-2 rounded-2xl border border-[#E9E9EC] dark:border-[#342427]">
                    <div class="flex items-center gap-1.5">
                        <button type="button" wire:click="setActiveTab('plan')"
                                class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-colors cursor-pointer {{ $activeTab === 'plan' ? 'bg-[#E54855] text-white shadow-xs' : 'text-[#777777] dark:text-[#AAA0A2] hover:bg-[#F7F7F8] dark:hover:bg-[#251518]' }}">
                            Daftar Jadwal
                        </button>
                        <button type="button" wire:click="setActiveTab('history')"
                                class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-colors cursor-pointer {{ $activeTab === 'history' ? 'bg-[#E54855] text-white shadow-xs' : 'text-[#777777] dark:text-[#AAA0A2] hover:bg-[#F7F7F8] dark:hover:bg-[#251518]' }}">
                            Riwayat Latihan
                        </button>
                        <button type="button" wire:click="setActiveTab('routines')"
                                class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-colors cursor-pointer {{ $activeTab === 'routines' ? 'bg-[#E54855] text-white shadow-xs' : 'text-[#777777] dark:text-[#AAA0A2] hover:bg-[#F7F7F8] dark:hover:bg-[#251518]' }}">
                            Rutinitas Mingguan
                        </button>
                    </div>

                    @if($selectedDate)
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-[#E54855]/10 text-[#E54855] text-xs font-bold">
                            <span>Tanggal: {{ \App\Models\WorkoutSession::formatIndonesianDate($selectedDate) }}</span>
                            <button type="button" wire:click="clearDateFilter" class="hover:text-[#C93646] cursor-pointer">&times;</button>
                        </div>
                    @endif
                </div>

                @if($activeTab === 'plan')
                    <!-- PLAN LIST CARD (GAMBAR 4) -->
                    <div class="bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] p-5 sm:p-6 space-y-5 shadow-xs">

                        <!-- Top Bar: Title + Filter Status Tabs + Search -->
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-[#E9E9EC] dark:border-[#342427] pb-4">
                            <div>
                                <h2 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">Daftar Rencana Latihan</h2>
                                <p class="text-xs text-[#777777] dark:text-[#AAA0A2] mt-0.5">
                                    Klik <strong>Mulai Latihan</strong> pada jadwal untuk mencatat progres dan durasi.
                                </p>
                            </div>

                            <!-- Status Pills: All | Unfinished | Finished -->
                            <div class="inline-flex items-center p-1 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] self-start">
                                <button type="button" wire:click="setStatusFilter('all')"
                                        class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors cursor-pointer {{ $statusFilter === 'all' ? 'bg-white dark:bg-[#1A1012] text-[#202124] dark:text-[#F5F5F5] shadow-xs' : 'text-[#777777] dark:text-[#AAA0A2]' }}">
                                    Semua
                                </button>
                                <button type="button" wire:click="setStatusFilter('unfinished')"
                                        class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors cursor-pointer {{ $statusFilter === 'unfinished' ? 'bg-white dark:bg-[#1A1012] text-[#E54855] shadow-xs' : 'text-[#777777] dark:text-[#AAA0A2]' }}">
                                    Belum Selesai
                                </button>
                                <button type="button" wire:click="setStatusFilter('finished')"
                                        class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors cursor-pointer {{ $statusFilter === 'finished' ? 'bg-white dark:bg-[#1A1012] text-[#202124] dark:text-[#F5F5F5] shadow-xs' : 'text-[#777777] dark:text-[#AAA0A2]' }}">
                                    Selesai
                                </button>
                            </div>
                        </div>

                        <!-- Search Input -->
                        <div class="relative">
                            <svg class="w-4 h-4 text-[#777777] dark:text-[#AAA0A2] absolute left-3.5 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" wire:model.live.debounce.250ms="search" placeholder="Cari nama jadwal atau kategori latihan..."
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-sm text-[#202124] dark:text-[#F5F5F5] placeholder-[#777777] dark:placeholder-[#AAA0A2] focus:outline-none focus:border-[#E54855]">
                        </div>

                        <!-- Plan Items -->
                        <div class="space-y-3">
                            @forelse($sessions as $session)
                                @php
                                    $effectiveStatus = $session->effectiveStatus();
                                    $isInProgress = $effectiveStatus === \App\Models\WorkoutSession::STATUS_IN_PROGRESS;
                                    $isCompleted = $effectiveStatus === \App\Models\WorkoutSession::STATUS_COMPLETED;
                                    $isMissed = $effectiveStatus === \App\Models\WorkoutSession::STATUS_MISSED;
                                    $dayNum = $session->scheduled_date ? $session->scheduled_date->day : '-';
                                    $dayShort = $session->scheduled_date ? \App\Models\WorkoutSession::shortIndonesianDay($session->scheduled_date) : '';
                                @endphp

                                <div wire:key="session-card-{{ $session->id }}"
                                     class="rounded-2xl border p-4 transition-all {{ $isInProgress ? 'bg-[#E54855] border-[#C93646] text-white shadow-md shadow-[#E54855]/20' : 'bg-[#F7F7F8]/60 dark:bg-[#251518]/60 border-[#E9E9EC] dark:border-[#342427] hover:border-[#E54855]/40' }}">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">

                                        <!-- Left: Date Badge + Info -->
                                        <div class="flex items-start sm:items-center gap-3.5 min-w-0 flex-1">
                                            <div class="w-12 h-12 rounded-xl flex flex-col items-center justify-center shrink-0 border {{ $isInProgress ? 'bg-white/15 border-white/25 text-white' : 'bg-white dark:bg-[#1A1012] border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5]' }}">
                                                <span class="text-base font-extrabold leading-none">{{ $dayNum }}</span>
                                                <span class="text-[10px] font-bold uppercase mt-0.5 {{ $isInProgress ? 'text-white/85' : 'text-[#777777] dark:text-[#AAA0A2]' }}">{{ $dayShort }}</span>
                                            </div>

                                            <div class="min-w-0 flex-1 space-y-1">
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <h3 class="text-sm sm:text-base font-bold truncate {{ $isInProgress ? 'text-white' : 'text-[#202124] dark:text-[#F5F5F5]' }}">
                                                        {{ $session->name }}
                                                    </h3>
                                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold uppercase {{ $isInProgress ? 'bg-white text-[#E54855]' : ($isCompleted ? 'bg-[#E54855]/12 text-[#C93646] dark:text-[#E54855]' : ($isMissed ? 'bg-[#C93646]/15 text-[#C93646] dark:text-[#E54855]' : 'bg-white dark:bg-[#1A1012] text-[#777777] dark:text-[#AAA0A2] border border-[#E9E9EC] dark:border-[#342427]')) }}">
                                                        {{ match($effectiveStatus) { 'in_progress' => 'On Progress', 'completed' => 'Completed', 'missed' => 'Missed', default => 'Upcoming' } }}
                                                    </span>
                                                </div>

                                                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs {{ $isInProgress ? 'text-white/85' : 'text-[#777777] dark:text-[#AAA0A2]' }}">
                                                    <span>{{ $session->category ?? 'Latihan Beban' }}</span>
                                                    <span>&bull; {{ \App\Models\WorkoutSession::formatIndonesianDate($session->scheduled_date) }}</span>
                                                    @if($session->scheduled_time)
                                                        <span>&bull; {{ $session->scheduled_time }} WIB</span>
                                                    @endif
                                                    @if($session->items->count() > 0)
                                                        <span>&bull; {{ $session->items->count() }} Gerakan</span>
                                                    @endif
                                                    @if($session->formattedDuration())
                                                        <span class="font-semibold">&bull; Durasi: {{ $session->formattedDuration() }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right: CTA + 3-Dot Menu -->
                                        <div class="flex items-center justify-end gap-2 shrink-0">
                                            @if($isInProgress)
                                                <button type="button" wire:click="openActiveSession({{ $session->id }})"
                                                        class="px-4 py-2 rounded-xl bg-white text-[#E54855] hover:bg-[#F7F7F8] text-xs font-extrabold transition-colors cursor-pointer">
                                                    Buka Pelacak ({{ $session->progress_percent }}%)
                                                </button>
                                                <button type="button" wire:click="forceFinishSession({{ $session->id }})"
                                                        class="px-3.5 py-2 rounded-xl bg-[#C93646] hover:bg-[#100809] text-white border border-white/25 text-xs font-bold transition-colors cursor-pointer">
                                                    Selesai
                                                </button>
                                            @elseif(!$isCompleted)
                                                <button type="button" wire:click="attemptStartSession({{ $session->id }})"
                                                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white dark:bg-[#1A1012] hover:bg-[#E54855] hover:text-white text-[#202124] dark:text-[#F5F5F5] border border-[#E9E9EC] dark:border-[#342427] hover:border-[#E54855] text-xs font-bold transition-colors cursor-pointer">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                    </svg>
                                                    <span>Mulai Latihan</span>
                                                </button>
                                            @else
                                                <button type="button" wire:click="openHistoryDetail({{ $session->id }})"
                                                        class="px-3.5 py-2 rounded-xl bg-white dark:bg-[#1A1012] text-[#202124] dark:text-[#F5F5F5] border border-[#E9E9EC] dark:border-[#342427] hover:border-[#E54855] text-xs font-semibold transition-colors cursor-pointer">
                                                    Lihat Detail
                                                </button>
                                            @endif

                                            <!-- 3-Dot Action Dropdown (Gambar 4) -->
                                            <div class="relative" x-data="{ menuOpen: false }">
                                                <button type="button" @click="menuOpen = !menuOpen"
                                                        class="p-2 rounded-xl border transition-colors cursor-pointer {{ $isInProgress ? 'bg-white/15 border-white/25 text-white hover:bg-white/25' : 'bg-white dark:bg-[#1A1012] border-[#E9E9EC] dark:border-[#342427] text-[#777777] dark:text-[#AAA0A2] hover:text-[#E54855]' }}"
                                                        title="Menu Aksi">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M12 7a2 2 0 100-4 2 2 0 000 4zm0 7a2 2 0 100-4 2 2 0 000 4zm0 7a2 2 0 100-4 2 2 0 000 4z"/>
                                                    </svg>
                                                </button>

                                                <div x-show="menuOpen" @click.away="menuOpen = false" x-cloak
                                                     class="absolute right-0 mt-1.5 w-44 rounded-xl bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] shadow-xl py-1.5 z-40 text-left">
                                                    <button type="button" @click="menuOpen = false" wire:click="editSession({{ $session->id }})"
                                                            class="w-full px-3.5 py-2 text-xs font-semibold text-[#202124] dark:text-[#F5F5F5] hover:bg-[#F7F7F8] dark:hover:bg-[#251518] text-left cursor-pointer">
                                                        Edit Jadwal
                                                    </button>
                                                    @if(!$isCompleted)
                                                        <button type="button" @click="menuOpen = false" wire:click="forceFinishSession({{ $session->id }})"
                                                                class="w-full px-3.5 py-2 text-xs font-semibold text-[#202124] dark:text-[#F5F5F5] hover:bg-[#F7F7F8] dark:hover:bg-[#251518] text-left cursor-pointer">
                                                            Tandai Selesai Paksa
                                                        </button>
                                                    @endif
                                                    <button type="button" @click="menuOpen = false" wire:click="deleteSession({{ $session->id }})"
                                                            wire:confirm="Hapus jadwal sesi ini?"
                                                            class="w-full px-3.5 py-2 text-xs font-semibold text-[#C93646] dark:text-[#E54855] hover:bg-[#E54855]/10 text-left cursor-pointer">
                                                        Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @empty
                                <div class="py-10 text-center rounded-2xl border border-dashed border-[#E9E9EC] dark:border-[#342427] space-y-3">
                                    <p class="text-sm font-semibold text-[#202124] dark:text-[#F5F5F5]">Belum ada jadwal sesi pada tampilan ini.</p>
                                    <p class="text-xs text-[#777777] dark:text-[#AAA0A2]">Buat jadwal baru atau terapkan template dari Rutinitas Mingguan Anda.</p>
                                    <button type="button" wire:click="openCreateSessionModal"
                                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white text-xs font-bold transition-colors cursor-pointer">
                                        + Buat Jadwal Latihan
                                    </button>
                                </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        @if($sessions->hasPages())
                            <div class="pt-3 border-t border-[#E9E9EC] dark:border-[#342427]">
                                {{ $sessions->links() }}
                            </div>
                        @endif
                    </div>

                @elseif($activeTab === 'history')
                    <!-- WORKOUT HISTORY TAB (PERMANENT DB STORAGE) -->
                    <div class="bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] p-5 sm:p-6 space-y-5 shadow-xs">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#E9E9EC] dark:border-[#342427] pb-4">
                            <div>
                                <h2 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">Riwayat Latihan Tersimpan</h2>
                                <p class="text-xs text-[#777777] dark:text-[#AAA0A2] mt-0.5">
                                    Seluruh sesi latihan yang telah selesai, terlewat, atau dijalankan di luar jadwal tercatat permanen.
                                </p>
                            </div>

                            <select wire:model.live="historyRange"
                                    class="px-3.5 py-2 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-xs font-bold text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]">
                                <option value="today">Hari ini</option>
                                <option value="7d">7 hari terakhir</option>
                                <option value="30d">30 hari terakhir</option>
                                <option value="all">Semua riwayat</option>
                            </select>
                        </div>

                        <div class="space-y-3">
                            @forelse($historySessions as $hist)
                                @php $histEffective = $hist->effectiveStatus(); @endphp
                                <div wire:key="history-item-{{ $hist->id }}"
                                     class="rounded-2xl border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8]/60 dark:bg-[#251518]/60 p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                    <div class="space-y-1.5 min-w-0">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <h3 class="text-sm sm:text-base font-bold text-[#202124] dark:text-[#F5F5F5]">
                                                {{ $hist->name }}
                                            </h3>
                                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold uppercase {{ $histEffective === 'completed' ? 'bg-[#E54855]/12 text-[#C93646] dark:text-[#E54855]' : ($histEffective === 'in_progress' ? 'bg-[#E54855] text-white' : 'bg-[#C93646]/15 text-[#C93646] dark:text-[#E54855]') }}">
                                                {{ match($histEffective) { 'completed' => 'Completed', 'in_progress' => 'On Progress', 'missed' => 'Missed', default => 'Upcoming' } }}
                                            </span>
                                            @if($hist->is_off_schedule)
                                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-[#E54855]/10 text-[#E54855] border border-[#E54855]/25">
                                                    Di Luar Jadwal
                                                </span>
                                            @elseif($histEffective === 'completed')
                                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-white dark:bg-[#1A1012] text-[#202124] dark:text-[#F5F5F5] border border-[#E9E9EC] dark:border-[#342427]">
                                                    Sesuai Jadwal
                                                </span>
                                            @endif
                                        </div>

                                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-[#777777] dark:text-[#AAA0A2]">
                                            <span>Tanggal Jadwal: <strong class="text-[#202124] dark:text-[#F5F5F5]">{{ \App\Models\WorkoutSession::formatIndonesianDate($hist->scheduled_date) }}</strong></span>
                                            <span>Tanggal Aktual: <strong class="text-[#202124] dark:text-[#F5F5F5]">{{ $hist->actual_date ? \App\Models\WorkoutSession::formatIndonesianDate($hist->actual_date) : '-' }}</strong></span>
                                            @if($hist->formattedDuration())
                                                <span>Durasi: <strong class="text-[#E54855]">{{ $hist->formattedDuration() }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="shrink-0">
                                        <button type="button" wire:click="openHistoryDetail({{ $hist->id }})"
                                                class="px-4 py-2 rounded-xl bg-white dark:bg-[#1A1012] hover:bg-[#E54855] hover:text-white text-[#202124] dark:text-[#F5F5F5] border border-[#E9E9EC] dark:border-[#342427] hover:border-[#E54855] text-xs font-bold transition-colors cursor-pointer">
                                            Lihat Detail
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="py-10 text-center rounded-2xl border border-dashed border-[#E9E9EC] dark:border-[#342427]">
                                    <p class="text-sm text-[#777777] dark:text-[#AAA0A2]">Belum ada riwayat latihan pada rentang waktu yang dipilih.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                @else
                    <!-- WEEKLY ROUTINES TEMPLATE TAB (EXISTING CRUD) -->
                    @php
                        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                        $groupedRoutines = $routines->groupBy('day_of_week');
                    @endphp
                    <div class="space-y-4">
                        <div class="bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h2 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">Template Rutinitas Mingguan</h2>
                                <p class="text-xs text-[#777777] dark:text-[#AAA0A2] mt-0.5">
                                    Susun pembagian gerakan Senin–Minggu yang bisa diterapkan otomatis ke kalender latihan Anda.
                                </p>
                            </div>
                            <button type="button" wire:click="openRoutineModal()"
                                    class="px-4 py-2 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white text-xs font-bold transition-colors shrink-0 cursor-pointer">
                                + Tambah ke Rutinitas
                            </button>
                        </div>

                        @foreach($days as $index => $day)
                            @php $dayItems = $groupedRoutines->get($day, collect()); @endphp
                            <div class="bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] p-5 space-y-3">
                                <div class="flex items-center justify-between border-b border-[#E9E9EC] dark:border-[#342427] pb-3">
                                    <div class="flex items-center gap-3">
                                        <span class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-extrabold {{ $dayItems->count() > 0 ? 'bg-[#E54855]/10 text-[#E54855]' : 'bg-[#F7F7F8] dark:bg-[#251518] text-[#777777] dark:text-[#AAA0A2]' }}">
                                            {{ $index + 1 }}
                                        </span>
                                        <h3 class="text-base font-bold text-[#202124] dark:text-[#F5F5F5]">{{ $day }}</h3>
                                        <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold {{ $dayItems->count() > 0 ? 'bg-[#E54855]/10 text-[#E54855]' : 'bg-[#F7F7F8] dark:bg-[#251518] text-[#777777] dark:text-[#AAA0A2]' }}">
                                            {{ $dayItems->count() > 0 ? $dayItems->count() . ' Gerakan' : 'Rest Day' }}
                                        </span>
                                    </div>
                                    <button type="button" wire:click="openRoutineModal(null, '{{ $day }}')"
                                            class="px-3 py-1.5 rounded-lg text-xs font-bold bg-[#E54855]/10 hover:bg-[#E54855] text-[#E54855] hover:text-white transition-colors cursor-pointer">
                                        + Tambah
                                    </button>
                                </div>

                                @if($dayItems->count() > 0)
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        @foreach($dayItems as $routine)
                                            <div wire:key="routine-{{ $routine->id }}" class="rounded-xl p-3.5 border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8]/60 dark:bg-[#251518]/60 flex flex-col justify-between gap-3">
                                                <div class="flex items-start gap-3">
                                                    @if($routine->exercise?->image_1 || $routine->exercise?->icon)
                                                        <div class="w-16 h-16 rounded-xl bg-white dark:bg-[#100809] border border-[#E9E9EC] dark:border-[#342427] p-1.5 flex items-center justify-center shrink-0 overflow-hidden">
                                                            <img src="{{ $routine->exercise->image_1 ?? $routine->exercise->icon }}"
                                                                 alt="{{ $routine->exercise->name }}"
                                                                 class="w-full h-full object-contain"
                                                                 loading="lazy">
                                                        </div>
                                                    @endif
                                                    <div class="min-w-0 flex-1">
                                                        <span class="text-[10px] font-bold uppercase tracking-wider text-[#E54855]">{{ $routine->exercise->target_muscle ?? 'Umum' }}</span>
                                                        <h4 class="text-sm font-bold text-[#202124] dark:text-[#F5F5F5] mt-0.5 truncate">{{ $routine->exercise->name ?? 'Gerakan' }}</h4>
                                                        <p class="text-xs text-[#777777] dark:text-[#AAA0A2] mt-1 font-semibold">{{ $routine->sets }} Set &times; {{ $routine->reps }} Reps</p>
                                                        @if($routine->notes)
                                                            <p class="text-xs text-[#777777] dark:text-[#AAA0A2] italic mt-1 line-clamp-2">"{{ $routine->notes }}"</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex justify-end gap-2 pt-2 border-t border-[#E9E9EC] dark:border-[#342427]">
                                                    <button type="button" wire:click="edit({{ $routine->id }})" class="px-2.5 py-1 rounded-lg text-xs font-semibold text-[#202124] dark:text-[#F5F5F5] bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] hover:border-[#E54855] cursor-pointer">Edit</button>
                                                    <button type="button" wire:click="delete({{ $routine->id }})" wire:confirm="Hapus gerakan ini dari rutinitas?" class="px-2.5 py-1 rounded-lg text-xs font-semibold text-[#C93646] dark:text-[#E54855] bg-[#E54855]/10 hover:bg-[#E54855]/20 cursor-pointer">Hapus</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-xs text-[#777777] dark:text-[#AAA0A2]">Belum ada gerakan terjadwal untuk hari {{ $day }}.</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- RIGHT COLUMN (4 COLS): MONTHLY CALENDAR (ASIA/JAKARTA) + NEXT PLANS + FAB (GAMBAR 4) -->
            <div class="lg:col-span-4 space-y-5 lg:sticky lg:top-24">

                <!-- Kalender Interaktif -->
                <div class="bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] p-5 shadow-xs space-y-4">
                    <div class="flex items-center justify-between gap-2">
                        <button type="button" wire:click="previousMonth"
                                class="w-8 h-8 rounded-lg flex items-center justify-center bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5] hover:border-[#E54855] cursor-pointer"
                                title="Bulan Sebelumnya">
                            &lsaquo;
                        </button>
                        <div class="text-center">
                            <h3 class="text-sm font-extrabold text-[#202124] dark:text-[#F5F5F5]">{{ $monthLabel }}</h3>
                        </div>
                        <button type="button" wire:click="nextMonth"
                                class="w-8 h-8 rounded-lg flex items-center justify-center bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5] hover:border-[#E54855] cursor-pointer"
                                title="Bulan Berikutnya">
                            &rsaquo;
                        </button>
                    </div>

                    <div class="flex items-center justify-between text-[11px]">
                        <button type="button" wire:click="goToToday" class="font-bold text-[#E54855] hover:underline cursor-pointer">
                            Hari Ini
                        </button>
                        <button type="button" wire:click="$toggle('showWeekStrip')" class="font-semibold text-[#777777] dark:text-[#AAA0A2] hover:text-[#E54855] cursor-pointer">
                            {{ $showWeekStrip ? 'Tampilkan Bulan' : 'Strip Minggu Ini' }}
                        </button>
                    </div>

                    @if($showWeekStrip)
                        <!-- Strip Mingguan -->
                        <div class="grid grid-cols-7 gap-1.5 pt-1">
                            @foreach($weekDays as $wd)
                                @php $isSel = $selectedDate === $wd['date']; @endphp
                                <button type="button" wire:click="selectCalendarDate('{{ $wd['date'] }}')"
                                        class="py-2 rounded-xl border text-center transition-colors cursor-pointer {{ $isSel ? 'bg-[#E54855] border-[#E54855] text-white' : ($wd['isToday'] ? 'border-[#E54855] bg-[#E54855]/10 text-[#E54855]' : 'border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5]') }}">
                                    <div class="text-[10px] font-bold uppercase">{{ $wd['short'] }}</div>
                                    <div class="text-sm font-extrabold mt-0.5">{{ $wd['day'] }}</div>
                                    @if($wd['count'] > 0)
                                        <span class="block w-1.5 h-1.5 mx-auto mt-1 rounded-full {{ $isSel ? 'bg-white' : 'bg-[#E54855]' }}"></span>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    @else
                        <!-- Header Hari -->
                        <div class="grid grid-cols-7 text-center text-[11px] font-bold text-[#777777] dark:text-[#AAA0A2]">
                            <span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span><span>Min</span>
                        </div>

                        <!-- Grid Tanggal Bulanan -->
                        <div class="grid grid-cols-7 gap-1">
                            @foreach($calendarDays as $cell)
                                @php $isSelected = $selectedDate === $cell['date']; @endphp
                                <button type="button" wire:click="selectCalendarDate('{{ $cell['date'] }}')"
                                        class="relative h-9 rounded-lg flex flex-col items-center justify-center text-xs font-bold transition-colors cursor-pointer
                                        {{ $isSelected ? 'bg-[#E54855] text-white shadow-xs' : ($cell['isToday'] ? 'ring-1.5 ring-[#E54855] bg-[#E54855]/10 text-[#E54855]' : ($cell['isCurrentMonth'] ? 'text-[#202124] dark:text-[#F5F5F5] hover:bg-[#F7F7F8] dark:hover:bg-[#251518]' : 'text-[#777777]/45 dark:text-[#AAA0A2]/35')) }}">
                                    <span>{{ $cell['day'] }}</span>
                                    @if($cell['hasSessions'])
                                        <span class="w-1.5 h-1.5 rounded-full {{ $isSelected ? 'bg-white' : ($cell['hasActiveOrUpcoming'] ? 'bg-[#E54855]' : 'bg-[#777777] dark:bg-[#AAA0A2]') }}"></span>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Jadwal Terdekat (Next Plan) + Tombol Tambah -->
                <div class="bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] p-5 shadow-xs space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-extrabold text-[#202124] dark:text-[#F5F5F5]">Jadwal Mendatang</h3>
                        <button type="button" wire:click="openCreateSessionModal"
                                class="w-8 h-8 rounded-full bg-[#E54855] hover:bg-[#C93646] text-white flex items-center justify-center shadow-sm transition-colors cursor-pointer"
                                title="Tambah Jadwal Baru">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-2.5">
                        @forelse($upcomingSessions as $up)
                            <div wire:click="attemptStartSession({{ $up->id }})"
                                 class="p-3 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] hover:border-[#E54855]/60 flex items-center gap-3 cursor-pointer transition-colors">
                                <div class="w-9 h-9 rounded-lg bg-[#E54855]/10 text-[#E54855] flex items-center justify-center font-extrabold text-xs shrink-0">
                                    {{ $up->scheduled_date?->day }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="text-xs font-bold text-[#202124] dark:text-[#F5F5F5] truncate">{{ $up->name }}</div>
                                    <div class="text-[11px] text-[#777777] dark:text-[#AAA0A2]">
                                        {{ \App\Models\WorkoutSession::shortIndonesianDay($up->scheduled_date) }}, {{ $up->scheduled_date?->format('d M') }} &bull; {{ $up->items_count }} Gerakan
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-[#777777] dark:text-[#AAA0A2] py-2">Tidak ada jadwal mendatang. Klik ikon + untuk menambah.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    @endif

    <!-- MODAL PERINGATAN KETIDAKSESUAIAN TANGGAL JADWAL -->
    @if($mismatchSessionId)
        <div class="fixed inset-0 z-[130] flex items-center justify-center p-4 bg-black/75 backdrop-blur-xs">
            <div class="w-full max-w-md bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] shadow-2xl overflow-hidden">
                <div class="h-1.5 bg-[#E54855] w-full"></div>
                <div class="p-6 space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#E54855]/10 text-[#E54855] flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="space-y-1">
                            <h3 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">Peringatan Jadwal Latihan</h3>
                            <p class="text-xs font-semibold text-[#E54855]">Tanggal pelaksanaan berbeda dari jadwal asli</p>
                        </div>
                    </div>

                    <p class="text-sm text-[#202124] dark:text-[#F5F5F5] leading-relaxed">
                        Jadwal latihan ini seharusnya dilakukan pada <strong>{{ $mismatchScheduledFormatted }}</strong>. Hari ini adalah <strong>{{ $mismatchTodayFormatted }}</strong>. Apakah kamu tetap ingin melanjutkan latihan?
                    </p>

                    @if($mismatchIsFuture)
                        <div class="p-3 rounded-xl bg-[#E54855]/10 border border-[#E54855]/25 text-xs font-medium text-[#C93646] dark:text-[#E54855]">
                            Perhatian: Latihan ini belum waktunya dilakukan karena dijadwalkan untuk tanggal mendatang.
                        </div>
                    @endif

                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-2.5 pt-3 border-t border-[#E9E9EC] dark:border-[#342427]">
                        <button type="button" wire:click="cancelMismatchStart"
                                class="px-4 py-2.5 rounded-xl bg-[#F1F1F4] dark:bg-[#251518] hover:bg-[#E9E9EC] dark:hover:bg-[#342427] text-[#202124] dark:text-[#F5F5F5] text-sm font-semibold transition-colors cursor-pointer">
                            Kembali ke Jadwal
                        </button>
                        <button type="button" wire:click="confirmMismatchStart"
                                class="px-4 py-2.5 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white text-sm font-bold transition-colors cursor-pointer">
                            Tetap Mulai Latihan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- 1 LAYAR FULL GERAKAN: GUIDED WORKOUT PLAYER (DENGAN TIMER LATIHAN & REST TIMER ANTAR GERAKAN) -->
    @if($activeSession)
        @php
            $sessionItems = $activeSession->items->values();
            $totalItems = $sessionItems->count();
            $currentIndex = $totalItems > 0 ? min(max(0, $activeExerciseIndex), $totalItems - 1) : 0;
            $currentItem = $sessionItems->get($currentIndex);
            $nextItem = $sessionItems->get($currentIndex + 1);
            $prevItem = $currentIndex > 0 ? $sessionItems->get($currentIndex - 1) : null;
            $currentExercise = $currentItem?->exercise;
            $currentImages = collect([
                $currentExercise?->image_1 ?? $currentExercise?->icon,
                $currentExercise?->image_2,
                $currentExercise?->image_3,
            ])->filter()->values()->all();
            $nextImage = $nextItem?->exercise?->image_1 ?? $nextItem?->exercise?->icon ?? null;
            $initialElapsed = $activeSession->started_at ? max(0, (int) now('Asia/Jakarta')->diffInSeconds($activeSession->started_at)) : 0;
        @endphp

        <div wire:key="fullscreen-workout-{{ $activeSession->id }}"
             x-data="{
                 elapsedSeconds: {{ $initialElapsed }},
                 workoutPaused: false,
                 workoutTimerId: null,
                 isResting: false,
                 restDuration: @entangle('restDurationSeconds'),
                 restRemaining: 0,
                 restTotal: 45,
                 restTimerId: null,
                 pendingItemId: null,
                 pendingNextIndex: 0,
                 showQuickAdd: false,
                 init() {
                     this.workoutTimerId = setInterval(() => {
                         if (!this.workoutPaused) {
                             this.elapsedSeconds++;
                         }
                     }, 1000);
                 },
                 formatClock(sec) {
                     const s = Math.max(0, parseInt(sec || 0, 10));
                     const h = String(Math.floor(s / 3600)).padStart(2, '0');
                     const m = String(Math.floor((s % 3600) / 60)).padStart(2, '0');
                     const r = String(s % 60).padStart(2, '0');
                     return h + ':' + m + ':' + r;
                 },
                 formatRest(sec) {
                     const s = Math.max(0, parseInt(sec || 0, 10));
                     const m = String(Math.floor(s / 60)).padStart(2, '0');
                     const r = String(s % 60).padStart(2, '0');
                     return m + ':' + r;
                 },
                 triggerNextWithRest(itemId, nextIdx) {
                     const customRest = Math.max(0, parseInt(this.restDuration || 0, 10));
                     if (customRest <= 0) {
                         $wire.completeItemAndAdvance(itemId, nextIdx);
                         return;
                     }
                     this.stopRestTimer();
                     this.pendingItemId = itemId;
                     this.pendingNextIndex = nextIdx;
                     this.restTotal = customRest;
                     this.restRemaining = customRest;
                     this.isResting = true;
                     this.restTimerId = setInterval(() => {
                         if (this.restRemaining > 1) {
                             this.restRemaining--;
                         } else {
                             this.finishRestAndAdvance();
                         }
                     }, 1000);
                 },
                 adjustRestRemaining(delta) {
                     this.restRemaining = Math.max(1, this.restRemaining + delta);
                     this.restTotal = Math.max(this.restTotal, this.restRemaining);
                 },
                 stopRestTimer() {
                     if (this.restTimerId) {
                         clearInterval(this.restTimerId);
                         this.restTimerId = null;
                     }
                     this.isResting = false;
                 },
                 finishRestAndAdvance() {
                     const itemId = this.pendingItemId;
                     const nextIdx = this.pendingNextIndex;
                     this.stopRestTimer();
                     if (itemId !== null) {
                         $wire.completeItemAndAdvance(itemId, nextIdx);
                     }
                 },
                 goPrevious(prevIdx) {
                     this.stopRestTimer();
                     $wire.goToExerciseStep(prevIdx);
                 }
             }"
             class="fixed inset-0 z-[140] bg-[#F7F7F8] dark:bg-[#100809] text-[#202124] dark:text-[#F5F5F5] flex flex-col overflow-hidden">

            <!-- TOP HEADER BAR: NAMA SESI + WAKTU TIMER LATIHAN + PENGATURAN WAKTU REST USER -->
            <div class="bg-white dark:bg-[#1A1012] border-b border-[#E9E9EC] dark:border-[#342427] px-4 sm:px-6 py-3.5 shrink-0 shadow-xs">
                <div class="max-w-6xl mx-auto flex flex-wrap items-center justify-between gap-3">
                    <!-- Kiri: Info Sesi -->
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-xl bg-[#E54855] text-white flex items-center justify-center font-extrabold text-sm shrink-0 shadow-sm shadow-[#E54855]/25">
                            {{ $totalItems > 0 ? ($currentIndex + 1) . '/' . $totalItems : '0/0' }}
                        </div>
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="px-2 py-0.5 rounded-md bg-[#E54855]/10 text-[#E54855] text-[10px] font-extrabold uppercase tracking-wider">
                                    Layar Latihan Aktif
                                </span>
                                @if($activeSession->is_off_schedule)
                                    <span class="px-2 py-0.5 rounded-md bg-[#C93646]/15 text-[#C93646] dark:text-[#E54855] text-[10px] font-bold">
                                        Di Luar Jadwal
                                    </span>
                                @endif
                            </div>
                            <h2 class="text-base sm:text-lg font-extrabold truncate text-[#202124] dark:text-[#F5F5F5]">
                                {{ $activeSession->name }}
                            </h2>
                        </div>
                    </div>

                    <!-- Tengah: Pengaturan Waktu Rest (Ditentukan User Sendiri) -->
                    <div class="flex flex-wrap items-center gap-2 bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] px-3 py-1.5 rounded-xl">
                        <span class="text-[11px] font-bold text-[#777777] dark:text-[#AAA0A2]">Waktu Rest:</span>
                        <div class="flex items-center gap-1">
                            @foreach([15, 30, 45, 60, 90] as $presetSec)
                                <button type="button"
                                        @click="restDuration = {{ $presetSec }}"
                                        :class="parseInt(restDuration) === {{ $presetSec }} ? 'bg-[#E54855] text-white' : 'bg-white dark:bg-[#1A1012] text-[#777777] dark:text-[#AAA0A2] hover:text-[#E54855]'"
                                        class="px-2 py-1 rounded-lg text-[11px] font-bold border border-[#E9E9EC] dark:border-[#342427] transition-colors cursor-pointer">
                                    {{ $presetSec }}d
                                </button>
                            @endforeach
                        </div>
                        <div class="flex items-center gap-1 pl-1 border-l border-[#E9E9EC] dark:border-[#342427]">
                            <input type="number" x-model.number="restDuration" min="0" max="600"
                                   class="w-14 px-2 py-1 rounded-lg bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] text-xs font-mono font-bold text-center text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]"
                                   title="Atur sendiri durasi istirahat (detik)">
                            <span class="text-[11px] font-semibold text-[#777777] dark:text-[#AAA0A2]">detik</span>
                        </div>
                    </div>

                    <!-- Kanan: Stopwatch Waktu Latihan Live + Tutup Sementara -->
                    <div class="flex items-center gap-2.5">
                        <div class="flex items-center gap-2 px-3.5 py-2 rounded-xl bg-[#E54855]/10 border border-[#E54855]/30">
                            <span class="w-2 h-2 rounded-full bg-[#E54855]" :class="!workoutPaused ? 'animate-ping' : ''"></span>
                            <div class="text-left">
                                <span class="block text-[9px] font-extrabold uppercase tracking-wider text-[#777777] dark:text-[#AAA0A2] leading-none">Durasi Latihan</span>
                                <span class="font-mono tabular-nums text-sm sm:text-base font-extrabold text-[#E54855]" x-text="formatClock(elapsedSeconds)">00:00:00</span>
                            </div>
                            <button type="button" @click="workoutPaused = !workoutPaused"
                                    class="ml-1 px-2 py-1 rounded-lg bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] text-[10px] font-bold text-[#202124] dark:text-[#F5F5F5] hover:border-[#E54855] cursor-pointer"
                                    x-text="workoutPaused ? 'Lanjut' : 'Jeda'">
                            </button>
                        </div>

                        <button type="button" wire:click="closeActiveSession"
                                class="px-3 py-2 rounded-xl bg-[#F1F1F4] dark:bg-[#251518] hover:bg-[#E9E9EC] dark:hover:bg-[#342427] border border-[#E9E9EC] dark:border-[#342427] text-xs font-bold text-[#202124] dark:text-[#F5F5F5] cursor-pointer">
                            Tutup Sementara
                        </button>
                    </div>
                </div>

                <!-- Progress Bar Keseluruhan Sesi -->
                <div class="max-w-6xl mx-auto mt-3">
                    <div class="w-full h-2 rounded-full bg-[#F1F1F4] dark:bg-[#251518] overflow-hidden">
                        <div class="h-full bg-[#E54855] rounded-full transition-all duration-300" style="width: {{ $activeSession->progress_percent }}%"></div>
                    </div>
                </div>
            </div>

            <!-- MAIN FULL-SCREEN STAGE -->
            <div class="flex-1 overflow-y-auto px-4 sm:px-6 py-5">
                <div class="max-w-4xl mx-auto space-y-5">

                    @if($totalItems > 0 && $currentItem)
                        <!-- Indikator Urutan Gerakan (Step Pills) -->
                        <div class="flex items-center gap-2 overflow-x-auto pb-1 hide-scrollbar">
                            @foreach($sessionItems as $idx => $stepItem)
                                <button type="button"
                                        @click="stopRestTimer(); $wire.goToExerciseStep({{ $idx }})"
                                        class="px-3 py-1.5 rounded-xl text-xs font-bold shrink-0 border transition-all flex items-center gap-1.5 cursor-pointer
                                        {{ $idx === $currentIndex
                                            ? 'bg-[#E54855] border-[#E54855] text-white shadow-sm'
                                            : ($stepItem->is_completed
                                                ? 'bg-[#E54855]/10 border-[#E54855]/30 text-[#E54855]'
                                                : 'bg-white dark:bg-[#1A1012] border-[#E9E9EC] dark:border-[#342427] text-[#777777] dark:text-[#AAA0A2]') }}">
                                    <span>{{ $idx + 1 }}.</span>
                                    <span class="max-w-[130px] truncate">{{ $stepItem->exercise_name }}</span>
                                    @if($stepItem->is_completed)
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    @endif
                                </button>
                            @endforeach
                        </div>

                        <!-- LAYAR A: TAMPILAN GERAKAN SAAT INI (ketika tidak sedang Rest) -->
                        <div x-show="!isResting"
                             wire:key="active-step-card-{{ $currentItem->id }}"
                             x-data="{
                                 frame: 0,
                                 animating: true,
                                 images: @js($currentImages),
                                 init() {
                                     if (this.images.length > 1) {
                                         setInterval(() => {
                                             if (this.animating) {
                                                 this.frame = (this.frame + 1) % this.images.length;
                                             }
                                         }, 900);
                                     }
                                 }
                             }"
                             class="bg-white dark:bg-[#1A1012] rounded-3xl border border-[#E9E9EC] dark:border-[#342427] p-5 sm:p-7 shadow-sm space-y-6">

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                                <!-- Gambar Gerakan Ukuran Sedang-Proporsional dari Database -->
                                <div class="md:col-span-5 flex flex-col items-center">
                                    <div class="relative w-full max-w-[260px] h-52 sm:h-56 rounded-2xl bg-[#F7F7F8] dark:bg-[#100809] border border-[#E9E9EC] dark:border-[#342427] p-3 flex items-center justify-center overflow-hidden">
                                        @if(count($currentImages) > 0)
                                            <img :src="images[frame] || '{{ $currentImages[0] }}'"
                                                 src="{{ $currentImages[0] }}"
                                                 alt="{{ $currentItem->exercise_name }}"
                                                 class="w-full h-full object-contain transition-all duration-300">
                                        @else
                                            <div class="text-center text-xs text-[#777777] dark:text-[#AAA0A2]">
                                                Visual Gerakan
                                            </div>
                                        @endif

                                        @if(count($currentImages) > 1)
                                            <button type="button" @click="animating = !animating"
                                                    class="absolute bottom-2.5 right-2.5 px-2.5 py-1 rounded-lg bg-black/70 text-white text-[10px] font-bold flex items-center gap-1 cursor-pointer">
                                                <span class="w-1.5 h-1.5 rounded-full bg-[#E54855]" :class="animating ? 'animate-pulse' : ''"></span>
                                                <span x-text="animating ? 'Animasi Aktif' : 'Jeda Animasi'"></span>
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <!-- Detail Target Gerakan, Set, dan Repetisi -->
                                <div class="md:col-span-7 space-y-4">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="px-3 py-1 rounded-lg bg-[#E54855]/10 text-[#E54855] text-xs font-extrabold uppercase tracking-wider">
                                            Gerakan {{ $currentIndex + 1 }} dari {{ $totalItems }}
                                        </span>
                                        <span class="px-2.5 py-1 rounded-lg bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-xs font-bold text-[#202124] dark:text-[#F5F5F5]">
                                            Otot: {{ $currentItem->target_muscle }}
                                        </span>
                                        @if($currentExercise?->equipment)
                                            <span class="px-2.5 py-1 rounded-lg bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-xs font-semibold text-[#777777] dark:text-[#AAA0A2]">
                                                Alat: {{ $currentExercise->equipment }}
                                            </span>
                                        @endif
                                        @if($currentExercise?->difficulty)
                                            <span class="px-2.5 py-1 rounded-lg bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-xs font-semibold text-[#777777] dark:text-[#AAA0A2]">
                                                Level: {{ $currentExercise->difficulty }}
                                            </span>
                                        @endif
                                    </div>

                                    <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-[#202124] dark:text-[#F5F5F5]">
                                        {{ $currentItem->exercise_name }}
                                    </h3>

                                    <!-- Kotak Target Set & Repetisi + Pencatat Set -->
                                    <div class="grid grid-cols-3 gap-3">
                                        <div class="p-3.5 rounded-2xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-center">
                                            <span class="block text-[11px] font-bold uppercase text-[#777777] dark:text-[#AAA0A2]">Target Set</span>
                                            <span class="font-mono tabular-nums text-xl sm:text-2xl font-extrabold text-[#202124] dark:text-[#F5F5F5] mt-0.5 block">
                                                {{ $currentItem->target_sets }}
                                            </span>
                                        </div>
                                        <div class="p-3.5 rounded-2xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-center">
                                            <span class="block text-[11px] font-bold uppercase text-[#777777] dark:text-[#AAA0A2]">Target Repetisi</span>
                                            <span class="font-mono tabular-nums text-xl sm:text-2xl font-extrabold text-[#E54855] mt-0.5 block">
                                                {{ $currentItem->target_reps }}
                                            </span>
                                        </div>
                                        <div class="p-3.5 rounded-2xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-center">
                                            <span class="block text-[11px] font-bold uppercase text-[#777777] dark:text-[#AAA0A2]">Set Selesai</span>
                                            <div class="flex items-center justify-center gap-2 mt-1">
                                                <button type="button" wire:click="decrementItemSet({{ $currentItem->id }})"
                                                        class="w-6 h-6 rounded-lg bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] font-bold text-xs hover:border-[#E54855] cursor-pointer">-</button>
                                                <span class="font-mono tabular-nums text-base sm:text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">
                                                    {{ $currentItem->completed_sets }}/{{ $currentItem->target_sets }}
                                                </span>
                                                <button type="button" wire:click="incrementItemSet({{ $currentItem->id }})"
                                                        class="w-6 h-6 rounded-lg bg-[#E54855] text-white font-bold text-xs hover:bg-[#C93646] cursor-pointer">+</button>
                                            </div>
                                        </div>
                                    </div>

                                    @if($currentExercise?->instructions)
                                        <div class="p-3.5 rounded-2xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-xs text-[#777777] dark:text-[#AAA0A2] leading-relaxed max-h-28 overflow-y-auto">
                                            <strong class="text-[#202124] dark:text-[#F5F5F5] block mb-1">Panduan Pelaksanaan:</strong>
                                            {{ $currentExercise->instructions }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- LAYAR B: WAKTU ISTIRAHAT (REST TIMER) SEBELUM KE GERAKAN BERIKUTNYA -->
                        <div x-show="isResting" x-cloak
                             class="bg-white dark:bg-[#1A1012] rounded-3xl border-2 border-[#E54855] p-6 sm:p-8 shadow-xl text-center space-y-6">
                            <div class="space-y-1">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#E54855]/10 text-[#E54855] text-xs font-extrabold uppercase tracking-wider">
                                    Waktu Istirahat (Rest)
                                </span>
                                <h3 class="text-xl sm:text-2xl font-extrabold text-[#202124] dark:text-[#F5F5F5]">
                                    Tarik Napas &amp; Siapkan Gerakan Berikutnya
                                </h3>
                                <p class="text-xs sm:text-sm text-[#777777] dark:text-[#AAA0A2]">
                                    Otomatis berpindah ke gerakan selanjutnya saat hitung mundur selesai.
                                </p>
                            </div>

                            <!-- Angka Countdown Besar -->
                            <div class="py-2">
                                <div class="font-mono tabular-nums text-5xl sm:text-6xl font-extrabold text-[#E54855] tracking-tight"
                                     x-text="formatRest(restRemaining)">
                                    00:45
                                </div>
                                <div class="max-w-xs mx-auto mt-3 h-2.5 rounded-full bg-[#F1F1F4] dark:bg-[#251518] overflow-hidden">
                                    <div class="h-full bg-[#E54855] transition-all duration-500 rounded-full"
                                         :style="'width: ' + Math.min(100, Math.round((restRemaining / Math.max(1, restTotal)) * 100)) + '%'"></div>
                                </div>
                            </div>

                            <!-- Tombol Ubah Cepat Durasi Rest Saat Berjalan -->
                            <div class="flex flex-wrap items-center justify-center gap-2">
                                <button type="button" @click="adjustRestRemaining(-15)"
                                        class="px-3.5 py-2 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] hover:border-[#E54855] text-xs font-bold cursor-pointer">
                                    -15 Detik
                                </button>
                                <button type="button" @click="adjustRestRemaining(15)"
                                        class="px-3.5 py-2 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] hover:border-[#E54855] text-xs font-bold cursor-pointer">
                                    +15 Detik
                                </button>
                                <button type="button" @click="adjustRestRemaining(30)"
                                        class="px-3.5 py-2 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] hover:border-[#E54855] text-xs font-bold cursor-pointer">
                                    +30 Detik
                                </button>
                            </div>

                            <!-- Preview Gerakan Berikutnya -->
                            @if($nextItem)
                                <div class="max-w-md mx-auto p-3.5 rounded-2xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] flex items-center gap-3.5 text-left">
                                    @if($nextImage)
                                        <div class="w-16 h-16 rounded-xl bg-white dark:bg-[#100809] border border-[#E9E9EC] dark:border-[#342427] p-1.5 flex items-center justify-center shrink-0">
                                            <img src="{{ $nextImage }}" alt="{{ $nextItem->exercise_name }}" class="w-full h-full object-contain">
                                        </div>
                                    @endif
                                    <div class="min-w-0 flex-1">
                                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-[#E54855]">Gerakan Berikutnya ({{ $currentIndex + 2 }}/{{ $totalItems }})</span>
                                        <h4 class="text-sm sm:text-base font-extrabold text-[#202124] dark:text-[#F5F5F5] truncate">{{ $nextItem->exercise_name }}</h4>
                                        <p class="text-xs text-[#777777] dark:text-[#AAA0A2] font-semibold">{{ $nextItem->target_sets }} Set &times; {{ $nextItem->target_reps }} Reps &bull; {{ $nextItem->target_muscle }}</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Aksi Saat Rest -->
                            <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
                                <button type="button" @click="stopRestTimer()"
                                        class="px-4 py-2.5 rounded-xl bg-[#F1F1F4] dark:bg-[#251518] text-xs sm:text-sm font-bold text-[#202124] dark:text-[#F5F5F5] cursor-pointer">
                                    &larr; Kembali ke Gerakan Tadi
                                </button>
                                <button type="button" @click="finishRestAndAdvance()"
                                        class="px-5 py-2.5 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white text-xs sm:text-sm font-extrabold shadow-md shadow-[#E54855]/25 cursor-pointer">
                                    Lewati Istirahat &amp; Mulai Gerakan Berikutnya &rarr;
                                </button>
                            </div>
                        </div>

                    @else
                        <!-- Jika Sesi Belum Memiliki Gerakan -->
                        <div class="bg-white dark:bg-[#1A1012] rounded-3xl border border-[#E9E9EC] dark:border-[#342427] p-8 text-center space-y-4">
                            <p class="text-base font-bold text-[#202124] dark:text-[#F5F5F5]">Belum ada gerakan di sesi latihan ini.</p>
                            <p class="text-xs text-[#777777] dark:text-[#AAA0A2]">Tambahkan gerakan di bawah untuk langsung memulai layar latihan.</p>
                        </div>
                    @endif

                    <!-- Panel Tambah Gerakan Cepat (Opsional) -->
                    <div class="bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-[#777777] dark:text-[#AAA0A2]">Ingin menambah gerakan tambahan ke sesi ini?</span>
                            <button type="button" @click="showQuickAdd = !showQuickAdd" class="text-xs font-bold text-[#E54855] hover:underline cursor-pointer">
                                <span x-text="showQuickAdd ? 'Sembunyikan' : '+ Tambah Gerakan'"></span>
                            </button>
                        </div>
                        <div x-show="showQuickAdd || {{ $totalItems === 0 ? 'true' : 'false' }}" x-cloak class="mt-3 pt-3 border-t border-[#E9E9EC] dark:border-[#342427] grid grid-cols-1 sm:grid-cols-12 gap-2.5 items-end">
                            <div class="sm:col-span-6">
                                <label class="block text-[11px] font-bold text-[#777777] dark:text-[#AAA0A2] mb-1">Pilih Gerakan</label>
                                <select wire:model="quickAddExerciseId" class="w-full px-3 py-2 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-xs font-semibold text-[#202124] dark:text-[#F5F5F5]">
                                    @foreach($exercises as $ex)
                                        <option value="{{ $ex->id }}">{{ $ex->name }} ({{ $ex->target_muscle }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-[11px] font-bold text-[#777777] dark:text-[#AAA0A2] mb-1">Set</label>
                                <input type="number" wire:model="quickAddSets" min="1" class="w-full px-3 py-2 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-xs text-[#202124] dark:text-[#F5F5F5]">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-[11px] font-bold text-[#777777] dark:text-[#AAA0A2] mb-1">Reps</label>
                                <input type="text" wire:model="quickAddReps" class="w-full px-3 py-2 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-xs text-[#202124] dark:text-[#F5F5F5]">
                            </div>
                            <div class="sm:col-span-2">
                                <button type="button" wire:click="addItemToActiveSession"
                                        class="w-full py-2 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white text-xs font-bold cursor-pointer">
                                    + Tambah
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- BOTTOM NAVIGATION BAR: TOMBOL MUNDUR (SEBELUMNYA) & LANJUT (BERIKUTNYA DENGAN REST) / SELESAI -->
            <div class="bg-white dark:bg-[#1A1012] border-t border-[#E9E9EC] dark:border-[#342427] px-4 sm:px-6 py-4 shrink-0">
                <div class="max-w-4xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3">
                    <!-- Tombol Mundur (Gerakan Sebelumnya) -->
                    <button type="button"
                            @if($prevItem)
                                @click="goPrevious({{ $currentIndex - 1 }})"
                            @else
                                disabled
                            @endif
                            class="w-full sm:w-auto px-5 py-3 rounded-xl border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#251518] hover:border-[#E54855] text-xs sm:text-sm font-bold text-[#202124] dark:text-[#F5F5F5] flex items-center justify-center gap-2 transition-colors disabled:opacity-40 disabled:pointer-events-none cursor-pointer">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span>Mundur (Gerakan Sebelumnya)</span>
                    </button>

                    <!-- Info Tengah -->
                    <div class="text-center text-xs text-[#777777] dark:text-[#AAA0A2] font-semibold">
                        @if($nextItem)
                            <span>Selanjutnya: <strong class="text-[#202124] dark:text-[#F5F5F5]">{{ $nextItem->exercise_name }}</strong> (Rest <span x-text="restDuration"></span> dtk)</span>
                        @else
                            <span class="text-[#E54855] font-bold">Gerakan Terakhir dalam Sesi Ini</span>
                        @endif
                    </div>

                    <!-- Tombol Lanjut (Ke Gerakan Berikutnya + Rest) atau Selesaikan Sesi -->
                    @if($nextItem && $currentItem)
                        <button type="button"
                                @click="triggerNextWithRest({{ $currentItem->id }}, {{ $currentIndex + 1 }})"
                                class="w-full sm:w-auto px-6 py-3 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white text-xs sm:text-sm font-extrabold shadow-md shadow-[#E54855]/25 flex items-center justify-center gap-2 transition-colors cursor-pointer">
                            <span>Lanjut (Istirahat &amp; Gerakan Berikutnya)</span>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    @else
                        <button type="button"
                                @click="stopRestTimer(); $wire.finishActiveSession(elapsedSeconds)"
                                class="w-full sm:w-auto px-6 py-3 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white text-xs sm:text-sm font-extrabold shadow-md shadow-[#E54855]/25 flex items-center justify-center gap-2 transition-colors cursor-pointer">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Selesaikan Latihan &amp; Simpan Riwayat</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL BUAT / EDIT JADWAL SESI (DENGAN PREVIEW GAMBAR GERAKAN UKURAN SEDANG DARI DATABASE) -->
    @if($showSessionModal)
        @php
            $filteredPickerExercises = trim($pickerSearch) !== ''
                ? $exercises->filter(fn ($e) => str_contains(strtolower($e->name), strtolower(trim($pickerSearch))) || str_contains(strtolower($e->target_muscle ?? ''), strtolower(trim($pickerSearch))))->values()
                : $exercises;
            $selectedDraftExercise = $exercises->firstWhere('id', (int) $addExerciseId) ?? $exercises->first();
            $selectedDraftImages = collect([
                $selectedDraftExercise?->image_1 ?? $selectedDraftExercise?->icon,
                $selectedDraftExercise?->image_2,
            ])->filter()->values()->all();
        @endphp
        <div class="fixed inset-0 z-[120] flex items-center justify-center p-4 bg-black/70 backdrop-blur-xs">
            <div class="w-full max-w-xl bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] shadow-2xl max-h-[92vh] flex flex-col overflow-hidden">
                <div class="p-5 border-b border-[#E9E9EC] dark:border-[#342427] flex items-center justify-between">
                    <h3 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">
                        {{ $editingSessionId ? 'Edit Jadwal Sesi' : 'Buat Jadwal Latihan Baru' }}
                    </h3>
                    <button type="button" wire:click="closeSessionModal" class="p-1.5 text-[#777777] hover:text-[#E54855] cursor-pointer">&times;</button>
                </div>

                <form wire:submit="saveSession" class="p-5 overflow-y-auto space-y-4 flex-1">
                    <div>
                        <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1">Nama Sesi Latihan</label>
                        <input type="text" wire:model="sessionName" required placeholder="Cth: Push Day (Dada, Bahu, Tricep)"
                               class="w-full px-3.5 py-2.5 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-sm text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]">
                        @error('sessionName') <span class="text-xs text-[#E54855] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1">Kategori</label>
                            <select wire:model="sessionCategory" class="w-full px-3 py-2.5 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-sm text-[#202124] dark:text-[#F5F5F5]">
                                <option value="Latihan Beban">Latihan Beban</option>
                                <option value="Calisthenics">Calisthenics</option>
                                <option value="Kardio">Kardio</option>
                                <option value="Mobilitas">Mobilitas</option>
                                <option value="Full Body">Full Body</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1">Tanggal Jadwal</label>
                            <input type="date" wire:model="sessionDate" required class="w-full px-3 py-2.5 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-sm text-[#202124] dark:text-[#F5F5F5]">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1">Jam (WIB)</label>
                            <input type="time" wire:model="sessionTime" class="w-full px-3 py-2.5 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-sm text-[#202124] dark:text-[#F5F5F5]">
                        </div>
                    </div>

                    <!-- Tambah Gerakan ke Draft Sesi + Preview Gambar Ukuran Sedang -->
                    <div class="p-4 rounded-2xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] space-y-3.5">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-extrabold text-[#202124] dark:text-[#F5F5F5]">
                                Pilih &amp; Tambah Gerakan ({{ count($sessionExercises) }} dipilih)
                            </span>
                            <span class="text-[11px] font-bold text-[#E54855]">{{ $exercises->count() }} Gerakan Tersedia</span>
                        </div>

                        <!-- Kartu Preview Gerakan Ukuran Sedang dari Database -->
                        @if($selectedDraftExercise)
                            <div wire:key="draft-preview-{{ $selectedDraftExercise->id }}"
                                 x-data="{
                                     frame: 0,
                                     imgs: @js($selectedDraftImages)
                                 }"
                                 @mouseenter="if(imgs.length > 1) frame = 1"
                                 @mouseleave="frame = 0"
                                 class="p-3 rounded-xl bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] flex items-center gap-3.5">
                                <div class="relative w-20 h-20 sm:w-24 sm:h-24 rounded-xl bg-[#F7F7F8] dark:bg-[#100809] border border-[#E9E9EC] dark:border-[#342427] p-1.5 flex items-center justify-center shrink-0 overflow-hidden">
                                    @if(count($selectedDraftImages) > 0)
                                        <img :src="imgs[frame] || '{{ $selectedDraftImages[0] }}'"
                                             src="{{ $selectedDraftImages[0] }}"
                                             alt="{{ $selectedDraftExercise->name }}"
                                             class="w-full h-full object-contain">
                                    @endif
                                    @if(count($selectedDraftImages) > 1)
                                        <span class="absolute bottom-1 inset-x-1 text-center py-0.5 rounded bg-black/65 text-white text-[9px] font-bold">
                                            Animasi
                                        </span>
                                    @endif
                                </div>

                                <div class="min-w-0 flex-1 space-y-1.5">
                                    <div class="text-sm sm:text-base font-extrabold text-[#202124] dark:text-[#F5F5F5] truncate">
                                        {{ $selectedDraftExercise->name }}
                                    </div>
                                    <div class="flex flex-wrap items-center gap-1.5">
                                        <span class="px-2 py-0.5 rounded-md bg-[#E54855]/10 text-[#E54855] text-[10px] font-extrabold uppercase">
                                            {{ $selectedDraftExercise->target_muscle ?? 'Umum' }}
                                        </span>
                                        <span class="px-2 py-0.5 rounded-md bg-[#F7F7F8] dark:bg-[#251518] text-[#777777] dark:text-[#AAA0A2] text-[10px] font-bold">
                                            {{ $selectedDraftExercise->difficulty ?? 'Menengah' }}
                                        </span>
                                        <span class="px-2 py-0.5 rounded-md bg-[#F7F7F8] dark:bg-[#251518] text-[#777777] dark:text-[#AAA0A2] text-[10px] font-semibold">
                                            {{ $selectedDraftExercise->equipment ?? 'Bodyweight' }}
                                        </span>
                                    </div>
                                    <!-- Pencarian cepat gerakan -->
                                    <input type="text" wire:model.live.debounce.200ms="pickerSearch"
                                           placeholder="Cari nama gerakan atau otot (cth: Bench, Dada, Perut)..."
                                           class="w-full px-2.5 py-1.5 rounded-lg bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-xs text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855]">
                                </div>
                            </div>
                        @endif

                        <!-- Baris Pilih Gerakan, Set, Reps, dan Tombol + Pilih -->
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-2 items-end">
                            <div class="sm:col-span-6">
                                <label class="block text-[10px] font-bold text-[#777777] dark:text-[#AAA0A2] mb-1">Ganti Gerakan</label>
                                <select wire:model.live="addExerciseId" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] text-xs font-semibold text-[#202124] dark:text-[#F5F5F5]">
                                    @foreach($filteredPickerExercises as $ex)
                                        <option value="{{ $ex->id }}">{{ $ex->name }} ({{ $ex->target_muscle }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-[10px] font-bold text-[#777777] dark:text-[#AAA0A2] mb-1">Set</label>
                                <input type="number" wire:model="addExerciseSets" min="1" placeholder="Set" class="w-full px-2.5 py-2 rounded-xl bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] text-xs text-[#202124] dark:text-[#F5F5F5]">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-[10px] font-bold text-[#777777] dark:text-[#AAA0A2] mb-1">Reps</label>
                                <input type="text" wire:model="addExerciseReps" placeholder="Reps" class="w-full px-2.5 py-2 rounded-xl bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] text-xs text-[#202124] dark:text-[#F5F5F5]">
                            </div>
                            <div class="sm:col-span-2">
                                <button type="button" wire:click="addExerciseToDraft"
                                        class="w-full py-2 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white text-xs font-bold cursor-pointer">
                                    + Pilih
                                </button>
                            </div>
                        </div>

                        <!-- Daftar Gerakan yang Sudah Ditambahkan ke Sesi -->
                        @if(count($sessionExercises) > 0)
                            <div class="space-y-2 pt-1 max-h-48 overflow-y-auto">
                                @foreach($sessionExercises as $idx => $item)
                                    <div class="flex items-center justify-between gap-3 px-3 py-2 rounded-xl bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] text-xs">
                                        <div class="flex items-center gap-2.5 min-w-0">
                                            @if(!empty($item['image']))
                                                <div class="w-11 h-11 rounded-lg bg-[#F7F7F8] dark:bg-[#100809] border border-[#E9E9EC] dark:border-[#342427] p-1 flex items-center justify-center shrink-0">
                                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-contain">
                                                </div>
                                            @endif
                                            <div class="min-w-0">
                                                <div class="font-bold text-[#202124] dark:text-[#F5F5F5] truncate">{{ $idx + 1 }}. {{ $item['name'] }}</div>
                                                <div class="text-[11px] text-[#777777] dark:text-[#AAA0A2]">
                                                    {{ $item['target_sets'] }} Set &times; {{ $item['target_reps'] }} Reps &bull; {{ $item['target_muscle'] ?? 'Umum' }}
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" wire:click="removeDraftExercise({{ $idx }})" class="text-[#C93646] dark:text-[#E54855] font-bold hover:underline shrink-0 cursor-pointer">Hapus</button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1">Catatan (Opsional)</label>
                        <textarea wire:model="sessionNotes" rows="2" placeholder="Fokus tempo terkontrol, istirahat 45-60 detik..."
                                  class="w-full px-3.5 py-2 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-sm text-[#202124] dark:text-[#F5F5F5]"></textarea>
                    </div>

                    <div class="flex justify-end gap-2.5 pt-3 border-t border-[#E9E9EC] dark:border-[#342427]">
                        <button type="button" wire:click="closeSessionModal" class="px-4 py-2.5 rounded-xl bg-[#F1F1F4] dark:bg-[#251518] text-sm font-semibold text-[#202124] dark:text-[#F5F5F5] cursor-pointer">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white text-sm font-bold cursor-pointer">
                            {{ $editingSessionId ? 'Simpan Perubahan' : 'Simpan Jadwal' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- MODAL DETAIL RIWAYAT LATIHAN -->
    @if($historyDetailSession)
        <div class="fixed inset-0 z-[125] flex items-center justify-center p-4 bg-black/70 backdrop-blur-xs">
            <div class="w-full max-w-lg bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] shadow-2xl overflow-hidden">
                <div class="p-5 border-b border-[#E9E9EC] dark:border-[#342427] flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">{{ $historyDetailSession->name }}</h3>
                        <p class="text-xs text-[#777777] dark:text-[#AAA0A2]">Detail Pelaksanaan Latihan</p>
                    </div>
                    <button type="button" wire:click="closeHistoryDetail" class="p-1.5 text-[#777777] hover:text-[#E54855] cursor-pointer">&times;</button>
                </div>

                <div class="p-5 space-y-4">
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div class="p-3 rounded-xl bg-[#F7F7F8] dark:bg-[#251518]">
                            <span class="text-[#777777] dark:text-[#AAA0A2] block">Tanggal Jadwal</span>
                            <strong class="text-[#202124] dark:text-[#F5F5F5]">{{ \App\Models\WorkoutSession::formatIndonesianDate($historyDetailSession->scheduled_date) }}</strong>
                        </div>
                        <div class="p-3 rounded-xl bg-[#F7F7F8] dark:bg-[#251518]">
                            <span class="text-[#777777] dark:text-[#AAA0A2] block">Tanggal Aktual</span>
                            <strong class="text-[#202124] dark:text-[#F5F5F5]">{{ $historyDetailSession->actual_date ? \App\Models\WorkoutSession::formatIndonesianDate($historyDetailSession->actual_date) : '-' }}</strong>
                        </div>
                        <div class="p-3 rounded-xl bg-[#F7F7F8] dark:bg-[#251518]">
                            <span class="text-[#777777] dark:text-[#AAA0A2] block">Status</span>
                            <strong class="text-[#E54855]">{{ $historyDetailSession->statusLabel() }}</strong>
                        </div>
                        <div class="p-3 rounded-xl bg-[#F7F7F8] dark:bg-[#251518]">
                            <span class="text-[#777777] dark:text-[#AAA0A2] block">Durasi</span>
                            <strong class="text-[#202124] dark:text-[#F5F5F5]">{{ $historyDetailSession->formattedDuration() ?? '-' }}</strong>
                        </div>
                    </div>

                    <div class="space-y-2 max-h-60 overflow-y-auto">
                        @forelse($historyDetailSession->items as $item)
                            <div class="px-3.5 py-2.5 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] flex items-center justify-between text-xs">
                                <div>
                                    <div class="font-bold text-[#202124] dark:text-[#F5F5F5]">{{ $item->exercise_name }}</div>
                                    <div class="text-[#777777] dark:text-[#AAA0A2]">{{ $item->target_sets }} Set &times; {{ $item->target_reps }} Reps</div>
                                </div>
                                <span class="px-2 py-0.5 rounded-md font-bold {{ $item->is_completed ? 'bg-[#E54855]/10 text-[#E54855]' : 'bg-white dark:bg-[#1A1012] text-[#777777]' }}">
                                    {{ $item->is_completed ? 'Selesai' : 'Belum' }}
                                </span>
                            </div>
                        @empty
                            <p class="text-xs text-[#777777] dark:text-[#AAA0A2]">Tidak ada rincian gerakan pada sesi ini.</p>
                        @endforelse
                    </div>
                </div>

                <div class="p-4 border-t border-[#E9E9EC] dark:border-[#342427] flex justify-end">
                    <button type="button" wire:click="closeHistoryDetail" class="px-5 py-2 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white text-xs font-bold cursor-pointer">Tutup</button>
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL TAMBAH/EDIT RUTINITAS MINGGUAN (DENGAN PREVIEW GAMBAR UKURAN SEDANG DARI DATABASE) -->
    @if($showRoutineModal)
        @php
            $selectedRoutineExercise = $exercises->firstWhere('id', (int) $exercise_id) ?? $exercises->first();
            $selectedRoutineImages = collect([
                $selectedRoutineExercise?->image_1 ?? $selectedRoutineExercise?->icon,
                $selectedRoutineExercise?->image_2,
            ])->filter()->values()->all();
        @endphp
        <div class="fixed inset-0 z-[120] flex items-center justify-center p-4 bg-black/70 backdrop-blur-xs">
            <div class="w-full max-w-lg bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] shadow-2xl overflow-hidden">
                <div class="p-5 border-b border-[#E9E9EC] dark:border-[#342427] flex items-center justify-between">
                    <h3 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">{{ $routine_id ? 'Edit Rutinitas' : 'Tambah ke Rutinitas Mingguan' }}</h3>
                    <button type="button" wire:click="closeRoutineModal" class="p-1.5 text-[#777777] hover:text-[#E54855] cursor-pointer">&times;</button>
                </div>

                <form wire:submit="save" class="p-5 space-y-4">
                    <div class="space-y-2.5">
                        <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2]">1. Pilih Gerakan Workout ({{ $exercises->count() }} Database Tersedia)</label>

                        @if($selectedRoutineExercise)
                            <div wire:key="routine-preview-{{ $selectedRoutineExercise->id }}"
                                 x-data="{
                                     frame: 0,
                                     imgs: @js($selectedRoutineImages)
                                 }"
                                 @mouseenter="if(imgs.length > 1) frame = 1"
                                 @mouseleave="frame = 0"
                                 class="p-3.5 rounded-2xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] flex items-center gap-4">
                                <div class="relative w-20 h-20 sm:w-24 sm:h-24 rounded-xl bg-white dark:bg-[#100809] border border-[#E9E9EC] dark:border-[#342427] p-1.5 flex items-center justify-center shrink-0 overflow-hidden">
                                    @if(count($selectedRoutineImages) > 0)
                                        <img :src="imgs[frame] || '{{ $selectedRoutineImages[0] }}'"
                                             src="{{ $selectedRoutineImages[0] }}"
                                             alt="{{ $selectedRoutineExercise->name }}"
                                             class="w-full h-full object-contain">
                                    @endif
                                    @if(count($selectedRoutineImages) > 1)
                                        <span class="absolute bottom-1 inset-x-1 text-center py-0.5 rounded bg-black/65 text-white text-[9px] font-bold">
                                            Animasi
                                        </span>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1 space-y-1.5">
                                    <div class="text-sm sm:text-base font-extrabold text-[#202124] dark:text-[#F5F5F5] truncate">
                                        {{ $selectedRoutineExercise->name }}
                                    </div>
                                    <div class="flex flex-wrap items-center gap-1.5">
                                        <span class="px-2 py-0.5 rounded-md bg-[#E54855]/10 text-[#E54855] text-[10px] font-extrabold uppercase">
                                            {{ $selectedRoutineExercise->target_muscle ?? 'Umum' }}
                                        </span>
                                        <span class="px-2 py-0.5 rounded-md bg-white dark:bg-[#1A1012] text-[#777777] dark:text-[#AAA0A2] text-[10px] font-bold">
                                            {{ $selectedRoutineExercise->difficulty ?? 'Pemula' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <select wire:model.live="exercise_id" class="w-full px-3.5 py-2.5 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-sm font-semibold text-[#202124] dark:text-[#F5F5F5]">
                            @foreach($exercises as $ex)
                                <option value="{{ $ex->id }}">{{ $ex->name }} ({{ $ex->target_muscle }})</option>
                            @endforeach
                        </select>
                        @error('exercise_id') <span class="text-xs text-[#E54855] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1">Hari Latihan Rutin</label>
                        <select wire:model="day_of_week" class="w-full px-3.5 py-2.5 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-sm text-[#202124] dark:text-[#F5F5F5]">
                            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $d)
                                <option value="{{ $d }}">{{ $d }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1">Jumlah Set</label>
                            <input type="number" wire:model="sets" min="1" max="50" class="w-full px-3.5 py-2.5 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-sm text-[#202124] dark:text-[#F5F5F5]">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1">Target Repetisi</label>
                            <input type="text" wire:model="reps" class="w-full px-3.5 py-2.5 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-sm text-[#202124] dark:text-[#F5F5F5]">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1">Catatan (Opsional)</label>
                        <textarea wire:model="notes" rows="2" class="w-full px-3.5 py-2.5 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-sm text-[#202124] dark:text-[#F5F5F5]"></textarea>
                    </div>

                    <div class="flex justify-end gap-2.5 pt-3 border-t border-[#E9E9EC] dark:border-[#342427]">
                        <button type="button" wire:click="closeRoutineModal" class="px-4 py-2.5 rounded-xl bg-[#F1F1F4] dark:bg-[#251518] text-sm font-semibold text-[#202124] dark:text-[#F5F5F5] cursor-pointer">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white text-sm font-bold cursor-pointer">Simpan ke Jadwal Latihan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
