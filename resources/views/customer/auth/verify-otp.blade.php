<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP Pelanggan - PraxisFit</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/praxisfit-logo.svg') }}">
    <script>
        (function () {
            const stored = localStorage.getItem('darkMode');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            document.documentElement.classList.toggle('dark', stored === 'true' || (stored === null && prefersDark));
        })();
        function togglePraxisTheme() {
            const targetDark = !document.documentElement.classList.contains('dark');
            localStorage.setItem('darkMode', targetDark ? 'true' : 'false');
            document.documentElement.classList.toggle('dark', targetDark);
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#F7F7F8] dark:bg-[#100809] text-[#202124] dark:text-[#F5F5F5] flex items-center justify-center p-4 antialiased transition-colors duration-200">

    <div class="w-full max-w-md bg-white dark:bg-[#1A1012] rounded-3xl border border-[#E9E9EC] dark:border-[#342427] shadow-2xl p-8 space-y-6 relative">
        <button type="button" onclick="togglePraxisTheme()" aria-label="Ganti Tema"
                class="absolute top-5 right-5 w-9 h-9 rounded-xl border border-[#E9E9EC] dark:border-[#342427] bg-[#F7F7F8] dark:bg-[#251518] text-[#202124] dark:text-[#F5F5F5] flex items-center justify-center hover:border-[#E54855] transition cursor-pointer">
            <svg class="w-4 h-4 hidden dark:block text-[#E54855]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <svg class="w-4 h-4 block dark:hidden text-[#E54855]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
            </svg>
        </button>

        <div class="flex justify-center">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group">
                <x-logo-badge size="lg" class="transition-transform duration-300 group-hover:scale-105" />
                <span class="font-extrabold text-2xl tracking-tight text-[#202124] dark:text-[#F5F5F5]">
                    Praxis<span class="text-[#E54855]">Fit</span>
                </span>
            </a>
        </div>

        <div class="text-center space-y-1.5">
            <h1 class="text-2xl font-extrabold tracking-tight text-[#202124] dark:text-[#F5F5F5]">Verifikasi OTP</h1>
            <p class="text-xs sm:text-sm text-[#777777] dark:text-[#AAA0A2]">
                Masukkan 6 digit kode yang dikirim ke <strong class="text-[#202124] dark:text-[#F5F5F5]">{{ $email }}</strong>
            </p>
        </div>

        @if (session('status'))
            <div class="p-3 rounded-xl bg-[#E54855]/10 border border-[#E54855]/30 text-[#C93646] dark:text-[#E54855] text-xs font-semibold text-center">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('customer.otp.verify') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">

            <div>
                <label for="otp_code" class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1.5">
                    Kode OTP (6 Digit)
                </label>
                <input
                    id="otp_code"
                    name="otp_code"
                    type="text"
                    inputmode="numeric"
                    maxlength="6"
                    required
                    autofocus
                    placeholder="123456"
                    class="w-full px-4 py-3 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-center font-mono text-xl font-extrabold tracking-[0.4em] text-[#202124] dark:text-[#F5F5F5] focus:bg-white dark:focus:bg-[#1A1012] focus:outline-none focus:border-[#E54855] focus:ring-2 focus:ring-[#E54855]/15 transition"
                >
                @error('otp_code')
                    <p class="mt-1.5 text-xs font-semibold text-[#C93646] dark:text-[#E54855] text-center">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                class="w-full py-3 px-4 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white text-sm font-bold shadow-md shadow-[#E54855]/25 transition cursor-pointer"
            >
                Verifikasi &amp; Masuk
            </button>
        </form>

        <div class="flex items-center justify-between pt-3 border-t border-[#E9E9EC] dark:border-[#342427] text-xs">
            <a href="{{ route('customer.login') }}" class="font-semibold text-[#777777] dark:text-[#AAA0A2] hover:text-[#E54855]">
                &larr; Ganti Email
            </a>

            <form method="POST" action="{{ route('customer.otp.send') }}" id="customer-resend-form">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <button type="submit" id="customer-resend-btn" class="font-bold text-[#E54855] hover:underline cursor-pointer disabled:opacity-60">
                    Kirim Ulang OTP
                </button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('customer-resend-form').addEventListener('submit', function () {
            const btn = document.getElementById('customer-resend-btn');
            btn.disabled = true;
            btn.textContent = 'Mengirim OTP...';
        });
    </script>
</body>
</html>

