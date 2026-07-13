@props(['icon', 'color' => '000000', 'name'])

@php
    $path = base_path("node_modules/simple-icons/icons/{$icon}.svg");
    $svg = file_exists($path) ? file_get_contents($path) : '';
    $svg = str_replace('<svg ', '<svg class="w-16 h-16 md:w-20 md:h-20 fill-current text-slate-300 transition-colors duration-500" ', $svg);
@endphp

<div class="flex flex-col items-center justify-center min-w-[80px] hover:scale-110 transition-transform duration-300 tech-icon-container cursor-default" style="--brand-color: #{{ ltrim($color, '#') }}" title="{{ $name }}">
    {!! $svg !!}
</div>
