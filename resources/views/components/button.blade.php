@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'type' => 'button',
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium transition-colors duration-150 focus-visible:outline-2 focus-visible:outline-offset-2 rounded-sm cursor-pointer select-none';

    $sizeClasses = match ($size) {
        'sm' => 'px-3.5 py-1.5 text-xs gap-1.5',
        'lg' => 'px-7 py-3.5 text-base gap-2.5 shadow-sm',
        default => 'px-5 py-2.5 text-sm gap-2 shadow-xs',
    };

    $variantClasses = match ($variant) {
        'secondary', 'dark' => 'bg-[#24140E] text-[#FAF6F0] hover:bg-[#180D08] focus-visible:outline-[#24140E]',
        'outline' => 'border border-[#24140E]/25 text-[#24140E] hover:bg-[#24140E]/5 hover:border-[#24140E] focus-visible:outline-[#24140E] dark:border-white/30 dark:text-[#FAF6F0] dark:hover:bg-white/10',
        'outline-white' => 'border border-white/60 text-white hover:bg-white/10 hover:border-white focus-visible:outline-white',
        'outline-orange' => 'border border-[#D96B27] text-[#D96B27] hover:bg-[#D96B27] hover:text-white focus-visible:outline-[#D96B27]',
        'ghost' => 'text-[#24140E] hover:text-[#D96B27] hover:bg-[#24140E]/5 focus-visible:outline-[#D96B27] dark:text-[#FAF6F0] dark:hover:text-[#D96B27]',
        default => 'bg-[#D96B27] text-white hover:bg-[#BF5A1B] focus-visible:outline-[#D96B27]',
    };

    $classes = "{$baseClasses} {$sizeClasses} {$variantClasses}";
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
