@props([
    'value' => '0',
    'suffix' => '',
    'format' => false,
    'label' => '',
])

<div class="group border-t border-black/5 pt-6 cursor-default">
    <div class="font-display text-6xl md:text-7xl lg:text-8xl font-bold mb-4 flex items-baseline justify-center md:justify-start tracking-tighter transition-transform duration-500 group-hover:-translate-y-1" style="-webkit-text-stroke: 1.5px #cbd5e1; color: transparent;">
        <span class="stat-counter" data-target="{{ $value }}" data-format="{{ $format ? 'true' : 'false' }}">0</span>
        <span class="ml-1 md:ml-2 text-4xl md:text-5xl font-bold tracking-normal" style="-webkit-text-stroke: 1.5px #cbd5e1;">{{ $suffix }}</span>
    </div>
    <div class="text-sm md:text-base font-semibold text-slate-600 leading-snug max-w-[200px] mx-auto md:mx-0 group-hover:text-black transition-colors">{!! $label !!}</div>
</div>
