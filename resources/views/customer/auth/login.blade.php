<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk atau Daftar Pelanggan - PraxisFit</title>
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

        <!-- Logo -->
        <div class="flex justify-center">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group">
                <x-logo-badge size="lg" class="transition-transform duration-300 group-hover:scale-105" />
                <span class="font-extrabold text-2xl tracking-tight text-[#202124] dark:text-[#F5F5F5]">
                    Praxis<span class="text-[#E54855]">Fit</span>
                </span>
            </a>
        </div>

        <div class="text-center space-y-1.5">
            <h1 class="text-2xl font-extrabold tracking-tight text-[#202124] dark:text-[#F5F5F5]">Masuk atau Daftar</h1>
            <p class="text-xs sm:text-sm text-[#777777] dark:text-[#AAA0A2]">
                Tanpa kata sandi. Gunakan email OTP atau akun Google Anda.
            </p>
        </div>

        <!-- Form 1 Kolom: Alamat Email -->
        <form method="POST" action="{{ route('customer.otp.send') }}" id="customer-otp-form" class="space-y-4">
            @csrf

            <div>
                <label for="customer-email" class="block text-xs font-bold text-[#202124] dark:text-[#F5F5F5] mb-1.5">
                    Alamat Email
                </label>
                <input
                    id="customer-email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    placeholder="nama@email.com"
                    class="w-full px-4 py-3 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] text-sm text-[#202124] dark:text-[#F5F5F5] placeholder-[#777777] dark:placeholder-[#AAA0A2] focus:bg-white dark:focus:bg-[#1A1012] focus:outline-none focus:border-[#E54855] focus:ring-2 focus:ring-[#E54855]/15 transition"
                >
                @error('email')
                    <p class="mt-1.5 text-xs font-semibold text-[#C93646] dark:text-[#E54855]">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                id="customer-otp-btn"
                class="w-full py-3 px-4 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white text-sm font-bold shadow-md shadow-[#E54855]/25 transition flex items-center justify-center gap-2 cursor-pointer disabled:opacity-60 disabled:cursor-not-allowed"
            >
                <span id="customer-otp-btn-text">Kirim Kode OTP</span>
            </button>
        </form>

        <div class="relative flex items-center py-1">
            <div class="flex-grow border-t border-[#E9E9EC] dark:border-[#342427]"></div>
            <span class="mx-3 text-xs font-medium text-[#777777] dark:text-[#AAA0A2]">atau</span>
            <div class="flex-grow border-t border-[#E9E9EC] dark:border-[#342427]"></div>
        </div>

        <!-- 1 Tombol: Lanjutkan dengan Google -->
        <a href="{{ route('customer.google.redirect') }}"
           class="w-full py-3 px-4 rounded-xl bg-white dark:bg-[#251518] hover:bg-[#F7F7F8] dark:hover:bg-[#342427] border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5] text-sm font-bold transition flex items-center justify-center gap-3 shadow-xs">
            <svg class="w-5 h-5" viewBox="0 0 24 24" aria-hidden="true">
                <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17z"/>
                <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.11-6.72-4.96H1.29v3.14C3.26 21.3 7.31 24 12 24z"/>
                <path fill="#FBBC05" d="M5.28 14.24c-.24-.72-.38-1.49-.38-2.24s.14-1.52.38-2.24V6.62H1.29C.47 8.24 0 10.06 0 12s.47 3.76 1.29 5.38l3.99-3.14z"/>
                <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.31 0 3.26 2.7 1.29 6.62l3.99 3.14c.95-2.85 3.6-4.96 6.72-4.96z"/>
            </svg>
            <span>Lanjutkan dengan Google</span>
        </a>

        <div class="pt-2 border-t border-[#E9E9EC] dark:border-[#342427] text-center">
            <a href="{{ url('/') }}" class="text-xs font-semibold text-[#777777] dark:text-[#AAA0A2] hover:text-[#E54855]">
                &larr; Kembali ke Beranda
            </a>
        </div>
    </div>

    <script>
        document.getElementById('customer-otp-form').addEventListener('submit', function () {
            const btn = document.getElementById('customer-otp-btn');
            const text = document.getElementById('customer-otp-btn-text');
            btn.disabled = true;
            text.textContent = 'Mengirim OTP...';
        });
    </script>
</body>
</html>

