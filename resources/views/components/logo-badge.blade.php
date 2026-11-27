@props([
    'size' => 'md',
])

@php
    $boxClass = match ($size) {
        'sm' => 'w-8 h-8 rounded-xl',
        'lg' => 'w-11 h-11 rounded-2xl',
        'xl' => 'w-12 h-12 rounded-2xl',
        default => 'w-9 h-9 rounded-xl',
    };

    $svgClass = match ($size) {
        'sm' => 'w-4 h-4',
        'lg', 'xl' => 'w-7 h-7',
        default => 'w-5 h-5',
    };
@endphp

<div {{ $attributes->merge(['class' => "{$boxClass} bg-white dark:bg-[#251518] border border-[#E9E9EC] dark:border-[#342427] flex items-center justify-center shadow-xs transition-colors duration-200"]) }}>
    <x-logo class="{{ $svgClass }}" />
</div>

