@props([
    'post',
    'accent' => 'gold',
    'compact' => false,
])

@php
    [$pillBg, $pillText, $hoverTitle] = match ($accent) {
        'forest' => ['bg-emerald-50', 'text-emerald-700', 'group-hover:text-emerald-600'],
        'gold' => ['bg-amber-50', 'text-amber-700', 'group-hover:text-amber-600'],
        'rust' => ['bg-orange-50', 'text-orange-700', 'group-hover:text-orange-600'],
        default => ['bg-slate-100', 'text-slate-700', 'group-hover:text-slate-600'],
    };
@endphp

<a href="{{ route('blog.show', $post) }}" class="group block bg-white p-4 rounded-[2rem] border border-black/5 hover:border-black/10 hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] transition-all duration-300 relative flex flex-col h-full">
    {{-- Inset Image --}}
    @if ($post->cover_image)
        <div class="w-full aspect-[4/3] relative overflow-hidden rounded-[1.5rem] bg-slate-50 mb-5">
            @php
                $cardImage = $post->cover_image_thumbnail ?? $post->cover_image;
            @endphp
            <img src="{{ \App\Helpers\AssetHelper::url($cardImage) }}" alt="{{ $post->cover_image_alt ?? 'Thumbnail for tutorial: ' . $post->title }}" loading="lazy" decoding="async" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
        </div>
    @else
        <div class="w-full aspect-[4/3] bg-gradient-to-br from-slate-100 to-slate-50 rounded-[1.5rem] flex items-center justify-center relative overflow-hidden mb-5 border border-black/5">
            <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        </div>
    @endif
    
    <div class="flex flex-col flex-grow px-2 pb-2">
        {{-- Author & Read Time --}}
        <div class="flex items-center gap-2 mb-3 text-xs font-medium text-slate-500">
            <span>Ohene Adjei Effah</span>
            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
            <span>{{ $post->read_time }} min read</span>
        </div>
        
        {{-- Title --}}
        <div class="mb-3">
            <h3 class="font-display font-semibold text-lg leading-snug text-black {{ $hoverTitle }} transition-colors line-clamp-2">{{ $post->title }}</h3>
        </div>
        
        {{-- Excerpt --}}
        @if (! $compact && $post->excerpt)
            <p class="text-sm text-slate-600 leading-relaxed mb-6 flex-grow line-clamp-2">{{ $post->excerpt }}</p>
        @else
            <div class="flex-grow mb-6"></div>
        @endif
        
        {{-- Footer: Category & Date & Button --}}
        <div class="flex items-center justify-between gap-3 mt-auto">
            <div class="flex items-center gap-3">
                @if ($post->category)
                    <span class="{{ $pillBg }} {{ $pillText }} px-3 py-1.5 rounded-full text-[11px] font-semibold tracking-wide">{{ $post->category->name }}</span>
                @endif
                @if ($post->published_at)
                    <span class="text-xs font-medium text-slate-500 ml-1">{{ $post->published_at->format('M d, Y') }}</span>
                @endif
            </div>
            
            <span class="flex-shrink-0 text-[11px] font-semibold uppercase tracking-wider text-slate-500 bg-slate-100 group-hover:bg-black group-hover:text-white px-4 py-2 rounded-full transition-colors flex items-center gap-1.5">
                Read
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </span>
        </div>
    </div>
</a>
