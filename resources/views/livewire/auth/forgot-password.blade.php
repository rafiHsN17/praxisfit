<div class="w-full max-w-md mx-auto bg-white dark:bg-[#1A1012] rounded-3xl border border-[#E9E9EC] dark:border-[#342427] p-7 sm:p-9 shadow-2xl">

    <div class="flex justify-center mb-5">
        <a href="{{ url('/') }}" wire:navigate class="inline-flex items-center gap-3 group">
            <x-logo-badge size="lg" class="transition-transform duration-300 group-hover:scale-105" />
        </a>
    </div>

    <div class="text-center mb-6 space-y-1">
        <h1 class="text-2xl font-extrabold text-[#202124] dark:text-[#F5F5F5]">Lupa Kata Sandi</h1>
        <p class="text-xs sm:text-sm text-[#777777] dark:text-[#AAA0A2]">
            Masukkan alamat email yang terdaftar untuk mengatur ulang kata sandi Anda.
        </p>
    </div>

    @if($statusMessage)
        <div class="mb-5 p-3.5 rounded-xl bg-[#E54855]/10 border border-[#E54855]/30 text-[#C93646] dark:text-[#E54855] text-xs font-semibold leading-relaxed">
            {{ $statusMessage }}
        </div>
    @endif

    <form wire:submit="sendResetLink" class="space-y-4">
        <div>
            <label for="forgot-email" class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1.5">Email Terdaftar</label>
            <input id="forgot-email" type="email" wire:model="email" required placeholder="Masukkan alamat email..."
                   class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-white dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] placeholder-[#777777] dark:placeholder-[#AAA0A2] border border-[#E9E9EC] dark:border-[#342427] focus:outline-none focus:border-[#E54855]">
            @error('email') <span class="text-[#C93646] dark:text-[#E54855] text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <button type="submit" wire:loading.attr="disabled"
                class="w-full py-3 px-4 rounded-xl text-sm font-bold text-white bg-[#E54855] hover:bg-[#C93646] shadow-md shadow-[#E54855]/25 transition-colors cursor-pointer">
            <span wire:loading.remove wire:target="sendResetLink">Kirim Tautan Atur Ulang</span>
            <span wire:loading wire:target="sendResetLink">Memproses...</span>
        </button>
    </form>

    <div class="mt-6 pt-5 border-t border-[#E9E9EC] dark:border-[#342427] text-center text-xs sm:text-sm text-[#777777] dark:text-[#AAA0A2]">
        <a href="{{ route('login') }}" wire:navigate class="font-bold text-[#E54855] hover:underline">&larr; Kembali ke halaman Masuk</a>
    </div>
</div>

