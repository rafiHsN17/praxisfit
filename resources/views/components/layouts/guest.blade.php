<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="transition-colors duration-300">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Portal Admin - PraxisFit' }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/praxisfit-logo.svg') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|manrope:600,700,800&display=swap" rel="stylesheet" />

    <script>
        (function () {
            const stored = localStorage.getItem('darkMode');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const isDark = stored === 'true' || (stored === null && prefersDark);
            document.documentElement.classList.toggle('dark', isDark);
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-[#F7F7F8] dark:bg-[#100809] text-[#202124] dark:text-[#F5F5F5] min-h-screen flex items-center justify-center relative selection:bg-[#E54855] selection:text-white">
    <div class="relative z-10 w-full max-w-md px-4">
        {{ $slot }}
    </div>
    @livewireScripts
</body>
</html>
