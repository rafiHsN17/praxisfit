<div class="w-full max-w-md mx-auto bg-white dark:bg-zinc-900 rounded-2xl sm:rounded-3xl border border-zinc-200/90 dark:border-zinc-800 p-6 sm:p-9 shadow-xl shadow-red-950/5 dark:shadow-[0_0_20px_rgba(16,185,129,0.12)] transition-all duration-300">

    <!-- Logo Resmi PraxisFit (Tengah) -->
    <div class="flex justify-center mb-5">
        <a href="{{ url('/') }}" wire:navigate class="inline-flex items-center gap-2.5 group">
            <div class="w-11 h-11 rounded-2xl bg-red-600 dark:bg-zinc-950 border border-red-600 dark:border-zinc-800 flex items-center justify-center shadow-sm shadow-red-600/20 dark:shadow-none transition-transform duration-300 group-hover:scale-105">
                <svg viewBox="0 0 400 240" fill="none" class="w-7 h-7 text-white dark:text-emerald-400" aria-hidden="true">
                    <path d="M117.8 200 H163.4 L185.3 125.7 H214.5 C249.2 125.7 268 111.8 274.6 85.9 C282.3 56 261 40 224.2 40 H164.7 L117.8 200 Z M195.1 92.5 H175 L186.2 55.4 H203.4 C218.4 55.4 226.7 60 223.3 73.1 C220 86.1 210.1 92.5 195.1 92.5 Z" fill="currentColor"/>
                    <polygon points="50,45 170,105 145,115 315,185 165,130 190,120" fill="currentColor"/>
                </svg>
            </div>
            <span class="font-bold text-2xl tracking-tight text-zinc-900 dark:text-zinc-100">
                Praxis<span class="text-red-600 dark:text-emerald-500">Fit</span>
            </span>
        </a>
    </div>

    <!-- Header Halaman Masuk -->
    <div class="text-center mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
            Selamat Datang
        </h1>
        <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1.5 leading-relaxed">
            Senang melihat Anda kembali &#128075;<br>
            Masuk ke akun PraxisFit Anda di bawah ini
        </p>
    </div>

    <!-- Tombol Visual Statis Google (Tanpa Fungsi OAuth) -->
    <div class="mb-5">
        <button
            type="button"
            class="w-full py-2.5 px-4 rounded-xl bg-white dark:bg-zinc-950/70 hover:bg-zinc-50 dark:hover:bg-zinc-800/80 text-zinc-800 dark:text-zinc-100 border border-zinc-200 dark:border-zinc-800 text-xs sm:text-sm font-medium flex items-center justify-center gap-2.5 transition-colors cursor-default"
        >
            <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                <path fill="#4285F4" d="M23.49 12.27c0-.79-.07-1.54-.19-2.27H12v4.51h6.47c-.29 1.48-1.14 2.73-2.4 3.58v3h3.86c2.26-2.09 3.56-5.17 3.56-8.82z"/>
                <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.86-3c-1.08.72-2.45 1.16-4.07 1.16-3.13 0-5.78-2.11-6.73-4.96H1.29v3.09C3.26 21.3 7.31 24 12 24z"/>
                <path fill="#FBBC05" d="M5.27 14.29c-.25-.72-.38-1.49-.38-2.29s.13-1.57.38-2.29V6.62H1.29C.47 8.24 0 10.06 0 12s.47 3.76 1.29 5.38l3.98-3.09z"/>
                <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.31 0 3.26 2.7 1.29 6.62l3.98 3.09c.95-2.85 3.6-4.96 6.73-4.96z"/>
            </svg>
            <span>Lanjutkan dengan Google</span>
        </button>
    </div>

    <!-- Form Masuk -->
    <form wire:submit="login" class="space-y-4">

        <!-- Email -->
        <div>
            <label for="login-email" class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">
                Email
            </label>
            <input
                id="login-email"
                wire:model="email"
                type="email"
                placeholder="Masukkan email..."
                autocomplete="email"
                required
                class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-white dark:bg-zinc-950/80 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 dark:placeholder-zinc-500 border border-zinc-200 dark:border-zinc-800 focus:outline-none focus:border-red-600 dark:focus:border-emerald-500 focus:ring-2 focus:ring-red-600/15 dark:focus:ring-emerald-500/20 transition-colors"
            >
            @error('email')
                <span class="text-red-600 dark:text-red-400 text-xs font-medium mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="login-password" class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">
                Password
            </label>
            <input
                id="login-password"
                wire:model="password"
                type="password"
                placeholder="Masukkan password..."
                autocomplete="current-password"
                required
                class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-white dark:bg-zinc-950/80 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 dark:placeholder-zinc-500 border border-zinc-200 dark:border-zinc-800 focus:outline-none focus:border-red-600 dark:focus:border-emerald-500 focus:ring-2 focus:ring-red-600/15 dark:focus:ring-emerald-500/20 transition-colors"
            >
            @error('password')
                <span class="text-red-600 dark:text-red-400 text-xs font-medium mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Tombol Masuk -->
        <div class="pt-2">
            <button
                type="submit"
                wire:loading.attr="disabled"
                class="w-full py-2.5 sm:py-3 px-4 rounded-xl text-sm font-semibold text-white bg-red-600 hover:bg-red-700 dark:bg-emerald-600 dark:hover:bg-emerald-500 shadow-md shadow-red-600/20 dark:shadow-emerald-600/20 transition-all flex items-center justify-center cursor-pointer disabled:opacity-60"
            >
                <span wire:loading.remove wire:target="login">Masuk</span>
                <span wire:loading wire:target="login">Memproses...</span>
            </button>
        </div>
    </form>

    <!-- Link Bawah ke Halaman Daftar -->
    <div class="mt-6 text-center text-xs sm:text-sm text-zinc-500 dark:text-zinc-400">
        <span>Belum punya akun?</span>
        <a href="{{ route('register') }}" wire:navigate
           class="font-bold text-red-600 hover:text-red-700 dark:text-emerald-400 dark:hover:text-emerald-300 hover:underline ml-1">
            Daftar
        </a>
    </div>

</div>
