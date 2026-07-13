@props(['testimonial'])

<figure class="bg-white border border-black/5 rounded-[2rem] p-8 md:p-10 shadow-[0_8px_30px_rgba(0,0,0,0.04)] hover:-translate-y-1 transition-transform duration-300">
    <div class="font-display text-4xl text-gold leading-none">&ldquo;</div>
    <blockquote class="text-slate-700 mt-2">{{ $testimonial->quote }}</blockquote>
    <figcaption class="flex items-center gap-3 mt-6">
        @if ($testimonial->avatar)
            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($testimonial->avatar) }}" alt="{{ $testimonial->client_name }}" width="40" height="40" loading="lazy" decoding="async" class="w-10 h-10 rounded-full object-cover">
        @endif
        <div>
            <div class="font-semibold text-sm">{{ $testimonial->client_name }}</div>
            <div class="font-mono text-xs text-slate-500">{{ collect([$testimonial->role, $testimonial->company])->filter()->join(' · ') }}</div>
        </div>
    </figcaption>
</figure>
