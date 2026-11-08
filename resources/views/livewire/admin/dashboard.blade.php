<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-black text-zinc-900 dark:text-zinc-100">
            Admin <span class="text-lime-500">Dashboard</span>
        </h1>
        <p class="mt-2 text-zinc-500 dark:text-zinc-400">
            Selamat datang di panel kontrol utama PraxisFit.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="bg-white dark:bg-zinc-900 rounded-3xl p-6 border border-zinc-200 dark:border-zinc-800 shadow-sm hover:border-lime-500 transition-colors">
            <div class="w-12 h-12 rounded-full bg-lime-100 dark:bg-lime-900/30 text-lime-600 dark:text-lime-400 flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">Manajemen Latihan</h3>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-2">Kelola katalog latihan beban dan calisthenics.</p>
            <a href="{{ route('admin.exercises') }}" class="mt-4 inline-block text-sm font-bold text-lime-600 dark:text-lime-400 hover:underline">Kelola &rarr;</a>
        </div>

        <div class="bg-white dark:bg-zinc-900 rounded-3xl p-6 border border-zinc-200 dark:border-zinc-800 shadow-sm hover:border-lime-500 transition-colors">
            <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">Manajemen FAQ</h3>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-2">Kelola pertanyaan umum untuk para pengguna.</p>
            <a href="{{ route('admin.faqs') }}" class="mt-4 inline-block text-sm font-bold text-blue-600 dark:text-blue-400 hover:underline">Kelola &rarr;</a>
        </div>

        <!-- Role & Permission Section (For future implementation) -->
        <div class="bg-white dark:bg-zinc-900 rounded-3xl p-6 border border-zinc-200 dark:border-zinc-800 shadow-sm hover:border-purple-500 transition-colors">
            <div class="w-12 h-12 rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">Akses & Peran</h3>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-2">Atur role & permission untuk tim admin Anda.</p>
            <a href="#" class="mt-4 inline-block text-sm font-bold text-purple-600 dark:text-purple-400 hover:underline opacity-50 cursor-not-allowed">Segera Hadir &rarr;</a>
        </div>
    </div>
</div>
