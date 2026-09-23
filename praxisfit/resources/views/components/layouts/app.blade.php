<!DOCTYPE html>
<html lang="id" class="dark transition-colors duration-300">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $title ?? 'PraxisFit - Platform Workout & Kebugaran Premium')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/praxisfit-logo.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/praxisfit-logo.svg') }}">

    <!-- [PENCEGAHAN BUG TEMA]: Konsistensi tema Dark/Light pada transisi halaman Livewire 3 wire:navigate -->
    <script>
        function initPraxisTheme() {
            const isDark = localStorage.getItem('darkMode') === 'true' || 
                          (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
            if (isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }

        function togglePraxisTheme() {
            const isDarkNow = document.documentElement.classList.contains('dark');
            const target = !isDarkNow;
            localStorage.setItem('darkMode', target ? 'true' : 'false');
            if (target) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
            window.dispatchEvent(new CustomEvent('theme-updated', { detail: { isDark: target } }));
        }

        initPraxisTheme();
        document.addEventListener('livewire:navigating', initPraxisTheme);
        document.addEventListener('livewire:navigated', () => {
            initPraxisTheme();
            window.dispatchEvent(new CustomEvent('theme-updated', { detail: { isDark: document.documentElement.classList.contains('dark') } }));
        });
    </script>

    <!-- Tailwind CSS & Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #09090b; }
    </style>
    @livewireStyles
</head>
<body class="bg-slate-50 dark:bg-zinc-950 text-slate-800 dark:text-zinc-300 font-sans min-h-screen transition-colors duration-300 antialiased selection:bg-red-600 dark:selection:bg-emerald-500 selection:text-white dark:selection:text-white">

    <!-- SLEEK MODERN NAVBAR -->
    <nav class="bg-white/80 dark:bg-zinc-950/80 backdrop-blur-xl border-b border-zinc-200 dark:border-zinc-800/80 sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <!-- Logo & Brand Power (Minimalist Clean-up) -->
                <div class="flex items-center">
                    <a href="{{ url('/') }}" wire:navigate class="flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-2xl bg-zinc-950 border border-zinc-800 flex items-center justify-center transition-transform duration-300 group-hover:scale-110 shadow-sm">
                            <x-logo class="w-6 h-6" />
                        </div>
                        <span class="font-bold text-2xl tracking-tight text-slate-900 dark:text-zinc-100">
                            Praxis<span class="text-red-600 dark:text-emerald-500">Fit</span>
                        </span>
                    </a>
                </div>

                <!-- Desktop Menu Navigasi -->
                <div class="hidden md:flex items-center gap-2 text-sm tracking-tight">
                    <a href="{{ url('/') }}" wire:navigate 
                       class="px-4 py-2 rounded-xl transition-colors {{ request()->is('/') ? 'text-red-600 dark:text-emerald-400 font-bold bg-slate-100 dark:bg-zinc-900 shadow-sm' : 'text-zinc-600 dark:text-zinc-300 hover:text-red-600 dark:hover:text-emerald-400 hover:bg-slate-50 dark:hover:bg-zinc-900 font-semibold' }}">
                        Home
                    </a>
                    <a href="{{ url('/kalkulator') }}" wire:navigate 
                       class="px-4 py-2 rounded-xl transition-colors {{ request()->is('kalkulator') ? 'text-red-600 dark:text-emerald-400 font-bold bg-slate-100 dark:bg-zinc-900 shadow-sm' : 'text-zinc-600 dark:text-zinc-300 hover:text-red-600 dark:hover:text-emerald-400 hover:bg-slate-50 dark:hover:bg-zinc-900 font-semibold' }}">
                        Kalkulator Protein
                    </a>
                    <a href="{{ url('/katalog') }}" wire:navigate 
                       class="px-4 py-2 rounded-xl transition-colors {{ request()->is('katalog') ? 'text-red-600 dark:text-emerald-400 font-bold bg-slate-100 dark:bg-zinc-900 shadow-sm' : 'text-zinc-600 dark:text-zinc-300 hover:text-red-600 dark:hover:text-emerald-400 hover:bg-slate-50 dark:hover:bg-zinc-900 font-semibold' }}">
                        Katalog Gerakan
                    </a>
                    <a href="{{ url('/faq') }}" wire:navigate 
                       class="px-4 py-2 rounded-xl transition-colors {{ request()->is('faq') ? 'text-red-600 dark:text-emerald-400 font-bold bg-slate-100 dark:bg-zinc-900 shadow-sm' : 'text-zinc-600 dark:text-zinc-300 hover:text-red-600 dark:hover:text-emerald-400 hover:bg-slate-50 dark:hover:bg-zinc-900 font-semibold' }}">
                        FAQ & Bantuan
                    </a>
                    @if(Auth::check() && Auth::user()->name === 'admin-praxisfit-1')
                        <a href="{{ route('exercise.create') }}" wire:navigate 
                           class="px-4 py-2 rounded-xl transition-colors {{ request()->routeIs('exercise.create') ? 'text-red-600 dark:text-emerald-400 font-bold bg-slate-100 dark:bg-zinc-900 shadow-sm' : 'text-zinc-600 dark:text-zinc-300 hover:text-red-600 dark:hover:text-emerald-400 hover:bg-slate-50 dark:hover:bg-zinc-900 font-semibold' }}">
                            Tambah Gerakan
                        </a>
                        <a href="{{ route('admin.faqs') }}" wire:navigate 
                           class="px-4 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.faqs') ? 'text-red-600 dark:text-emerald-400 font-bold bg-slate-100 dark:bg-zinc-900 shadow-sm' : 'text-zinc-600 dark:text-zinc-300 hover:text-red-600 dark:hover:text-emerald-400 hover:bg-slate-50 dark:hover:bg-zinc-900 font-semibold' }}">
                            Kelola FAQ
                        </a>
                    @endif
                    <a href="{{ url('/rutinku') }}" wire:navigate 
                       class="ml-2 px-5 py-2.5 rounded-xl transition-all {{ request()->is('rutinku') ? 'bg-red-600 dark:bg-emerald-500 text-white dark:text-white shadow-lg scale-105' : 'bg-zinc-900 dark:bg-zinc-800 text-white dark:text-zinc-200 hover:bg-red-600 dark:hover:bg-emerald-500 hover:text-white' }} font-bold uppercase tracking-wider text-xs flex items-center gap-2 duration-300">
                        <span>Jadwal Latihan</span>
                    </a>
                </div>

                <!-- Right Action Bar -->
                <div class="flex items-center gap-3">
                    
                    @guest
                        <a href="{{ route('login') }}" class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold transition-colors bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 hover:text-red-600 dark:hover:text-emerald-400 border border-transparent hover:border-red-200 dark:hover:border-emerald-800">
                            Masuk
                        </a>
                    @endguest
                    
                    @auth
                        <div class="hidden sm:flex items-center gap-2">
                            <span class="text-sm font-bold text-zinc-600 dark:text-zinc-300 mr-1 hidden lg:block">
                                Hai, {{ strtok(Auth::user()->name, ' ') }}
                            </span>
                            <form method="POST" action="{{ route('logout') }}" class="inline m-0 p-0">
                                @csrf
                                <button type="submit" class="p-2.5 rounded-xl border border-zinc-200 dark:border-zinc-800 text-zinc-500 hover:text-red-600 dark:text-zinc-400 dark:hover:text-emerald-400 bg-white dark:bg-zinc-900 hover:bg-slate-50 dark:hover:bg-zinc-800 transition-colors shadow-sm" title="Keluar">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endauth

                    <!-- Theme Toggle Button -->
                    <button onclick="togglePraxisTheme()" class="p-2.5 rounded-xl border border-zinc-200 dark:border-zinc-800 text-zinc-500 hover:text-red-600 dark:text-zinc-400 dark:hover:text-emerald-400 bg-white dark:bg-zinc-900 hover:bg-slate-50 dark:hover:bg-zinc-800 transition-colors focus:outline-none shadow-sm">
                        <!-- Sun icon for dark mode (to switch to light) -->
                        <svg class="w-5 h-5 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <!-- Moon icon for light mode (to switch to dark) -->
                        <svg class="w-5 h-5 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>

                    <!-- Mobile Menu Trigger -->
                    <div x-data="{ mobileMenuOpen: false }" class="md:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2.5 text-zinc-600 dark:text-zinc-300 hover:text-red-600 dark:hover:text-emerald-400 focus:outline-none bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm transition-colors">
                            <svg x-show="!mobileMenuOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            <svg x-show="mobileMenuOpen" x-cloak class="w-5 h-5 text-red-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                        
                        <!-- Mobile Dropdown Menu -->
                        <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             class="absolute right-4 top-18 w-64 bg-white/95 dark:bg-zinc-900/95 backdrop-blur-2xl border border-zinc-200 dark:border-zinc-800 rounded-3xl shadow-2xl p-4 space-y-2 text-sm flex flex-col z-50">
                            
                            <a href="{{ url('/') }}" wire:navigate @click="mobileMenuOpen = false"
                               class="px-4 py-3 rounded-2xl {{ request()->is('/') ? 'bg-red-100 text-red-700 font-bold dark:bg-emerald-500/20 dark:text-emerald-400' : 'text-zinc-600 font-semibold dark:text-zinc-300 hover:text-red-600 dark:hover:text-emerald-400 hover:bg-zinc-50 dark:hover:bg-zinc-800' }} transition-colors">
                                Home
                            </a>
                            <a href="{{ url('/kalkulator') }}" wire:navigate @click="mobileMenuOpen = false"
                               class="px-4 py-3 rounded-2xl {{ request()->is('kalkulator') ? 'bg-red-100 text-red-700 font-bold dark:bg-emerald-500/20 dark:text-emerald-400' : 'text-zinc-600 font-semibold dark:text-zinc-300 hover:text-red-600 dark:hover:text-emerald-400 hover:bg-zinc-50 dark:hover:bg-zinc-800' }} transition-colors">
                                Kalkulator Protein
                            </a>
                            <a href="{{ url('/katalog') }}" wire:navigate @click="mobileMenuOpen = false"
                               class="px-4 py-3 rounded-2xl {{ request()->is('katalog') ? 'bg-red-100 text-red-700 font-bold dark:bg-emerald-500/20 dark:text-emerald-400' : 'text-zinc-600 font-semibold dark:text-zinc-300 hover:text-red-600 dark:hover:text-emerald-400 hover:bg-zinc-50 dark:hover:bg-zinc-800' }} transition-colors">
                                Katalog Gerakan
                            </a>
                            <a href="{{ url('/faq') }}" wire:navigate @click="mobileMenuOpen = false"
                               class="px-4 py-3 rounded-2xl {{ request()->is('faq') ? 'bg-red-100 text-red-700 font-bold dark:bg-emerald-500/20 dark:text-emerald-400' : 'text-zinc-600 font-semibold dark:text-zinc-300 hover:text-red-600 dark:hover:text-emerald-400 hover:bg-zinc-50 dark:hover:bg-zinc-800' }} transition-colors">
                                FAQ & Bantuan
                            </a>
                            @if(Auth::check() && Auth::user()->name === 'admin-praxisfit-1')
                                <a href="{{ route('exercise.create') }}" wire:navigate @click="mobileMenuOpen = false"
                                   class="px-4 py-3 rounded-2xl {{ request()->routeIs('exercise.create') ? 'bg-red-100 text-red-700 font-bold dark:bg-emerald-500/20 dark:text-emerald-400' : 'text-zinc-600 font-semibold dark:text-zinc-300 hover:text-red-600 dark:hover:text-emerald-400 hover:bg-zinc-50 dark:hover:bg-zinc-800' }} transition-colors">
                                    Tambah Gerakan
                                </a>
                                <a href="{{ route('admin.faqs') }}" wire:navigate @click="mobileMenuOpen = false"
                                   class="px-4 py-3 rounded-2xl {{ request()->routeIs('admin.faqs') ? 'bg-red-100 text-red-700 font-bold dark:bg-emerald-500/20 dark:text-emerald-400' : 'text-zinc-600 font-semibold dark:text-zinc-300 hover:text-red-600 dark:hover:text-emerald-400 hover:bg-zinc-50 dark:hover:bg-zinc-800' }} transition-colors">
                                    Kelola FAQ
                                </a>
                            @endif
                            <a href="{{ url('/rutinku') }}" wire:navigate @click="mobileMenuOpen = false"
                               class="px-4 py-3 rounded-2xl bg-zinc-900 dark:bg-emerald-500 text-white dark:text-white hover:bg-red-600 dark:hover:bg-emerald-400 hover:text-white font-bold uppercase tracking-wider text-xs text-center transition-all">
                                Jadwal Latihan
                            </a>

                            <hr class="border-zinc-200 dark:border-zinc-800 my-1">
                            
                            @guest
                                <a href="{{ route('login') }}" wire:navigate @click="mobileMenuOpen = false"
                                   class="px-4 py-3 rounded-2xl text-zinc-600 font-bold dark:text-zinc-300 hover:text-red-600 dark:hover:text-emerald-400 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                                    Masuk / Daftar
                                </a>
                            @endguest
                            
                            @auth
                                <div class="px-4 pt-1 pb-2">
                                    <span class="text-xs font-semibold text-zinc-400">Masuk sebagai:</span>
                                    <div class="font-bold text-zinc-800 dark:text-zinc-200 truncate">{{ Auth::user()->name }}</div>
                                </div>
                                @if(Auth::user()->name === 'admin-praxisfit-1')
                                    <a href="{{ route('exercise.create') }}" wire:navigate @click="mobileMenuOpen = false" class="block px-4 py-3 mb-1 rounded-2xl text-zinc-900 bg-zinc-100 dark:text-zinc-100 dark:bg-zinc-800 font-bold hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        Admin Panel
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}" class="m-0">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-3 rounded-2xl text-red-600 font-bold dark:text-emerald-400 hover:bg-red-50 dark:hover:bg-emerald-900/20 transition-colors">
                                        Keluar Akun
                                    </button>
                                </form>
                            @endauth
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
         x-transition:enter-start="opacity-0 translate-y-8 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-8 scale-90"
         x-cloak
         class="fixed bottom-6 right-6 z-[100] max-w-md w-full bg-white/95 dark:bg-zinc-900/95 border-2 border-red-500/50 dark:border-emerald-400/60 rounded-2xl shadow-2xl p-4 text-slate-900 dark:text-white flex items-center gap-4 backdrop-blur-xl shadow-red-500/10 dark:shadow-emerald-400/10">
        <div class="w-11 h-11 rounded-xl bg-red-50 dark:bg-emerald-400/15 border border-red-200 dark:border-emerald-400/30 flex items-center justify-center text-red-600 dark:text-emerald-400 text-xl shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div class="flex-1 text-xs sm:text-sm font-black tracking-tight leading-snug" x-text="message"></div>
        <button @click="show = false" class="text-gray-400 hover:text-red-600 dark:hover:text-emerald-400 transition-colors p-1.5 rounded-lg text-lg font-black">&times;</button>
    </div>

    <!-- MAIN RESPONSIVE CONTENT CONTAINER WITH PROPER PADDING -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 min-h-[calc(100vh-160px)] relative">
        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset
    </main>

    <!-- PREMIUM HIGH-ENERGY FOOTER -->
    <footer class="bg-white/60 dark:bg-zinc-950 border-t border-gray-200/80 dark:border-zinc-900 mt-20 py-10 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-zinc-950 flex items-center justify-center shadow-md border border-zinc-800">
                    <x-logo class="w-5 h-5" />
                </div>
                <span class="font-extrabold text-sm tracking-tight text-slate-800 dark:text-zinc-300">
                    Praxis<span class="text-red-600 dark:text-emerald-500">Fit</span> &bull; Konsistensi Hari Ini Adalah Kekuatan Besok.
                </span>
            </div>
            <div class="text-xs font-extrabold text-gray-500 dark:text-zinc-500 uppercase tracking-widest flex items-center gap-2">
                &copy; {{ date('Y') }} PraxisFit Platform &bull; Built For Champions 
                <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 0110 2zM5.5 4.5a.75.75 0 011.06 0l1.061 1.06a.75.75 0 01-1.06 1.062L5.5 5.56a.75.75 0 010-1.06zm9 0a.75.75 0 010 1.06l-1.06 1.061a.75.75 0 11-1.061-1.06l1.06-1.061a.75.75 0 011.06 0zM10 7a3 3 0 100 6 3 3 0 000-6z" clip-rule="evenodd"></path></svg>
            </div>
        </div>
    </footer>

    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>
