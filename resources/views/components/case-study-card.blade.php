@props([
    'project'
])

@php
    $pillBg = 'bg-amber-50';
    $pillText = 'text-amber-700';
    $hoverTitle = 'group-hover:text-amber-600';
@endphp

<a href="{{ route('work.show', $project) }}" class="group block bg-white p-5 md:p-5 rounded-[2rem] border border-black/5 hover:border-black/10 hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] transition-all duration-300 relative flex flex-col md:flex-row gap-5 md:gap-6 max-w-[52rem] mx-auto">
    
    {{-- Framed Image Stage --}}
    <div class="w-full md:w-[48%] aspect-video md:aspect-[4/3] relative flex items-center justify-center overflow-hidden rounded-[1.5rem] bg-slate-50/50 border border-black/5 flex-shrink-0 p-3 md:p-4 group-hover:bg-slate-50 transition-colors duration-500">
        
        {{-- Browser mock window --}}
        <div class="w-full h-full relative flex flex-col bg-white rounded-lg overflow-hidden border border-black/10 shadow-[0_8px_30px_rgba(0,0,0,0.04)] group-hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)] group-hover:-translate-y-1 transition-all duration-500">
            {{-- Toolbar --}}
            <div class="h-6 md:h-7 bg-slate-50/80 backdrop-blur border-b border-black/5 flex items-center px-3 gap-1.5 flex-shrink-0 relative z-10">
                <div class="w-2 h-2 md:w-2.5 md:h-2.5 rounded-full bg-slate-300"></div>
                <div class="w-2 h-2 md:w-2.5 md:h-2.5 rounded-full bg-slate-300"></div>
                <div class="w-2 h-2 md:w-2.5 md:h-2.5 rounded-full bg-slate-300"></div>
            </div>
            {{-- Image wrapper --}}
            <div class="flex-grow relative bg-slate-100 p-1.5">
                <div class="w-full h-full relative overflow-hidden rounded-sm bg-white shadow-[0_2px_8px_rgba(0,0,0,0.04)] border border-black/5">
                    @if ($project->cover_image)
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($project->cover_image) }}" alt="{{ $project->cover_image_alt ?? $project->title }}" loading="lazy" decoding="async" class="absolute inset-0 w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-slate-100 to-slate-50 flex items-center justify-center">
                             <span class="font-display font-bold text-3xl md:text-5xl text-slate-300">{{ substr($project->title, 0, 1) }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    {{-- Content --}}
    <div class="flex flex-col flex-grow py-2 md:py-6 pr-2 md:pr-6 w-full">
        {{-- Meta --}}
        <div class="flex items-center gap-2 mb-3 text-xs font-medium text-slate-500">
            <span>Ohene Adjei Effah</span>
            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
            <span>Case Study</span>
        </div>
        
        {{-- Title --}}
        <div class="mb-3">
            <h3 class="font-display font-semibold text-xl md:text-2xl leading-snug text-black {{ $hoverTitle }} transition-colors line-clamp-2">{{ $project->title }}</h3>
        </div>
        
        {{-- Tagline --}}
        <p class="text-sm md:text-base text-slate-600 leading-relaxed mb-6 flex-grow line-clamp-2">{{ $project->tagline }}</p>
        
        {{-- Footer: Pill & Button --}}
        <div class="flex items-center justify-between gap-3 mt-auto">
            <div class="flex items-center gap-3">
                @if (!empty($project->tech_stack))
                    <span class="{{ $pillBg }} {{ $pillText }} px-4 py-1.5 rounded-full text-[11px] font-semibold tracking-wide">{{ $project->tech_stack[0] }}</span>
                @endif
                @if (count($project->tech_stack) > 1)
                    <span class="text-xs font-medium text-slate-500">+{{ count($project->tech_stack) - 1 }}</span>
                @endif
            </div>
            
            <span class="flex-shrink-0 text-[11px] font-semibold uppercase tracking-wider text-slate-500 bg-slate-100 group-hover:bg-amber-100 group-hover:text-amber-700 px-4 py-2 rounded-full transition-colors flex items-center gap-1.5">
                View
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </span>
        </div>
    </div>
</a>
