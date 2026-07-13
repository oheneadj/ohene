@props([
    'accent' => 'golddeep',
    'title' => '',
])

@php
    // Soft backgrounds with colored icons for a premium look
    $accentClass = match ($accent) {
        'forest' => 'bg-emerald-50 text-emerald-600',
        'rust' => 'bg-orange-50 text-orange-600',
        default => 'bg-amber-50 text-amber-600',
    };
    $hoverText = match ($accent) {
        'forest' => 'group-hover:text-emerald-600',
        'rust' => 'group-hover:text-orange-600',
        default => 'group-hover:text-amber-600',
    };
@endphp

<div class="bg-white p-6 md:p-8 rounded-[2rem] border border-black/5 hover:border-black/10 hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] transition-all duration-300 group relative">
    <div class="w-12 h-12 rounded-[1rem] {{ $accentClass }} flex items-center justify-center mb-5 group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-300">
        {{ $icon ?? '' }}
    </div>
    <h3 class="font-display font-semibold text-lg md:text-xl text-black mb-3 {{ $hoverText }} transition-colors">{{ $title }}</h3>
    <p class="text-sm md:text-base text-slate-600 leading-relaxed">{{ $slot }}</p>
</div>
