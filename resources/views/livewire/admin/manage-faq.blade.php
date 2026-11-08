<div class="max-w-7xl mx-auto py-4 px-4 sm:px-0 space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-4">
        <div class="space-y-1.5">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                Kelola FAQ & Pusat Bantuan
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Tambah, ubah pertanyaan, jawaban, judul kategori, hingga sumber referensi Indonesia secara langsung.
            </p>
        </div>

        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 text-xs font-medium">
            <span class="text-zinc-500 dark:text-zinc-400">Total Database:</span>
            <span class="text-zinc-900 dark:text-zinc-100 font-bold">{{ $totalFaqs }} FAQ</span>
            <span class="text-zinc-300 dark:text-zinc-700">&bull;</span>
            <span class="text-zinc-600 dark:text-zinc-400">{{ count($categoryCounts) }} Judul</span>
        </div>
    </div>

    <!-- Feedback Message -->
    @if (session()->has('message'))
        <div class="p-3.5 flex items-center gap-3 text-sm font-medium text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-xl dark:bg-zinc-800 dark:text-zinc-200 dark:border-zinc-700" role="alert">
            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- Left Column: Form Tambah/Edit FAQ & Ganti Judul Kategori -->
        <div class="lg:col-span-5 space-y-6 lg:sticky lg:top-20">

            <!-- Card 1: Form Tambah / Edit FAQ -->
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow border border-zinc-200 dark:border-zinc-800 p-6">
                <div class="flex items-center justify-between mb-5 border-b border-zinc-200 dark:border-zinc-800 pb-4">
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">
                        {{ $isEditMode ? 'Edit Data FAQ' : 'Tambah FAQ Baru' }}
                    </h2>
                    @if($isEditMode)
                        <span class="px-2.5 py-1 text-[10px] font-black uppercase tracking-wider rounded-full bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300">
                            Mode Edit #{{ $faq_id }}
                        </span>
                    @endif
                </div>

                <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}" class="space-y-4">

                    <!-- Judul / Kategori -->
                    <div>
                        <label for="kategori" class="block text-[11px] font-bold tracking-widest text-zinc-500 dark:text-zinc-400 uppercase mb-1.5">
                            Judul Kategori
                        </label>
                        <select id="kategori" wire:model.live="kategori"
                                class="w-full rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white px-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-red-600 dark:focus:ring-lime-400">
                            @foreach($availableCategories as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                            <option value="__baru__">+ Buat Judul Kategori Baru...</option>
                        </select>
                        @error('kategori') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror

                        @if($kategori === '__baru__')
                            <div class="mt-2.5">
                                <input type="text" wire:model="kategori_baru" placeholder="Contoh: Tips Latihan Kalistenik..."
                                       class="w-full rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-600 dark:focus:ring-lime-400">
                                @error('kategori_baru') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        @endif
                    </div>

                    <!-- Pertanyaan -->
                    <div>
                        <label for="pertanyaan" class="block text-[11px] font-bold tracking-widest text-zinc-500 dark:text-zinc-400 uppercase mb-1.5">
                            Pertanyaan
                        </label>
                        <input type="text" id="pertanyaan" wire:model="pertanyaan" placeholder="Ketik pertanyaan pengguna..."
                               class="w-full rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-600 dark:focus:ring-lime-400">
                        @error('pertanyaan') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Jawaban Singkat -->
                    <div>
                        <label for="jawaban_singkat" class="block text-[11px] font-bold tracking-widest text-zinc-500 dark:text-zinc-400 uppercase mb-1.5">
                            Jawaban / Penjelasan
                        </label>
                        <textarea id="jawaban_singkat" wire:model="jawaban_singkat" rows="4" placeholder="Tulis jawaban kasual namun profesional..."
                                  class="w-full rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-600 dark:focus:ring-lime-400"></textarea>
                        @error('jawaban_singkat') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Contoh Praktis -->
                    <div>
                        <label for="contoh" class="block text-[11px] font-bold tracking-widest text-zinc-500 dark:text-zinc-400 uppercase mb-1.5">
                            Contoh Praktis (Opsional)
                        </label>
                        <textarea id="contoh" wire:model="contoh" rows="2" placeholder="Contoh penerapan sehari-hari..."
                                  class="w-full rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-600 dark:focus:ring-lime-400"></textarea>
                        @error('contoh') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Sumber Nama & URL -->
                    <div class="grid grid-cols-1 gap-3 pt-1">
                        <div>
                            <label for="sumber_nama" class="block text-[11px] font-bold tracking-widest text-zinc-500 dark:text-zinc-400 uppercase mb-1.5">
                                Nama Sumber Referensi (Indonesia)
                            </label>
                            <input type="text" id="sumber_nama" wire:model="sumber_nama" placeholder="Cth: Ade Rai / dr. Andi Kurniawan, Sp.KO via Alodokter"
                                   class="w-full rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-600 dark:focus:ring-lime-400">
                            @error('sumber_nama') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="sumber_url" class="block text-[11px] font-bold tracking-widest text-zinc-500 dark:text-zinc-400 uppercase mb-1.5">
                                Link URL Sumber
                            </label>
                            <input type="url" id="sumber_url" wire:model="sumber_url" placeholder="https://www.alodokter.com/..."
                                   class="w-full rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-600 dark:focus:ring-lime-400">
                            @error('sumber_url') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="pt-3 flex flex-col gap-2.5">
                        <button type="submit"
                                class="w-full px-5 py-2.5 rounded-xl font-semibold text-sm transition-colors bg-red-600 hover:bg-red-700 dark:bg-emerald-600 dark:hover:bg-emerald-500 text-white shadow-sm flex items-center justify-center gap-2">
                            <span wire:loading.remove wire:target="store, update">
                                {{ $isEditMode ? 'Simpan Perubahan FAQ' : 'Tambahkan ke Daftar FAQ' }}
                            </span>
                            <span wire:loading wire:target="store, update">Menyimpan...</span>
                        </button>

                        @if($isEditMode)
                            <button type="button" wire:click="cancelEdit"
                                    class="w-full px-6 py-2.5 rounded-xl font-bold text-sm transition-all bg-zinc-100 text-zinc-700 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700">
                                Batal Edit
                            </button>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Card 2: Ganti Nama Judul Kategori Sekaligus -->
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow border border-zinc-200 dark:border-zinc-800 p-6" x-data="{ openRename: false }">
                <button type="button" @click="openRename = !openRename" class="w-full flex items-center justify-between text-left">
                    <div>
                        <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100">Ganti Nama Judul Kategori</h3>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Ubah judul bagian sekaligus untuk semua FAQ di dalamnya.</p>
                    </div>
                    <svg class="w-5 h-5 text-zinc-400 transition-transform duration-200" :class="openRename ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <form x-show="openRename" x-cloak wire:submit.prevent="renameCategory" class="mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-800 space-y-3">
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400 mb-1">Pilih Judul Saat Ini</label>
                        <select wire:model="renameTargetKey"
                                class="w-full rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white px-3.5 py-2.5 text-sm">
                            <option value="">-- Pilih Judul Kategori --</option>
                            @foreach($categoryCounts as $catKey => $count)
                                <option value="{{ $catKey }}">{{ \App\Models\Faq::categoryLabel($catKey) }} ({{ $count }} FAQ)</option>
                            @endforeach
                        </select>
                        @error('renameTargetKey') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400 mb-1">Judul Baru</label>
                        <input type="text" wire:model="renameNewTitle" placeholder="Ketik nama judul baru..."
                               class="w-full rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white px-3.5 py-2.5 text-sm">
                        @error('renameNewTitle') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit"
                            class="w-full px-4 py-2.5 rounded-xl font-semibold text-xs uppercase tracking-wider bg-red-600 text-white hover:bg-red-700 dark:bg-emerald-600 dark:hover:bg-emerald-500 transition-colors">
                        Simpan Judul Baru
                    </button>
                </form>
            </div>
        </div>

        <!-- Right Column: Filter, Pencarian & Daftar FAQ -->
        <div class="lg:col-span-7 space-y-4">

            <!-- Filter Bar -->
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-zinc-200 dark:border-zinc-800 p-4 space-y-3">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1 relative">
                        <input type="text" wire:model.live.debounce.250ms="search" placeholder="Cari pertanyaan, jawaban, atau sumber..."
                               class="w-full rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white pl-9 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-600 dark:focus:ring-lime-400">
                        <svg class="w-4 h-4 text-zinc-400 absolute left-3 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16.5 10.5a6 6 0 11-12 0 6 6 0 0112 0z"/>
                        </svg>
                    </div>

                    <select wire:model.live="filterKategori"
                            class="sm:w-64 rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white px-3.5 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-red-600 dark:focus:ring-lime-400">
                        <option value="">Semua Judul ({{ $totalFaqs }})</option>
                        @foreach($categoryCounts as $catKey => $count)
                            <option value="{{ $catKey }}">{{ \App\Models\Faq::categoryLabel($catKey) }} ({{ $count }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Daftar Kartu / Tabel FAQ -->
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow overflow-hidden border border-zinc-200 dark:border-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse($faqs as $faq)
                    <div wire:key="admin-faq-{{ $faq->id }}" class="p-5 hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition-colors {{ $faq_id === $faq->id ? 'bg-zinc-100/70 dark:bg-zinc-800/60' : '' }}">
                        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 mb-2">
                            <div class="space-y-1.5">
                                <span class="inline-block px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-red-50 text-red-600 border border-red-100 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20">
                                    {{ \App\Models\Faq::categoryLabel($faq->kategori) }}
                                </span>
                                <h3 class="text-base font-semibold text-zinc-900 dark:text-zinc-100 leading-snug">
                                    {{ $faq->pertanyaan }}
                                </h3>
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                                <button type="button" wire:click="edit({{ $faq->id }})"
                                        onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
                                        class="px-3 py-1.5 rounded-lg text-xs font-bold bg-blue-50 text-blue-600 hover:bg-blue-100 dark:bg-blue-500/15 dark:text-blue-400 dark:hover:bg-blue-500/25 transition-colors">
                                    Edit
                                </button>
                                <button type="button" wire:click="delete({{ $faq->id }})"
                                        wire:confirm="Yakin ingin menghapus pertanyaan ini?"
                                        class="px-3 py-1.5 rounded-lg text-xs font-bold bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-500/15 dark:text-red-400 dark:hover:bg-red-500/25 transition-colors">
                                    Hapus
                                </button>
                            </div>
                        </div>

                        <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">
                            {{ \Illuminate\Support\Str::limit($faq->jawaban_singkat, 180) }}
                        </p>

                        <div class="mt-3 pt-2.5 border-t border-zinc-100 dark:border-zinc-800/80 flex flex-wrap items-center justify-between gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                            <span class="font-medium truncate max-w-md">
                                Sumber: <strong class="text-zinc-700 dark:text-zinc-300">{{ $faq->sumber_nama }}</strong>
                            </span>
                            @if($faq->sumber_url)
                                <a href="{{ $faq->sumber_url }}" target="_blank" rel="noopener noreferrer" class="text-red-600 dark:text-lime-400 hover:underline font-semibold">
                                    Buka Link &nearr;
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-14 text-center text-zinc-500 dark:text-zinc-400 text-sm">
                        Belum ada data FAQ yang sesuai dengan pencarian atau filter.
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
