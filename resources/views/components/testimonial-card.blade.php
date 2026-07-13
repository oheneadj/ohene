@props(['testimonial'])

<figure class="bg-white border border-black/5 rounded-[2rem] p-8 md:p-10 shadow-[0_8px_30px_rgba(0,0,0,0.04)] hover:-translate-y-1 transition-transform duration-300 flex flex-col h-full">
    <div class="font-display text-4xl text-gold leading-none">&ldquo;</div>
    <blockquote class="text-slate-700 mt-2 flex-grow">{{ $testimonial->quote }}</blockquote>
    
    <div class="mt-8 flex flex-wrap items-center justify-between gap-4 pt-6 border-t border-black/5">
        <figcaption class="flex items-center gap-3">
            @if ($testimonial->avatar)
                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($testimonial->avatar) }}" alt="{{ $testimonial->client_name }}" width="40" height="40" loading="lazy" decoding="async" class="w-10 h-10 rounded-full object-cover border border-black/5">
            @endif
            <div>
                <div class="font-semibold text-sm text-black">{{ $testimonial->client_name }}</div>
                <div class="font-mono text-[11px] text-slate-500 uppercase tracking-wide">{{ collect([$testimonial->role, $testimonial->company])->filter()->join(' · ') }}</div>
            </div>
        </figcaption>

        @if ($testimonial->relationLoaded('project') && $testimonial->project)
            <a href="{{ route('work.show', $testimonial->project) }}" class="flex-shrink-0 text-[11px] font-semibold uppercase tracking-wider text-slate-500 bg-slate-100 hover:bg-black hover:text-white px-4 py-2 rounded-full transition-colors flex items-center gap-1.5">
                Case study
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        @endif
    </div>
</figure>
