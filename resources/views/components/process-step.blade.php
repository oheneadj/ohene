@props([
    'number' => '01',
    'title' => '',
])

<div class="relative bg-white border border-black/5 rounded-[2rem] p-8 h-full transition-all duration-500 hover:-translate-y-1 hover:border-black/10 hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] overflow-hidden group">
    <!-- Watermark Number -->
    <div class="absolute -right-2 -bottom-4 font-display font-bold text-9xl text-slate-50 pointer-events-none group-hover:scale-105 group-hover:-translate-y-2 transition-all duration-500">{{ $number }}</div>
    
    <div class="relative z-10">
        <!-- Step Dot -->
        <div class="w-5 h-5 rounded-full bg-ink mb-8 relative flex items-center justify-center">
            <div class="w-1.5 h-1.5 rounded-full bg-white"></div>
        </div>
        
        <h3 class="font-display font-bold text-xl mb-3 text-ink">{{ $title }}</h3>
        <p class="text-base text-slate-600 leading-relaxed">{{ $slot }}</p>
    </div>
</div>
