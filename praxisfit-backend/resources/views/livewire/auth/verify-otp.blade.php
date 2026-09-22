<div class="min-h-[80vh] flex items-center justify-center bg-slate-50 dark:bg-zinc-950 px-4 py-12 transition-colors duration-300">
    <div class="bg-white dark:bg-zinc-900 rounded-3xl shadow-2xl border border-zinc-200 dark:border-zinc-800 p-8 sm:p-12 max-w-md w-full text-center">
        
        <!-- Icon Header -->
        <div class="mx-auto w-16 h-16 bg-red-50 text-red-600 dark:bg-lime-900/30 dark:text-lime-400 rounded-full flex items-center justify-center mb-6 border border-red-100 dark:border-lime-500/20 shadow-sm">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        
        <h2 class="text-3xl font-black text-zinc-900 dark:text-zinc-100 tracking-tight">
            Cek Email Anda
        </h2>
        <p class="mt-3 text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
            Kami telah mengirimkan kode verifikasi 6 digit ke <br>
            <strong class="text-zinc-800 dark:text-zinc-200">{{ $email }}</strong>
        </p>

        <form wire:submit="verify" class="mt-8 space-y-6">
            <div>
                <label class="sr-only">Kode OTP</label>
                <!-- Alpine.js Component for OTP -->
                <div class="flex justify-between gap-2" x-data="otpForm()">
                    @for($i = 0; $i < 6; $i++)
                        <input id="otp{{ $i }}" x-ref="input{{ $i }}" type="text" maxlength="1" 
                               wire:model="otp.{{ $i }}" 
                               @input="handleInput({{ $i }}, $event)" 
                               @keydown.backspace="handleBackspace({{ $i }}, $event)"
                               class="w-12 h-14 sm:w-14 sm:h-16 text-center text-2xl font-bold rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white transition-all duration-300 focus:ring-2 focus:ring-red-600 dark:focus:ring-lime-400 focus:border-transparent outline-none">
                    @endfor
                </div>
                <!-- Error handling -->
                @error('otp') <span class="block text-red-500 dark:text-red-400 text-xs font-bold mt-3 text-left">{{ $message }}</span> @enderror
                @error('otp.*') <span class="block text-red-500 dark:text-red-400 text-xs font-bold mt-1 text-left">{{ $message }}</span> @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" wire:loading.attr="disabled" 
                    class="w-full bg-red-600 text-white hover:bg-red-700 dark:bg-lime-400 dark:text-zinc-950 dark:hover:bg-lime-500 rounded-xl py-3.5 font-bold transition-transform transform hover:-translate-y-1 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed flex justify-center items-center gap-2">
                <span wire:loading.remove wire:target="verify">Verifikasi Akun</span>
                <span wire:loading wire:target="verify" class="flex items-center gap-2">
                    <svg class="animate-spin h-5 w-5 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memproses...
                </span>
            </button>
        </form>

        <!-- Links -->
        <p class="mt-8 text-sm text-zinc-600 dark:text-zinc-400 font-medium">
            Tidak menerima email? 
            <a href="{{ route('register') }}" class="font-bold text-red-600 hover:text-red-700 dark:text-lime-400 dark:hover:text-lime-500 transition-colors">
                Kembali & daftar ulang
            </a>
        </p>
    </div>
</div>

<!-- Alpine.js OTP Logic -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('otpForm', () => ({
            handleInput(index, event) {
                // If a number is typed and it's not the last input, focus the next one
                if (event.target.value !== '' && index < 5) {
                    let next = this.$refs['input' + (index + 1)];
                    if (next) {
                        next.focus();
                        next.select(); // auto select for easy overwrite
                    }
                }
            },
            handleBackspace(index, event) {
                // If backspace is pressed on an empty field, focus the previous one
                if (event.target.value === '' && index > 0) {
                    let prev = this.$refs['input' + (index - 1)];
                    if (prev) {
                        prev.focus();
                    }
                }
            }
        }));
    });
</script>
