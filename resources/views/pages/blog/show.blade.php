<x-layouts.app
    :title="$post->meta_title ?? $post->title . ' | Ohene Adjei Effah'"
    :description="$post->meta_description ?? $post->excerpt"
    :image="$post->cover_image"
    type="article"
    :published_time="$post->published_at?->toIso8601String()"
    :modified_time="$post->updated_at?->toIso8601String()">

    <x-slot:head>
        <x-json-ld :data="[
            [
                '@context' => 'https://schema.org',
                '@type' => 'BlogPosting',
                'headline' => $post->title,
                'description' => $post->meta_description ?? $post->excerpt,
                'url' => route('blog.show', $post),
                'datePublished' => $post->published_at?->toAtomString(),
                'dateModified' => $post->updated_at?->toAtomString(),
                'image' => $post->cover_image ? \Illuminate\Support\Facades\Storage::disk('public')->url($post->cover_image) : null,
                'author' => ['@type' => 'Person', 'name' => config('site.name')],
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => route('blog.index')],
                    ['@type' => 'ListItem', 'position' => 3, 'name' => $post->title, 'item' => route('blog.show', $post)],
                ]
            ]
        ]" />
        
        {{-- JetBrains Mono Font for Code Blocks --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
        
        {{-- Prism.js Theme for Code Highlighting (Monokai Pro Base) --}}
        <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-numbers/prism-line-numbers.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/toolbar/prism-toolbar.min.css" rel="stylesheet" />
        <style>
            /* Monokai Pro Custom Theme Overrides */
            code[class*="language-"], pre[class*="language-"] {
                color: #FCFCFA !important;
                background: #2D2A2E !important;
                text-shadow: none !important;
                font-family: 'JetBrains Mono', Consolas, Monaco, 'Andale Mono', 'Ubuntu Mono', monospace !important;
                font-variant-ligatures: contextual;
                font-size: 0.875rem !important;
                line-height: 1.5 !important;
            }
            .token.comment, .token.prolog, .token.doctype, .token.cdata { color: #727072 !important; font-style: italic !important; }
            .token.punctuation { color: #939293 !important; }
            .token.namespace { opacity: .7 !important; }
            .token.property, .token.tag, .token.constant, .token.symbol, .token.deleted { color: #FF6188 !important; }
            .token.boolean, .token.number { color: #AB9DF2 !important; }
            .token.selector, .token.attr-name, .token.char, .token.builtin, .token.inserted { color: #A9DC76 !important; }
            .token.string { color: #FFD866 !important; }
            .token.operator, .token.entity, .token.url, .language-css .token.string, .style .token.string { color: #FF6188 !important; }
            .token.atrule, .token.attr-value, .token.keyword { color: #FF6188 !important; font-style: italic !important; }
            .token.function, .token.class-name { color: #A9DC76 !important; }
            .token.regex, .token.important, .token.variable { color: #FC9867 !important; }

            /* Enforce text wrapping to prevent horizontal scrolling in code blocks */
            pre[class*="language-"] {
                white-space: pre-wrap !important;
                word-wrap: break-word !important;
                overflow-x: hidden !important;
            }
            code[class*="language-"] {
                white-space: pre-wrap !important;
                word-wrap: break-word !important;
            }
            /* Make toolbar copy button look sleek */
            div.code-toolbar > .toolbar {
                opacity: 1;
                right: .5em;
                top: .5em;
            }
            div.code-toolbar > .toolbar a,
            div.code-toolbar > .toolbar button {
                border-radius: .3em;
                padding: .2em .5em;
                background: rgba(255, 255, 255, 0.1);
                color: #ccc;
                box-shadow: none;
                font-family: ui-sans-serif, system-ui, sans-serif;
                font-size: 0.8rem;
                transition: all 0.2s ease;
            }
            div.code-toolbar > .toolbar a:hover,
            div.code-toolbar > .toolbar button:hover {
                background: rgba(255, 255, 255, 0.2);
                color: #fff;
            }
        </style>
    </x-slot:head>

    @if ($preview ?? false)
        <div class="bg-gray-100 text-black font-mono text-sm text-center py-2.5 px-4">
            Preview — this post is <strong>{{ $post->status->label() }}</strong> and not visible to the public.
        </div>
    @endif

    <section class="bg-black text-white relative overflow-hidden pt-24 pb-{{ $post->cover_image ? '32 md:pb-48' : '24 md:pb-32' }} border-b border-white/10">
        <div class="bg-aurora-animated pointer-events-none opacity-40" aria-hidden="true"></div>
        <div class="max-w-3xl mx-auto px-7 relative z-10">
            <p class="font-mono text-xs text-slate-400 mb-6">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a> /
                <a href="{{ route('blog.index') }}" class="hover:text-white transition-colors">Blog</a>
                @if ($post->category) / <span class="text-white">{{ $post->category->name }}</span> @endif
            </p>
            @if ($post->category)
                <p class="font-mono text-xs uppercase tracking-widest text-forest mb-4">&rsaquo; {{ $post->category->name }}</p>
            @endif
            <h1 class="font-display text-4xl md:text-5xl font-semibold mb-6 leading-tight">{{ $post->title }}</h1>
            <div class="flex flex-wrap items-center justify-between gap-6">
                <p class="text-slate-400 text-sm font-mono">By Ohene Adjei Effah &middot; {{ $post->read_time }} min read</p>
                
                <div class="flex items-center gap-3">
                    <div class="mr-1 md:mr-3 md:pr-6 md:border-r border-white/20">
                        <button type="button" onclick="copyUrlToClipboard(this)" class="flex items-center gap-2 text-xs font-semibold text-slate-300 hover:text-white transition-colors focus:outline-none">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            <span class="copy-text">Copy link</span>
                            <span class="copied-text text-emerald-400" style="display: none;">Copied!</span>
                        </button>
                    </div>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full border border-white/20 flex items-center justify-center text-slate-300 hover:text-white hover:border-white hover:bg-white/10 transition-premium" title="Share on X">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.008 4.076H5.078z"/></svg>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($post->title) }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full border border-white/20 flex items-center justify-center text-slate-300 hover:text-white hover:border-white hover:bg-white/10 transition-premium" title="Share on LinkedIn">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . request()->url()) }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full border border-white/20 flex items-center justify-center text-slate-300 hover:text-white hover:border-white hover:bg-white/10 transition-premium" title="Share on WhatsApp">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.012 2c-5.506 0-9.989 4.478-9.99 9.984a9.964 9.964 0 001.333 4.993L2 22l5.233-1.237a9.994 9.994 0 004.779 1.217h.004c5.505 0 9.988-4.478 9.989-9.9840 0-2.753-1.069-5.34-3.015-7.286A9.954 9.954 0 0012.012 2zm5.744 14.398c-.244.693-1.42 1.341-1.959 1.411-.539.071-1.229.17-3.864-1.077-3.177-1.503-5.231-4.73-5.389-4.94-.158-.21-1.29-1.721-1.29-3.284 0-1.563.816-2.336 1.106-2.645.29-.309.632-.387.843-.387.21 0 .42-.001.605 0 .198.001.464-.075.727.561.264.636.903 2.197.982 2.355.079.158.132.342.026.553-.105.21-.158.342-.316.527-.158.185-.33.411-.474.553-.158.158-.323.332-.14.646.185.316.822 1.356 1.764 2.197 1.218 1.087 2.228 1.42 2.545 1.578.316.158.5.132.685-.079.185-.21.791-.922.999-1.238.21-.316.42-.264.711-.158.29.105 1.844.87 2.16 1.027.316.158.527.237.606.369.079.132.079.764-.165 1.457z"/></svg>
                    </a>
                    <a href="https://t.me/share/url?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full border border-white/20 flex items-center justify-center text-slate-300 hover:text-white hover:border-white hover:bg-white/10 transition-premium" title="Share on Telegram">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0zm5.952 7.825-1.97 9.296c-.144.654-.53.812-1.072.508l-2.966-2.186-1.43 1.378c-.158.158-.291.291-.595.291l.211-3.031 5.513-4.981c.24-.213-.053-.332-.373-.119L8.398 12.26 5.46 11.34c-.64-.2-.64-.64.133-.944l11.433-4.407c.528-.198.988.12.87.836z"/></svg>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full border border-white/20 flex items-center justify-center text-slate-300 hover:text-white hover:border-white hover:bg-white/10 transition-premium" title="Share on Facebook">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    @if ($post->cover_image)
        <div class="max-w-5xl mx-auto px-7 -mt-16 md:-mt-32 relative z-20">
            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($post->cover_image) }}" alt="{{ $post->cover_image_alt ?? $post->title }}" class="w-full aspect-video md:aspect-[21/9] object-cover rounded-2xl border border-black/10 shadow-lg">
        </div>
    @endif


    {{-- Mobile Share Toggle --}}
    <button id="mobileShareToggle" class="lg:hidden fixed top-1/2 -translate-y-1/2 right-0 bg-black text-white p-2.5 rounded-l-xl z-50 transition-all duration-300 opacity-0 pointer-events-none shadow-lg group">
        <svg class="w-5 h-5 transition-transform group-[.is-active]:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
    </button>

    {{-- Floating Vertical Share & Progress Widget --}}
    <div class="flex fixed top-1/2 -translate-y-1/2 right-0 lg:right-8 xl:right-[calc(50%-450px)] flex-col items-center gap-4 z-40 transition-all duration-300 opacity-0 pointer-events-none translate-x-full lg:translate-x-0 bg-slate-50 lg:bg-transparent p-4 lg:p-0 rounded-l-2xl border border-r-0 border-black/10 lg:border-none shadow-2xl lg:shadow-none" id="floatingWidget">
        {{-- Read Progress --}}
        <div class="h-32 w-1 bg-black/10 rounded-full overflow-hidden mb-2 shadow-inner">
            <div id="readProgress" class="w-full bg-forest" style="height: 0%"></div>
        </div>
        
        {{-- Social Links --}}
        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-full border border-black/10 bg-white shadow-sm flex items-center justify-center text-slate-500 hover:text-black hover:border-black hover:-translate-y-1 transition-premium" title="Share on X">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.008 4.076H5.078z"/></svg>
        </a>
        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($post->title) }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-full border border-black/10 bg-white shadow-sm flex items-center justify-center text-slate-500 hover:text-[#0a66c2] hover:border-[#0a66c2] hover:-translate-y-1 transition-premium" title="Share on LinkedIn">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
        </a>
        <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . request()->url()) }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-full border border-black/10 bg-white shadow-sm flex items-center justify-center text-slate-500 hover:text-[#25D366] hover:border-[#25D366] hover:-translate-y-1 transition-premium" title="Share on WhatsApp">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.012 2c-5.506 0-9.989 4.478-9.99 9.984a9.964 9.964 0 001.333 4.993L2 22l5.233-1.237a9.994 9.994 0 004.779 1.217h.004c5.505 0 9.988-4.478 9.989-9.9840 0-2.753-1.069-5.34-3.015-7.286A9.954 9.954 0 0012.012 2zm5.744 14.398c-.244.693-1.42 1.341-1.959 1.411-.539.071-1.229.17-3.864-1.077-3.177-1.503-5.231-4.73-5.389-4.94-.158-.21-1.29-1.721-1.29-3.284 0-1.563.816-2.336 1.106-2.645.29-.309.632-.387.843-.387.21 0 .42-.001.605 0 .198.001.464-.075.727.561.264.636.903 2.197.982 2.355.079.158.132.342.026.553-.105.21-.158.342-.316.527-.158.185-.33.411-.474.553-.158.158-.323.332-.14.646.185.316.822 1.356 1.764 2.197 1.218 1.087 2.228 1.42 2.545 1.578.316.158.5.132.685-.079.185-.21.791-.922.999-1.238.21-.316.42-.264.711-.158.29.105 1.844.87 2.16 1.027.316.158.527.237.606.369.079.132.079.764-.165 1.457z"/></svg>
        </a>
        <a href="https://t.me/share/url?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-full border border-black/10 bg-white shadow-sm flex items-center justify-center text-slate-500 hover:text-[#2AABEE] hover:border-[#2AABEE] hover:-translate-y-1 transition-premium" title="Share on Telegram">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0zm5.952 7.825-1.97 9.296c-.144.654-.53.812-1.072.508l-2.966-2.186-1.43 1.378c-.158.158-.291.291-.595.291l.211-3.031 5.513-4.981c.24-.213-.053-.332-.373-.119L8.398 12.26 5.46 11.34c-.64-.2-.64-.64.133-.944l11.433-4.407c.528-.198.988.12.87.836z"/></svg>
        </a>
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-full border border-black/10 bg-white shadow-sm flex items-center justify-center text-slate-500 hover:text-[#1877F2] hover:border-[#1877F2] hover:-translate-y-1 transition-premium" title="Share on Facebook">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
        </a>
        <button type="button" onclick="copyUrlToClipboard(this)" class="w-10 h-10 rounded-full border border-black/10 bg-white shadow-sm flex items-center justify-center text-slate-500 hover:text-emerald-500 hover:border-emerald-500 hover:-translate-y-1 transition-premium" title="Copy Link">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
        </button>
    </div>

    {{-- Body is sanitized rich text from the restricted CMS editor (req 4.3),
         so it's rendered unescaped by design (CLAUDE.md Section 12). --}}
    <article class="max-w-3xl mx-auto px-7 py-10 prose prose-slate prose-headings:font-display prose-headings:text-black prose-a:text-black hover:prose-a:text-forest prose-strong:text-black">
        {!! $post->body !!}
    </article>

    <div class="max-w-3xl mx-auto px-7 pb-16">
        <div class="flex items-center justify-between border-t border-black/10 pt-8 mt-4">
            @if ($previous)
                <a href="{{ route('blog.show', $previous) }}" class="text-sm font-semibold text-slate-500 hover:text-black transition-colors">&larr; <span class="hidden sm:inline">{{ $previous->title }}</span><span class="sm:hidden">Previous</span></a>
            @else
                <a href="{{ route('blog.index') }}" class="text-sm font-semibold text-slate-500 hover:text-black transition-colors">&larr; All posts</a>
            @endif

            @if ($next)
                <a href="{{ route('blog.show', $next) }}" class="text-sm font-semibold text-black hover:text-forest transition-colors"><span class="hidden sm:inline">Next: {{ $next->title }}</span><span class="sm:hidden">Next</span> &rarr;</a>
            @else
                <a href="{{ route('blog.index') }}" class="text-sm font-semibold text-black hover:text-forest transition-colors">Back to blog &rarr;</a>
            @endif
        </div>
    </div>

    @if ($related->isNotEmpty())


        <section class="max-w-6xl mx-auto px-7 py-16">
            <h2 class="font-display text-2xl font-semibold mb-8">Related posts</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ($related as $item)
                    <x-blog-card :post="$item" :accent="['gold', 'forest'][$loop->index % 2]" />
                @endforeach
            </div>
        </section>
    @endif

    <script>
        function copyUrlToClipboard(btn) {
            const url = window.location.href;
            const copyText = btn.querySelector('.copy-text');
            const copiedText = btn.querySelector('.copied-text');
            
            const showSuccess = () => {
                if (copyText && copiedText) {
                    const originalSvg = btn.querySelector('svg')?.outerHTML || '';
                    const svgEl = btn.querySelector('svg');
                    if (svgEl) {
                        svgEl.outerHTML = `<svg class="w-3.5 h-3.5 text-emerald-400 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
                    }
                    copyText.style.display = 'none';
                    copiedText.style.display = 'inline';
                    setTimeout(() => {
                        copyText.style.display = 'inline';
                        copiedText.style.display = 'none';
                        const newSvg = btn.querySelector('svg');
                        if (newSvg && originalSvg) {
                            newSvg.outerHTML = originalSvg;
                        }
                    }, 2000);
                } else {
                    // Feedback for icon-only buttons: swap the SVG icon to a checkmark!
                    const originalInner = btn.innerHTML;
                    btn.innerHTML = `<svg class="w-4 h-4 text-emerald-500 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
                    btn.classList.add('!border-emerald-500', '!bg-emerald-50');
                    setTimeout(() => {
                        btn.innerHTML = originalInner;
                        btn.classList.remove('!border-emerald-500', '!bg-emerald-50');
                    }, 2000);
                }
            };

            if (navigator.clipboard) {
                navigator.clipboard.writeText(url)
                    .then(showSuccess)
                    .catch(err => {
                        console.warn('Clipboard API failed, trying fallback:', err);
                        fallbackCopy(url, showSuccess);
                    });
            } else {
                fallbackCopy(url, showSuccess);
            }
        }

        function fallbackCopy(text, onSuccess) {
            const textArea = document.createElement("textarea");
            textArea.value = text;
            
            // Position invisibly in top-left to avoid scrolling/visual glitches
            textArea.style.position = 'fixed';
            textArea.style.top = '0';
            textArea.style.left = '0';
            textArea.style.width = '2em';
            textArea.style.height = '2em';
            textArea.style.padding = '0';
            textArea.style.border = 'none';
            textArea.style.outline = 'none';
            textArea.style.boxShadow = 'none';
            textArea.style.background = 'transparent';
            
            document.body.appendChild(textArea);
            
            // Focus and selection logic
            if (navigator.userAgent.match(/ipad|ipod|iphone/i)) {
                const range = document.createRange();
                range.selectNodeContents(textArea);
                const selection = window.getSelection();
                selection.removeAllRanges();
                selection.addRange(range);
                textArea.setSelectionRange(0, 999999);
            } else {
                textArea.focus();
                textArea.select();
            }
            
            try {
                const successful = document.execCommand('copy');
                if (successful) {
                    onSuccess();
                } else {
                    console.error('execCommand copy returned false');
                }
            } catch (err) {
                console.error('Fallback copy via execCommand failed:', err);
            }
            
            document.body.removeChild(textArea);
        }

        // Read Progress & Widget Visibility Logic
        document.addEventListener('scroll', () => {
            const article = document.querySelector('article');
            const progress = document.getElementById('readProgress');
            const widget = document.getElementById('floatingWidget');
            const mobileToggle = document.getElementById('mobileShareToggle');
            
            if (!article || !progress || !widget) return;
            
            const windowHeight = window.innerHeight;
            const articleRect = article.getBoundingClientRect();
            
            // Show widget/toggle only when scrolling past the hero header
            if (window.scrollY > 400) {
                if (window.innerWidth >= 1024) { // Desktop
                    widget.classList.remove('opacity-0', 'pointer-events-none');
                    widget.classList.add('opacity-100', 'pointer-events-auto');
                    if (mobileToggle) mobileToggle.classList.add('hidden');
                } else { // Mobile
                    if (mobileToggle) {
                        mobileToggle.classList.remove('hidden', 'opacity-0', 'pointer-events-none');
                        mobileToggle.classList.add('opacity-100', 'pointer-events-auto');
                    }
                    widget.classList.remove('opacity-0', 'pointer-events-none'); // Opacity handled via translate
                    widget.classList.add('opacity-100', 'pointer-events-auto');
                }
            } else {
                widget.classList.add('opacity-0', 'pointer-events-none');
                widget.classList.remove('opacity-100', 'pointer-events-auto');
                if (mobileToggle) {
                    mobileToggle.classList.add('opacity-0', 'pointer-events-none');
                    mobileToggle.classList.remove('opacity-100', 'pointer-events-auto');
                    // Auto-close panel if open
                    if (widget.classList.contains('!translate-x-0')) {
                        widget.classList.remove('!translate-x-0');
                        mobileToggle.classList.remove('is-active', 'mr-[72px]');
                    }
                }
            }

            // Calculate progress through the article content
            let scrolled = (windowHeight - articleRect.top) / (articleRect.height + windowHeight);
            scrolled = Math.max(0, Math.min(1, scrolled));
            
            progress.style.height = (scrolled * 100) + '%';
        }, { passive: true });

        // Mobile Panel Toggle
        const mobileToggleBtn = document.getElementById('mobileShareToggle');
        if (mobileToggleBtn) {
            mobileToggleBtn.addEventListener('click', () => {
                const widget = document.getElementById('floatingWidget');
                const isOpen = widget.classList.contains('!translate-x-0');
                
                if (isOpen) {
                    widget.classList.remove('!translate-x-0');
                    mobileToggleBtn.classList.remove('is-active', 'mr-[72px]');
                } else {
                    widget.classList.add('!translate-x-0');
                    mobileToggleBtn.classList.add('is-active', 'mr-[72px]');
                }
            });
        }
    </script>
    
    {{-- Add line-numbers class to all pre blocks before Prism highlights them --}}
    <script>
        document.querySelectorAll('article pre').forEach(pre => {
            pre.classList.add('line-numbers');
        });
    </script>
    
    {{-- Prism.js for syntax highlighting --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-numbers/prism-line-numbers.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/toolbar/prism-toolbar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js"></script>
</x-layouts.app>
