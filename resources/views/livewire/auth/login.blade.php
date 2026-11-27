<div class="w-full max-w-md mx-auto bg-white dark:bg-[#1A1012] rounded-3xl border border-[#E9E9EC] dark:border-[#342427] p-7 sm:p-9 shadow-2xl">

    <!-- Logo Resmi PraxisFit (Tengah - Gambar 6) -->
    <div class="flex justify-center mb-6">
        <a href="{{ url('/') }}" wire:navigate class="inline-flex items-center gap-3 group">
            <x-logo-badge size="lg" class="transition-transform duration-300 group-hover:scale-105" />
            <span class="font-extrabold text-2xl tracking-tight text-[#202124] dark:text-[#F5F5F5]">
                Praxis<span class="text-[#E54855]">Fit</span>
            </span>
        </a>
    </div>

    <!-- Header Halaman Masuk -->
    <div class="text-center mb-6 space-y-1">
        <h1 class="text-2xl font-extrabold tracking-tight text-[#202124] dark:text-[#F5F5F5]">
            Selamat Datang Kembali!
        </h1>
        <p class="text-xs sm:text-sm text-[#777777] dark:text-[#AAA0A2]">
            Silakan masuk untuk melanjutkan.
        </p>
    </div>

    <!-- Flash Status -->
    @if (session()->has('success'))
        <div class="mb-4 p-3 rounded-xl bg-[#E54855]/10 border border-[#E54855]/30 text-[#C93646] dark:text-[#E54855] text-xs font-semibold text-center">
            {{ session('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="mb-4 p-3 rounded-xl bg-[#C93646]/15 border border-[#C93646]/40 text-[#C93646] dark:text-[#E54855] text-xs font-semibold text-center">
            {{ session('error') }}
        </div>
    @endif

    <!-- Form Masuk -->
    <form wire:submit="login" class="space-y-4">

        <!-- Email atau Nama Pengguna -->
        <div>
            <label for="login-email" class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1.5">
                Email / Nama Akun
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-[#E54855] pointer-events-none">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </span>
                <input
                    id="login-email"
                    wire:model="email"
                    type="text"
                    placeholder="Masukkan email atau nama akun."
                    autocomplete="username"
                    required
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm bg-white dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] placeholder-[#777777] dark:placeholder-[#AAA0A2] border border-[#E9E9EC] dark:border-[#342427] focus:outline-none focus:border-[#E54855] focus:ring-2 focus:ring-[#E54855]/15 transition-colors"
                >
            </div>
            @error('email')
                <span class="text-[#C93646] dark:text-[#E54855] text-xs font-semibold mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Kata Sandi dengan Toggle Show/Hide -->
        <div x-data="{ showPass: false }">
            <label for="login-password" class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1.5">
                Kata Sandi
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-[#E54855] pointer-events-none">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </span>
                <input
                    id="login-password"
                    wire:model="password"
                    :type="showPass ? 'text' : 'password'"
                    placeholder="Masukkan kata sandi."
                    autocomplete="current-password"
                    required
                    class="w-full pl-10 pr-10 py-2.5 rounded-xl text-sm bg-white dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] placeholder-[#777777] dark:placeholder-[#AAA0A2] border border-[#E9E9EC] dark:border-[#342427] focus:outline-none focus:border-[#E54855] focus:ring-2 focus:ring-[#E54855]/15 transition-colors"
                >
                <button type="button" @click="showPass = !showPass"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-[#777777] hover:text-[#E54855] cursor-pointer"
                        title="Tampilkan / Sembunyikan Kata Sandi">
                    <svg x-show="!showPass" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg x-show="showPass" x-cloak class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <span class="text-[#C93646] dark:text-[#E54855] text-xs font-semibold mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Remember Me & Lupa Kata Sandi -->
        <div class="flex items-center justify-between text-xs pt-0.5">
            <label class="inline-flex items-center gap-2 text-[#777777] dark:text-[#AAA0A2] cursor-pointer select-none">
                <input type="checkbox" wire:model="remember"
                       class="rounded border-[#E9E9EC] dark:border-[#342427] text-[#E54855] focus:ring-[#E54855]">
                <span>Ingat saya</span>
            </label>

            <a href="{{ route('password.request') }}" wire:navigate
               class="font-semibold text-[#777777] dark:text-[#AAA0A2] hover:text-[#E54855] transition-colors">
                Lupa kata sandi?
            </a>
        </div>

        <!-- Tombol Masuk (MERAH PRAXISFIT) -->
        <div class="pt-2">
            <button
                type="submit"
                wire:loading.attr="disabled"
                class="w-full py-3 px-4 rounded-xl text-sm font-bold text-white bg-[#E54855] hover:bg-[#C93646] shadow-md shadow-[#E54855]/25 transition-all flex items-center justify-center cursor-pointer disabled:opacity-60"
            >
                <span wire:loading.remove wire:target="login">Masuk</span>
                <span wire:loading wire:target="login">Memproses...</span>
            </button>
        </div>
    </form>

    <!-- Footer Link ke Daftar -->
    <div class="mt-6 pt-5 border-t border-[#E9E9EC] dark:border-[#342427] text-center text-xs sm:text-sm text-[#777777] dark:text-[#AAA0A2]">
        <span>Belum memiliki akun?</span>
        <a href="{{ route('register') }}" wire:navigate
           class="font-bold text-[#E54855] hover:text-[#C93646] hover:underline ml-1">
            Daftar sekarang.
        </a>
    </div>

</div>
