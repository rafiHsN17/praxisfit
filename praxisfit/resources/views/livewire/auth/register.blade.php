<div class="flex justify-center items-center h-full min-h-[70vh]">
    <div class="bg-white dark:bg-zinc-800 p-8 rounded-2xl shadow-lg border border-gray-100 dark:border-zinc-700 w-full max-w-md transition-colors duration-300">
        <h2 class="text-2xl font-extrabold mb-6 text-center text-red-600 dark:text-lime-400 transition-colors duration-300">
            Daftar Akun Baru
        </h2>
      
        <form wire:submit="register" class="space-y-4">
            <div>
                <input 
                    wire:model="name"
                    type="text" 
                    placeholder="Nama Lengkap" 
                    class="w-full p-3 border border-gray-200 dark:border-zinc-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:focus:ring-lime-400 outline-none bg-gray-50 dark:bg-zinc-900 text-slate-800 dark:text-white transition-colors duration-300" 
                    required
                >
                @error('name') <span class="text-red-500 dark:text-red-400 text-xs font-medium mt-1">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <input 
                    wire:model="email"
                    type="email" 
                    placeholder="Alamat Email" 
                    class="w-full p-3 border border-gray-200 dark:border-zinc-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:focus:ring-lime-400 outline-none bg-gray-50 dark:bg-zinc-900 text-slate-800 dark:text-white transition-colors duration-300" 
                    required
                >
                @error('email') <span class="text-red-500 dark:text-red-400 text-xs font-medium mt-1">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <input 
                    wire:model="password"
                    type="password" 
                    placeholder="Password (minimal 6 karakter)" 
                    class="w-full p-3 border border-gray-200 dark:border-zinc-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:focus:ring-lime-400 outline-none bg-gray-50 dark:bg-zinc-900 text-slate-800 dark:text-white transition-colors duration-300" 
                    required
                >
                @error('password') <span class="text-red-500 dark:text-red-400 text-xs font-medium mt-1">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <input 
                    wire:model="password_confirmation"
                    type="password" 
                    placeholder="Konfirmasi Password" 
                    class="w-full p-3 border border-gray-200 dark:border-zinc-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:focus:ring-lime-400 outline-none bg-gray-50 dark:bg-zinc-900 text-slate-800 dark:text-white transition-colors duration-300" 
                    required
                >
            </div>
            
            <button type="submit" wire:loading.attr="disabled" class="w-full bg-red-600 dark:bg-lime-400 text-white dark:text-zinc-900 font-bold p-3 rounded-xl hover:bg-red-700 dark:hover:bg-lime-500 transition-colors duration-300 shadow-md flex justify-center items-center">
                <span wire:loading.remove wire:target="register">Buat Akun</span>
                <span wire:loading wire:target="register">Memproses...</span>
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-gray-500 dark:text-zinc-400">
            <span>Sudah punya akun?</span>
            <a href="{{ route('login') }}" wire:navigate class="text-red-600 dark:text-lime-400 font-bold hover:underline ml-1">
                Login di sini
            </a>
        </div>
    </div>
</div>
