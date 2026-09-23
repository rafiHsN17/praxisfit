<div class="min-h-screen flex items-center justify-center bg-zinc-950 px-4 py-12 transition-colors duration-300">
    <div class="max-w-md w-full space-y-8 bg-zinc-900 p-8 sm:p-10 rounded-3xl border border-zinc-800">
        
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 rounded-3xl bg-zinc-950 flex items-center justify-center shadow-lg border border-zinc-800 transition-transform duration-500 hover:scale-105 hover:rotate-3">
                <x-logo class="w-12 h-12" />
            </div>
        </div>

        <div class="text-center">
            <h2 class="text-3xl font-black text-zinc-100 tracking-tight">
                Portal <span class="text-lime-400">Admin</span>
            </h2>
            <p class="mt-2 text-sm text-zinc-400">
                Masuk ke area khusus pengelola.
            </p>
        </div>

        <form wire:submit="login" class="space-y-5 mt-8">
            <div>
                <label for="email" class="block text-sm font-semibold text-zinc-300">Email Admin</label>
                <div class="mt-1">
                    <input wire:model="email" id="email" type="email" required class="appearance-none block w-full px-4 py-3 border border-zinc-700 rounded-xl bg-zinc-950 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-transparent transition-colors sm:text-sm">
                </div>
                @error('email') <span class="text-red-400 text-xs font-medium mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-zinc-300">Kata Sandi</label>
                <div class="mt-1">
                    <input wire:model="password" id="password" type="password" required class="appearance-none block w-full px-4 py-3 border border-zinc-700 rounded-xl bg-zinc-950 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-transparent transition-colors sm:text-sm">
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" wire:loading.attr="disabled" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-zinc-950 bg-lime-400 hover:bg-lime-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-900 focus:ring-offset-zinc-950 transition-all disabled:opacity-50">
                    <span wire:loading.remove wire:target="login">Masuk ke Panel</span>
                    <span wire:loading wire:target="login">Memverifikasi...</span>
                </button>
            </div>
        </form>
        
        <div class="text-center mt-6">
            <a href="{{ route('dashboard') }}" class="text-xs text-zinc-500 hover:text-lime-400 transition-colors">
                &larr; Kembali ke Situs Utama
            </a>
        </div>
    </div>
</div>
