<div class="flex justify-center items-center h-full min-h-[70vh]">
    <div class="bg-white dark:bg-zinc-800 p-8 rounded-2xl shadow-lg border border-gray-100 dark:border-zinc-700 w-full max-w-md transition-colors duration-300">
        <h2 class="text-2xl font-extrabold mb-6 text-center text-red-600 dark:text-lime-400 transition-colors duration-300">
            Login PraxisFit
        </h2>
      
        <form wire:submit="login" class="space-y-4">
            <div>
                <input 
                    wire:model="email"
                    type="text" 
                    placeholder="Alamat Email atau Username" 
                    class="w-full p-3 border border-gray-200 dark:border-zinc-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:focus:ring-lime-400 outline-none bg-gray-50 dark:bg-zinc-900 text-slate-800 dark:text-white transition-colors duration-300" 
                    required
                >
                @error('email') <span class="text-red-500 dark:text-red-400 text-xs font-medium mt-1">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <input 
                    wire:model="password"
                    type="password" 
                    placeholder="Password" 
                    class="w-full p-3 border border-gray-200 dark:border-zinc-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:focus:ring-lime-400 outline-none bg-gray-50 dark:bg-zinc-900 text-slate-800 dark:text-white transition-colors duration-300" 
                    required
                >
                @error('password') <span class="text-red-500 dark:text-red-400 text-xs font-medium mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center">
                <input wire:model="remember" id="remember" type="checkbox" class="h-4 w-4 text-red-600 dark:text-lime-400 focus:ring-red-500 dark:focus:ring-lime-400 border-gray-300 dark:border-zinc-600 rounded bg-gray-50 dark:bg-zinc-900">
                <label for="remember" class="ml-2 block text-sm text-gray-700 dark:text-zinc-300">
                    Ingat Saya
                </label>
            </div>
            
            <button type="submit" wire:loading.attr="disabled" class="w-full bg-red-600 dark:bg-lime-400 text-white dark:text-zinc-900 font-bold p-3 rounded-xl hover:bg-red-700 dark:hover:bg-lime-500 transition-colors duration-300 shadow-md flex justify-center items-center">
                <span wire:loading.remove wire:target="login">Masuk Sekarang</span>
                <span wire:loading wire:target="login">Memproses...</span>
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-gray-500 dark:text-zinc-400">
            <span>Belum punya akun?</span>
            <a href="{{ route('register') }}" wire:navigate class="text-red-600 dark:text-lime-400 font-bold hover:underline ml-1">
                Daftar di sini
            </a>
        </div>
    </div>
</div>
