<!DOCTYPE html>
<html lang="id" class="transition-colors duration-300">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $title ?? 'Panel Admin - PraxisFit')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/praxisfit-logo.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/praxisfit-logo.svg') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|manrope:600,700,800&display=swap" rel="stylesheet" />

    <script>
        function initPraxisTheme() {
            const stored = localStorage.getItem('darkMode');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const isDark = stored === 'true' || (stored === null && prefersDark);
            document.documentElement.classList.toggle('dark', isDark);
        }

        function togglePraxisTheme() {
            const target = !document.documentElement.classList.contains('dark');
            localStorage.setItem('darkMode', target ? 'true' : 'false');
            document.documentElement.classList.toggle('dark', target);
            window.dispatchEvent(new CustomEvent('theme-updated', { detail: { isDark: target } }));
        }

        initPraxisTheme();
        document.addEventListener('livewire:navigating', initPraxisTheme);
        document.addEventListener('livewire:navigated', () => {
            initPraxisTheme();
            window.dispatchEvent(new CustomEvent('theme-updated', { detail: { isDark: document.documentElement.classList.contains('dark') } }));
        });
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
    @livewireStyles
</head>
<body class="bg-[#F7F7F8] dark:bg-[#100809] text-[#202124] dark:text-[#F5F5F5] font-sans min-h-screen transition-colors duration-300 antialiased selection:bg-[#E54855] selection:text-white">

    <!-- ADMIN NAVBAR -->
    <nav class="bg-white/95 dark:bg-[#1A1012]/95 backdrop-blur-xl border-b border-[#E9E9EC] dark:border-[#342427] sticky top-0 z-50 transition-all duration-300 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center gap-4">

                <!-- Logo & Brand -->
                <a href="{{ route('admin.dashboard') }}" wire:navigate class="flex items-center gap-3 shrink-0 group">
                    <x-logo-badge size="md" class="transition-transform duration-300 group-hover:scale-105" />
                    <span class="font-extrabold text-lg sm:text-xl tracking-tight text-[#202124] dark:text-[#F5F5F5]">
                        Admin <span class="text-[#E54855]">PraxisFit</span>
                    </span>
                </a>

                <!-- Desktop Admin Navigasi -->
                <div class="hidden lg:flex items-center gap-1.5 text-xs sm:text-sm tracking-tight">
                    <a href="{{ route('admin.dashboard') }}" wire:navigate
                       class="px-3.5 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.dashboard') ? 'text-[#E54855] font-bold bg-[#E54855]/10' : 'text-[#777777] dark:text-[#AAA0A2] hover:text-[#E54855] font-semibold' }}">
                        Dasbor
                    </a>
                    <a href="{{ route('admin.exercises') }}" wire:navigate
                       class="px-3.5 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.exercises') ? 'text-[#E54855] font-bold bg-[#E54855]/10' : 'text-[#777777] dark:text-[#AAA0A2] hover:text-[#E54855] font-semibold' }}">
                        Kelola Gerakan
                    </a>
                    <a href="{{ route('admin.goals') }}" wire:navigate
                       class="px-3.5 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.goals') ? 'text-[#E54855] font-bold bg-[#E54855]/10' : 'text-[#777777] dark:text-[#AAA0A2] hover:text-[#E54855] font-semibold' }}">
                        Tujuan Latihan
                    </a>
                    <a href="{{ route('admin.protein-sources') }}" wire:navigate
                       class="px-3.5 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.protein-sources') ? 'text-[#E54855] font-bold bg-[#E54855]/10' : 'text-[#777777] dark:text-[#AAA0A2] hover:text-[#E54855] font-semibold' }}">
                        Sumber Nutrisi
                    </a>
                    <a href="{{ route('admin.faqs') }}" wire:navigate
                       class="px-3.5 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.faqs') ? 'text-[#E54855] font-bold bg-[#E54855]/10' : 'text-[#777777] dark:text-[#AAA0A2] hover:text-[#E54855] font-semibold' }}">
                        Kelola FAQ
                    </a>
                </div>

                <!-- Right Action Bar -->
                <div class="flex items-center gap-2.5">
                    @auth('admin')
                        <div class="hidden sm:flex items-center gap-2">
                            <span class="text-xs font-bold text-[#777777] dark:text-[#AAA0A2] border-r border-[#E9E9EC] dark:border-[#342427] pr-3">
                                {{ Auth::guard('admin')->user()->name }}
                            </span>
                            <form method="POST" action="{{ route('admin.logout') }}" class="inline m-0 p-0">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 rounded-lg border border-[#E9E9EC] dark:border-[#342427] text-xs font-semibold text-[#C93646] dark:text-[#E54855] hover:bg-[#E54855]/10 transition-colors cursor-pointer">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    @endauth

                    <button type="button" onclick="togglePraxisTheme()" class="p-2 rounded-xl border border-[#E9E9EC] dark:border-[#342427] text-[#777777] hover:text-[#E54855] dark:text-[#AAA0A2] bg-white dark:bg-[#251518] transition-colors cursor-pointer" title="Ubah Tema">
                        <svg class="w-4 h-4 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <svg class="w-4 h-4 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 min-h-[calc(100vh-140px)]">
        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset
    </main>

    @livewireScripts
</body>
</html>
