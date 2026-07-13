{{-- Terminal/file-path section eyebrow, e.g. "› ~/work" (design motif, req 4.1). --}}
<p {{ $attributes->merge(['class' => 'font-mono text-xs uppercase tracking-widest text-black mb-3 flex items-center gap-2']) }}><span class="w-1.5 h-1.5 rounded-full bg-forest flex-shrink-0"></span> {{ $slot }}</p>
