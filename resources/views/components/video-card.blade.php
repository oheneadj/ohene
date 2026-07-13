@props(['video'])

<a href="https://www.youtube.com/watch?v={{ $video->youtube_video_id }}" target="_blank" rel="noopener" class="group block bg-white p-4 rounded-[2rem] border border-black/5 hover:border-black/10 hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] transition-all duration-300 relative flex flex-col h-full">
    {{-- Inset Image --}}
    <div class="w-full aspect-video relative overflow-hidden rounded-[1.5rem] bg-slate-50 mb-5 border border-black/5">
        <img src="{{ $video->thumbnailUrl() }}" alt="{{ $video->title }}" loading="lazy" decoding="async" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
        
        {{-- Floating Play Button Overlay --}}
        <div class="absolute inset-0 flex items-center justify-center bg-black/10 group-hover:bg-transparent transition-colors duration-300">
            <div class="w-12 h-12 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:text-red-600 transition-all duration-300 text-black">
                <svg class="w-5 h-5 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
            </div>
        </div>
    </div>
    
    <div class="flex flex-col flex-grow px-2 pb-2">
        {{-- Author & Type --}}
        <div class="flex items-center gap-2 mb-3 text-xs font-medium text-slate-500">
            <span>Ohene Adjei Effah</span>
            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
            <span>Video</span>
        </div>
        
        {{-- Title --}}
        <div class="flex items-start justify-between gap-4 mb-3">
            <h3 class="font-display font-semibold text-lg leading-snug text-black group-hover:text-red-600 transition-colors line-clamp-2">{{ $video->title }}</h3>
        </div>
        
        <div class="flex-grow mb-4"></div>
        
        {{-- Footer: Pill & Date --}}
        <div class="flex items-center gap-3 mt-auto">
            <span class="bg-red-50 text-red-700 px-3 py-1.5 rounded-full text-[11px] font-semibold tracking-wide">YouTube</span>
            @if ($video->published_at)
                <span class="text-xs font-medium text-slate-500 ml-1">{{ $video->published_at->format('M d, Y') }}</span>
            @endif
        </div>
    </div>
</a>
