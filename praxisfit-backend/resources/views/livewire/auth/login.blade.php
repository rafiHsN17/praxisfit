<div class="min-h-screen flex items-center justify-center bg-slate-50 dark:bg-zinc-950 px-4 py-12 transition-colors duration-300">
    <div class="max-w-md w-full space-y-8 bg-white dark:bg-zinc-900 p-8 sm:p-10 rounded-3xl shadow-xl dark:shadow-none border border-zinc-200 dark:border-zinc-800">
        
        <div class="text-center">
            <h2 class="text-3xl font-black text-zinc-900 dark:text-zinc-100 tracking-tight">
                Selamat <span class="text-red-600 dark:text-lime-400">Kembali</span>
            </h2>
            <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                Masuk untuk melanjutkan jadwal latihan Anda.
            </p>
        </div>

        <form wire:submit="login" class="space-y-5 mt-8">
            <div>
                <label for="email" class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">Email atau Username</label>
                <div class="mt-1">
                    <input wire:model="email" id="email" type="text" required class="appearance-none block w-full px-4 py-3 border border-zinc-300 dark:border-zinc-700 rounded-xl bg-slate-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-red-600 dark:focus:ring-lime-400 focus:border-transparent transition-colors sm:text-sm">
                </div>
                @error('email') <span class="text-red-500 dark:text-red-400 text-xs font-medium mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">Kata Sandi</label>
                <div class="mt-1">
                    <input wire:model="password" id="password" type="password" required class="appearance-none block w-full px-4 py-3 border border-zinc-300 dark:border-zinc-700 rounded-xl bg-slate-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-red-600 dark:focus:ring-lime-400 focus:border-transparent transition-colors sm:text-sm">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input wire:model="remember" id="remember" type="checkbox" class="h-4 w-4 text-red-600 dark:text-lime-400 focus:ring-red-500 dark:focus:ring-lime-400 border-zinc-300 dark:border-zinc-700 rounded bg-slate-50 dark:bg-zinc-950">
                    <label for="remember" class="ml-2 block text-sm text-zinc-700 dark:text-zinc-300">
                        Ingat Saya
                    </label>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" wire:loading.attr="disabled" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white dark:text-zinc-950 bg-red-600 dark:bg-lime-400 hover:bg-red-700 dark:hover:bg-lime-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600 dark:focus:ring-lime-400 transition-all disabled:opacity-50">
                    <span wire:loading.remove wire:target="login">Masuk</span>
                    <span wire:loading wire:target="login">Memproses...</span>
                </button>
            </div>
        </form>

        <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-zinc-200 dark:border-zinc-800"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-3 bg-white dark:bg-zinc-900 text-zinc-500 dark:text-zinc-400 font-medium">Atau masuk dengan</span>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-2 gap-3">
                <a href="{{ url('/auth/google/redirect') }}" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-transparent text-sm font-bold bg-zinc-900 text-white hover:bg-red-600 dark:bg-zinc-800 dark:text-zinc-100 dark:hover:bg-lime-500 dark:hover:text-zinc-950 transition-all">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z"/>
                    </svg>
                    Google
                </a>
                <a href="{{ url('/auth/facebook/redirect') }}" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-transparent text-sm font-bold bg-zinc-900 text-white hover:bg-red-600 dark:bg-zinc-800 dark:text-zinc-100 dark:hover:bg-lime-500 dark:hover:text-zinc-950 transition-all">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M24,12.073c0-6.627-5.373-12-12-12s-12,5.373-12,12c0,5.99,4.388,10.954,10.125,11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007,1.792-4.669,4.533-4.669c1.312,0,2.686,0.235,2.686,0.235v2.953H15.83c-1.491,0-1.956,0.925-1.956,1.874v2.25h3.328l-0.532,3.469h-2.796v8.385C19.612,23.027,24,18.062,24,12.073z"/>
                    </svg>
                    Facebook
                </a>
            </div>
        </div>
        
        <p class="text-center text-sm text-zinc-600 dark:text-zinc-400">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="font-bold text-red-600 hover:text-red-700 dark:text-lime-400 dark:hover:text-lime-500 transition-colors">
                Daftar sekarang
            </a>
        </p>

    </div>
</div>
