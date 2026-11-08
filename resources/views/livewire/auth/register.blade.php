<div class="w-full max-w-xl mx-auto bg-white dark:bg-zinc-900 rounded-2xl sm:rounded-3xl border border-zinc-200/90 dark:border-zinc-800 p-6 sm:p-9 lg:p-10 shadow-xl shadow-red-950/5 dark:shadow-[0_0_20px_rgba(16,185,129,0.12)] transition-all duration-300">

    <!-- Logo Resmi PraxisFit (Kiri Atas) -->
    <div class="mb-5">
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

    <!-- Header Halaman Daftar -->
    <div class="mb-7">
        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
            Daftar Akun
        </h1>
        <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1.5">
            Lengkapi data di bawah ini untuk membuat akun PraxisFit dan mulai latihan.
        </p>
    </div>

    <!-- Form Daftar (5 Input dalam Grid 2 Kolom Responsif) -->
    <form wire:submit="register" class="space-y-5">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">

            <!-- 1. Nama Lengkap -->
            <div>
                <label for="signup-fullname" class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">
                    Nama Lengkap
                </label>
                <input
                    id="signup-fullname"
                    wire:model="name"
                    type="text"
                    placeholder="Masukkan nama..."
                    autocomplete="name"
                    required
                    class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-white dark:bg-zinc-950/80 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 dark:placeholder-zinc-500 border border-zinc-200 dark:border-zinc-800 focus:outline-none focus:border-red-600 dark:focus:border-emerald-500 focus:ring-2 focus:ring-red-600/15 dark:focus:ring-emerald-500/20 transition-colors"
                >
                @error('name')
                    <span class="text-red-600 dark:text-red-400 text-xs font-medium mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- 2. Email -->
            <div>
                <label for="signup-email" class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">
                    Email
                </label>
                <input
                    id="signup-email"
                    wire:model="email"
                    type="email"
                    placeholder="contoh@gmail.com"
                    autocomplete="email"
                    required
                    class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-white dark:bg-zinc-950/80 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 dark:placeholder-zinc-500 border border-zinc-200 dark:border-zinc-800 focus:outline-none focus:border-red-600 dark:focus:border-emerald-500 focus:ring-2 focus:ring-red-600/15 dark:focus:ring-emerald-500/20 transition-colors"
                >
                @error('email')
                    <span class="text-red-600 dark:text-red-400 text-xs font-medium mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- 3. Nomor Telepon (+62 Bendera Indonesia, 2 Kolom Seimbang) -->
            <div class="md:col-span-2">
                <label for="signup-phone" class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">
                    Nomor Telepon
                </label>
                <div class="flex items-center rounded-xl bg-white dark:bg-zinc-950/80 border border-zinc-200 dark:border-zinc-800 focus-within:border-red-600 dark:focus-within:border-emerald-500 focus-within:ring-2 focus-within:ring-red-600/15 dark:focus-within:ring-emerald-500/20 transition-colors overflow-hidden">
                    <div class="flex items-center gap-2 pl-3.5 pr-3 py-2.5 border-r border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/80 select-none shrink-0">
                        <svg class="w-5 h-3.5 rounded-[2px] ring-1 ring-zinc-300/80 dark:ring-zinc-700 shrink-0" viewBox="0 0 20 14" fill="none" aria-hidden="true">
                            <rect width="20" height="7" fill="#DC2626"/>
                            <rect y="7" width="20" height="7" fill="#FFFFFF"/>
                        </svg>
                        <span class="text-xs sm:text-sm font-medium text-zinc-700 dark:text-zinc-300">+62</span>
                    </div>
                    <input
                        id="signup-phone"
                        wire:model="phone"
                        type="tel"
                        placeholder="812-3456-7890"
                        autocomplete="tel"
                        required
                        class="w-full px-3.5 py-2.5 text-sm bg-transparent text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 dark:placeholder-zinc-500 focus:outline-none"
                    >
                </div>
                @error('phone')
                    <span class="text-red-600 dark:text-red-400 text-xs font-medium mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- 4. Password -->
            <div>
                <label for="signup-password" class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">
                    Password
                </label>
                <input
                    id="signup-password"
                    wire:model="password"
                    type="password"
                    placeholder="Minimal 6 karakter..."
                    autocomplete="new-password"
                    required
                    class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-white dark:bg-zinc-950/80 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 dark:placeholder-zinc-500 border border-zinc-200 dark:border-zinc-800 focus:outline-none focus:border-red-600 dark:focus:border-emerald-500 focus:ring-2 focus:ring-red-600/15 dark:focus:ring-emerald-500/20 transition-colors"
                >
                @error('password')
                    <span class="text-red-600 dark:text-red-400 text-xs font-medium mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- 5. Konfirmasi Password -->
            <div>
                <label for="signup-password-confirmation" class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">
                    Konfirmasi Password
                </label>
                <input
                    id="signup-password-confirmation"
                    wire:model="password_confirmation"
                    type="password"
                    placeholder="Ulangi password..."
                    autocomplete="new-password"
                    required
                    class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-white dark:bg-zinc-950/80 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 dark:placeholder-zinc-500 border border-zinc-200 dark:border-zinc-800 focus:outline-none focus:border-red-600 dark:focus:border-emerald-500 focus:ring-2 focus:ring-red-600/15 dark:focus:ring-emerald-500/20 transition-colors"
                >
            </div>

        </div>

        <!-- Tombol Aksi: Batal & Daftar -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 pt-2">
            <button
                type="button"
                wire:click="resetForm"
                class="w-full py-2.5 sm:py-3 px-4 rounded-xl text-sm font-semibold text-zinc-700 dark:text-zinc-200 bg-white dark:bg-zinc-950/60 hover:bg-zinc-50 dark:hover:bg-zinc-800 border border-zinc-200 dark:border-zinc-800 transition-colors cursor-pointer"
            >
                Batal
            </button>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="w-full py-2.5 sm:py-3 px-4 rounded-xl text-sm font-semibold text-white bg-red-600 hover:bg-red-700 dark:bg-emerald-600 dark:hover:bg-emerald-500 shadow-md shadow-red-600/20 dark:shadow-emerald-600/20 transition-all flex items-center justify-center cursor-pointer disabled:opacity-60"
            >
                <span wire:loading.remove wire:target="register">Daftar</span>
                <span wire:loading wire:target="register">Memproses...</span>
            </button>
        </div>
    </form>

    <!-- Link Bawah ke Halaman Masuk -->
    <div class="mt-6 text-center text-xs sm:text-sm text-zinc-500 dark:text-zinc-400">
        <span>Sudah punya akun?</span>
        <a href="{{ route('login') }}" wire:navigate
           class="font-bold text-red-600 hover:text-red-700 dark:text-emerald-400 dark:hover:text-emerald-300 hover:underline ml-1">
            Masuk
        </a>
    </div>

</div>
