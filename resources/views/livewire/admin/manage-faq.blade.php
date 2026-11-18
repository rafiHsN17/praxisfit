<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div class="space-y-1">
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-[#202124] dark:text-[#F5F5F5]">
                Kelola <span class="text-[#E54855]">FAQ &amp; Pusat Bantuan</span>
            </h1>
            <p class="text-sm text-[#777777] dark:text-[#AAA0A2]">
                Tambah, ubah pertanyaan, jawaban, judul kategori, hingga sumber referensi Indonesia secara langsung.
            </p>
        </div>

        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] text-xs font-medium">
            <span class="text-[#777777] dark:text-[#AAA0A2]">Total Database:</span>
            <span class="text-[#202124] dark:text-[#F5F5F5] font-extrabold">{{ $totalFaqs }} FAQ</span>
            <span class="text-[#E9E9EC] dark:text-[#342427]">&bull;</span>
            <span class="text-[#E54855] font-bold">{{ count($categoryCounts) }} Judul</span>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="p-4 flex items-center gap-3 text-sm font-semibold text-[#C93646] dark:text-[#E54855] bg-[#E54855]/10 border border-[#E54855]/30 rounded-xl" role="alert">
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Left Column: Form Tambah/Edit FAQ & Rename Kategori -->
        <div class="lg:col-span-5 space-y-5 lg:sticky lg:top-20">
            <div class="bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] p-6 shadow-xs">
                <div class="flex items-center justify-between mb-5 border-b border-[#E9E9EC] dark:border-[#342427] pb-4">
                    <h2 class="text-lg font-extrabold text-[#202124] dark:text-[#F5F5F5]">
                        {{ $isEditMode ? 'Edit Data FAQ' : 'Tambah FAQ Baru' }}
                    </h2>
                    @if($isEditMode)
                        <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-[#E54855]/10 text-[#E54855]">
                            Mode Edit #{{ $faq_id }}
                        </span>
                    @endif
                </div>

                <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}" class="space-y-4">
                    <div>
                        <label for="kategori" class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] uppercase mb-1.5">Judul Kategori</label>
                        <select id="kategori" wire:model.live="kategori"
                                class="w-full rounded-xl border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] px-3.5 py-2.5 text-sm font-semibold focus:outline-none focus:border-[#E54855]">
                            @foreach($availableCategories as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                            <option value="__baru__">+ Buat Judul Kategori Baru...</option>
                        </select>
                        @error('kategori') <span class="text-xs text-[#E54855] font-semibold mt-1 block">{{ $message }}</span> @enderror

                        @if($kategori === '__baru__')
                            <div class="mt-2.5">
                                <input type="text" wire:model="kategori_baru" placeholder="Contoh: Tips Latihan Kalistenik..."
                                       class="w-full rounded-xl border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#E54855]">
                                @error('kategori_baru') <span class="text-xs text-[#E54855] font-semibold mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        @endif
                    </div>

                    <div>
                        <label for="pertanyaan" class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] uppercase mb-1.5">Pertanyaan</label>
                        <input type="text" id="pertanyaan" wire:model="pertanyaan" placeholder="Ketik pertanyaan pengguna..."
                               class="w-full rounded-xl border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#E54855]">
                        @error('pertanyaan') <span class="text-xs text-[#E54855] font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="jawaban_singkat" class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] uppercase mb-1.5">Jawaban / Penjelasan</label>
                        <textarea id="jawaban_singkat" wire:model="jawaban_singkat" rows="4" placeholder="Tulis jawaban jelas dan ringkas..."
                                  class="w-full rounded-xl border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#E54855]"></textarea>
                        @error('jawaban_singkat') <span class="text-xs text-[#E54855] font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="contoh" class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] uppercase mb-1.5">Contoh Praktis (Opsional)</label>
                        <textarea id="contoh" wire:model="contoh" rows="2" placeholder="Contoh penerapan sehari-hari..."
                                  class="w-full rounded-xl border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#E54855]"></textarea>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label for="sumber_nama" class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] uppercase mb-1.5">Nama Sumber Referensi (Indonesia)</label>
                            <input type="text" id="sumber_nama" wire:model="sumber_nama" placeholder="Cth: Ade Rai / Alodokter"
                                   class="w-full rounded-xl border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#E54855]">
                            @error('sumber_nama') <span class="text-xs text-[#E54855] font-semibold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="sumber_url" class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] uppercase mb-1.5">Link URL Sumber</label>
                            <input type="url" id="sumber_url" wire:model="sumber_url" placeholder="https://www.alodokter.com/..."
                                   class="w-full rounded-xl border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#E54855]">
                        </div>
                    </div>

                    <div class="pt-2 flex flex-col gap-2">
                        <button type="submit"
                                class="w-full px-5 py-2.5 rounded-xl font-bold text-sm bg-[#E54855] hover:bg-[#C93646] text-white shadow-sm transition-colors cursor-pointer">
                            {{ $isEditMode ? 'Simpan Perubahan FAQ' : 'Tambahkan ke Daftar FAQ' }}
                        </button>
                        @if($isEditMode)
                            <button type="button" wire:click="cancelEdit"
                                    class="w-full px-5 py-2.5 rounded-xl font-semibold text-sm bg-[#F1F1F4] dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] cursor-pointer">
                                Batal Edit
                            </button>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Rename Category Card -->
            <div class="bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] p-5 shadow-xs" x-data="{ openRename: false }">
                <button type="button" @click="openRename = !openRename" class="w-full flex items-center justify-between text-left cursor-pointer">
                    <div>
                        <h3 class="text-sm font-extrabold text-[#202124] dark:text-[#F5F5F5]">Ganti Nama Judul Kategori</h3>
                        <p class="text-xs text-[#777777] dark:text-[#AAA0A2] mt-0.5">Ubah judul bagian sekaligus untuk semua FAQ di dalamnya.</p>
                    </div>
                    <span class="text-xs font-bold text-[#E54855]" x-text="openRename ? 'Tutup' : 'Buka'"></span>
                </button>

                <form x-show="openRename" x-cloak wire:submit.prevent="renameCategory" class="mt-4 pt-4 border-t border-[#E9E9EC] dark:border-[#342427] space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1">Pilih Judul Saat Ini</label>
                        <select wire:model="renameTargetKey" class="w-full rounded-xl border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#251518] text-sm px-3.5 py-2.5 text-[#202124] dark:text-[#F5F5F5]">
                            <option value="">-- Pilih Judul Kategori --</option>
                            @foreach($categoryCounts as $catKey => $count)
                                <option value="{{ $catKey }}">{{ \App\Models\Faq::categoryLabel($catKey) }} ({{ $count }} FAQ)</option>
                            @endforeach
                        </select>
                        @error('renameTargetKey') <span class="text-xs text-[#E54855] font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#777777] dark:text-[#AAA0A2] mb-1">Judul Baru</label>
                        <input type="text" wire:model="renameNewTitle" placeholder="Ketik nama judul baru..." class="w-full rounded-xl border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#251518] text-sm px-3.5 py-2.5 text-[#202124] dark:text-[#F5F5F5]">
                        @error('renameNewTitle') <span class="text-xs text-[#E54855] font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full px-4 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-[#E54855] hover:bg-[#C93646] text-white cursor-pointer">
                        Simpan Judul Baru
                    </button>
                </form>
            </div>
        </div>

        <!-- Right Column: Search & List -->
        <div class="lg:col-span-7 space-y-4">
            <div class="bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] p-4 shadow-xs">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1 relative">
                        <input type="text" wire:model.live.debounce.250ms="search" placeholder="Cari pertanyaan, jawaban, atau sumber..."
                               class="w-full rounded-xl border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] pl-9 pr-4 py-2.5 text-sm focus:outline-none focus:border-[#E54855]">
                        <svg class="w-4 h-4 text-[#777777] absolute left-3 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16.5 10.5a6 6 0 11-12 0 6 6 0 0112 0z"/>
                        </svg>
                    </div>

                    <select wire:model.live="filterKategori"
                            class="sm:w-64 rounded-xl border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] px-3.5 py-2.5 text-sm font-semibold focus:outline-none focus:border-[#E54855]">
                        <option value="">Semua Judul ({{ $totalFaqs }})</option>
                        @foreach($categoryCounts as $catKey => $count)
                            <option value="{{ $catKey }}">{{ \App\Models\Faq::categoryLabel($catKey) }} ({{ $count }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="bg-white dark:bg-[#1A1012] rounded-2xl border border-[#E9E9EC] dark:border-[#342427] divide-y divide-[#E9E9EC] dark:divide-[#342427] shadow-xs overflow-hidden">
                @forelse($faqs as $faq)
                    <div wire:key="admin-faq-{{ $faq->id }}" class="p-5 hover:bg-[#F7F7F8]/60 dark:hover:bg-[#251518]/60 transition-colors {{ $faq_id === $faq->id ? 'bg-[#E54855]/5' : '' }}">
                        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 mb-2">
                            <div class="space-y-1.5">
                                <span class="inline-block px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-[#E54855]/10 text-[#E54855]">
                                    {{ \App\Models\Faq::categoryLabel($faq->kategori) }}
                                </span>
                                <h3 class="text-base font-bold text-[#202124] dark:text-[#F5F5F5] leading-snug">
                                    {{ $faq->pertanyaan }}
                                </h3>
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                                <button type="button" wire:click="edit({{ $faq->id }})" onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
                                        class="px-3 py-1.5 rounded-lg text-xs font-bold bg-[#F7F7F8] dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] border border-[#E9E9EC] dark:border-[#342427] hover:border-[#E54855] cursor-pointer">
                                    Edit
                                </button>
                                <button type="button" wire:click="delete({{ $faq->id }})" wire:confirm="Yakin ingin menghapus pertanyaan ini?"
                                        class="px-3 py-1.5 rounded-lg text-xs font-bold bg-[#E54855]/10 text-[#C93646] dark:text-[#E54855] hover:bg-[#E54855]/20 cursor-pointer">
                                    Hapus
                                </button>
                            </div>
                        </div>

                        <p class="text-sm text-[#777777] dark:text-[#AAA0A2] leading-relaxed">
                            {{ \Illuminate\Support\Str::limit($faq->jawaban_singkat, 180) }}
                        </p>

                        <div class="mt-3 pt-2.5 border-t border-[#E9E9EC] dark:border-[#342427] flex flex-wrap items-center justify-between gap-2 text-xs text-[#777777] dark:text-[#AAA0A2]">
                            <span class="truncate max-w-md">Sumber: <strong class="text-[#202124] dark:text-[#F5F5F5]">{{ $faq->sumber_nama }}</strong></span>
                            @if($faq->sumber_url)
                                <a href="{{ $faq->sumber_url }}" target="_blank" rel="noopener noreferrer" class="text-[#E54855] hover:underline font-bold">
                                    Buka Link &nearr;
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-sm text-[#777777] dark:text-[#AAA0A2]">
                        Belum ada data FAQ yang sesuai dengan pencarian atau filter.
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
