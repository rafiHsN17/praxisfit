<!DOCTYPE html>
<html lang="id" class="transition-colors duration-200">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $title ?? 'PraxisFit - Manajemen Kebugaran & Nutrisi')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/praxisfit-logo.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/praxisfit-logo.svg') }}">

    <!-- Fonts: Inter & Manrope -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|manrope:600,700,800&display=swap" rel="stylesheet" />

    <!-- [PENCEGAHAN BUG TEMA]: Konsistensi tema Dark/Light pada refresh & transisi Livewire wire:navigate -->
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
        document.addEventListener('livewire:navigating', initPraxisTheme);
        document.addEventListener('livewire:navigated', () => {
            initPraxisTheme();
            window.dispatchEvent(new CustomEvent('theme-updated', {
                detail: { isDark: document.documentElement.classList.contains('dark') }
            }));
        });
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 7px; height: 7px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(119, 119, 119, 0.35); border-radius: 9999px; }
        .dark ::-webkit-scrollbar-thumb { background: rgba(229, 72, 85, 0.35); }
    </style>
    @livewireStyles
</head>
<body class="bg-[#F7F7F8] dark:bg-[#100809] text-[#202124] dark:text-[#F5F5F5] font-sans min-h-screen overflow-x-hidden transition-colors duration-200 antialiased selection:bg-[#E54855] selection:text-white flex flex-col">

    <!-- MODERN ATHLETIC NAVBAR (RED / WHITE LIGHT • RED / BLACK DARK) -->
    <nav class="bg-white/95 dark:bg-[#1A1012]/95 backdrop-blur-xl border-b border-[#E9E9EC] dark:border-[#342427] sticky top-0 z-50 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center gap-3">

                <!-- Brand Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ url('/') }}" wire:navigate class="flex items-center gap-2.5 group">
                        <div class="w-9 h-9 rounded-xl bg-[#202124] dark:bg-[#251518] border border-[#342427] flex items-center justify-center transition-transform duration-200 group-hover:scale-105 shadow-xs">
                            <x-logo class="w-5 h-5 text-[#E54855]" />
                        </div>
                        <span class="font-bold text-xl sm:text-2xl tracking-tight text-[#202124] dark:text-[#F5F5F5]">
                            Praxis<span class="text-[#E54855]">Fit</span>
                        </span>
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <div class="hidden lg:flex items-center gap-1 text-sm">
                    <a href="{{ url('/') }}" wire:navigate
                       class="px-3.5 py-2 rounded-xl transition-colors {{ request()->is('/') ? 'text-[#E54855] font-bold bg-[#E54855]/10' : 'text-[#777777] dark:text-[#AAA0A2] hover:text-[#202124] dark:hover:text-[#F5F5F5] hover:bg-[#F7F7F8] dark:hover:bg-[#251518] font-semibold' }}">
                        Home
                    </a>
                    <a href="{{ url('/kalkulator') }}" wire:navigate
                       class="px-3.5 py-2 rounded-xl transition-colors {{ request()->is('kalkulator') ? 'text-[#E54855] font-bold bg-[#E54855]/10' : 'text-[#777777] dark:text-[#AAA0A2] hover:text-[#202124] dark:hover:text-[#F5F5F5] hover:bg-[#F7F7F8] dark:hover:bg-[#251518] font-semibold' }}">
                        Kalkulator Nutrisi
                    </a>
                    <a href="{{ url('/katalog') }}" wire:navigate
                       class="px-3.5 py-2 rounded-xl transition-colors {{ request()->is('katalog') ? 'text-[#E54855] font-bold bg-[#E54855]/10' : 'text-[#777777] dark:text-[#AAA0A2] hover:text-[#202124] dark:hover:text-[#F5F5F5] hover:bg-[#F7F7F8] dark:hover:bg-[#251518] font-semibold' }}">
                        Katalog Gerakan
                    </a>
                    <a href="{{ url('/faq') }}" wire:navigate
                       class="px-3.5 py-2 rounded-xl transition-colors {{ request()->is('faq') ? 'text-[#E54855] font-bold bg-[#E54855]/10' : 'text-[#777777] dark:text-[#AAA0A2] hover:text-[#202124] dark:hover:text-[#F5F5F5] hover:bg-[#F7F7F8] dark:hover:bg-[#251518] font-semibold' }}">
                        FAQ & Bantuan
                    </a>

                    @if((Auth::check() && Auth::user()->name === 'admin-praxisfit-1') || Auth::guard('admin')->check())
                        <a href="{{ route('admin.dashboard') }}" wire:navigate
                           class="px-3.5 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.*') ? 'text-[#E54855] font-bold bg-[#E54855]/10' : 'text-[#777777] dark:text-[#AAA0A2] hover:text-[#E54855] hover:bg-[#F7F7F8] dark:hover:bg-[#251518] font-semibold' }}">
                            Panel Admin
                        </a>
                    @endif

                    <a href="{{ url('/rutinku') }}" wire:navigate
                       class="ml-2 px-4 py-2 rounded-xl transition-all {{ request()->is('rutinku') ? 'bg-[#C93646] text-white shadow-md shadow-[#E54855]/25' : 'bg-[#E54855] text-white hover:bg-[#C93646] shadow-sm shadow-[#E54855]/20' }} font-bold text-xs uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>Jadwal Latihan</span>
                    </a>
                </div>

                <!-- Right Action Bar -->
                <div class="flex items-center gap-2 sm:gap-2.5 shrink-0">
                    @guest
                        <a href="{{ route('login') }}"
                           class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs sm:text-sm font-bold text-[#202124] dark:text-[#F5F5F5] bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] hover:border-[#E54855] hover:text-[#E54855] transition-colors">
                            Masuk
                        </a>
                    @endguest

                    @auth
                        <div class="hidden sm:flex items-center gap-2">
                            <a href="{{ route('profile.edit') }}" wire:navigate
                               class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-[#F7F7F8] dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] hover:border-[#E54855] transition-colors">
                                <span class="w-6 h-6 rounded-lg bg-[#E54855]/15 text-[#E54855] text-xs font-extrabold flex items-center justify-center uppercase">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                                <span class="text-xs font-bold text-[#202124] dark:text-[#F5F5F5] max-w-[110px] truncate">
                                    {{ strtok(Auth::user()->name, ' ') }}
                                </span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline m-0 p-0">
                                @csrf
                                <button type="submit"
                                        class="p-2 rounded-xl border border-[#E9E9EC] dark:border-[#342427] text-[#777777] dark:text-[#AAA0A2] hover:text-[#E54855] hover:border-[#E54855] bg-white dark:bg-[#1A1012] transition-colors cursor-pointer"
                                        title="Keluar Akun">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endauth

                    <!-- Persistent Dark / Light Mode Toggle -->
                    <button type="button" onclick="togglePraxisTheme()"
                            aria-label="Ubah Tema Gelap atau Terang"
                            title="Ubah Tema (Gelap / Terang)"
                            class="p-2 rounded-xl border border-[#E9E9EC] dark:border-[#342427] text-[#777777] dark:text-[#AAA0A2] hover:text-[#E54855] hover:border-[#E54855] bg-white dark:bg-[#1A1012] transition-colors focus:outline-none cursor-pointer">
                        <svg class="w-5 h-5 hidden dark:block text-[#E54855]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <svg class="w-5 h-5 block dark:hidden text-[#202124]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>

                    <!-- Responsive Mobile Drawer Trigger -->
                    <div x-data="{ mobileMenuOpen: false }" class="lg:hidden relative">
                        <button type="button" @click="mobileMenuOpen = !mobileMenuOpen"
                                aria-label="Buka Menu Navigasi"
                                class="p-2 rounded-xl border border-[#E9E9EC] dark:border-[#342427] text-[#202124] dark:text-[#F5F5F5] hover:text-[#E54855] hover:border-[#E54855] bg-white dark:bg-[#1A1012] transition-colors focus:outline-none cursor-pointer">
                            <svg x-show="!mobileMenuOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            <svg x-show="mobileMenuOpen" x-cloak class="w-5 h-5 text-[#E54855]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>

                        <!-- Mobile Drawer Panel -->
                        <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             class="absolute right-0 top-12 w-72 max-w-[calc(100vw-2rem)] bg-white dark:bg-[#1A1012] border border-[#E9E9EC] dark:border-[#342427] rounded-2xl shadow-2xl p-3 space-y-1 text-sm flex flex-col z-50">

                            <a href="{{ url('/') }}" wire:navigate @click="mobileMenuOpen = false"
                               class="px-3.5 py-2.5 rounded-xl transition-colors {{ request()->is('/') ? 'bg-[#E54855]/10 text-[#E54855] font-bold' : 'text-[#202124] dark:text-[#F5F5F5] font-semibold hover:bg-[#F7F7F8] dark:hover:bg-[#251518]' }}">
                                Home
                            </a>
                            <a href="{{ url('/kalkulator') }}" wire:navigate @click="mobileMenuOpen = false"
                               class="px-3.5 py-2.5 rounded-xl transition-colors {{ request()->is('kalkulator') ? 'bg-[#E54855]/10 text-[#E54855] font-bold' : 'text-[#202124] dark:text-[#F5F5F5] font-semibold hover:bg-[#F7F7F8] dark:hover:bg-[#251518]' }}">
                                Kalkulator Nutrisi
                            </a>
                            <a href="{{ url('/katalog') }}" wire:navigate @click="mobileMenuOpen = false"
                               class="px-3.5 py-2.5 rounded-xl transition-colors {{ request()->is('katalog') ? 'bg-[#E54855]/10 text-[#E54855] font-bold' : 'text-[#202124] dark:text-[#F5F5F5] font-semibold hover:bg-[#F7F7F8] dark:hover:bg-[#251518]' }}">
                                Katalog Gerakan
                            </a>
                            <a href="{{ url('/faq') }}" wire:navigate @click="mobileMenuOpen = false"
                               class="px-3.5 py-2.5 rounded-xl transition-colors {{ request()->is('faq') ? 'bg-[#E54855]/10 text-[#E54855] font-bold' : 'text-[#202124] dark:text-[#F5F5F5] font-semibold hover:bg-[#F7F7F8] dark:hover:bg-[#251518]' }}">
                                FAQ & Bantuan
                            </a>
                            <a href="{{ url('/rutinku') }}" wire:navigate @click="mobileMenuOpen = false"
                               class="mt-1 px-3.5 py-2.5 rounded-xl bg-[#E54855] hover:bg-[#C93646] text-white font-bold uppercase tracking-wider text-xs text-center transition-colors">
                                Jadwal Latihan
                            </a>

                            @if(Auth::check() && Auth::user()->name === 'admin-praxisfit-1')
                                <div class="pt-1 border-t border-[#E9E9EC] dark:border-[#342427]">
                                    <a href="{{ route('admin.dashboard') }}" wire:navigate @click="mobileMenuOpen = false"
                                       class="block px-3.5 py-2.5 rounded-xl text-[#202124] dark:text-[#F5F5F5] font-semibold hover:bg-[#F7F7F8] dark:hover:bg-[#251518]">
                                        Panel Admin
                                    </a>
                                </div>
                            @endif

                            <div class="pt-2 mt-1 border-t border-[#E9E9EC] dark:border-[#342427]">
                                @guest
                                    <a href="{{ route('login') }}" @click="mobileMenuOpen = false"
                                       class="block px-3.5 py-2.5 rounded-xl text-center font-bold text-[#E54855] bg-[#E54855]/10 hover:bg-[#E54855]/15 transition-colors">
                                        Masuk / Daftar Akun
                                    </a>
                                @endguest

                                @auth
                                    <div class="px-3.5 py-1.5 mb-1">
                                        <span class="text-[11px] font-medium text-[#777777] dark:text-[#AAA0A2]">Masuk sebagai:</span>
                                        <div class="font-bold text-xs text-[#202124] dark:text-[#F5F5F5] truncate">{{ Auth::user()->name }}</div>
                                    </div>
                                    <a href="{{ route('profile.edit') }}" wire:navigate @click="mobileMenuOpen = false"
                                       class="block px-3.5 py-2 rounded-xl text-xs font-semibold text-[#202124] dark:text-[#F5F5F5] hover:bg-[#F7F7F8] dark:hover:bg-[#251518]">
                                        Profil & Tujuan Latihan
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                                        @csrf
                                        <button type="submit"
                                                class="w-full text-left px-3.5 py-2 rounded-xl text-xs font-bold text-[#E54855] hover:bg-[#E54855]/10 transition-colors cursor-pointer">
                                            Keluar Akun
                                        </button>
                                    </form>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- GLOBAL ALPINE TOAST NOTIFICATION COMPONENT -->
    <div x-data="{
            show: false,
            message: '{{ session('success') ?: session('message', '') }}',
            type: 'success',
            init() {
                if (this.message.trim() !== '') {
                    this.show = true;
                    setTimeout(() => { this.show = false; }, 4500);
                }
                window.addEventListener('toast', (e) => {
                    this.message = e.detail.message || e.detail;
                    this.type = e.detail.type || 'success';
                    this.show = true;
                    setTimeout(() => { this.show = false; }, 4500);
                });
            }
         }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-6 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-6 scale-95"
         x-cloak
         class="fixed bottom-5 right-5 z-[100] max-w-sm w-[calc(100%-2.5rem)] bg-white dark:bg-[#1A1012] border border-[#E54855]/40 rounded-2xl shadow-2xl p-4 text-[#202124] dark:text-[#F5F5F5] flex items-center gap-3.5 backdrop-blur-xl">
        <div class="w-10 h-10 rounded-xl bg-[#E54855]/10 border border-[#E54855]/25 flex items-center justify-center text-[#E54855] shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="flex-1 text-xs sm:text-sm font-semibold leading-snug" x-text="message"></div>
        <button type="button" @click="show = false" class="text-[#777777] dark:text-[#AAA0A2] hover:text-[#E54855] transition-colors p-1 rounded-lg text-lg font-bold">&times;</button>
    </div>

    <!-- MAIN CONTENT CONTAINER -->
    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10 relative">
        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset
    </main>

    <!-- FOOTER -->
    <footer class="bg-white dark:bg-[#1A1012] border-t border-[#E9E9EC] dark:border-[#342427] mt-16 py-8 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-[#202124] dark:bg-[#251518] border border-[#342427] flex items-center justify-center">
                    <x-logo class="w-4 h-4 text-[#E54855]" />
                </div>
                <span class="font-bold text-sm tracking-tight text-[#202124] dark:text-[#F5F5F5]">
                    Praxis<span class="text-[#E54855]">Fit</span> &bull; <span class="font-medium text-[#777777] dark:text-[#AAA0A2]">Konsistensi Hari Ini Adalah Kekuatan Besok.</span>
                </span>
            </div>
            <div class="text-xs font-semibold text-[#777777] dark:text-[#AAA0A2] tracking-wide">
                &copy; {{ date('Y') }} PraxisFit Platform
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
