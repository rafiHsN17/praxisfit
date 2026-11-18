<div class="w-full space-y-6 bg-white dark:bg-[#1A1012] p-8 rounded-3xl border border-[#E9E9EC] dark:border-[#342427] shadow-2xl">
    <div class="flex justify-center">
        <div class="w-12 h-12 rounded-2xl bg-[#E54855] flex items-center justify-center shadow-md shadow-[#E54855]/25">
            <x-logo class="w-7 h-7 text-white" />
        </div>
    </div>

    <div class="text-center space-y-1">
        <h2 class="text-2xl font-extrabold text-[#202124] dark:text-[#F5F5F5] tracking-tight">
            Portal <span class="text-[#E54855]">Admin</span>
        </h2>
        <p class="text-xs sm:text-sm text-[#777777] dark:text-[#AAA0A2]">
            Masuk ke panel kendali pengelola PraxisFit.
        </p>
    </div>

    <form wire:submit="login" class="space-y-4">
        <div>
            <label for="admin-name" class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1.5">Nama Admin</label>
            <input wire:model="name" id="admin-name" type="text" required placeholder="Masukkan nama admin..." autocomplete="username"
                   class="w-full px-3.5 py-2.5 border border-[#E9E9EC] dark:border-[#342427] rounded-xl bg-[#F7F7F8] dark:bg-[#251518] text-sm text-[#202124] dark:text-[#F5F5F5] placeholder-[#777777] dark:placeholder-[#AAA0A2] focus:outline-none focus:border-[#E54855]">
            @error('name') <span class="text-[#E54855] text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div x-data="{ showPass: false }">
            <label for="admin-password" class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1.5">Kata Sandi</label>
            <div class="relative">
                <input wire:model="password" id="admin-password" :type="showPass ? 'text' : 'password'" required placeholder="Masukkan kata sandi..." autocomplete="current-password"
                       class="w-full px-3.5 pr-10 py-2.5 border border-[#E9E9EC] dark:border-[#342427] rounded-xl bg-[#F7F7F8] dark:bg-[#251518] text-sm text-[#202124] dark:text-[#F5F5F5] placeholder-[#777777] dark:placeholder-[#AAA0A2] focus:outline-none focus:border-[#E54855]">
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
            @error('password') <span class="text-[#E54855] text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <button type="submit" wire:loading.attr="disabled"
                class="w-full py-3 px-4 rounded-xl shadow-sm text-sm font-bold text-white bg-[#E54855] hover:bg-[#C93646] transition-all cursor-pointer disabled:opacity-60">
            <span wire:loading.remove wire:target="login">Masuk ke Panel</span>
            <span wire:loading wire:target="login">Memverifikasi...</span>
        </button>
    </form>

    <div class="text-center pt-2 border-t border-[#E9E9EC] dark:border-[#342427]">
        <a href="{{ route('dashboard') }}" class="text-xs font-semibold text-[#777777] dark:text-[#AAA0A2] hover:text-[#E54855] transition-colors">
            &larr; Kembali ke Situs Utama
        </a>
    </div>
</div>
