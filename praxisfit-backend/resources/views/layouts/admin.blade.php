<!DOCTYPE html>
<html lang="id" class="dark transition-colors duration-300">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $title ?? 'Admin Panel - PraxisFit')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/praxisfit-logo.svg') }}">

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

    <!-- Tailwind CSS CDN & Configuration -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            red: '#dc2626',
                            lime: '#a3e635'
                        }
                    },
                    boxShadow: {
                        'glow-lime': '0 0 25px -5px rgba(163, 230, 53, 0.25)',
                        'glow-red': '0 0 25px -5px rgba(220, 38, 38, 0.3)',
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #09090b; }
    </style>
    @livewireStyles
</head>
<body class="bg-slate-50 dark:bg-zinc-950 text-slate-800 dark:text-zinc-300 font-sans min-h-screen transition-colors duration-300 antialiased selection:bg-red-600 dark:selection:bg-lime-400 selection:text-white dark:selection:text-zinc-950">

    <!-- ADMIN NAVBAR -->
    <nav class="bg-white/90 dark:bg-zinc-900/90 backdrop-blur-xl border-b border-zinc-200 dark:border-zinc-800/80 sticky top-0 z-50 transition-all duration-300 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <!-- Logo & Brand -->
                <div class="flex items-center">
                    <div class="flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-2xl bg-zinc-950 border border-zinc-800 flex items-center justify-center transition-transform duration-300 group-hover:scale-110 shadow-sm">
                            <x-logo class="w-6 h-6" />
                        </div>
                        <span class="font-bold text-xl tracking-tight text-slate-900 dark:text-zinc-100">
                            Admin <span class="text-red-600 dark:text-lime-400">PraxisFit</span>
                        </span>
                    </div>
                </div>

                <!-- Desktop Admin Navigasi -->
                <div class="hidden md:flex items-center gap-2 text-sm tracking-tight">
                    <a href="{{ route('exercise.create') }}" wire:navigate 
                       class="px-4 py-2 rounded-xl transition-colors {{ request()->routeIs('exercise.create') ? 'text-red-600 dark:text-lime-400 font-bold bg-slate-100 dark:bg-zinc-800 shadow-sm' : 'text-zinc-600 dark:text-zinc-300 hover:text-red-600 dark:hover:text-lime-400 font-semibold' }}">
                        + Tambah Gerakan
                    </a>
                </div>

                <!-- Right Action Bar -->
                <div class="flex items-center gap-3">
                    @auth
                        <div class="hidden sm:flex items-center gap-2">
                            <span class="text-sm font-bold text-zinc-600 dark:text-zinc-300 mr-2 border-r border-zinc-300 dark:border-zinc-700 pr-3">
                                {{ Auth::user()->name }}
                            </span>
                            <a href="{{ url('/') }}" wire:navigate class="text-xs font-semibold px-3 py-1.5 bg-zinc-100 dark:bg-zinc-800 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors">
                                Keluar ke Web User
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline m-0 p-0 ml-1">
                                @csrf
                                <button type="submit" class="p-2 rounded-xl border border-zinc-200 dark:border-zinc-700 text-zinc-500 hover:text-red-600 dark:text-zinc-400 dark:hover:text-red-400 bg-white dark:bg-zinc-800 transition-colors shadow-sm" title="Keluar">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @endauth

                    <!-- Theme Toggle Button -->
                    <button onclick="togglePraxisTheme()" class="p-2.5 rounded-xl border border-zinc-200 dark:border-zinc-700 text-zinc-500 hover:text-red-600 dark:text-zinc-400 dark:hover:text-lime-400 bg-white dark:bg-zinc-800 hover:bg-slate-50 dark:hover:bg-zinc-700 transition-colors focus:outline-none shadow-sm">
                        <svg class="w-5 h-5 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <svg class="w-5 h-5 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>
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
         class="fixed bottom-6 right-6 z-[100] max-w-md w-full bg-white/95 dark:bg-zinc-900/95 border-2 border-blue-500/50 dark:border-blue-400/60 rounded-2xl shadow-2xl p-4 text-slate-900 dark:text-white flex items-center gap-4 backdrop-blur-xl">
        <div class="flex-1 text-xs sm:text-sm font-black tracking-tight leading-snug" x-text="message"></div>
        <button @click="show = false" class="text-gray-400 hover:text-blue-600 transition-colors p-1.5 rounded-lg text-lg font-black">&times;</button>
    </div>

    <!-- MAIN CONTENT -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 min-h-[calc(100vh-160px)]">
        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset
    </main>

    @livewireScripts
</body>
</html>
