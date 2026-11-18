<div class="w-full max-w-xl mx-auto bg-white dark:bg-[#1A1012] rounded-3xl border border-[#E9E9EC] dark:border-[#342427] p-7 sm:p-9 shadow-2xl">

    <!-- Logo Resmi PraxisFit -->
    <div class="flex justify-center mb-5">
        <a href="{{ url('/') }}" wire:navigate class="inline-flex items-center gap-3 group">
            <div class="w-11 h-11 rounded-2xl bg-[#E54855] flex items-center justify-center shadow-md shadow-[#E54855]/25 transition-transform duration-300 group-hover:scale-105">
                <x-logo class="w-7 h-7 text-white" />
            </div>
            <span class="font-extrabold text-2xl tracking-tight text-[#202124] dark:text-[#F5F5F5]">
                Praxis<span class="text-[#E54855]">Fit</span>
            </span>
        </a>
    </div>

    <!-- Header -->
    <div class="text-center mb-7 space-y-1">
        <h1 class="text-2xl font-extrabold tracking-tight text-[#202124] dark:text-[#F5F5F5]">
            Buat Akun Baru
        </h1>
        <p class="text-xs sm:text-sm text-[#777777] dark:text-[#AAA0A2]">
            Lengkapi detail di bawah untuk memulai perjalanan latihan &amp; nutrisi Anda.
        </p>
    </div>

    <!-- Form Daftar -->
    <form wire:submit="register" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- 1. Nama Lengkap -->
            <div>
                <label for="signup-fullname" class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1.5">
                    Nama Lengkap
                </label>
                <input
                    id="signup-fullname"
                    wire:model="name"
                    type="text"
                    placeholder="Masukkan nama lengkap..."
                    autocomplete="name"
                    required
                    class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-white dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] placeholder-[#777777] dark:placeholder-[#AAA0A2] border border-[#E9E9EC] dark:border-[#342427] focus:outline-none focus:border-[#E54855] focus:ring-2 focus:ring-[#E54855]/15 transition-colors"
                >
                @error('name')
                    <span class="text-[#C93646] dark:text-[#E54855] text-xs font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- 2. Email -->
            <div>
                <label for="signup-email" class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1.5">
                    Email
                </label>
                <input
                    id="signup-email"
                    wire:model="email"
                    type="email"
                    placeholder="nama@email.com"
                    autocomplete="email"
                    required
                    class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-white dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] placeholder-[#777777] dark:placeholder-[#AAA0A2] border border-[#E9E9EC] dark:border-[#342427] focus:outline-none focus:border-[#E54855] focus:ring-2 focus:ring-[#E54855]/15 transition-colors"
                >
                @error('email')
                    <span class="text-[#C93646] dark:text-[#E54855] text-xs font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- 3. Nomor Telepon (+62 Indonesia) -->
            <div class="md:col-span-2">
                <label for="signup-phone" class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1.5">
                    Nomor Telepon
                </label>
                <div class="flex items-center rounded-xl bg-white dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] focus-within:border-[#E54855] focus-within:ring-2 focus-within:ring-[#E54855]/15 transition-colors overflow-hidden">
                    <div class="flex items-center gap-2 pl-3.5 pr-3 py-2.5 border-r border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#1A1012] select-none shrink-0">
                        <svg class="w-5 h-3.5 rounded-[2px] ring-1 ring-[#E9E9EC] dark:ring-[#342427] shrink-0" viewBox="0 0 20 14" fill="none" aria-hidden="true">
                            <rect width="20" height="7" fill="#E54855"/>
                            <rect y="7" width="20" height="7" fill="#FFFFFF"/>
                        </svg>
                        <span class="text-xs sm:text-sm font-semibold text-[#202124] dark:text-[#F5F5F5]">+62</span>
                    </div>
                    <input
                        id="signup-phone"
                        wire:model="phone"
                        type="tel"
                        placeholder="812-3456-7890"
                        autocomplete="tel"
                        required
                        class="w-full px-3.5 py-2.5 text-sm bg-transparent text-[#202124] dark:text-[#F5F5F5] placeholder-[#777777] dark:placeholder-[#AAA0A2] focus:outline-none"
                    >
                </div>
                @error('phone')
                    <span class="text-[#C93646] dark:text-[#E54855] text-xs font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- 4. Kata Sandi -->
            <div x-data="{ showP1: false }">
                <label for="signup-password" class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1.5">
                    Kata Sandi
                </label>
                <div class="relative">
                    <input
                        id="signup-password"
                        wire:model="password"
                        :type="showP1 ? 'text' : 'password'"
                        placeholder="Minimal 6 karakter..."
                        autocomplete="new-password"
                        required
                        class="w-full pl-3.5 pr-10 py-2.5 rounded-xl text-sm bg-white dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] placeholder-[#777777] dark:placeholder-[#AAA0A2] border border-[#E9E9EC] dark:border-[#342427] focus:outline-none focus:border-[#E54855] focus:ring-2 focus:ring-[#E54855]/15 transition-colors"
                    >
                    <button type="button" @click="showP1 = !showP1"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#777777] hover:text-[#E54855] cursor-pointer">
                        <svg x-show="!showP1" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg x-show="showP1" x-cloak class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M3 3l18 18"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <span class="text-[#C93646] dark:text-[#E54855] text-xs font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- 5. Konfirmasi Kata Sandi -->
            <div x-data="{ showP2: false }">
                <label for="signup-password-confirmation" class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1.5">
                    Konfirmasi Kata Sandi
                </label>
                <div class="relative">
                    <input
                        id="signup-password-confirmation"
                        wire:model="password_confirmation"
                        :type="showP2 ? 'text' : 'password'"
                        placeholder="Ulangi kata sandi..."
                        autocomplete="new-password"
                        required
                        class="w-full pl-3.5 pr-10 py-2.5 rounded-xl text-sm bg-white dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] placeholder-[#777777] dark:placeholder-[#AAA0A2] border border-[#E9E9EC] dark:border-[#342427] focus:outline-none focus:border-[#E54855] focus:ring-2 focus:ring-[#E54855]/15 transition-colors"
                    >
                    <button type="button" @click="showP2 = !showP2"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#777777] hover:text-[#E54855] cursor-pointer">
                        <svg x-show="!showP2" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg x-show="showP2" x-cloak class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M3 3l18 18"/>
                        </svg>
                    </button>
                </div>
            </div>

        </div>

        <!-- Tombol Aksi: Reset & Daftar Sekarang -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
            <button
                type="button"
                wire:click="resetForm"
                class="w-full py-2.5 sm:py-3 px-4 rounded-xl text-sm font-semibold text-[#202124] dark:text-[#F5F5F5] bg-[#F7F7F8] dark:bg-[#251518] hover:bg-[#E9E9EC] dark:hover:bg-[#342427] border border-[#E9E9EC] dark:border-[#342427] transition-colors cursor-pointer"
            >
                Batal
            </button>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="w-full py-2.5 sm:py-3 px-4 rounded-xl text-sm font-bold text-white bg-[#E54855] hover:bg-[#C93646] shadow-md shadow-[#E54855]/25 transition-all flex items-center justify-center cursor-pointer disabled:opacity-60"
            >
                <span wire:loading.remove wire:target="register">Daftar Sekarang</span>
                <span wire:loading wire:target="register">Memproses...</span>
            </button>
        </div>
    </form>

    <!-- Link Bawah ke Masuk -->
    <div class="mt-6 pt-5 border-t border-[#E9E9EC] dark:border-[#342427] text-center text-xs sm:text-sm text-[#777777] dark:text-[#AAA0A2]">
        <span>Sudah memiliki akun?</span>
        <a href="{{ route('login') }}" wire:navigate
           class="font-bold text-[#E54855] hover:text-[#C93646] hover:underline ml-1">
            Masuk sekarang.
        </a>
    </div>

</div>
