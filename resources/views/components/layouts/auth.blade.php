<!DOCTYPE html>
<html lang="id" class="transition-colors duration-300">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? (request()->routeIs('register') ? 'Daftar Akun - PraxisFit' : 'Masuk - PraxisFit') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/praxisfit-logo.svg') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|manrope:600,700,800&display=swap" rel="stylesheet" />

    <script>
        function initPraxisTheme() {
            const stored = localStorage.getItem('darkMode');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const isDark = stored === 'true' || (stored === null && prefersDark);

            if (isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }

        function togglePraxisTheme() {
            const targetDark = !document.documentElement.classList.contains('dark');
            localStorage.setItem('darkMode', targetDark ? 'true' : 'false');
            document.documentElement.classList.toggle('dark', targetDark);
            window.dispatchEvent(new CustomEvent('theme-updated', { detail: { isDark: targetDark } }));
        }

        initPraxisTheme();
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (localStorage.getItem('darkMode') === null) {
                document.documentElement.classList.toggle('dark', e.matches);
            }
        });
        document.addEventListener('livewire:navigating', initPraxisTheme);
        document.addEventListener('livewire:navigated', initPraxisTheme);
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-text-fill-color: #202124;
            -webkit-box-shadow: 0 0 0px 1000px #ffffff inset;
            transition: background-color 5000s ease-in-out 0s;
        }
        .dark input:-webkit-autofill,
        .dark input:-webkit-autofill:hover,
        .dark input:-webkit-autofill:focus {
            -webkit-text-fill-color: #F5F5F5;
            -webkit-box-shadow: 0 0 0px 1000px #251518 inset;
        }
    </style>
    @livewireStyles
</head>
<body class="min-h-screen font-sans antialiased text-[#202124] dark:text-[#F5F5F5] bg-[#100809] selection:bg-[#E54855] selection:text-white relative overflow-x-hidden flex flex-col">

    <!-- Gym Photo Background + Overlay -->
    <div class="pointer-events-none fixed inset-0 -z-10">
        <img src="{{ asset('images/auth-gym-bg.jpg') }}" alt="" class="w-full h-full object-cover object-center opacity-55 dark:opacity-40">
        <div class="absolute inset-0 bg-gradient-to-br from-[#100809]/80 via-[#100809]/70 to-[#E54855]/25 dark:from-[#100809]/90 dark:via-[#100809]/85 dark:to-[#1A1012]/90 backdrop-blur-[2px]"></div>
    </div>

    <!-- Header Minimalis: Kembali ke Beranda & Toggle Tema -->
    <header class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-5 pb-2 flex items-center justify-between">
        <a href="{{ url('/') }}" wire:navigate
           class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white bg-black/40 hover:bg-black/60 backdrop-blur-md border border-white/15 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Beranda PraxisFit</span>
        </a>

        <button type="button" onclick="togglePraxisTheme()"
                class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold text-white bg-black/40 hover:bg-black/60 backdrop-blur-md border border-white/15 transition-colors cursor-pointer">
            <svg class="w-4 h-4 hidden dark:block text-[#E54855]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <svg class="w-4 h-4 block dark:hidden text-[#E54855]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
            </svg>
            <span class="hidden sm:inline dark:hidden">Dark Mode</span>
            <span class="hidden dark:sm:inline">Light Mode</span>
        </button>
    </header>

    <!-- Konten Utama Centered Card -->
    <main class="flex-1 w-full px-4 sm:px-6 py-6 sm:py-10 flex items-center justify-center">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
