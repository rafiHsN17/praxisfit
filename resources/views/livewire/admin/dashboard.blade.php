<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#202124] dark:text-[#F5F5F5] tracking-tight">
                Admin <span class="text-[#E54855]">Dashboard</span>
            </h1>
            <p class="mt-1 text-sm text-[#777777] dark:text-[#AAA0A2]">
                Ringkasan data katalog gerakan, nutrisi TKPI, tujuan latihan, FAQ, dan pesan bantuan pengguna.
            </p>
        </div>
    </div>

    <!-- STAT CARDS GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <a href="{{ route('admin.exercises') }}" wire:navigate class="bg-white dark:bg-[#1A1012] rounded-2xl p-5 border border-[#E9E9EC] dark:border-[#342427] hover:border-[#E54855] transition-colors space-y-3 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="w-10 h-10 rounded-xl bg-[#E54855]/10 text-[#E54855] flex items-center justify-center font-bold text-sm">EX</span>
                <span class="text-2xl font-extrabold text-[#202124] dark:text-[#F5F5F5]">{{ $exerciseCount }}</span>
            </div>
            <div>
                <h3 class="text-sm font-bold text-[#202124] dark:text-[#F5F5F5]">Katalog Gerakan</h3>
                <p class="text-xs text-[#777777] dark:text-[#AAA0A2] mt-0.5">Kelola gerakan, kategori &amp; alat.</p>
            </div>
        </a>

        <a href="{{ route('admin.protein-sources') }}" wire:navigate class="bg-white dark:bg-[#1A1012] rounded-2xl p-5 border border-[#E9E9EC] dark:border-[#342427] hover:border-[#E54855] transition-colors space-y-3 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="w-10 h-10 rounded-xl bg-[#E54855]/10 text-[#E54855] flex items-center justify-center font-bold text-sm">NT</span>
                <span class="text-2xl font-extrabold text-[#202124] dark:text-[#F5F5F5]">{{ $proteinSourceCount }}</span>
            </div>
            <div>
                <h3 class="text-sm font-bold text-[#202124] dark:text-[#F5F5F5]">Sumber Nutrisi</h3>
                <p class="text-xs text-[#777777] dark:text-[#AAA0A2] mt-0.5">Protein, kalori, lemak &amp; karbohidrat.</p>
            </div>
        </a>

        <a href="{{ route('admin.faqs') }}" wire:navigate class="bg-white dark:bg-[#1A1012] rounded-2xl p-5 border border-[#E9E9EC] dark:border-[#342427] hover:border-[#E54855] transition-colors space-y-3 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="w-10 h-10 rounded-xl bg-[#E54855]/10 text-[#E54855] flex items-center justify-center font-bold text-sm">FQ</span>
                <span class="text-2xl font-extrabold text-[#202124] dark:text-[#F5F5F5]">{{ $faqCount }}</span>
            </div>
            <div>
                <h3 class="text-sm font-bold text-[#202124] dark:text-[#F5F5F5]">Pertanyaan FAQ</h3>
                <p class="text-xs text-[#777777] dark:text-[#AAA0A2] mt-0.5">Kelola kategori &amp; sumber Indonesia.</p>
            </div>
        </a>

        <a href="{{ route('admin.goals') }}" wire:navigate class="bg-white dark:bg-[#1A1012] rounded-2xl p-5 border border-[#E9E9EC] dark:border-[#342427] hover:border-[#E54855] transition-colors space-y-3 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="w-10 h-10 rounded-xl bg-[#E54855]/10 text-[#E54855] flex items-center justify-center font-bold text-sm">GL</span>
                <span class="text-2xl font-extrabold text-[#202124] dark:text-[#F5F5F5]">{{ $goalCount }}</span>
            </div>
            <div>
                <h3 class="text-sm font-bold text-[#202124] dark:text-[#F5F5F5]">Tujuan Latihan</h3>
                <p class="text-xs text-[#777777] dark:text-[#AAA0A2] mt-0.5">Rekomendasi split rutin mingguan.</p>
            </div>
        </a>
    </div>

    <!-- SUPPORT MESSAGES INBOX -->
    <div class="bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] overflow-hidden shadow-xs">
        <div class="px-6 py-4 border-b border-[#E9E9EC] dark:border-[#342427] flex items-center justify-between">
            <div>
                <h2 class="text-base font-extrabold text-[#202124] dark:text-[#F5F5F5]">Pesan Bantuan Pengguna</h2>
                <p class="text-xs text-[#777777] dark:text-[#AAA0A2]">Laporan yang dikirim melalui halaman FAQ &amp; Pusat Bantuan.</p>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-[#E54855]/10 text-[#E54855]">
                {{ $newSupportCount }} Baru
            </span>
        </div>

        <div class="divide-y divide-[#E9E9EC] dark:divide-[#342427]">
            @forelse($recentSupportMessages as $msg)
                <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-[#202124] dark:text-[#F5F5F5]">{{ $msg->subject }}</span>
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold uppercase {{ $msg->status === 'resolved' ? 'bg-[#F7F7F8] dark:bg-[#251518] text-[#777777] dark:text-[#AAA0A2]' : 'bg-[#E54855] text-white' }}">
                                {{ $msg->status === 'resolved' ? 'Selesai' : 'Baru' }}
                            </span>
                        </div>
                        <p class="text-xs text-[#777777] dark:text-[#AAA0A2]">{{ $msg->message }}</p>
                        <div class="text-[11px] text-[#777777] dark:text-[#AAA0A2]">
                            Dari: <strong>{{ $msg->name }}</strong> ({{ $msg->email }}) &bull; {{ $msg->created_at?->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB
                        </div>
                    </div>

                    <button type="button" wire:click="markSupportRead({{ $msg->id }})"
                            class="px-3.5 py-2 rounded-xl border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#251518] hover:border-[#E54855] text-xs font-bold text-[#202124] dark:text-[#F5F5F5] shrink-0 cursor-pointer">
                        {{ $msg->status === 'resolved' ? 'Tandai Baru' : 'Tandai Selesai' }}
                    </button>
                </div>
            @empty
                <div class="p-8 text-center text-xs text-[#777777] dark:text-[#AAA0A2]">
                    Belum ada pesan bantuan yang masuk.
                </div>
            @endforelse
        </div>
    </div>
</div>
