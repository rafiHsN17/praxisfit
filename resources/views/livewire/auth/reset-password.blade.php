<div class="w-full max-w-md mx-auto bg-white dark:bg-[#1A1012] rounded-3xl border border-[#E9E9EC] dark:border-[#342427] p-7 sm:p-9 shadow-2xl">

    <div class="flex justify-center mb-5">
        <div class="w-11 h-11 rounded-2xl bg-[#E54855] flex items-center justify-center shadow-md shadow-[#E54855]/25">
            <x-logo class="w-7 h-7 text-white" />
        </div>
    </div>

    <div class="text-center mb-6 space-y-1">
        <h1 class="text-2xl font-extrabold text-[#202124] dark:text-[#F5F5F5]">Atur Ulang Kata Sandi</h1>
        <p class="text-xs sm:text-sm text-[#777777] dark:text-[#AAA0A2]">
            Buat kata sandi baru untuk akun PraxisFit Anda.
        </p>
    </div>

    <form wire:submit="resetPassword" class="space-y-4">
        <div>
            <label for="reset-email" class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1.5">Email</label>
            <input id="reset-email" type="email" wire:model="email" required
                   class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-white dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] border border-[#E9E9EC] dark:border-[#342427] focus:outline-none focus:border-[#E54855]">
            @error('email') <span class="text-[#C93646] dark:text-[#E54855] text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="reset-pass" class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1.5">Kata Sandi Baru</label>
            <input id="reset-pass" type="password" wire:model="password" required placeholder="Minimal 6 karakter..."
                   class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-white dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] border border-[#E9E9EC] dark:border-[#342427] focus:outline-none focus:border-[#E54855]">
            @error('password') <span class="text-[#C93646] dark:text-[#E54855] text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="reset-pass-conf" class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1.5">Konfirmasi Kata Sandi</label>
            <input id="reset-pass-conf" type="password" wire:model="password_confirmation" required placeholder="Ulangi kata sandi baru..."
                   class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-white dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] border border-[#E9E9EC] dark:border-[#342427] focus:outline-none focus:border-[#E54855]">
        </div>

        <button type="submit" wire:loading.attr="disabled"
                class="w-full py-3 px-4 rounded-xl text-sm font-bold text-white bg-[#E54855] hover:bg-[#C93646] shadow-md shadow-[#E54855]/25 transition-colors cursor-pointer">
            <span wire:loading.remove wire:target="resetPassword">Simpan Kata Sandi Baru</span>
            <span wire:loading wire:target="resetPassword">Memproses...</span>
        </button>
    </form>
</div>

