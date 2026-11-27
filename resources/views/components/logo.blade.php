@props([
    'mono' => false,
])

<svg {{ $attributes }} viewBox="0 0 400 240" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    @if ($mono)
        <path d="M117.8 200 H163.4 L185.3 125.7 H214.5 C249.2 125.7 268 111.8 274.6 85.9 C282.3 56 261 40 224.2 40 H164.7 L117.8 200 Z M195.1 92.5 H175 L186.2 55.4 H203.4 C218.4 55.4 226.7 60 223.3 73.1 C220 86.1 210.1 92.5 195.1 92.5 Z" fill="currentColor"/>
        <polygon points="50,45 170,105 145,115 315,185 165,130 190,120" fill="currentColor" />
    @else
        <!-- PraxisFit P Base: adapts to Light (#202124) & Dark (#F5F5F5) -->
        <path class="fill-[#202124] dark:fill-[#F5F5F5] transition-colors duration-200" d="M117.8 200 H163.4 L185.3 125.7 H214.5 C249.2 125.7 268 111.8 274.6 85.9 C282.3 56 261 40 224.2 40 H164.7 L117.8 200 Z M195.1 92.5 H175 L186.2 55.4 H203.4 C218.4 55.4 226.7 60 223.3 73.1 C220 86.1 210.1 92.5 195.1 92.5 Z" />
        <!-- Signature Red Lightning Cut -->
        <polygon class="fill-[#E54855]" points="50,45 170,105 145,115 315,185 165,130 190,120" />
    @endif
</svg>
