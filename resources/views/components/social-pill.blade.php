@props(['href'])

<a href="{{ $href }}" target="_blank" rel="noopener noreferrer"
    class="inline-flex items-center gap-2.5 bg-white/5 border border-white/10 backdrop-blur-md rounded-full px-5 py-3 text-sm font-medium hover:bg-white/10 hover:border-white/20 hover:-translate-y-0.5 transition-premium text-slate-200 hover:text-white group">
    <span class="flex items-center justify-center w-5 h-5 text-slate-400 group-hover:text-white transition-colors">
        {{ $icon ?? '' }}
    </span>
    <span class="flex items-center leading-none">{{ $slot }}</span>
</a>
