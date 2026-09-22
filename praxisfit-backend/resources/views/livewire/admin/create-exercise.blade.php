<div class="max-w-4xl mx-auto py-8 px-4 sm:px-0 space-y-6">

    <!-- Feedback Messages -->
    @if (session()->has('message'))
        <div class="p-4 flex items-center gap-3 text-sm font-bold text-lime-800 bg-lime-50 border border-lime-200 rounded-2xl dark:bg-lime-500/10 dark:text-lime-400 dark:border-lime-500/20 shadow-sm animate-pulse" role="alert">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="p-4 flex items-center gap-3 text-sm font-bold text-red-800 bg-red-50 border border-red-200 rounded-2xl dark:bg-red-500/10 dark:text-red-400 dark:border-red-500/20 shadow-sm animate-pulse" role="alert">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- Main Card -->
    <div class="bg-white dark:bg-zinc-900 rounded-3xl shadow-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
        
        <!-- Header Section -->
        <div class="bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-800 p-6 sm:p-8">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-zinc-900 dark:bg-white rounded-2xl flex items-center justify-center shadow-md">
                    <span class="text-2xl text-white dark:text-zinc-900">🏋️</span>
                </div>
                <div>
                    <h1 class="text-2xl font-black tracking-tight text-zinc-900 dark:text-zinc-100">
                        Tambah <span class="text-red-600 dark:text-lime-400">Gerakan Baru</span>
                    </h1>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                        Sistem Hybrid: Tambahkan video gerakan baru langsung melalui link YouTube.
                    </p>
                </div>
            </div>
        </div>

        <!-- Form Body -->
        <form wire:submit.prevent="save" class="p-6 sm:p-8 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                <!-- Row 1: Name (Full width) -->
                <div class="col-span-1 md:col-span-12">
                    <label for="name" class="block text-[11px] font-bold tracking-widest text-zinc-500 dark:text-zinc-400 uppercase mb-2">
                        Nama Gerakan
                    </label>
                    <input type="text" id="name" wire:model="name" placeholder="Misal: Spiderman Push-up" 
                           class="w-full rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white px-4 py-3 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-600 dark:focus:ring-lime-400 focus:border-transparent">
                    @error('name') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Row 2: Target Muscle (1/2) & Equipment (1/2) -->
                <div class="col-span-1 md:col-span-6">
                    <label for="target_muscle" class="block text-[11px] font-bold tracking-widest text-zinc-500 dark:text-zinc-400 uppercase mb-2">
                        Target Otot
                    </label>
                    <input type="text" id="target_muscle" wire:model="target_muscle" placeholder="Misal: Dada" 
                           class="w-full rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white px-4 py-3 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-600 dark:focus:ring-lime-400 focus:border-transparent">
                    @error('target_muscle') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div class="col-span-1 md:col-span-6">
                    <label for="equipment" class="block text-[11px] font-bold tracking-widest text-zinc-500 dark:text-zinc-400 uppercase mb-2">
                        Equipment
                    </label>
                    <input type="text" id="equipment" wire:model="equipment" placeholder="Misal: Bodyweight" 
                           class="w-full rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white px-4 py-3 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-600 dark:focus:ring-lime-400 focus:border-transparent">
                    @error('equipment') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Row 3: Difficulty (1/3) & YouTube URL (2/3) -->
                <div class="col-span-1 md:col-span-4">
                    <label for="difficulty" class="block text-[11px] font-bold tracking-widest text-zinc-500 dark:text-zinc-400 uppercase mb-2">
                        Tingkat Kesulitan
                    </label>
                    <select id="difficulty" wire:model="difficulty" 
                            class="w-full rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white px-4 py-3 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-600 dark:focus:ring-lime-400 focus:border-transparent">
                        <option value="Pemula">Pemula</option>
                        <option value="Menengah">Menengah</option>
                        <option value="Lanjut">Lanjut</option>
                    </select>
                    @error('difficulty') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div class="col-span-1 md:col-span-8">
                    <label for="youtube_url" class="block text-[11px] font-bold tracking-widest text-zinc-500 dark:text-zinc-400 uppercase mb-2 flex items-center gap-2">
                        YouTube URL <span class="text-[9px] px-1.5 py-0.5 rounded-sm bg-zinc-200 dark:bg-zinc-800 text-zinc-500">Opsional</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-zinc-400">🔗</span>
                        <input type="text" id="youtube_url" wire:model="youtube_url" placeholder="https://www.youtube.com/watch?v=..." 
                               class="w-full pl-11 pr-4 py-3 rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-600 dark:focus:ring-lime-400 focus:border-transparent">
                    </div>
                    @error('youtube_url') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Row 4: Instructions (Full width) -->
                <div class="col-span-1 md:col-span-12">
                    <label for="instructions" class="block text-[11px] font-bold tracking-widest text-zinc-500 dark:text-zinc-400 uppercase mb-2 flex justify-between">
                        <span>Instruksi Pelaksanaan</span>
                        <span class="text-zinc-400 dark:text-zinc-500 font-medium normal-case tracking-normal">Pisahkan dengan baris/titik</span>
                    </label>
                    <textarea id="instructions" wire:model="instructions" rows="5" placeholder="Langkah-langkah eksekusi yang benar..." 
                              class="w-full rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white px-4 py-3 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-600 dark:focus:ring-lime-400 focus:border-transparent"></textarea>
                    @error('instructions') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Submit Action -->
            <div class="pt-6 border-t border-zinc-200 dark:border-zinc-800 flex justify-end">
                <button type="submit" 
                        wire:loading.attr="disabled"
                        class="px-8 py-3 rounded-xl font-bold transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg bg-zinc-900 text-white hover:bg-red-600 dark:bg-lime-400 dark:text-zinc-950 dark:hover:bg-lime-500 flex items-center justify-center gap-2">
                    <span wire:loading.remove wire:target="save">Simpan Gerakan ke Database</span>
                    <span wire:loading wire:target="save" class="flex items-center gap-2">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menyimpan...
                    </span>
                </button>
            </div>

        </form>
    </div>
</div>
