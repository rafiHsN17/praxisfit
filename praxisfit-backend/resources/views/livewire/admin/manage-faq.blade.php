<div class="max-w-6xl mx-auto py-8 px-4 sm:px-0 space-y-6">

    <!-- Header Section -->
    <div class="space-y-2 mb-8">
        <h1 class="text-3xl font-black tracking-tight text-zinc-900 dark:text-zinc-100">
            Kelola <span class="text-red-600 dark:text-lime-400">FAQ</span>
        </h1>
        <p class="text-sm text-zinc-500 dark:text-zinc-400">
            Pusat manajemen pertanyaan yang sering diajukan.
        </p>
    </div>

    <!-- Feedback Message -->
    @if (session()->has('message'))
        <div class="p-4 flex items-center gap-3 text-sm font-bold text-lime-800 bg-lime-50 border border-lime-200 rounded-2xl dark:bg-lime-500/10 dark:text-lime-400 dark:border-lime-500/20 shadow-sm animate-pulse mb-6" role="alert">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Form -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow border border-zinc-200 dark:border-zinc-800 p-6 sticky top-24">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-zinc-100 mb-6 border-b border-zinc-200 dark:border-zinc-800 pb-4">
                    {{ $isEditMode ? 'Edit FAQ' : 'Tambah FAQ Baru' }}
                </h2>

                <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}" class="space-y-5">
                    
                    <div>
                        <label for="question" class="block text-[11px] font-bold tracking-widest text-zinc-500 dark:text-zinc-400 uppercase mb-2">
                            Pertanyaan
                        </label>
                        <input type="text" id="question" wire:model="question" placeholder="Ketik pertanyaan..." 
                               class="w-full rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white px-4 py-3 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-600 dark:focus:ring-lime-400 focus:border-transparent">
                        @error('question') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="answer" class="block text-[11px] font-bold tracking-widest text-zinc-500 dark:text-zinc-400 uppercase mb-2">
                            Jawaban
                        </label>
                        <textarea id="answer" wire:model="answer" rows="5" placeholder="Ketik jawaban..." 
                                  class="w-full rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white px-4 py-3 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-600 dark:focus:ring-lime-400 focus:border-transparent"></textarea>
                        @error('answer') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-2 flex flex-col gap-3">
                        <button type="submit" 
                                class="w-full px-6 py-3 rounded-xl font-bold transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg bg-zinc-900 text-white hover:bg-red-600 dark:bg-lime-400 dark:text-zinc-950 dark:hover:bg-lime-500 flex items-center justify-center gap-2">
                            <span wire:loading.remove wire:target="store, update">
                                {{ $isEditMode ? 'Perbarui FAQ' : 'Simpan FAQ' }}
                            </span>
                            <span wire:loading wire:target="store, update" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Menyimpan...
                            </span>
                        </button>
                        
                        @if($isEditMode)
                            <button type="button" wire:click="cancelEdit" 
                                    class="w-full px-6 py-3 rounded-xl font-bold transition-all duration-300 bg-zinc-100 text-zinc-600 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700">
                                Batal Edit
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Column: Data Table -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow overflow-hidden border border-zinc-200 dark:border-zinc-800">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-800 text-xs font-bold tracking-wider uppercase text-zinc-500 dark:text-zinc-400">
                                <th class="px-6 py-4">Pertanyaan</th>
                                <th class="px-6 py-4">Jawaban</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800 text-sm">
                            @forelse($faqs as $faq)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition-colors">
                                    <td class="px-6 py-4 text-zinc-900 dark:text-zinc-100 font-semibold align-top w-1/3">
                                        {{ $faq->question }}
                                    </td>
                                    <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400 align-top">
                                        {{ Str::limit($faq->answer, 80) }}
                                    </td>
                                    <td class="px-6 py-4 align-top text-right space-x-3 whitespace-nowrap">
                                        <button wire:click="edit({{ $faq->id }})" class="font-bold text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                                            Edit
                                        </button>
                                        <button wire:click="delete({{ $faq->id }})" wire:confirm="Yakin ingin menghapus FAQ ini?" class="font-bold text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-zinc-500 dark:text-zinc-400">
                                        Belum ada data FAQ yang ditambahkan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
