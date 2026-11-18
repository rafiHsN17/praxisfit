<div class="w-full max-w-md mx-auto bg-white dark:bg-[#1A1012] rounded-3xl border border-[#E9E9EC] dark:border-[#342427] p-7 sm:p-9 shadow-2xl text-center">

    <!-- Logo Resmi PraxisFit -->
    <div class="flex justify-center mb-5">
        <a href="{{ url('/') }}" wire:navigate class="inline-flex items-center gap-3 group">
            <div class="w-12 h-12 rounded-2xl bg-[#E54855] flex items-center justify-center shadow-md shadow-[#E54855]/25">
                <x-logo class="w-7 h-7 text-white" />
            </div>
        </a>
    </div>

    <h1 class="text-2xl font-extrabold text-[#202124] dark:text-[#F5F5F5] tracking-tight">
        Verifikasi Email Anda
    </h1>
    <p class="mt-2 text-xs sm:text-sm text-[#777777] dark:text-[#AAA0A2] leading-relaxed">
        Kami telah mengirimkan kode OTP 6 digit ke alamat email:<br>
        <strong class="text-[#202124] dark:text-[#F5F5F5]">{{ $email }}</strong>
    </p>

    @if (session()->has('info'))
        <div class="mt-4 p-3 rounded-xl bg-[#E54855]/10 border border-[#E54855]/30 text-[#C93646] dark:text-[#E54855] text-xs font-semibold">
            {{ session('info') }}
        </div>
    @endif

    @if ($resendNotice !== '')
        <div class="mt-4 p-3 rounded-xl bg-[#E54855]/10 border border-[#E54855]/30 text-[#C93646] dark:text-[#E54855] text-xs font-semibold">
            {{ $resendNotice }}
        </div>
    @endif

    <form wire:submit="verify" class="mt-6 space-y-5"
          x-data="{
              cooldown: 0,
              startCooldown() {
                  this.cooldown = 60;
                  const t = setInterval(() => {
                      this.cooldown--;
                      if (this.cooldown <= 0) clearInterval(t);
                  }, 1000);
              },
              handleInput(index, event) {
                  const val = event.target.value.replace(/[^0-9]/g, '').slice(-1);
                  event.target.value = val;
                  $wire.set('otp.' + index, val);
                  if (val !== '' && index < 5) {
                      const next = this.$refs['input' + (index + 1)];
                      if (next) { next.focus(); next.select(); }
                  }
              },
              handleBackspace(index, event) {
                  if (event.target.value === '' && index > 0) {
                      const prev = this.$refs['input' + (index - 1)];
                      if (prev) { prev.focus(); }
                  }
              },
              handlePaste(event) {
                  const text = (event.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '').slice(0, 6);
                  if (!text) return;
                  text.split('').forEach((ch, idx) => {
                      if (idx < 6) {
                          if (this.$refs['input' + idx]) this.$refs['input' + idx].value = ch;
                          $wire.set('otp.' + idx, ch);
                      }
                  });
                  const lastIdx = Math.min(text.length - 1, 5);
                  if (this.$refs['input' + lastIdx]) this.$refs['input' + lastIdx].focus();
              }
          }">
        <div>
            <label class="sr-only">Kode OTP</label>
            <div class="flex justify-between gap-2" @paste.prevent="handlePaste($event)">
                @for($i = 0; $i < 6; $i++)
                    <input id="otp{{ $i }}" x-ref="input{{ $i }}" type="text" inputmode="numeric" maxlength="1"
                           wire:model="otp.{{ $i }}"
                           @input="handleInput({{ $i }}, $event)"
                           @keydown.backspace="handleBackspace({{ $i }}, $event)"
                           class="w-11 h-13 sm:w-12 sm:h-14 text-center text-xl font-extrabold rounded-xl border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] focus:outline-none focus:border-[#E54855] focus:ring-2 focus:ring-[#E54855]/20 transition-all">
                @endfor
            </div>
            @error('otp') <span class="block text-[#C93646] dark:text-[#E54855] text-xs font-semibold mt-3 text-left">{{ $message }}</span> @enderror
            @error('otp.*') <span class="block text-[#C93646] dark:text-[#E54855] text-xs font-semibold mt-1 text-left">{{ $message }}</span> @enderror
        </div>

        <button type="submit" wire:loading.attr="disabled"
                class="w-full py-3 px-4 rounded-xl text-sm font-bold text-white bg-[#E54855] hover:bg-[#C93646] shadow-md shadow-[#E54855]/25 transition-all flex items-center justify-center cursor-pointer disabled:opacity-60">
            <span wire:loading.remove wire:target="verify">Verifikasi &amp; Aktifkan Akun</span>
            <span wire:loading wire:target="verify">Memverifikasi...</span>
        </button>

        <div class="pt-2 flex flex-col items-center gap-2 text-xs text-[#777777] dark:text-[#AAA0A2]">
            <div>
                Belum menerima kode?
                <button type="button"
                        @click="if (cooldown === 0) { startCooldown(); $wire.resendOtp(); }"
                        :disabled="cooldown > 0"
                        class="font-bold text-[#E54855] hover:underline disabled:opacity-50 cursor-pointer ml-1">
                    <span x-show="cooldown === 0">Kirim Ulang OTP</span>
                    <span x-show="cooldown > 0" x-cloak x-text="'Kirim Ulang (' + cooldown + 'd)'"></span>
                </button>
            </div>
            <a href="{{ route('register') }}" wire:navigate class="hover:text-[#E54855] transition-colors">
                Gunakan alamat email lain
            </a>
        </div>
    </form>

</div>
